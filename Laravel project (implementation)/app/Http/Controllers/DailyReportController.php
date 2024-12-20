<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\DailyReport;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyReportController extends Controller
{
    public function create($employee_id)
    {
        // Pass the employee_id to the view or perform other operations
        return view('daily_reports.create', compact('employee_id'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',  // Validate employee_id
            'report' => 'required|string',
        ]);
    
        $sanitizedReport = strip_tags($request->report, '<b><i><strong><em><u>');
        $currentDay = strtolower(now()->format('l'));
        $currentDate = now()->format('Y-m-d');
    
        $existingReport = DailyReport::where('employee_id', $request->employee_id)
            ->where('day', $currentDay)
            ->where('report_date', $currentDate)
            ->first();
    
        if ($existingReport) {
            $existingReport->report .= "\n\n" . $sanitizedReport;
            $existingReport->save();
        } else {
            DailyReport::create([
                'employee_id' => $request->employee_id,
                'report_date' => $currentDate,
                'day' => $currentDay,
                'report' => $sanitizedReport,
                'report_id' => $this->getOrCreateReport($request->employee_id, $currentDate),
            ]);
        }
    
        return redirect()->route('daily_reports.index')->with('success', 'Report added successfully.');
    }
    

    private function getOrCreateReport($employeeId, $reportDate)
    {
        $report = Report::firstOrNew(['employee_id' => $employeeId, 'report_date' => $reportDate]);
        $report->save();
        return $report->id;
    }

   

public function showSubmitPage($reportId)
{
    // Get the report
    $report = DailyReport::findOrFail($reportId);

    // Check if the report is already submitted
    if ($report->is_submitted) {
        return redirect()->route('daily_reports.index')->with('error', 'This report has already been submitted.');
    }

    // Pass the report to the view
    return view('daily_reports.submit', compact('report'));
}

public function submit(DailyReport $dailyReport)
{
    // Ensure the report is not already submitted
    if ($dailyReport->is_submitted) {
        return redirect()->route('daily_reports.index')->with('error', 'This report has already been submitted.');
    }

    // Mark the daily report as submitted
    $dailyReport->update(['is_submitted' => true]);

    // Determine the column to update in the reports table
    $dayColumn = strtolower($dailyReport->day); 

    // Find or create the corresponding row in the reports table
    $report = Report::firstOrNew([
        'employee_id' => $dailyReport->employee_id,
        'report_date' => $dailyReport->report_date,
    ]);

    // Update the appropriate column with the daily report content
    $report->$dayColumn = $dailyReport->report;

    // Save the updated report
    $report->save();

    return redirect()->route('daily_reports.index')->with('success', 'Report successfully submitted.');
}



public function index()
{
    // Get the logged-in user
    $user = Auth::user();

    // Fetch reports only for the logged-in user
    $reports = DailyReport::where('employee_id', $user->id)->get();

    return view('daily_reports.index', compact('reports'));
}


    public function edit($id)
    {
        $report = DailyReport::findOrFail($id);
        return view('daily_reports.edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['report' => 'required|string']);

        $report = DailyReport::findOrFail($id);
        $report->report = strip_tags($request->report, '<b><i><strong><em><u>');
        $report->save();

        return redirect()->route('daily_reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy($id)
    {
        $report = DailyReport::findOrFail($id);
        $report->delete();

        return redirect()->route('daily_reports.index')->with('success', 'Report deleted successfully.');
    }
}
