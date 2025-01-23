<!-- Dept Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dept_name', 'Dept Name:') !!}
    {!! Form::text('dept_name', $department->dept_name ?? null, ['class' => 'form-control', 'maxlength' => 100]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', $department->description ?? null, ['class' => 'form-control', 'maxlength' => 65535]) !!}
</div>

<!-- Head of Department Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employee_id', 'Head of Department:') !!}
    {!! Form::select('employee_id', $employees, $department->head_id ?? null, ['class' => 'form-control', 'placeholder' => 'Select Head of Department']) !!}
</div>
