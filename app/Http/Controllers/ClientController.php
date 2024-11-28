<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use App\Models\Employee;
use Flash;

class ClientController extends AppBaseController
{
    /** @var ClientRepository $clientRepository */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepository = $clientRepo;
    }

    /**
     * Display a listing of the Client.
     */
/**
 * Display a listing of the Client.
 */
/**
 * Display a listing of the Client.
 */
public function index(Request $request)
{
    // Get search term from the request
    $search = $request->input('search');
    
    // Query clients with related data
    $clients = $this->clientRepository->query()->with('lead', 'employee');  // Include related lead data
    
    // Apply search filters dynamically
    if ($search) {
        $clients = $clients->where(function ($query) use ($search) {
            $query->where('full_name', 'like', '%' . $search . '%')
                  ->orWhere('company_name', 'like', '%' . $search . '%')
                  ->orWhere('email_address', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhereHas('lead', function ($query) use ($search) {
                      $query->where('name', 'like', '%' . $search . '%');
                  }); // Search the related lead's name
        });
    }
    
    // Paginate results (10 per page, adjustable)
    $clients = $clients->paginate(10);
    
    return view('clients.index', compact('clients'));
}

    /**
     * Show the form for creating a new Client.
     */
    public function create()
    {
        // Fetch all leads and pass them to the view
        $employees = Employee::all(); 
        $leads = \App\Models\Lead::all();
        $interactionTypes = [
            'phone' => 'Call',
            'email' => 'Email',
            'referral' => 'Referral',
            'social media' => 'Social Media',
        ];

        return view('clients.create', compact('employees', 'leads','interactionTypes'));  
    }

    /**
     * Store a newly created Client in storage.
     */
    public function store(CreateClientRequest $request)
    {
        // Validate the incoming data and add 'client_date' validation (none of the fields are required)
        $validatedData = $request->validate([
            'full_name' => 'nullable|string|max:100',
            'company_name' => 'nullable|string|max:100',
            'email_address' => 'nullable|string|max:100|email',
            'phone_number' => 'nullable|string',
            'location' => 'nullable|string|max:30',
            'employee_id' => 'nullable|exists:employees,id',
            'client_date' => 'nullable|date',
        ]);
    
        // Merge the validated data to include 'client_date'
        $clientData = $validatedData;
    
        // If a product is selected, associate it (if the relationship exists in the Client model)
        if ($request->has('product_id') && $request->product_id) {
            $clientData['product_id'] = $request->product_id;
        }
    
        // Create the client with the validated data
        $client = $this->clientRepository->create($clientData);
    
        // If a client_date is provided, update it after creation
        if ($request->has('client_date') && $request->client_date) {
            $client->client_date = \Carbon\Carbon::parse($request->client_date)->timezone('UTC');
            $client->save();
        }
    
        Flash::success('Client saved successfully.');
    
        return redirect(route('clients.index'));
    }
    
    

    /**
     * Display the specified Client.
     */
    public function show($id)
    {
        // Ensure that $id is being passed properly
        $client = $this->clientRepository->find($id);
    
        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }
    
        // Eager load the 'lead' relationship after finding the client
        $client->load(['lead', 'employee']); 
    
        return view('clients.show')->with('client', $client);
    }
    

    /**
     * Show the form for editing the specified Client.
     */
    public function edit($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        return view('clients.edit')->with('client', $client);
    }

    /**
     * Update the specified Client in storage.
     */
    public function update($id, UpdateClientRequest $request)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        $client = $this->clientRepository->update($request->all(), $id);

        Flash::success('Client updated successfully.');

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified Client from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        $this->clientRepository->delete($id);

        Flash::success('Client deleted successfully.');

        return redirect(route('clients.index'));
    }
}
