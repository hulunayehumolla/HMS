@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Stats Cards --}}
   
      {{-- Dashboard Cards --}}
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['label'=>'Total Department','value'=>$stats['total'],'icon'=>'fa-users','bg'=>'bg-dark text-white'],
                ['label'=>'Active Department','value'=>$stats['active'],'icon'=>'fa-user-check','bg'=>'bg-success text-white'],
                ['label'=>'Inactive Department','value'=>$stats['inactive'],'icon'=>'fa-user-xmark','bg'=>'bg-danger text-white'],
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

    {{-- Add Department Button --}}
    <div class="mb-3 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createDepartmentModal">
            <i class="fa-solid fa-plus"></i> Add Department
        </button>
    </div>

    {{-- Departments Table --}}
    <table class="table table-bordered table-hover align-middle" id="departments">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
            <tr>
                <td>{{ $loop->iteration + ($departments->currentPage() - 1) * $departments->perPage() }}</td>
                <td>{{ $department->name }}</td>
                <td>{{ $department->description }}</td>
                <td>
                    <span class="badge bg-{{ $department->status ? 'success' : 'danger' }}">
                        {{ $department->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm border px-3" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button class="dropdown-item text-danger btn-delete-department" data-url="{{ route('departments.destroy', $department) }}">
                                    <i class="fa-solid fa-trash-can me-2"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $departments->links() }}

</div>

{{-- Create Department Modal --}}
<div class="modal fade" id="createDepartmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Department</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="createDepartmentForm" method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Department</button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- JS --}}
<script>
$(document).ready(function(){
    new DataTable('#departments', {lengthMenu:[[5,10,25,50,-1],[5,10,25,50,'All']]});
});

document.addEventListener('click', function(e){
    if(!e.target.classList.contains('btn-delete-department')) return;

    let button = e.target;
    let url = button.dataset.url;

    Swal.fire({
        title:'Are you sure?',
        text:'Department will be permanently deleted!',
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

// AJAX form submit
$('#createDepartmentForm').submit(function(e){
    e.preventDefault();
    let form = this;
    let btn = form.querySelector('button[type="submit"]');
    btn.disabled=true; btn.innerText='Saving...';

    fetch(form.action,{
        method:'POST',
        headers:{'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
        body:new FormData(form)
    }).then(res=>res.json()).then(data=>{
        btn.disabled=false; btn.innerText='Save Department';
        if(data.success){
            bootstrap.Modal.getInstance(document.getElementById('createDepartmentModal')).hide();
            form.reset();
            window.location.reload();
        }else{
            alert(data.message || 'Something went wrong');
        }
    }).catch(()=>{btn.disabled=false; btn.innerText='Save Department'; alert('Server error');});
});
</script>
@endsection
