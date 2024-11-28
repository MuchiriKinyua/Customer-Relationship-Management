@extends('layouts.app')

@section('content')
<script src="https://cdn.tiny.cloud/1/szmzegr123rg6numlp7htb51kriozngu1ykd031wqhloty9p/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Edit Daily Report for Employee</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('adminlte-templates::common.errors')

    <div class="card">
        {!! Form::model($dailyReport, ['route' => ['daily_reports.update', $dailyReport->id], 'method' => 'patch']) !!}
        @csrf

        <div class="card-body">
            <!-- Display Current Day (Non-editable) -->
            <div class="form-group">
                {!! Form::label('day', 'Today:') !!}
                <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->format('l') }}" disabled>
            </div>

            <!-- Report Field -->
            <div class="form-group">
                {!! Form::label('report', 'Report:') !!}
                {!! Form::textarea('report', old('report', $dailyReport->report), ['class' => 'form-control', 'id' => 'report-editor']) !!}
                @if($errors->has('report'))
                    <small class="text-danger">{{ $errors->first('report') }}</small>
                @endif
            </div>

            <!-- TinyMCE Setup -->
            <script>
              tinymce.init({
                selector: '#report-editor',
                plugins: [
                  'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                  'checklist', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'advtable'
                ],
                toolbar: 'undo redo | bold italic underline | numlist bullist | align | link image | removeformat',
                valid_elements: '*[*]',  // This allows all elements (but you can limit to a whitelist of elements like <b>, <i>, etc.)
                // Optional: to clean up content before saving
                remove_linebreaks: true,
                extended_valid_elements: "strong,em,b,i,u,p,a[href],br,img[src|alt]",
                // Allow TinyMCE to save the content with styles
                content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
              });
            </script>

            <!-- Report Date Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('report_date', 'Report Date:') !!}
                {!! Form::date('report_date', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'id' => 'report_date', 'disabled' => 'disabled']) !!}
            </div>

        </div>

        <div class="card-footer">
            {!! Form::submit('Update Report', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('employees.index') }}" class="btn btn-default">Cancel</a>
        </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection
