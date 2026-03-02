@extends('layouts.app')

@section('content')

<style>
       :root {
       --dt-row-selected: 116, 160, 158;

     }

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
        <div class="progress" style="height: 4px;">
            <div class="progress-bar bg-info" style="animation: progress-animation 3s linear forwards;"></div>
        </div>
    </div>
</div>
@endif

<div class="card vh-100">
<div class="card-header bg-secondary text-white">Manage Users</div>
<div class="card-body overflow-auto">



    <hr class="text-primary">
 @if(isset($users) && !$users->isEmpty())
    <table class="table table-striped table-bordered table-sm" id="userTable" style="font-size: 14px;">
        <thead>
            <tr>
                <th scope="col">S#</th>
                <th scope="col">Username</th>
                <th scope="col">Full name</th>
                <th scope="col">Email</th>
                <th scope="col">Roles</th>
                <th scope="col">Status</th>
                <th scope="col" class="notexport">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $user->username }}</td>
                <td>{{ $user->first_name }} {{ $user->middle_name }}. {{ substr($user->last_name, 0, 1) ?? 'N/A' }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <ul class="list-unstyled">
                        @forelse ($user->getRoleNames() as $role)
                            <li class="mb-2">
                                <span class="fw-bold" style="color: #0e4991;">{{ $role }}</span>
                            </li>
                        @empty
                            <li class="text-muted">No roles assigned to this user.</li>
                        @endforelse
                    </ul>
                </td>
                <td>
                    @if($user->status==1)
                        <i class="fas fa-check-circle  text-success"></i><label class="text-success mx-2">Active</label>
                    @else
                    <i class="fas fa-exclamation-circle text-danger" ></i><label class="text-danger mx-2">In Active</label>
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                            @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []))
                                @if (Auth::user()->hasRole('Super Admin'))
                                    <li><a class="dropdown-item text-secondary fw-bold" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-pen "></i> Edit</a></li>
                                @endif
                            @else
                                @can('edit-user-status')
                                    <li>
                                        @if($user->status == 1)
                                            <button class="dropdown-item text-secondary fw-bold" onclick="updateUserStatus(event, {{ $user->id }}, 0)">
                                                <i class="fa fa-user-slash fa-xl"></i> Disable
                                            </button>
                                        @else
                                            <button class="dropdown-item text-secondary fw-bold" onclick="updateUserStatus(event, {{ $user->id }}, 1)">
                                                <i class="fa fa-user-check fa-xl"></i> Enable
                                            </button>
                                        @endif
                                    </li>
                                @endcan
                                @can('edit-user-role')
                                    <li><a class="dropdown-item text-secondary fw-bold" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-user-shield fa-xl"></i> Edit Role</a></li>
                                @endcan
                                @can('edit-user')
                                    <li><a class="dropdown-item text-secondary fw-bold" href="{{ route('users.changePassword', $user->id) }}"><i class="fa-solid fa-key"></i> Change Password</a></li>
                                @endcan
                                @can('delete-user')
                                    @if (Auth::user()->id != $user->id)
                                        <li>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post" id="delete-form-{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Do you want to delete this user?');">
                                                    <i class="fa fa-trash-can"></i> Delete
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
                <td colspan="7">
                    <span class="text-danger">
                          <p class="text-primary text-center mt-3">No employee found for the selected college and department.</p>
                    </span>
                </td>
            @endforelse
        </tbody>
    </table>
        @else (empty(request('userCollege')) || empty(request('userDepartment')))
            <div class="text-info mt-3">
                <p>Please select both <code>College</code> and <code>Department</code> to view Users.</p>
            </div>
   
         
        @endif

</div>
</div>
<script type="text/javascript">

$(document).ready(function(){

    var table= new DataTable('#userTable',{
      lengthMenu: [
            [5,10, 25, 50, 100,500,-1],
            [5,10, 25, 50, 100,500,'All']
           ],
       stateSave:true,
       responsive: true,
       select: true,
        ordering: true,
       pagingType: 'full_numbers',
     dom: '<"top"Bf>rt<"bottom"lpi><"clear">',
                   /*dom: 'lBfrtip',*/
            columnDefs: [
                {
                    targets: 0, // Index of the serial number column
                    orderable: false, // Disable sorting
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Sequential numbering
                    }
                }
            ],
            buttons: [
                {
                    extend: "collection",
                    className: "btn-Export",
                    text: '<i class="fa-solid fa-file-export fa-lg" style="color: #275a82;"></i>',
                    buttons: [
                        { 
                            extend: "pdf", 
                            filename: 'User List ', 
                            title: '', // Title will be customized below
                            exportOptions: { columns: ':not(.notexport)' },
                            customize: function (doc) {
                                // Add custom title with reduced font size and underlined instructor name
                                doc.content.splice(0, 0, {
                                    text: [
                                        "User List: ",
                                    ],
                                    fontSize: 10, // Set smaller font size
                                    alignment: 'center',
                                    margin: [0, 0, 0, 10] // Add spacing below the title
                                });

                                // Watermark customization with reduced font size and changed angle
                                doc.watermark = { 
                                    text: 'Printed by INU | PerEva systems', // Watermark text
                                    angle: 20,            // Angle of watermark (changed to 45 degrees)
                                    opacity: 0.1,         // Opacity of watermark
                                    fontSize: 8           // Font size of watermark (reduced)
                                };
                            }
                        },
                        { 
                            extend: "excel",
                            filename: 'User List',
                            title: "User List .",
                            exportOptions: { columns: ':not(.notexport)' }
                        },
                        {  
                            extend: "csv", 
                            filename: 'User List', 
                            title: null,
                            exportOptions: { columns: ':not(.notexport)' },
                            customize: function (csv) {
                                const titleRow = `"User List"\n`;
                                return titleRow + csv; // Prepend the title to the CSV content
                            }
                        }
                    ]
                },
                {
                    className: "buttons-print",
                    titleAttr: 'Print data',
                    text: '<i class="fa-solid fa-print fa-lg" style="color: #158cd5;"></i>',
                    extend: 'print',
                    filename: 'User List',
                    title: "User List",
                    exportOptions: { columns: ':not(.notexport)' },
                    customize: function (win) {
                        // Reduce general font size for print
                        $(win.document.body).css('font-size', '14px'); // Global font size
                        $(win.document.body).find('h1').css({
                            'font-size': '18px', // Adjust the font size of the title
                            'text-align': 'center', // Center the title
                            'margin-bottom': '10px' // Add spacing below the title
                        });
                        $(win.document.body).find('table').css({
                            'font-size': '14px', // Reduce table font size
                            'border': '1px solid #000' // Add border to the table
                        });
                    }
                }
            ],
            drawCallback: function(settings) {
                var api = this.api();
                api.column(0, { order: 'applied' }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1; // Update serial number for each row
                });
            }
        }); // end of DataTable


});



