<!-- Dept Name Field -->
<div class="col-sm-12">
    {!! Form::label('dept_name', 'Dept Name:') !!}
    <p>{{ $department->dept_name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $department->description }}</p>
</div>

<!-- Head of Department Field -->
<div class="col-sm-12">
    {!! Form::label('head_of_department', 'Head of Department:') !!}
    <p>{{ $department->head->full_name ?? 'Not Assigned' }}</p>
</div>
