<!-- Lead Full Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lead_full_name', 'Full Name:') !!}
    {!! Form::text('lead_full_name', isset($lead) ? $lead->full_name : null,  ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Enter lead name', 'readonly' => isset($lead)]) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    <select name="type" id="type" class="form-control">
        <option value="">Select Type</option>
        <option value="Lead" {{ isset($lead) ? 'selected' : '' }}>Lead</option>
        <option value="Client" {{ isset($client) ? 'selected' : '' }}>Client</option>
    </select>
</div>

<!-- Employee Field -->
<div class="form-group">
    <label for="employee_id">Employee</label>
    <select name="employee_id" id="employee_id" class="form-control">
        <option value="">Select Employee</option>
        @foreach ($employees as $employee)
            <option value="{{ $employee->id }}" 
                {{ old('employee_id', isset($interaction) ? $interaction->employee_id : '') == $employee->id ? 'selected' : '' }}>
                {{ $employee->first_name }} {{ $employee->last_name }}
            </option>
        @endforeach
    </select>
</div>




<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'maxlength' => 65535]) !!}
</div>

<!-- Interaction Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interactions_date', 'Interactions Date:') !!}
    {!! Form::date('interactions_date', null, ['class' => 'form-control', 'id' => 'interactions_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#interactions_date').datepicker();
    </script>
@endpush

@if(isset($lead))
    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
@endif

@if(isset($client))
    <input type="hidden" name="client_id" value="{{ $client->id }}">
@endif
