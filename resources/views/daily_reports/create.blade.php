@extends('layouts.app')

@section('content')
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/szmzegr123rg6numlp7htb51kriozngu1ykd031wqhloty9p/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Daily Report for Employee</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card">
            {!! Form::open(['route' => 'daily_reports.store']) !!}
            @csrf

            <div class="card-body">
                <!-- Employee ID (hidden) -->
                {!! Form::hidden('employee_id', $employee->id) !!}

                <!-- Display Current Day (Non-editable) -->
                <div class="form-group">
                    {!! Form::label('day', 'Today:') !!}
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->format('l') }}" disabled>
                </div>

<!-- Report Field -->
<div class="form-group">
    {!! Form::label('report', 'Report:') !!}
    <!-- Use a rich text editor for this field -->
    {!! Form::textarea('report', old('report', $existingReport->report ?? ''), ['class' => 'form-control', 'id' => 'report-editor']) !!}
    @if($errors->has('report'))
        <small class="text-danger">{{ $errors->first('report') }}</small>
    @endif
</div>



<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Dec 12, 2024:
      'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown',
      // Early access to document converters
      'importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    exportpdf_converter_options: { 'format': 'Letter', 'margin_top': '1in', 'margin_right': '1in', 'margin_bottom': '1in', 'margin_left': '1in' },
    exportword_converter_options: { 'document': { 'size': 'Letter' } },
    importword_converter_options: { 'formatting': { 'styles': 'inline', 'resets': 'inline',	'defaults': 'inline', } },
  });
</script>


                <!-- Report Date Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('report_date', 'Report Date:') !!}
                    {!! Form::date('report_date', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'id' => 'report_date', 'disabled' => 'disabled']) !!}
                </div>




            <div class="card-footer">
                {!! Form::submit('Save Report', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('employees.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
