<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
use App\Models\Employee;
use Flash;

class ReportController extends AppBaseController
{
    /** @var ReportRepository $reportRepository*/
    private $reportRepository;

    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepository = $reportRepo;
    }

    /**
     * Display a listing of the Report.
     */
    public function index(Request $request)
    {
        // Retrieve all employees
        $employees = Employee::all(); 
    
        // Get the base query from the report repository
        $query = $this->reportRepository->query();
        
        // Check if search terms are provided and filter accordingly
        if ($request->has('search')) {
            $search = $request->get('search');
            
            // Apply search filters
            $query->where(function ($q) use ($search) {
                $q->where('employee_name', 'like', "%$search%")
                    ->orWhere('lead_name', 'like', "%$search%")
                    ->orWhere('client_name', 'like', "%$search%")
                    ->orWhere('lead_date', 'like', "%$search%")
                    ->orWhere('client_date', 'like', "%$search%")
                    ->orWhere('product_id', 'like', "%$search%")
                    ->orWhere('quantity_ordered', 'like', "%$search%")
                    ->orWhere('order_date', 'like', "%$search%")
                    ->orWhere('order_status', 'like', "%$search%")
                    ->orWhere('interaction_type', 'like', "%$search%");
            });
        }
        
        // Paginate the filtered results
        $reports = $query->paginate(10);
        
        // Return the view with the reports and employees
        return view('reports.index', compact('employees', 'reports'));
    }
    
    

    /**
     * Show the form for creating a new Report.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created Report in storage.
     */
    public function store(CreateReportRequest $request)
    {
        $input = $request->all();

        $report = $this->reportRepository->create($input);

        Flash::success('Report saved successfully.');

        return redirect(route('reports.index'));
    }

    /**
     * Display the specified Report.
     */
    public function show($id)
    {
        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        return view('reports.show')->with('report', $report);
    }

    /**
     * Show the form for editing the specified Report.
     */
    public function edit($id)
    {
        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        return view('reports.edit')->with('report', $report);
    }

    /**
     * Update the specified Report in storage.
     */
    public function update($id, UpdateReportRequest $request)
    {
        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        $report = $this->reportRepository->update($request->all(), $id);

        Flash::success('Report updated successfully.');

        return redirect(route('reports.index'));
    }

    /**
     * Remove the specified Report from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        $this->reportRepository->delete($id);

        Flash::success('Report deleted successfully.');

        return redirect(route('reports.index'));
    }
}