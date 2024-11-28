<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\DailyReport;
use App\Models\Report;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function create($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        return view('daily_reports.create', compact('employee'));
    }

    public function store(Request $request)
    {
        // Validate the request, including reCAPTCHA
        $request->validate([
            'employee_id' => 'required|exists:employees,id', // Ensure the employee exists
            'report' => 'required|string',
        ]);
        
        // Sanitize the report content by removing all HTML tags but keep the styles in place
        $sanitizedReport = strip_tags($request->report, '<b><i><strong><em><u>'); // Allow certain tags like <b>, <i>, <strong>, etc.
        
        // Get the current day (e.g., "Monday", "Tuesday", etc.)
        $currentDay = \Carbon\Carbon::now()->format('l'); // Get the full name of the current day (e.g., 'Monday')
        
        // Check if a report already exists for the employee on the current day
        $existingReport = DailyReport::where('employee_id', $request->employee_id)
                                      ->where('day', strtolower($currentDay))
                                      ->where('report_date', \Carbon\Carbon::now()->format('Y-m-d'))
                                      ->first();
        
        if ($existingReport) {
            // Append the new sanitized report to the existing report
            $existingReport->report .= "\n\n" . $sanitizedReport; // Add a new line before appending
            $existingReport->save();
        } else {
            // Create a new daily report if none exists
            $dailyReport = new DailyReport();
            $dailyReport->employee_id = $request->employee_id;
            $dailyReport->report_date = \Carbon\Carbon::now()->format('Y-m-d');
            $dailyReport->day = strtolower($currentDay);  // Automatically set the current day as the value of the 'day' field
            $dailyReport->report = $sanitizedReport;  // Save the sanitized report content
            $dailyReport->save();
        }
    
        // Save the report to the reports table (which aggregates the reports)
        $report = Report::firstOrNew([
            'employee_id' => $request->employee_id,
            'report_date' => \Carbon\Carbon::now()->format('Y-m-d'),
        ]);
        $report->{$currentDay} = $sanitizedReport;  // Save the sanitized report under the correct day
        $report->save();
        
        return redirect()->route('employees.index')->with('success', 'Successfully added a report, it has been saved.');
    }
    
    


    public function viewReport($employeeId)
    {
        // Retrieve the employee and the daily reports for the week
        $employee = Employee::findOrFail($employeeId);

        // Define the days of the week
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        
        // Fetch the reports for each day of the week for the specified employee
        $reports = DailyReport::where('employee_id', $employeeId)
                              ->whereIn('day', $days)
                              ->get()
                              ->keyBy('day'); // This will return the reports indexed by day (monday, tuesday, etc.)

        // Create a summary of the reports
        $summary = $reports->map(function ($report) {
            return $report->report;
        })->implode("\n\n"); // Combining reports with a new line between each day

        // Pass the data to the view
        return view('daily_reports.view', compact('employee', 'reports', 'days', 'summary'));
    }

    public function index()
    {
        // Display the list of reports for all employees, filtered by the current week
        $currentWeekStart = \Carbon\Carbon::now()->startOfWeek();
        $currentWeekEnd = \Carbon\Carbon::now()->endOfWeek();

        // Fetch all reports for the current week
        $reports = DailyReport::whereBetween('report_date', [$currentWeekStart, $currentWeekEnd])
            ->orderBy('report_date')
            ->get();

        return view('daily_reports.index', compact('reports', 'currentWeekStart', 'currentWeekEnd'));
    }

    public function edit($id)
{
    // Retrieve the specific daily report using the ID
    $dailyReport = DailyReport::findOrFail($id);

    return view('daily_reports.edit', compact('dailyReport'));
}

public function update(Request $request, $id)
{
    // Validate the input
    $request->validate([
        'report' => 'required|string',
    ]);

    // Find the daily report
    $dailyReport = DailyReport::findOrFail($id);

    // Update the daily report with the provided data
    $dailyReport->report = $request->report;
    $dailyReport->save();

    return redirect()->route('employees.index')->with('success', 'Daily Report updated successfully.');
}
    

}
