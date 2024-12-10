<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="reports-table">
            <thead>
                <tr>
                    <th class="filterable department-column">Department Name</th>
                    <th class="filterable employee-column">Employee Name</th>
                    <th class="filterable monday-column">
                        Monday<br>{{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }}
                    </th>
                    <th class="filterable tuesday-column">
                        Tuesday<br>{{ \Carbon\Carbon::now()->startOfWeek()->addDay()->format('d/m/Y') }}
                    </th>
                    <th class="filterable wednesday-column">
                        Wednesday<br>{{ \Carbon\Carbon::now()->startOfWeek()->addDays(2)->format('d/m/Y') }}
                    </th>
                    <th class="filterable thursday-column">
                        Thursday<br>{{ \Carbon\Carbon::now()->startOfWeek()->addDays(3)->format('d/m/Y') }}
                    </th>
                    <th class="filterable friday-column">
                        Friday<br>{{ \Carbon\Carbon::now()->startOfWeek()->addDays(4)->format('d/m/Y') }}
                    </th>
                    <th class="filterable summary-column">Summary</th>
                    <th>Actions</th> <!-- Always visible -->
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                    <td class="filterable employee-column">
                            <!-- Dynamically fetch the employee name -->
                            {{ $report->employee->full_name ?? 'N/A' }}
                    </td>
                        <td class="filterable department-column">
                            {{ $report->department->dept_name ?? 'N/A' }}
                        </td>
                        <td class="filterable monday-column">
                            {{ $report->monday ?? 'N/A' }}
                        </td>
                        <td class="filterable tuesday-column">
                            {{ $report->tuesday ?? 'N/A' }}
                        </td>
                        <td class="filterable wednesday-column">
                            {{ $report->wednesday ?? 'N/A' }}
                        </td>
                        <td class="filterable thursday-column">
                            {{ $report->thursday ?? 'N/A' }}
                        </td>
                        <td class="filterable friday-column">
                            {{ $report->friday ?? 'N/A' }}
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
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $reports])
        </div>
    </div>
</div>
