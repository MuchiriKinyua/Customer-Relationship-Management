<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Report;
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
        $query = Report::query();

        // Filter reports based on search input (e.g., employee, day of the week)
        if ($request->has('search')) {
            $search = $request->get('search');

            $query->where(function ($q) use ($search) {
                $q->orWhereHas('employee', function($q) use ($search) {
                    $q->where('full_name', 'like', "%$search%");
                })
                ->orWhere('day_of_week', 'like', "%$search%")
                ->orWhere('report_details', 'like', "%$search%")
                ->orWhere('report_date', 'like', "%$search%");
            });
        }

        // Get the reports with the necessary relationships (employee)
        $reports = $query->with('employee')->paginate(10);

        // Fetch the list of employees for the dropdown
        $employees = Employee::all();

        // Return the view with reports and employees
        return view('reports.index', compact('reports', 'employees'));
    }

    /**
     * Show the form for creating a new Report.
     */
    public function create()
    {
        // Fetch all employees for the dropdown
        $employees = Employee::pluck('full_name', 'id');

        // Return the view for creating a new report
        return view('reports.create', compact('employees'));
    }

    /**
     * Store a newly created Report in storage.
     */
    public function store(CreateReportRequest $request)
    {
        $input = $request->all();
    
        // Validate the day_of_week and report details
        $request->validate([
            'day_of_week' => 'required|string',
            'report_details' => 'required|string',
        ]);
    
        // Check if a report for the employee and day already exists
        $existingReport = Report::where('employee_id', $input['employee_id'])
                                ->where('day_of_week', $input['day_of_week'])
                                ->where('report_date', now()->format('Y-m-d'))
                                ->first();
    
        if ($existingReport) {
            // Append the new report details
            $existingReport->report_details .= "\n\n" . $input['report_details'];
            $existingReport->save();
        } else {
            // Create the report
            Report::create($input);
        }
    
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

        // Fetch all employees for the dropdown (if needed)
        $employees = Employee::pluck('full_name', 'id');

        return view('reports.edit', compact('report', 'employees'));
    }

    /**
     * Update the specified Report in storage.
     */
    public function update($id, UpdateReportRequest $request)
    {
        $report = Report::find($id);

        if (empty($report)) {
            Flash::error('Report not found');
            return redirect(route('reports.index'));
        }

        // Validate the day_of_week and report details
        $request->validate([
            'day_of_week' => 'required|string',
            'report_details' => 'required|string',
        ]);

        // Update the report using the validated data
        $report->update($request->all());

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

    /**
     * Synchronize Employee Reports Data (e.g., for the week).
     */
    public function syncData()
    {
        // Fetch active employees
        $employees = Employee::where('status', 'active')->get();

        // Loop through each employee and generate or update reports
        foreach ($employees as $employee) {
            // Check if a report for the current week exists
            $existingReport = Report::where('employee_id', $employee->id)
                ->where('day_of_week', 'like', "%$employee->working_day%")
                ->first();

            // If no report exists for this employee and day of the week, create a new one
            if (!$existingReport) {
                Report::create([
                    'employee_id' => $employee->id,
                    'day_of_week' => $employee->working_day, // Assume 'working_day' holds the correct day
                    'report_details' => 'Generated report for ' . $employee->full_name, // Example content
                    'report_date' => now(), // Set to current date
                ]);
            }
        }

        Flash::success('Employee report data has been synchronized successfully.');

        return redirect(route('reports.index'));
    }
}
