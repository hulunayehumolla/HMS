@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Dashboard Cards --}}
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['label'=>'Total Staff','value'=>$stats['total'],'icon'=>'fa-users','bg'=>'bg-dark text-white'],
                ['label'=>'Active Staff','value'=>$stats['active'],'icon'=>'fa-user-check','bg'=>'bg-success text-white'],
                ['label'=>'Inactive Staff','value'=>$stats['inactive'],'icon'=>'fa-user-xmark','bg'=>'bg-danger text-white'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3 px-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box {{ $card['bg'] }} me-3">
                            <i class="fa-solid {{ $card['icon'] }}"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">{{ $card['label'] }}</small>
                            <h5 class="fw-bold mb-0 {{ $card['bg']=='bg-success text-white' ? 'text-success' : ($card['bg']=='bg-danger text-white' ? 'text-danger':'') }}">{{ $card['value'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <style>
        .icon-box {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    {{-- Staff Form & Tabs --}}
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Messages --}}
            @foreach (['success','error'] as $msg)
                @if(session($msg))
                    <div class="alert alert-{{ $msg=='success'?'success':'danger' }} alert-dismissible fade show">
                        {{ session($msg) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            @endforeach

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        <ul class="nav nav-tabs mb-3" id="staffTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal">
                    <i class="fa-solid fa-pills me-1"></i> View Pharmacist
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#employment">
                    <i class="fa-solid fa-user-plus me-1"></i> Add Pharmacist
                </button>
            </li>
        </ul>

            <div class="tab-content">

                {{-- Add Doctor --}}
                <div class="tab-pane fade" id="employment">
                <form id="staffForm" action="{{ route('pharmacist.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ================= BASIC INFO ================= --}}
                    <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                    <div class="row g-2 mb-2">

                        <div class="col-md-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                   class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                   class="form-control form-control-sm" required>
                        </div>

                    </div>

                    {{-- ================= EMPLOYMENT INFO ================= --}}
                    <h5 class="mt-3 mb-2 border-bottom pb-2">Employment Information</h5>
                    <div class="row g-2 mb-2">

                        <div class="col-md-3">
                            <label class="form-label">Department</label>
                            <select name="department_id" class="form-select form-select-sm">
                                <option value="">-- Select --</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}"
                                        {{ old('department_id') == $d->id ? 'selected' : '' }}>
                                        {{ $d->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select form-select-sm" required>
                                <option value="">-- Select --</option>
                                <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
                                <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Employment Type</label>
                            <select name="employment_type" class="form-select form-select-sm">
                                <option value="">-- Select --</option>
                                <option value="Permanent" {{ old('employment_type')=='Permanent'?'selected':'' }}>Permanent</option>
                                <option value="Contract" {{ old('employment_type')=='Contract'?'selected':'' }}>Contract</option>
                                <option value="Temporary" {{ old('employment_type')=='Temporary'?'selected':'' }}>Temporary</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Hire Date</label>
                            <input type="date" name="hire_date"
                                   value="{{ old('hire_date') }}"
                                   class="form-control form-control-sm">
                        </div>

                    </div>

                    {{-- ================= PERSONAL DETAILS ================= --}}
                    <h5 class="mt-3 mb-2 border-bottom pb-2">Personal Details</h5>
                    <div class="row g-2 mb-2">

                        <div class="col-md-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                   value="{{ old('date_of_birth') }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone"
                                   value="{{ old('phone') }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email') }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="Active" {{ old('status')=='Active'?'selected':'' }}>Active</option>
                                <option value="Inactive" {{ old('status')=='Inactive'?'selected':'' }}>Inactive</option>
                            </select>
                        </div>

                    </div>

                    {{-- ================= LOCATION ================= --}}
                    <h5 class="mt-3 mb-2 border-bottom pb-2">Location Information</h5>
                    <div class="row g-2 mb-2">

                        <div class="col-md-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country_name"
                                   value="{{ old('country_name') }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Region</label>
                            <input type="text" name="region_name"
                                   value="{{ old('region_name') }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Zone</label>
                            <input type="text" name="zone_name"
                                   value="{{ old('zone_name') }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Kebele</label>
                            <input type="text" name="kebele_name"
                                   value="{{ old('kebele_name') }}"
                                   class="form-control form-control-sm">
                        </div>

                    </div>

                 

                                     {{-- ================= PROFESSIONAL ================= --}}
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Professional Info</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label class="form-label">Salary</label>
                                    <input type="number" step="0.01" name="salary"
                                           value="{{ old('salary') }}"
                                           class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Qualification</label>
                                    <input type="text" name="qualification"
                                           value="{{ old('qualification') }}"
                                           class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">License Number</label>
                                    <input type="text" name="license_number"
                                           value="{{ old('license_number') }}"
                                           class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Photo</label>
                                    <input type="file" name="photo"
                                           class="form-control"
                                           onchange="previewStaffPhoto(this)">
                                    <div id="photoPreviewContainer" class="mt-2"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <a href="{{ route('pharmacist.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-success  saveBtn btn-sm">Save Pharmacist</button>
                    </div>
                </form>
                </div>

                {{-- View Doctor --}}
                <div class="tab-pane show active fade" id="personal">
                    {{-- Filtering --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body bg-light rounded">
                            <form action="{{ route('pharmacist.index') }}" method="GET" class="row g-2 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Department</label>
                                    <select name="department_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="">All Departments</option>
                                        @foreach($departments as $d)
                                            <option value="{{ $d->id }}" {{ request('department_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Status</label>
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="">All Status</option>
                                        <option value="Active" {{ request('status')=='Active'?'selected':'' }}>Active</option>
                                        <option value="NoActive" {{ request('status')=='NoActive'?'selected':'' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('doctor.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fa-solid fa-rotate-left"></i> Reset Filters
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Staff Table --}}
                    <table class="table table-bordered table-hover align-middle" id="staffTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Staff Id</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pharmacists as $s)
                            <tr id="staffRow{{ $s->id }}">
                                <td>{{ $loop->iteration + ($staffs->currentPage()-1)*$staffs->perPage() }}</td>
                                <td>
                                    @if($s->photo)
                                        <img src="{{ asset('storage/'.$s->photo) }}" class="img-thumbnail" style="width:50px;height:50px;object-fit:cover;cursor:pointer;" onclick="openPhotoModal('{{ asset('storage/'.$s->photo) }}')">
                                    @else
                                        <span class="text-muted">No photo</span>
                                    @endif
                                </td>
                                <td>{{ $s->pharmacist_id ?? '-' }}</td>
                                <td>
                                    {{ $s->staff->first_name ?? '-' }} 
                                    {{ $s->staff->middle_name ?? '-' }} 
                                    {{ $s->staff->last_name ?? '-' }}
                                </td>
                                <td>{{ $s->staff->department->name ?? '-' }}</td>
                                <td><span class="badge bg-{{ $s->status=='Active'?'success':'danger' }}">{{ $s->status }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">Action</button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" target="_blank" href="{{ route('staff.edit', $s->id) }}"><i class="fa-solid fa-pen-to-square me-2"></i> Update</a></li>
                                            <li><button class="dropdown-item text-danger deleteBtn" data-url="{{ route('staff.destroy',$s) }}"><i class="fa-solid fa-trash-can me-2"></i> Delete</button></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
    // Save Staff via AJAX
    $(document).on('click','.saveBtn',function(e){
        e.preventDefault();
        let btn=$(this), form=$('#staffForm')[0], formData=new FormData(form);
        btn.prop('disabled',true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        $.ajax({
            url:$(form).attr('action'),
            method:'POST',
            data:formData,
            processData:false,
            contentType:false,
            success:function(res){
                btn.prop('disabled',false).text('Save Staff');
                Swal.fire({icon:'success',title:'Success!',text:res.success??'Staff created successfully!',timer:2000,showConfirmButton:false});
               /* setTimeout(()=>window.location.href="{{ route('staff.index') }}",2000);*/
            },
            error:function(xhr){
                btn.prop('disabled',false).text('Save Staff');
                if(xhr.status===422){
                    let msg=''; $.each(xhr.responseJSON.errors,(k,v)=>{msg+=v[0]+'\n';});
                    Swal.fire({icon:'error',title:'Validation Error',text:msg});
                }else Swal.fire('Error','Something went wrong.','error');
            }
        });
    });

    // Delete Staff
    document.addEventListener('click',function(e){
        if(!e.target.classList.contains('deleteBtn')) return;
        let btn=e.target,url=btn.dataset.url;
        Swal.fire({title:'Are you sure?',text:'Your account will be permanently deleted!',toast:true,position:'top-right',icon:'warning',showCancelButton:true,confirmButtonColor:'#d33',cancelButtonColor:'#6c757d',confirmButtonText:'Yes, delete!',cancelButtonText:'Cancel'})
        .then(res=>{
            if(!res.isConfirmed) return;
            btn.disabled=true;
            fetch(url,{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}})
            .then(r=>r.json())
            .then(d=>{
                if(d.success){Swal.fire('Deleted!',d.message,'success');btn.closest('tr').remove();}
                else throw new Error(d.message);
            }).catch(()=>{Swal.fire('Error','Failed to delete','error');btn.disabled=false;});
        });
    });

    // Photo preview
    function previewStaffPhoto(input){
        const container=document.getElementById('photoPreviewContainer'); container.innerHTML='';
        if(input.files && input.files[0]){
            const reader=new FileReader();
            reader.onload=e=>{
                const img=document.createElement('img'); img.src=e.target.result;
                img.style.width='100px'; img.style.height='100px'; img.style.objectFit='cover'; img.className='img-thumbnail';
                container.appendChild(img);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Initialize DataTable
    $(document).ready(()=>new DataTable('#staffTable',{lengthMenu:[[5,10,25,50,-1],[5,10,25,50,'All']]}));
</script>
@endsection