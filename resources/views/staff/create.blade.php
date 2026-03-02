@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Add New Staff</h3>
               </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
           
            <form id="staffForm" action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Basic Information --}}
                <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                <div class="row g-2 mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Staff Code</label>
                        <input type="text" name="staff_code" value="{{ old('staff_code') }}" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control form-control-sm" required>
                    </div>
                </div>

                {{-- Employment Details --}}
                <h5 class="mt-3 mb-2 border-bottom pb-2">Employment Details</h5>
                <div class="row g-2 mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select form-select-sm">
                            <option value="">-- Select --</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select form-select-sm" required>
                            <option value="">-- Select --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select form-select-sm" required>
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="NoActive" {{ old('status') == 'NoActive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hire Date</label>
                        <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="form-control form-control-sm">
                    </div>
                </div>

                {{-- Personal Details --}}
                <h5 class="mt-3 mb-2 border-bottom pb-2">Personal Details</h5>
                <div class="row g-2 mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control form-control-sm">
                    </div>
                </div>

                {{-- Professional Info --}}
                <h5 class="mt-3 mb-2 border-bottom pb-2">Professional Info</h5>
                <div class="row g-2 mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Salary</label>
                        <input type="number" step="0.01" name="salary" value="{{ old('salary') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="qualification" value="{{ old('qualification') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" value="{{ old('specialization') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">License Number</label>
                        <input type="text" name="license_number" value="{{ old('license_number') }}" class="form-control form-control-sm">
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="mt-3 text-end">
                    <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                    <button type="submit" class="btn btn-success btn-sm saveBtn" >Save Staff</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(document).on('click', '.saveBtn', function(e){
        e.preventDefault();

        // 1. Initialize FormData with the form element
        // This automatically captures all inputs, including the file (photo)
        let form = $('#staffForm')[0];
        let formData = new FormData(form);

        // 2. Visual feedback: Disable button to prevent double clicks
        let btn = $(this);
        btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: $(form).attr('action'),
            method: 'POST',
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function(response) {
                // If your controller returns a redirect route or success message

                btn.prop('disabled', false).text('Save Staff');
               
               
                    Swal.fire({
                        toast:true,
                        position:'top-right',
                        title: 'Success!',
                        text: response.success,
                        icon: 'success',
                        timerProgressBar: true,
                        timer: 3000,
                        showConfirmButton: false
                    });
                
                //window.location.href = "{{ route('staff.index') }}";
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Save Staff');
                
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul></div>';
                    
                    // Prepend errors to the card body
                    $('.card-body').prepend(errorHtml);
                } else {
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    });
});
</script>
@endsection
