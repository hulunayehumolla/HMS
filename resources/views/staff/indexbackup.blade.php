@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Dashboard Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-lg h-100" style="background: #1a1a1a; border-top: 4px solid #d4af37;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-light"><i class="fa-solid fa-users me-2"></i>Total Staff</h5>
                    <h3 class="fw-bold text-white">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-lg h-100" style="background: #062c21;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-white"><i class="fa-solid fa-user-check me-2"></i>Active Staff</h5>
                    <h3 class="fw-bold text-white">{{ $stats['active'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-lg h-100" style="background: #334155;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-white"><i class="fa-solid fa-user-xmark me-2"></i>Inactive Staff</h5>
                    <h3 class="fw-bold text-white">{{ $stats['inactive'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtering --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body bg-light rounded">
            <form action="{{ route('staff.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Department</label>
                    <select name="department_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Departments</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}" {{ request('department_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Status</label>
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="NoActive" {{ request('status') == 'NoActive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Staff Button --}}
  <!--    <div class="mb-3 text-end">
            <a href="{{ route('staff.create') }}" class="btn btn-success" target="_blank">
                Add Staff
            </a>
        </div> -->

 <!--    <div class="mb-3 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createStaffModal">
            <i class="fa-solid fa-plus text-white"></i> Add Staff
        </button>
    </div> -->

    {{-- Staff Table --}}
    <table class="table table-bordered table-hover align-middle" id="staffTable">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Staff Code</th>
                <th>Name</th>
                <th>Department</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $s)
                <tr id="staffRow{{ $s->id }}">
                    <td>{{ $loop->iteration + ($staffs->currentPage() - 1) * $staffs->perPage() }}</td>
                    <td>
                        @if($s->photo)
                            <img src="{{ asset('storage/'.$s->photo) }}" class="img-thumbnail" style="width:50px;height:50px;object-fit:cover;cursor:pointer;" onclick="openPhotoModal('{{ asset('storage/'.$s->photo) }}')">
                        @else
                            <span class="text-muted">No photo</span>
                        @endif
                    </td>
                    <td>{{ $s->staff_code }}</td>
                    <td>{{ $s->first_name }} {{ $s->middle_name }} {{ $s->last_name }}</td>
                    <td>{{ $s->department->name ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $s->status == 'Active' ? 'success' : 'danger' }}">{{ $s->status }}</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                            <a class="dropdown-item " target="_blank" href="{{ route('staff.edit', $s->id) }}">
                                        <i class="fa-solid fa-pen-to-square me-2"></i> Update
                                    </a>
                                </li>
                    <li>
                 <button class="dropdown-item text-danger deleteBtn" data-url="{{ route('staff.destroy', $s) }}">
                                    <i class="fa-solid fa-trash-can me-2"></i> Delete
                                </button>
                            </li>
<!--                             <li>
                            <button type="button" class="dropdown-item text-danger deleteBtn" data-id="{{ $s->id }}">
                            <i class="fa-solid fa-trash me-2"></i> Delete
                        </button>
                    </li> -->
                                                </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

<!--     <div class="mt-3">
        {{ $staffs->links() }}
    </div> -->
</div>





{{-- Scripts --}}
<script>
function openPhotoModal(src) {
    document.getElementById('modalPhoto').src = src;
    new bootstrap.Modal(document.getElementById('photoModal')).show();
}

function previewStaffPhoto(input) {
    const container = document.getElementById('photoPreviewContainer');
    container.innerHTML = '';
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function(e){
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.objectFit = 'cover';
            img.className = 'img-thumbnail';
            container.appendChild(img);
        }
        reader.readAsDataURL(input.files[0]);
    }
}



document.addEventListener('click', function(e){
    if(!e.target.classList.contains('deleteBtn')) return;

    let button = e.target;
    let url = button.dataset.url;

    Swal.fire({
        title:'Are you sure?',
        text:'Your account will be permanently deleted!',
        toast:true,
        position:'top-right',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#d33',
        cancelButtonColor:'#6c757d',
        confirmButtonText:'Yes, delete!',
        cancelButtonText:'Cancel'
    }).then(result=>{
        if(!result.isConfirmed) return;

        button.disabled=true;
        fetch(url,{method:'DELETE', headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}})
        .then(res=>res.json())
        .then(data=>{
            if(data.success){
                Swal.fire('Deleted!', data.message, 'success');
                button.closest('tr').remove();
            } else {
                throw new Error(data.message);
            }
        })
        .catch(()=>{Swal.fire('Error','Failed to delete','error'); button.disabled=false;});
    });
});
// Initialize DataTable
$(document).ready(function(){
    new DataTable('#staffTable', { lengthMenu:[[5,10,25,50,-1],[5,10,25,50,'All']] });
});
</script>
@endsection