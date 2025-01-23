<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInteractionRequest;
use App\Http\Requests\UpdateInteractionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InteractionRepository;
use Illuminate\Http\Request;
use App\Models\Interaction;
use App\Models\Client;  // Correct import at the top
use App\Models\Lead;
use App\Models\Employee;
use Flash;

class InteractionController extends AppBaseController
{
    /** @var InteractionRepository $interactionRepository */
    private $interactionRepository;

    public function __construct(InteractionRepository $interactionRepo)
    {
        $this->interactionRepository = $interactionRepo;
    }

    /**
     * Display a listing of the Interaction.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $interactions = Interaction::with(['lead', 'employee']) // Eager load employee
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('type', 'like', '%' . $search . '%')
                             ->orWhere('description', 'like', '%' . $search . '%')
                             ->orWhere('interactions_date', 'like', '%' . $search . '%')
                             ->orWhereHas('lead', function ($query) use ($search) {
                                 $query->where('full_name', 'like', '%' . $search . '%')
                                       ->orWhere('email', 'like', '%' . $search . '%')
                                       ->orWhere('phone_number', 'like', '%' . $search . '%');
                             });
                });
            })
            ->selectRaw('
                MAX(interactions.id) as interaction_id,
                lead_id,
                MAX(interactions.type) as type,
                MAX(interactions.description) as description,
                MAX(interactions.interactions_date) as interaction_date
            ')
            ->groupBy('lead_id') // Grouping by lead_id ensures unique leads
            ->paginate(10);
    
        return view('interactions.index', compact('interactions'));
    }
    

    

   // In your InteractionController, create method:
public function create(Request $request)
{
    // Fetch all employees to populate the employee dropdown
    $employees = \App\Models\Employee::all(); // Fetch all employees

    // Fetch lead and client if provided
    $leadId = $request->query('lead_id');
    $clientId = $request->query('client_id');
    
    $lead = null;
    $client = null;

    if ($leadId) {
        $lead = \App\Models\Lead::find($leadId);
        if (!$lead) {
            Flash::error('Lead not found');
        }
    }

    if ($clientId) {
        $client = \App\Models\Client::find($clientId);
        if (!$client) {
            Flash::error('Client not found');
        }
    }

    // Pass employees, lead, and client to the view
    return view('interactions.create', compact('lead', 'client', 'employees'));
}

    
    

    /**
     * Store a newly created Interaction in storage.
     */
    public function store(CreateInteractionRequest $request)
{
    // Validate the required inputs
    $request->validate([
        'lead_full_name' => 'required|string|max:255',
        'type' => 'nullable|in:Lead,Client',
        'employee_id' => 'required|exists:employees,id', // Add validation for employee_id
    ]);

    // Retrieve full input from request
    $input = $request->all();

    // Check if a lead with this name already exists, otherwise create a new one
    $lead = \App\Models\Lead::firstOrCreate([
        'full_name' => $input['lead_full_name']
    ]);

    // Link this interaction to the correct lead
    $input['lead_id'] = $lead->id;

    // If 'type' is not provided in the request, determine it dynamically
    if (!isset($input['type'])) {
        $input['type'] = $request->has('client_id') ? 'Client' : 'Lead';
    }

    // Store the employee_id if provided
    $input['employee_id'] = $request->employee_id;

    // Create the interaction
    $interaction = $this->interactionRepository->create($input);

    Flash::success('Interaction saved successfully.');

    return redirect(route('interactions.index'));
}


    /**
     * Display the specified Interaction.
     */
    /**
 * Display all interactions for a specific Lead.
 */
public function show($id)
{
    $lead = Lead::findOrFail($id);

    // Fetch all interactions for the lead, ordered by creation date and eager load employee
    $interactions = Interaction::with('employee')
        ->where('lead_id', $lead->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Fetch the most recent interaction for this lead
    $currentInteraction = $interactions->first(); // The most recent interaction is the first one

    return view('interactions.show', compact('lead', 'currentInteraction', 'interactions'));
}




    /**
     * Show the form for editing the specified Interaction.
     */
    public function edit($id)
    {
        $interaction = $this->interactionRepository->find($id);

        if (empty($interaction)) {
            Flash::error('Interaction not found');

            return redirect(route('interactions.index'));
        }

        return view('interactions.edit')->with('interaction', $interaction);
    }

    /**
     * Update the specified Interaction in storage.
     */
    public function update($id, UpdateInteractionRequest $request)
    {
        $interaction = $this->interactionRepository->find($id);

        if (empty($interaction)) {
            Flash::error('Interaction not found');

            return redirect(route('interactions.index'));
        }

        $interaction = $this->interactionRepository->update($request->all(), $id);

        Flash::success('Interaction updated successfully.');

        return redirect(route('interactions.index'));
    }

    /**
     * Remove the specified Interaction from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $interaction = $this->interactionRepository->find($id);

        if (empty($interaction)) {
            Flash::error('Interaction not found');

            return redirect(route('interactions.index'));
        }

        $this->interactionRepository->delete($id);

        Flash::success('Interaction deleted successfully.');

        return redirect(route('interactions.index'));
    }

    public function deleteAll($leadId)
{
    // Find the lead and delete all its interactions
    $lead = Lead::findOrFail($leadId);

    // Delete all interactions for the lead
    $lead->interactions()->delete();

    // Flash a success message
    session()->flash('success', 'All interactions for the lead have been deleted successfully.');

    // Redirect back to the interactions index
    return redirect()->route('interactions.index');
}

}
