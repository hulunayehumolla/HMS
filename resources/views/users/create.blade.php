@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add New User</h5>
                <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="userId" class="form-label">User ID</label>
                            <input type="text" class="form-control @error('userId') is-invalid @enderror" id="userId" name="userId" value="{{ old('userId') }}">
                            @error('userId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="userFname" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('userFname') is-invalid @enderror" id="userFname" name="userFname" value="{{ old('userFname') }}">
                            @error('userFname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="userMname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control @error('userMname') is-invalid @enderror" id="userMname" name="userMname" value="{{ old('userMname') }}">
                            @error('userMname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="userLname" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('userLname') is-invalid @enderror" id="userLname" name="userLname" value="{{ old('userLname') }}">
                            @error('userLname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control @error('userEmail') is-invalid @enderror" id="userEmail" name="userEmail" value="{{ old('userEmail') }}">
                            @error('userEmail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label for="college" class="form-label">College</label>
                            <select class="form-select form-select-sm" id="college" name="college">
                                <option value="" disabled selected>Choose College</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->coll_dir_Id }}">{{ $college->coll_dir_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select form-select-sm" id="department" name="department">
                                <option value="" disabled selected>Choose Department</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select form-select-sm" id="type" name="type">
                                <option value="" disabled selected>Choose Type</option>
                                <option value="academic" >Academic</option>
                                <option value="admin" >Admin</option>
                                <!-- Add Type options here -->
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="roles" class="form-label">Roles</label>
                            <select class="form-select @error('roles') is-invalid @enderror" id="roles" name="roles[]" multiple>
                                @forelse ($roles as $role)
                                    @if ($role != 'Super Admin')
                                        <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @else
                                        @if (Auth::user()->hasRole('Super Admin'))
                                            <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endif
                                    @endif
                                @empty
                                    <option disabled>No roles available</option>
                                @endforelse
                            </select>
                            @error('roles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const departments = @json($departments); // All departments grouped by college
        const collegeSelect = document.getElementById('college');
        const departmentSelect = document.getElementById('department');

        collegeSelect.addEventListener('change', function () {
            const selectedCollegeId = this.value;

            // Clear previous options
            departmentSelect.innerHTML = '<option value="" disabled selected>Choose Department</option>';

            // Populate departments for the selected college
            if (departments[selectedCollegeId]) {
                departments[selectedCollegeId].forEach(department => {
                    const option = document.createElement('option');
                    option.value = department.dept_team_Id;
                    option.textContent = department.dept_team_Name;
                    departmentSelect.appendChild(option);
                });
            }
        });
    });
</script>
@endsection
