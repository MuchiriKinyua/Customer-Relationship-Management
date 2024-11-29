<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Full Name</th>
                   <!-- <th>Last Name</th>-->
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Department</th>
                    <th>Report</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $employee)
                    <tr>
                        <td>{{ $employee->full_name }}</td>
                       <!-- <td>{{ $employee->last_name }}</td>-->
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone_number }}</td>
                        <td>{{ $employee->department->dept_name ?? 'No Department' }}</td>
                        <td>
                            <!-- Add Report Button -->
                            <a href="{{ route('daily_reports.create', ['employeeId' => $employee->id]) }}" class="btn btn-primary btn-xs">Add Report</a>

                            <!-- View Report Button -->
                            <a href="{{ route('daily_reports.view', ['employeeId' => $employee->id, 'dayIndex' => 0]) }}" class="btn btn-info btn-xs">View Report</a>

                            @if($employee->dailyReports->isNotEmpty())
                                @foreach ($employee->dailyReports as $report)
                                    @if ($report->is_submitted)
                                        <!-- If Report is Submitted, Only View Option -->
                                        <span>Report Submitted</span>
                                    @else
                                        <!-- If Report is Draft, Show Submit Option -->
                                        <form action="{{ route('daily_reports.submit', ['daily_report' => $report->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-xs" onclick="return confirm('Are you sure you want to submit this report?')">
                                                Submit Report
                                            </button>
                                        </form>
                                        <!-- Edit Report Button -->
                                        <a href="{{ route('daily_reports.edit', ['daily_report' => $report->id]) }}" class="btn btn-warning btn-xs">Edit Report</a>
                                        <!-- Delete Report Button -->
                                        <form action="{{ route('daily_reports.destroy', $report->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this report?')">
                                                Delete Report
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            @endif
                        </td>

                        <td>
                            <!-- Action Buttons -->
                            <div class='btn-group'>
                                <a href="{{ route('employees.show', $employee->id) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('employees.edit', $employee->id) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card-footer clearfix">
    {{ $employees->links() }}
</div>
