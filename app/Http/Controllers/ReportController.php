<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Report;
use App\Models\DailyReport;  
use App\Models\Department; // Add Department model
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
        
        // Filter reports based on search input (e.g., department, day of the week)
        if ($request->has('search')) {
            $search = $request->get('search');
    
            $query->where(function ($q) use ($search) {
                $q->orWhereHas('department', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhere('day_of_week', 'like', "%$search%")
                ->orWhere('report_details', 'like', "%$search%")
                ->orWhere('report_date', 'like', "%$search%");
            });
        }
        
        // Filter reports based on is_submitted from the related 'daily_reports' table
        $query->whereIn('reports.id', function($q) {
            $q->select('daily_reports.report_id') // Ensure to select the correct column name from daily_reports
              ->from('daily_reports')
              ->where('is_submitted', true); // Only include reports that have been submitted
        });
        
        // Get the reports with the necessary relationships (department)
        $reports = $query->with('department')->paginate(10);
        
        // Fetch the list of employees and departments for the dropdown
        $employees = Employee::all(); // Fetch employees from the database
        $departments = Department::all(); // Fetch departments from the database
        
        // Return the view with reports, departments, and employees
        return view('reports.index', compact('reports', 'departments', 'employees'));
    }
    

    public function create()
    {
        // Fetch all departments for the dropdown
        $departments = Department::pluck('name', 'id'); // Get department names and ids

        // Return the view for creating a new report
        return view('reports.create', compact('departments'));
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
    
        // Check if a report for the department and day already exists
        $existingReport = Report::where('department_id', $input['department_id'])
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

        // Fetch all departments for the dropdown
        $departments = Department::pluck('name', 'id');

        return view('reports.edit', compact('report', 'departments'));
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
     * Synchronize Department Reports Data (e.g., for the week).
     */
    public function syncData()
    {
        // Fetch active departments
        $departments = Department::all();

        // Loop through each department and generate or update reports
        foreach ($departments as $department) {
            // Check if a report for the current week exists
            $existingReport = Report::where('department_id', $department->id)
                ->where('day_of_week', 'like', "%$department->working_day%")
                ->first();

            // If no report exists for this department and day of the week, create a new one
            if (!$existingReport) {
                Report::create([
                    'department_id' => $department->id,
                    'day_of_week' => $department->working_day, // Assume 'working_day' holds the correct day
                    'report_details' => 'Generated report for department ' . $department->name, // Example content
                    'report_date' => now(), // Set to current date
                ]);
            }
        }

        Flash::success('Department report data has been synchronized successfully.');

        return redirect(route('reports.index'));
    }
}
