<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\DailyReport;
use App\Models\Report;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    /**
     * Show form to create a new daily report.
     */
    public function create($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        return view('daily_reports.create', compact('employee'));
    }

    /**
     * Store a new daily report.
     */
    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'report' => 'required|string',
    ]);

    // Sanitize the report content
    $sanitizedReport = strip_tags($request->report, '<b><i><strong><em><u>');

    // Get current day and date
    $currentDay = strtolower(now()->format('l'));
    $currentDate = now()->format('Y-m-d');

    // Check if a report already exists
    $existingReport = DailyReport::where('employee_id', $request->employee_id)
        ->where('day', $currentDay)
        ->where('report_date', $currentDate)
        ->first();

    if ($existingReport) {
        // Append to the existing report
        $existingReport->report .= "\n\n" . $sanitizedReport;
        $existingReport->save();
    } else {
        // Create a new daily report
        DailyReport::create([
            'employee_id' => $request->employee_id,
            'report_date' => $currentDate,
            'day' => $currentDay,
            'report' => $sanitizedReport,
            'report_id' => $this->getOrCreateReport($request->employee_id, $currentDate) // Assign the report_id here
        ]);
    }

    // Update the aggregated report table
    $report = Report::firstOrNew([
        'employee_id' => $request->employee_id,
        'report_date' => $currentDate,
    ]);
    $report->{ucfirst($currentDay)} = $sanitizedReport; // e.g., 'Monday'
    $report->save();

    return redirect()->route('employees.index')->with('success', 'Report successfully added and saved.');
}

// Helper method to create or fetch the report and get its ID
private function getOrCreateReport($employeeId, $reportDate)
{
    $report = Report::firstOrNew([
        'employee_id' => $employeeId,
        'report_date' => $reportDate,
    ]);
    $report->save(); // Ensure it gets saved
    return $report->id; // Return the report_id
}

    /**
     * View reports for a specific employee.
     */
    public function viewReport($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        // Fetch reports for each day of the week
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $reports = DailyReport::where('employee_id', $employeeId)
            ->whereIn('day', $days)
            ->get()
            ->keyBy('day'); // Key by day for easy access

        // Summarize reports into a single string
        $summary = $reports->map(fn($report) => $report->report)->implode("\n\n");

        return view('daily_reports.view', compact('employee', 'reports', 'days', 'summary'));
    }

    /**
     * List all reports for the current week.
     */
    public function index()
    {
        $currentWeekStart = now()->startOfWeek();
        $currentWeekEnd = now()->endOfWeek();

        $reports = DailyReport::whereBetween('report_date', [$currentWeekStart, $currentWeekEnd])
            ->orderBy('report_date')
            ->get();

        return view('daily_reports.index', compact('reports', 'currentWeekStart', 'currentWeekEnd'));
    }

    /**
     * Show form to edit a daily report.
     */
    public function edit($id)
    {
        $dailyReport = DailyReport::findOrFail($id);
        return view('daily_reports.edit', compact('dailyReport'));
    }

    /**
     * Update an existing daily report.
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'report' => 'required|string',
        ]);

        // Sanitize the report content
        $sanitizedReport = strip_tags($request->report, '<b><i><strong><em><u>');

        // Update the daily report
        $dailyReport = DailyReport::findOrFail($id);
        $dailyReport->report = $sanitizedReport;
        $dailyReport->save();

        // Update the reports table
        $report = Report::where('employee_id', $dailyReport->employee_id)
            ->where('report_date', $dailyReport->report_date)
            ->first();

        if ($report) {
            $day = ucfirst($dailyReport->day); // e.g., 'Monday'
            $report->{$day} = $sanitizedReport;
            $report->save();
        }

        return redirect()->route('employees.index')->with('success', 'Report updated successfully.');
    }

    /**
     * Delete a daily report.
     */
    public function destroy($id)
    {
        $dailyReport = DailyReport::findOrFail($id);
        $employeeId = $dailyReport->employee_id;
        $day = ucfirst($dailyReport->day);

        // Delete the daily report
        $dailyReport->delete();

        // Update or delete the reports table entry
        $report = Report::where('employee_id', $employeeId)
            ->where('report_date', $dailyReport->report_date)
            ->first();

        if ($report) {
            $report->{$day} = null;

            // Check if all days are empty and delete if so
            if (collect($report->only(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']))->filter()->isEmpty()) {
                $report->delete();
            } else {
                $report->save();
            }
        }

        return redirect()->route('employees.index')->with('success', 'Report deleted successfully.');
    }


    public function submitReport($id)
{
    $report = DailyReport::findOrFail($id);
    $report->is_submitted = true; // Set the report as submitted
    $report->save();

    return redirect()->back()->with('success', 'Report submitted successfully!');
}

}
