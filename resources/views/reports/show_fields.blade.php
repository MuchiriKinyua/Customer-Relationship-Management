<!-- Department Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('department_name', 'Department Name:') !!}
    {!! Form::select('department_id', $departments, null, ['class' => 'form-control', 'placeholder' => 'Select Department']) !!}
</div>

<!-- Employee Name Field -->
<div class="col-sm-12">
    {!! Form::label('employee_name', 'Employee Name:') !!}
    <p>{{ $report->employee_name ?? 'N/A' }}</p>
</div>

<!-- Monday Field -->
<div class="col-sm-12">
    {!! Form::label('monday', 'Monday:') !!}
    <p>{{ $report->monday ?? 'N/A' }}</p>
</div>

<!-- Tuesday Field -->
<div class="col-sm-12">
    {!! Form::label('tuesday', 'Tuesday:') !!}
    <p>{{ $report->tuesday ?? 'N/A' }}</p>
</div>

<!-- Wednesday Field -->
<div class="col-sm-12">
    {!! Form::label('wednesday', 'Wednesday:') !!}
    <p>{{ $report->wednesday ?? 'N/A' }}</p>
</div>

<!-- Thursday Field -->
<div class="col-sm-12">
    {!! Form::label('thursday', 'Thursday:') !!}
    <p>{{ $report->thursday ?? 'N/A' }}</p>
</div>

<!-- Friday Field -->
<div class="col-sm-12">
    {!! Form::label('friday', 'Friday:') !!}
    <p>{{ $report->friday ?? 'N/A' }}</p>
</div>

<!-- Summary Field -->
<div class="col-sm-12">
    {!! Form::label('summary', 'Summary:') !!}
    <p>{{ $report->summary ?? 'N/A' }}</p>
</div>
