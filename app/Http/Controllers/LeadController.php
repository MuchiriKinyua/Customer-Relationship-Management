<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Repositories\ClientRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LeadRepository;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Carbon\Carbon;
use Flash;

class LeadController extends AppBaseController
{
    /** @var LeadRepository $leadRepository*/
    private $leadRepository;

    private $clientRepository;

    public function __construct(LeadRepository $leadRepo, ClientRepository $clientRepo)
    {
        $this->leadRepository = $leadRepo;
        $this->clientRepository = $clientRepo; // Inject the ClientRepository
    }

    /**
     * Display a listing of the Lead.
     */
    public function index(Request $request)
    {
        // Get search query from the request
        $search = $request->input('search');
        
        // Query leads with employee relationships and apply search if a term is provided
        $leads = Lead::with(['employee', 'products']) // Eager load product and employee
            ->when($search, function ($query) use ($search) {
                $query->where('full_name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone_number', 'like', '%' . $search . '%') // Added phone number search
                      ->orWhere('source', 'like', '%' . $search . '%') // Added source search
                      ->orWhere('status', 'like', '%' . $search . '%') // Added status search
                      ->orWhere('description', 'like', '%' . $search . '%') // Added description search
                      ->orWhereHas('employee', function ($query) use ($search) {
                          // Search employee's first name, last name, and email
                          $query->where('full_name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                      })
                      ->orWhereHas('products', function ($query) use ($search) {
                          // Search product related fields, if necessary
                          $query->where('product_name', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');
                      });
            })
            ->paginate(10);
    
        return view('leads.index', compact('leads'));
    }
    
    
    /**
     * Show the form for creating a new Lead.
     */
    public function create()
    {
        // Retrieve all employees to populate the employee dropdown
        $employees = Employee::all();
    
        // Retrieve all products to populate the product selection
        $products = Product::all();
    
        // Define interaction types for the "Form of Contact" dropdown
        $interactionTypes = [
            'phone' => 'Call',
            'email' => 'Email',
            'referral' => 'Referral',
            'social media' => 'Social Media',
        ];
    
        // Pass the retrieved data and interaction types to the create view
        return view('leads.create', compact('employees', 'products', 'interactionTypes'));
    }
    
    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone_number' => 'nullable|string',
            'source' => 'nullable|string',
            'status' => 'nullable|string',
            'employee_id' => 'nullable|exists:employees,id',
            'description' => 'nullable|string',
            'lead_date' => 'nullable|date',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
        ]);
    
        $lead = Lead::create($validatedData);
    
        // Attach selected products with quantities
        $productQuantities = [];
        foreach ($request->products as $productId) {
            $productQuantities[$productId] = [
                'quantity' => $request->quantities[$productId] ?? 1, // Use quantity from input
            ];
        }
    
        $lead->products()->sync($productQuantities);
    
        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }
    
    


    /**
     * Store a newly created Lead in storage.
     */
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
    
        // Validate input data
        $data = $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'description' => 'nullable|string|max:65535',
            'lead_date' => 'nullable|date',
            'products' => 'array',
            'products.*' => 'exists:products,id',
            'quantities' => 'array',
            'quantities.*' => 'integer|min:1',
        ]);
    
        // Update only specific fields
        $lead->employee_id = $data['employee_id'] ?? $lead->employee_id;
        $lead->description = $data['description'] ?? $lead->description;
        $lead->lead_date = $data['lead_date'] ?? $lead->lead_date;
    
        $lead->save();
    
        // Maintain existing product logic
        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);
    
        $productData = [];
        foreach ($products as $productId) {
            $productData[$productId] = ['quantity' => $quantities[$productId] ?? 1];
        }
    
        $lead->products()->sync($productData);
    
        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }
    
    

    

    /**
     * Display the specified Lead.
     */
    public function show($id)
    {
        $lead = $this->leadRepository->find($id);

        if (empty($lead)) {
            Flash::error('Lead not found');
            return redirect(route('leads.index'));
        }

        return view('leads.show')->with('lead', $lead);
    }

    /**
     * Show the form for editing the specified Lead.
     */
    public function edit($id)
    {
        $lead = Lead::with('products')->findOrFail($id);
        $products = Product::all();
        $employees = Employee::all();
    
        $selectedProducts = $lead->products->pluck('id')->toArray();
        $quantities = $lead->products->pluck('pivot.quantity', 'id')->toArray();
    
        return view('leads.edit', compact('lead', 'products', 'employees', 'selectedProducts', 'quantities'));
    }
    


    /**
     * Remove the specified Lead from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $lead = $this->leadRepository->find($id);

        if (empty($lead)) {
            Flash::error('Lead not found');
            return redirect(route('leads.index'));
        }

        $this->leadRepository->delete($id);

        Flash::success('Lead deleted successfully.');

        return redirect(route('leads.index'));
    }

    /**
     * Convert lead to client.
     */
    public function convertToClient($leadId)
    {
        $lead = Lead::find($leadId);
    
        if (!$lead) {
            Flash::error('Lead not found');
            return redirect(route('leads.index'));
        }
    
        $existingClient = Client::where('lead_id', $lead->id)
            ->orWhere('email_address', $lead->email)
            ->orWhere('phone_number', $lead->phone_number)
            ->first();
    
        if ($existingClient) {
            Flash::warning('This lead is already associated with a client.');
            return redirect(route('leads.index'));
        }
    
        if ($lead->status !== 'converted') {
            $lead->status = 'converted';
            $lead->save();
        }
    
        $client = Client::create([
            'full_name' => $lead->full_name,
            'email_address' => $lead->email,
            'phone_number' => $lead->phone_number,
            'lead_id' => $lead->id,
            'employee_id' => $lead->employee_id,
            'location' => 'Unknown', 
        ]);
    
        Flash::success('Lead successfully converted to client.');
        return redirect(route('leads.index'));
    }
    
    public function getLeadData(Request $request)
    {
        $interval = $request->get('interval', 'days'); // Default to daily

        $query = DB::table('leads')
            ->select(
                DB::raw('COUNT(id) as total_leads'),
                DB::raw("DATE_FORMAT(created_at, CASE WHEN '$interval' = 'days' THEN '%Y-%m-%d' WHEN '$interval' = 'weeks' THEN '%Y-%u' WHEN '$interval' = 'months' THEN '%Y-%m' END) as date_group")
            )
            ->groupBy('date_group')
            ->orderBy('date_group');

        $data = $query->get();

        return response()->json($data);
    }
    public function addDetails($id)
    {
        // Fetch the lead by ID
        $lead = Lead::findOrFail($id);
    
        // Fetch other data required by the view
        $employees = Employee::all();
        $products = Product::all();
        $interactionTypes = [
            'phone' => 'Call',
            'email' => 'Email',
            'referral' => 'Referral',
            'social media' => 'Social Media',
        ];
    
        // Pass the lead and other data to the view
        return view('leads.add_details', compact('lead', 'employees', 'products', 'interactionTypes'));
    }
    
    

    public function storeDetails(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
    
        $validatedData = $request->validate([
            'description' => 'required|string|max:65535',
            'lead_date' => 'required|date',
            'employee_id' => 'nullable|exists:employees,id',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'interactionTypes' => 'required|string|max:255',
        ]);
    
        // Update specific fields
        $lead->description = $validatedData['description'];
        $lead->lead_date = $validatedData['lead_date'];
        $lead->employee_id = $validatedData['employee_id'];
        $lead->interaction_type = $validatedData['interactionTypes'];
        $lead->save();
        
    
        // Maintain existing product logic
        foreach ($validatedData['products'] as $productId) {
            $quantity = $validatedData['quantities'][$productId] ?? 1;
            $lead->products()->attach($productId, ['quantity' => $quantity]);
        }
    
        return redirect()->route('leads.index')->with('success', 'Details added to lead successfully.');
    }
    

}