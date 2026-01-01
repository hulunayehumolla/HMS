@extends('layouts.app')

@section('content')
<style>
@keyframes progress-animation {
    from {
        width: 100%;
    }
    to {
        width: 0;
    }
}
.progress-bar {
    width: 100%;
}
/* Narrow the table rows */
#roleTable td {
    padding: 8px 12px;
    font-size: 14px;
}

/* Narrow the action column */
#roleTable th:nth-child(4), #roleTable td:nth-child(4) {
    width: 180px;
    text-align: center;
}

/* Make the collapsible list more compact */
.collapse ul {
    padding-left: 20px;
    list-style-type: none;
}

/* Adding padding and font style to the collapse button */
.collapse button {
    padding: 0;
    font-weight: bold;
}



</style>



 @if (session('success'))
<!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="toast-success" data-bs-autohide="true" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <!-- Optional Progress Bar -->
        <div class="progress" style="height: 4px;">
            <div class="progress-bar bg-info" style="animation: progress-animation 3s linear forwards;"></div>
        </div>
    </div>
</div>
    @endif

<div class="card">
    <div class="card-header">Manage Roles</div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @can('create-role')
                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Add New Role
                </a>
            @endcan
            
            @role('Super Admin')
                <form method="POST" action="{{ route('seed.permissions') }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                        Run Permission Seeder
                    </button>
                </form>
            @endrole
        </div>
<table class="table table-striped table-bordered table-hover" id="roleTable">
    <thead>
        <tr>
            <th scope="col">S#</th>
            <th scope="col" style="max-width:100px;">Role Name</th>
            <th scope="col" class="text-end">Permissions</th>
            <th scope="col" class="text-end">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($roles as $role)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td><span class="fw-bold" style="color: #0e4991;">{{ $role->name }}</span></td>
            <td>
                <!-- Button to toggle permissions list for this role -->

                <button class="btn fw-bold text-light btn-sm toggle-permissions float-end" type="button" data-role-id="{{ $role->id }}" style="background-color: #687b87;">
                    <strong class="text-light"> Show <i class="bi bi-chevron-bar-down bi-xl" id="toggleIcon{{ $role->id }}"></i></strong>
                </button>

                <!-- Collapsible permissions list for the role -->
                <div class="permissions-list mt-3" id="permissions{{ $role->id }}" style="display: none;">
                    <ul class="list-unstyled ps-4">
                        @foreach ($role->permissions as $permission)
                            <li class="d-flex align-items-center mb-2">
                                <i class="bi bi-arrow-right-circle text-primary me-2"></i>
                                <span class="text-dark">{{ $permission->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </td>
            <td class="text-end">
                <!-- Dropdown for actions -->
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown{{ $role->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $role->id }}">
                        @if ($role->name != 'Super Admin')
                            @can('edit-role')
                                <li><a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}"><i class="bi bi-pencil-square"></i> Edit</a></li>
                            @endcan
                            
                            @can('delete-role')
                                @if ($role->name != Auth::user()->hasRole($role->name))
                                    <li>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Do you want to delete this role?');">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            @endcan
                        @endif
                    </ul>
                </div>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="4">
                    <span class="text-danger">
                        <strong>No Role Found!</strong>
                    </span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>







    </div>
</div>

<script>
$(document).ready(function(){

    var table= new DataTable('#roleTable',{
      lengthMenu: [
            [3,5,10, 25, 50, 100,500,-1],
            [3,5,10, 25, 50, 100,500,'All']
           ],
       stateSave:true,
       responsive: true,
      // select: true,
        ordering: true,
       pagingType: 'full_numbers',
     dom: '<"top"f>rt<"bottom"lpi><"clear">',
       

   }); // end of DataTable

  });

    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.display = 'none';
        }
    }, 3000); // 3 seconds

        document.addEventListener('DOMContentLoaded', () => {
            const toastEl = document.getElementById('toast-success');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });



document.addEventListener('DOMContentLoaded', function () {
    // Add event listener for all toggle buttons
    const toggleButtons = document.querySelectorAll('.toggle-permissions');

    toggleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const roleId = this.getAttribute('data-role-id');
            const permissionsList = document.getElementById('permissions' + roleId);
            
            // Toggle visibility of the permissions list
            if (permissionsList.style.display === 'none' || permissionsList.style.display === '') {
                permissionsList.style.display = 'block';
                this.innerHTML = '<strong class="text-light">Hide <i class="bi bi-chevron-bar-up text-light"></i></strong>'; // Change button text
            } else {
                permissionsList.style.display = 'none';
                this.innerHTML = '<strong class="text-light">Show <i class="bi bi-chevron-bar-down toggle-icon text-light"></i></strong>'; // Change button text
            }
        });
    });
});



    </script>
@endsection