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


    <div class="card-header">Manage Users</div>
    <div class="card-body">
        @can('create-user')
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New User</a>
        @endcan
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col">Id</th>
                <th scope="col">Full name</th>
                <th scope="col">Username</th>
                <th scope="col">Roles</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->user_Fname }} {{ $user->user_Mname }}</td>
                    <td>{{ $user->username }}</td>
                    <td>

                      <ul class="list-unstyled">
                        @forelse ($user->getRoleNames() as $role)
                            <li class="mb-2">
                                <span class="fw-bold " style="color: #0e4991;" >{{ $role }}</span> <!-- Bold and primary color -->
                            </li>
                         @empty
                             <li class="text-muted">No roles assigned to this user.</li>
                          @endforelse
                      </ul>
                    </td>
                    <td>
                        @if($user->status==1)
                        <i class="fa-solid fa-square-check fa-xl" style="color: #036168;"></i>
                        @else
                        <i class="fa-solid fa-square-xmark fa-xl" style="color: #cd440a;"></i>
                        @endif

                       </td>
                    <td>
                     <form action="{{ route('users.destroy', $user->id) }}" method="post" id="delete-form-{{ $user->id }}">
                        @csrf
                        @method('DELETE')

                        @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                            @if (Auth::user()->hasRole('Super Admin'))
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endif
                        @else
                            @can('edit-user-status')
                                @if($user->status == 1)
                                    <button type="button" class="btn btn-primary btn-sm" onclick="updateUserStatus(event, {{ $user->id }}, 0)" > 
                                        <i class="fa fa-user-slash fa-xl"></i> Disable
                                    </button>
                                @else
                                  <button type="button" class="btn btn-info btn-sm" onclick="updateUserStatus(event, {{ $user->id }}, 1)">
                                        <i class="fa fa-user-check fa-xl"></i> Enable
                                    </button>
                                @endif
                            @endcan
                            @can('edit-user-role')
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-user-shield fa-xl"></i> Role</a> 
                            @endcan
                            @can('edit-user')
                                <a href="{{ route('users.changePassword', $user->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-key"></i> Password</a>   
                            @endcan
                            @can('delete-user')
                                @if (Auth::user()->id!=$user->id)
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this user?');"><i class="bi bi-trash"></i> Delete</button>
                                @endif
                            @endcan
                        @endif

                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="5">
                        <span class="text-danger">
                            <strong>No User Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>

       

    </div>
</div>
    <script>
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


     function updateUserStatus(event, userId, currentStatus) {
            // Prevent the form from submitting if the button is inside a form
            //event.preventDefault();
            // Confirm before proceeding with the status change
            //if (confirm('Are you sure you want to change the status of this user?')) {
                $.ajax({
                    url: '{{ route('users.updateUserStatus', ':id') }}'.replace(':id', userId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: currentStatus
                    },
                    success: function(response) {
                        // Handle success response
                        if (response.success) {
                            // Update the button text and color based on new status
                            let button = $('button[onclick="updateUserStatus(event,' + userId + ',' + currentStatus + ')"]');
                            if (currentStatus === 1) {
                                button.html('Disable');
                                button.removeClass('btn-danger').addClass('btn-primary');
                            } else {
                                button.html('Enable');
                                button.removeClass('btn-primary').addClass('btn-danger');
                            }
                            // Show success message
                             window.location.reload();
                        } else {
                            // Show error message
                            $('#toast-container').html('<div class="alert alert-danger">Error updating user status!</div>');
                        }
                    },
                    error: function() {
                        // Handle AJAX error
                        $('#toast-container').html('<div class="alert alert-danger">An error occurred. Please try again later.</div>');
                    }
                });
            }
        //}



    </script>


@endsection