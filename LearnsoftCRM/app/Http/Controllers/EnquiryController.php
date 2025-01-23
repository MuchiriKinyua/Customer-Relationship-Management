<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEnquiryRequest;
use App\Http\Requests\UpdateEnquiryRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\EnquiryRepository;
use Illuminate\Http\Request;
use Flash;

class EnquiryController extends AppBaseController
{
    /** @var EnquiryRepository $enquiryRepository*/
    private $enquiryRepository;

    public function __construct(EnquiryRepository $enquiryRepo)
    {
        $this->enquiryRepository = $enquiryRepo;
    }

    /**
     * Display a listing of the Enquiry.
     */
    public function index(Request $request)
    {
        $query = $this->enquiryRepository->query();
    
        // Apply search if the search parameter is provided
        if ($request->has('search') && $request->get('search') != '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_names', 'like', "%$search%")
                  ->orWhere('phone_number', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('records', 'like', "%$search%");
            });
        }
    
        // Paginate the results
        $enquiries = $query->paginate(10);
    
        return view('enquiries.index')
            ->with('enquiries', $enquiries);
    }
    
    /**
     * Show the form for creating a new Enquiry.
     */
    public function create()
    {
        return view('enquiries.create');
    }

    /**
     * Store a newly created Enquiry in storage.
     */
    public function store(CreateEnquiryRequest $request)
    {
        $input = $request->all();

        $enquiry = $this->enquiryRepository->create($input);

        Flash::success('Enquiry saved successfully.');

        return redirect(route('enquiries.index'));
    }

    /**
     * Display the specified Enquiry.
     */
    public function show($id)
    {
        $enquiry = $this->enquiryRepository->find($id);

        if (empty($enquiry)) {
            Flash::error('Enquiry not found');

            return redirect(route('enquiries.index'));
        }

        return view('enquiries.show')->with('enquiry', $enquiry);
    }

    /**
     * Show the form for editing the specified Enquiry.
     */
    public function edit($id)
    {
        $enquiry = $this->enquiryRepository->find($id);

        if (empty($enquiry)) {
            Flash::error('Enquiry not found');

            return redirect(route('enquiries.index'));
        }

        return view('enquiries.edit')->with('enquiry', $enquiry);
    }

    /**
     * Update the specified Enquiry in storage.
     */
    public function update($id, UpdateEnquiryRequest $request)
    {
        $enquiry = $this->enquiryRepository->find($id);

        if (empty($enquiry)) {
            Flash::error('Enquiry not found');

            return redirect(route('enquiries.index'));
        }

        $enquiry = $this->enquiryRepository->update($request->all(), $id);

        Flash::success('Enquiry updated successfully.');

        return redirect(route('enquiries.index'));
    }

    /**
     * Remove the specified Enquiry from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $enquiry = $this->enquiryRepository->find($id);

        if (empty($enquiry)) {
            Flash::error('Enquiry not found');

            return redirect(route('enquiries.index'));
        }

        $this->enquiryRepository->delete($id);

        Flash::success('Enquiry deleted successfully.');

        return redirect(route('enquiries.index'));
    }
}
