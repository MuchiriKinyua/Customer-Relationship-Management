<!-- Employee Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employee_name', 'Employee Name:') !!}
    {!! Form::text('employee_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Employee Name']) !!}
</div>

<!-- Monday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('monday', 'Monday:') !!}
    {!! Form::textarea('monday', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Enter Monday Report']) !!}
</div>

<!-- Tuesday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tuesday', 'Tuesday:') !!}
    {!! Form::textarea('tuesday', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Enter Tuesday Report']) !!}
</div>

<!-- Wednesday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('wednesday', 'Wednesday:') !!}
    {!! Form::textarea('wednesday', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Enter Wednesday Report']) !!}
</div>

<!-- Thursday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('thursday', 'Thursday:') !!}
    {!! Form::textarea('thursday', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Enter Thursday Report']) !!}
</div>

<!-- Friday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('friday', 'Friday:') !!}
    {!! Form::textarea('friday', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Enter Friday Report']) !!}
</div>

<!-- Summary Field -->
<div class="form-group col-sm-6">
    {!! Form::label('summary', 'Summary:') !!}
    {!! Form::textarea('summary', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Enter Weekly Summary']) !!}
</div>
