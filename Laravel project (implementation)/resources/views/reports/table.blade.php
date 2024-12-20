<div class="card-body p-0">


    <div class="table-responsive">
        <table class="table" id="reports-table">
            <thead>
                <tr>
                    <th class="filterable department-column">Department Name</th>
                    <th class="filterable employee-column">Employee Name</th>
                    <th class="filterable {{ $selectedDay }}-column">
                        {{ ucfirst($selectedDay) }}<br>
                        {{ \Carbon\Carbon::now()->startOfWeek()->addDays(array_search($selectedDay, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']))->format('d/m/Y') }}
                    </th>
                    <th class="filterable summary-column">Summary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td class="filterable department-column">
                            {{ $report->employee->department->dept_name ?? 'N/A' }}
                        </td>
                        
                        <td class="filterable employee-column">
                            {{ $report->employee->full_name ?? 'N/A' }}
                        </td>
                        
                        <td class="filterable {{ $selectedDay }}-column">
                            {{ $report->$selectedDay ?? 'N/A' }}
                        </td>
                        
                        <td class="filterable summary-column">
                            {{ $report->summary ?? 'N/A' }}
                        </td>
                        
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['reports.destroy', $report->id], 'method' => 'delete']) !!}
                            <div class="btn-group">
                                <a href="{{ route('reports.show', [$report->id]) }}" class="btn btn-default btn-xs">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('reports.edit', [$report->id]) }}" class="btn btn-default btn-xs">
                                    <i class="far fa-edit"></i>
                                </a>
                                {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No reports found for {{ ucfirst($selectedDay) }}.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $reports->links() }}
        </div>
    </div>
</div>