document.addEventListener('DOMContentLoaded', () => {
    const toastEl = document.getElementById('toast-success');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
});

function updateUserStatus(event, userId, currentStatus) {
    $.ajax({
        url: '{{ route('users.updateUserStatus', ':id') }}'.replace(':id', userId),
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: currentStatus
        },
        success: function(response) {
            if (response.success) {
                window.location.reload();
            } else {
                alert('Error updating user status!');
            }
        },
        error: function() {
            alert('An error occurred. Please try again later.');
        }
    });
}


//to populate department on userCollege chnages

    $(document).on('change', '.college', function () {
        var collegeId = $(this).val();
        var selectedDepartment = '{{ request("userDepartment") }}'; // Get previously selected department
        var departmentSelect = $('.department');

        // Show loading
        departmentSelect.html('<option value="">Loading...</option>');

        $.ajax({
            url: "{{ route('users.getdepartment') }}",
            method: "POST",
            data: {
                collegeId: collegeId,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                departmentSelect.empty();
                departmentSelect.append('<option value="" disabled>Select department</option>');

                $.each(response.departments, function (index, department) {
                    let selected = department.dept_team_Id == selectedDepartment ? 'selected' : '';
                    departmentSelect.append(
                        '<option value="' + department.dept_team_Id + '" ' + selected + '>' + department.dept_team_Name + '</option>'
                    );
                });
            },
            error: function () {
                alert('Failed to load departments. Please try again.');
            }
        });
    });

    // Also trigger department load on page load if college is already selected
    $(document).ready(function () {
        if ($('.college').val()) {
            $('.college').trigger('change');
        }
    });







</script>

@endsection
