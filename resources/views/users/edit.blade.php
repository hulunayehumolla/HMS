@extends('layouts.app')

@section('content')
<style>
    /* Custom styling for a visually impressive form */
    .form-container {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: auto;
    }

    .form-header {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #555;
    }

    .form-check {
        margin-bottom: 10px;
    }

    .form-check-label {
        font-size: 1rem;
        font-weight: 500;
        color: #333;
    }

    .form-check-input {
        transform: scale(1.3);
        margin-right: 12px;
    }

    .form-check-input.previous {
        border-color: #0fddf5;

    }

    .form-check-input.newly-checked {
        border-color: #f09006;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .back-link {
        font-size: 0.9rem;
        color: #555;
        text-decoration: none;
    }

    .back-link:hover {
        color: #007bff;
        text-decoration: underline;
    }

    .section-heading {
        font-size: 1.2rem;
        font-weight: 600;
        color: #444;
        margin-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 5px;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }

        .form-header {
            font-size: 1.5rem;
        }

        .btn-primary {
            font-size: 0.9rem;
        }
    }
    .form-check-input{
    border-color: #0b4572;
    width: 15px;
    height: 15px;
    }
</style>

<div class="container-fluid mt-4">
    <div class="form-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="col-md-3 form-header">Edit User Roles</span>
            <a href="{{ route('users.index') }}" class="back-link">&larr; Back</a>
        </div>
        <form action="{{ route('users.update', $user->id) }}" method="POST" id="edit-user-form">
            @csrf
            @method('PUT')
            <!-- Username Field -->
            <div class="row col-sm-12">
                <div class="col-sm-3">     
                <label for="name" class="form-label">Username (Id number)</label>
                <input type="text" id="name"  name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ $user->username }}"  readonly>
                </div>

                <div class="col-sm-6">
                    <label for="fullname" class="form-label">Full Name</label>
                     
                    <input type="text" name="fullname" class="form-control" readonly value="{{ $employee->emp_Fname }} {{ $employee->emp_Mname }} {{ $employee->emp_Lname }}">

                    
                    
                </div>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Roles Checkboxes -->
            <div class="mb-4 col-sm-12">
                <span class="section-heading">List of Roles</span>
                <hr class="text-primary col-sm-12 bg-primary">
                @forelse ($roles as $role)
                    @php
                        $isChecked = in_array($role, $userRoles ?? []);
                    @endphp
                    @if ($role != 'Super Admin')
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input {{ $isChecked ? 'previous' : '' }}" 
                                id="role-{{ $role }}" 
                                name="roles[]" 
                                value="{{ $role }}" 
                                {{ $isChecked ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-{{ $role }}">
                                {{ $role }}
                            </label>
                        </div>
                    @else
                        @if (Auth::user()->hasRole('Super Admin'))
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input {{ $isChecked ? 'previous' : '' }}" 
                                    id="role-{{ $role }}" 
                                    name="roles[]" 
                                    value="{{ $role }}" 
                                    {{ $isChecked ? 'checked' : '' }}>
                                <label class="form-check-label" for="role-{{ $role }}">
                                    {{ $role }}
                                </label>
                            </div>
                        @endif
                    @endif
                @empty
                    <span class="text-muted">No roles available</span>
                @endforelse
                @error('roles')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="btn btn-primary btn-sm">Update User</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.form-check-input').forEach((checkbox) => {
        checkbox.addEventListener('change', (e) => {
            if (e.target.checked && !e.target.classList.contains('previous')) {
                e.target.classList.add('newly-checked');
            } else {
                e.target.classList.remove('newly-checked');
            }
        });
    });
</script>
@endsection
