@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Update Staff</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Form --}}
            <form id="staffForm" action="{{ route('staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Basic Information --}}
                <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                <div class="row g-2 mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Staff Id</label>
                        <input type="text" name="staff_id" class="form-control form-control-sm" value="{{ $staff->staff_id }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control form-control-sm" value="{{ $staff->first_name }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control form-control-sm" value="{{ $staff->middle_name }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control form-control-sm" value="{{ $staff->last_name }}">
                    </div>
                </div>

                {{-- Employment Details --}}
                <h5 class="mt-3 mb-2 border-bottom pb-2">Employment Details</h5>
                <div class="row g-2 mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select form-select-sm">
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}" {{ $staff->department_id==$d->id?'selected':'' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select form-select-sm">
                            <option value="Male" {{ $staff->gender=='Male'?'selected':'' }}>Male</option>
                            <option value="Female" {{ $staff->gender=='Female'?'selected':'' }}>Female</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="Active" {{ $staff->status=='Active'?'selected':'' }}>Active</option>
                            <option value="NoActive" {{ $staff->status=='NoActive'?'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hire Date</label>
                        <input type="date" name="hire_date" class="form-control form-control-sm" value="{{ $staff->hire_date }}">
                    </div>
                </div>

                {{-- Personal Details --}}
                <h5 class="mt-3 mb-2 border-bottom pb-2">Personal Details</h5>
                <div class="row g-2 mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control form-control-sm" value="{{ $staff->date_of_birth }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control form-control-sm" value="{{ $staff->phone }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control form-control-sm" value="{{ $staff->address }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control form-control-sm">
                        @if($staff->photo)
                            <img src="{{ asset('storage/'.$staff->photo) }}" class="rounded mt-1" width="70">
                        @endif
                    </div>
                </div>

                {{-- Professional Info --}}
                <h5 class="mt-3 mb-2 border-bottom pb-2">Professional Info</h5>
                <div class="row g-2 mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Salary</label>
                        <input type="number" step="0.01" name="salary" class="form-control form-control-sm" value="{{ $staff->salary }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="qualification" class="form-control form-control-sm" value="{{ $staff->qualification }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control form-control-sm" value="{{ $staff->specialization }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">License Number</label>
                        <input type="text" name="license_number" class="form-control form-control-sm" value="{{ $staff->license_number }}">
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="mt-3 text-end">
                    <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                    <button type="submit" class="btn btn-dark btn-sm saveBtn">Update Staff</button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
$(document).ready(function(){
    $(document).on('click', '.saveBtn', function(e){
        e.preventDefault();
        let form = $('#staffForm')[0];
        let formData = new FormData(form);
        let btn = $(this);
        btn.prop('disabled', true).text('Updating...');

        $.ajax({
            url: $(form).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                btn.prop('disabled', false).text('Update Staff');
                Swal.fire({
                    toast:true,
                    position:'top-right',
                    title:'Success!',
                    text: response.success,
                    icon:'success',
                    timer:3000,
                    showConfirmButton:false
                });
            },
            error: function(xhr){
                btn.prop('disabled', false).text('Update Staff');
                if(xhr.status===422){
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors,function(k,v){ errorHtml+='<li>'+v[0]+'</li>'; });
                    errorHtml+='</ul></div>';
                    $('.card-body').prepend(errorHtml);
                }else{
                    alert('Something went wrong.');
                }
            }
        });
    });
});
</script>
@endsection