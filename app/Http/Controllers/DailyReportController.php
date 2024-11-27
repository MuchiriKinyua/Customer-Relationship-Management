<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\DailyReport;
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
    // Validate the request
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'day' => 'required|in:monday,tuesday,wednesday,thursday,friday',
        'report' => 'required|string',
        'report_date' => 'required|date',
        'signature' => 'required|string',  // Ensure signature is provided
        'is_human' => 'accepted',  // Ensure the "I'm not a robot" checkbox is checked
    ]);

    // Create the daily report
    DailyReport::create([
        'employee_id' => $request->employee_id,
        'day' => $request->day,
        'report' => $request->report,
        'report_date' => $request->report_date,
        'signature' => $request->signature,
    ]);

    return redirect()->route('employees.index')->with('success', 'Report saved successfully.');
}


public function viewReport($employeeId)
{
    // Retrieve the employee and the daily reports for the week
    $employee = Employee::findOrFail($employeeId);

    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    
    // Fetch the reports for each day of the week for the specified employee
    $reports = DailyReport::where('employee_id', $employeeId)
                          ->whereIn('day', $days)
                          ->get()
                          ->keyBy('day'); // This will return the reports indexed by day (monday, tuesday, etc.)

    // Generate a summary by combining the reports from Monday to Friday
    $summary = $reports->map(function ($report) {
        return $report->report;
    })->implode("\n\n"); // Combining reports with a new line between each day

    // Pass the data to the view
    return view('daily_reports.view', compact('employee', 'reports', 'days', 'summary'));
}


}
