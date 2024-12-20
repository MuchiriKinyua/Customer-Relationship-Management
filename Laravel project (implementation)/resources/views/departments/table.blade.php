<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="departments-table">
            <thead>
            <tr>
                <th>Dept Name</th>
                <th>Description</th>
                <th>Head of Department</th> <!-- Added this column -->
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->dept_name }}</td>
                    <td>{{ $department->description }}</td>
                    <td>
                        {{ $department->head->full_name ?? 'Not Assigned' }} <!-- Display head or 'Not Assigned' -->
                    </td>
                    <td style="width: 120px">
                        {!! Form::open(['route' => ['departments.destroy', $department->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('departments.show', [$department->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('departments.edit', [$department->id]) }}"
                               class='btn btn-default btn-xs'>
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
            @include('adminlte-templates::common.paginate', ['records' => $departments])
        </div>
    </div>
</div>
