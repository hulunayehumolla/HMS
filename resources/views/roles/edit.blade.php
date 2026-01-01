@extends('layouts.app')

@section('content')
<style type="text/css">
    /* Optional: style for indeterminate state */
input[type="checkbox"]:indeterminate {
    background-color: #f0ad4e; /* or any color you prefer */
}

.parent-checkbox {
    border-color: #0b4572;
    width: 17px;
    height: 17px;
}
.child-checkbox{
    border-color: #298797;
}




</style>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
            <div class="card-header form-header col-sm-12 d-flex justify-content-between align-items-center">
                <a href="{{ route('roles.index') }}" class="back-link">&larr; Back</a>
                <span class="ms-auto">Edit Roles by checking permissions</span>
            </div>

                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Role Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ $role->name }}" readonly>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mb-2">List of Permissions(Tasks)</h5>
                     <div class="col-sm-12 row">
                      @foreach ($groupedPermissions as $group => $permissions)
                        <div class="col-sm-6 border rounded p-3  mt-3">
                            <!-- Parent Checkbox -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input parent-checkbox" 
                                    id="group-{{ $loop->index }}">
                                <label class="form-check-label fw-bold" 
                                    for="group-{{ $loop->index }}"><u>{{ $group }} </u></label>
                            </div>

                            <!-- Child Checkboxes -->
                            <div class="ps-4">
                                @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input child-checkbox group-group-{{ $loop->parent->index }}" 
                                        id="permission-{{ $permission->id }}" 
                                        name="permissions[]" 
                                        value="{{ $permission->id }}" 
                                        data-parent="group-{{ $loop->parent->index }}"
                                        {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" 
                                        for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    </div>


                        <div class="mb-3 row mt-4">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Update Role</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to update the parent checkbox state based on the children
    function updateParentCheckboxState(parentCheckbox, groupClass) {
        const allChecked = document.querySelectorAll(`${groupClass}:checked`).length === document.querySelectorAll(groupClass).length;
        const someChecked = document.querySelectorAll(`${groupClass}:checked`).length > 0;

        // Set parent checkbox to checked or indeterminate based on the children
        parentCheckbox.checked = allChecked;
        parentCheckbox.indeterminate = !allChecked && someChecked;
    }

    // Handle parent checkbox toggle
    document.querySelectorAll('.parent-checkbox').forEach(function (parentCheckbox) {
        parentCheckbox.addEventListener('change', function () {
            const groupClass = `.group-${parentCheckbox.id}`;
            const isChecked = parentCheckbox.checked;

            // Toggle all child checkboxes in the group
            document.querySelectorAll(groupClass).forEach(function (childCheckbox) {
                childCheckbox.checked = isChecked;
            });

            // Update parent state
            updateParentCheckboxState(parentCheckbox, groupClass);
        });

        // Update parent checkbox state on page load
        const groupClass = `.group-${parentCheckbox.id}`;
        updateParentCheckboxState(parentCheckbox, groupClass);
    });

    // Handle child checkbox toggle
    document.querySelectorAll('.child-checkbox').forEach(function (childCheckbox) {
        childCheckbox.addEventListener('change', function () {
            const parentId = childCheckbox.dataset.parent;
            const parentCheckbox = document.getElementById(parentId);
            const groupClass = `.group-${parentId}`;

            // Check if all children are checked
            const allChecked = document.querySelectorAll(`${groupClass}:checked`).length === document.querySelectorAll(groupClass).length;
            const someChecked = document.querySelectorAll(`${groupClass}:checked`).length > 0;

            // Check parent checkbox if all children are checked
            parentCheckbox.checked = allChecked;

            // Apply half-checked state if some but not all children are checked
            parentCheckbox.indeterminate = !allChecked && someChecked;

            // Uncheck parent checkbox if any child is unchecked
            if (!allChecked) {
                parentCheckbox.checked = false;
            }

            // Update parent state
            updateParentCheckboxState(parentCheckbox, groupClass);
        });
    });
});


</script>
@endsection
