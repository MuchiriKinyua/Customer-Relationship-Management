@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Role : {{ $role->name }}</h4>
                    <a href="{{ url('roles') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <label for="">Permissions</label>
                            <div class="mb-2">
                                <input type="checkbox" id="selectAll" /> Select All
                                <input type="checkbox" id="selectNone" style="margin-left: 10px;" /> Select None
                            </div>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                <div class="col-md-3">
                                    <label>
                                        <input 
                                            type="checkbox" 
                                            class="permission-checkbox"
                                            name="permission[]" 
                                            value="{{ $permission->name }}" 
                                            {{ ($role->hasPermissionTo($permission->name) || $role->name === 'super-admin') ? 'checked' : '' }}
                                        />
                                        {{ $permission->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<div>
    <input type="checkbox" id="selectAll"> Select All
    <input type="checkbox" id="selectNone" style="margin-left: 10px;"> Select None
    <div>
        <label><input type="checkbox" class="permission-checkbox"> Permission 1</label>
        <label><input type="checkbox" class="permission-checkbox"> Permission 2</label>
        <label><input type="checkbox" class="permission-checkbox"> Permission 3</label>
    </div>
</div>

<script>
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectNoneCheckbox = document.getElementById('selectNone');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

    selectAllCheckbox.addEventListener('change', function() {
        permissionCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        selectNoneCheckbox.checked = false; // Uncheck Select None
    });

    selectNoneCheckbox.addEventListener('change', function() {
        permissionCheckboxes.forEach(checkbox => {
            checkbox.checked = !selectNoneCheckbox.checked;
        });
        selectAllCheckbox.checked = false; // Uncheck Select All
    });
</script>



@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const selectNoneCheckbox = document.getElementById('selectNone');
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            console.log('Select All clicked:', selectAllCheckbox.checked);
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked; // Set each checkbox to match selectAllCheckbox
            });
            selectNoneCheckbox.checked = false; // Uncheck the Select None checkbox
        });

        selectNoneCheckbox.addEventListener('change', function() {
            console.log('Select None clicked:', selectNoneCheckbox.checked);
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = !selectNoneCheckbox.checked; // Uncheck all if Select None is checked
            });
            selectAllCheckbox.checked = false; // Uncheck the Select All checkbox
        });
    });
</script>
@endsection


@endsection
