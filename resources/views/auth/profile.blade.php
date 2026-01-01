@extends('layouts.app')

@section('content')
<style>
    /* Add custom styling for a smarter look */
    .profile-card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .profile-card-header {
        background-color: #707b81;
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        border-radius: 8px 8px 0 0;
        padding: 15px;
    }
    .profile-table th {
        width: 30%;
        text-align: left;
    }
    .profile-table td {
        width: 70%;
        text-align: left;
    }
    .toggle-button {
        color: #007bff;
        font-size: 16px;
        display: flex;
        align-items: center;
    }
    .toggle-button i {
        margin-right: 5px;
        transition: transform 0.3s ease;
    }
    .password-section {
    
        margin-top: 10px;
    }
    .submit-btn {
        background-color: #007bff;
        color: white;
        border: none;
        transition: background-color 0.3s ease;
    }
    .submit-btn:hover {
        background-color: #0056b3;
    }
</style>

<div class="card profile-card mb-4">
    <!-- Card Header -->
    <div class="profile-card-header">
        {{ __('My Profile') }}
    </div>

    <!-- User Details Section -->
    <div class="card-body">
        <h5 class="mb-3">{{ __('User Details') }}</h5>
        <table class="table table-bordered profile-table">
            <tr>
                <th>{{ __('Full Name') }}</th>
                <td>{{ $firstName }} {{ $middleName }} {{ $lastName }}</td>
            </tr>
            <tr>
                <th>{{ __('Username (ID)') }}</th>
                <td>{{ auth()->user()->username }}</td>
            </tr>
            <tr>
                <th>{{ __('Joined At') }}</th>
                <td>{{ auth()->user()->created_at->format('d-m-Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Profile Update Form -->
    <form action="{{ route('profile.update') }}" method="POST" id="updateForm">
        @csrf

        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <!-- Toggle Password Section -->
            <div class="mb-3 col-sm-12">
                <span id="togglePasswordSection" class="toggle-button col-sm-6">
                 {{ __('Needs To Change Password') }} 
                </span>
            </div>

            <!-- Password Change Section -->
            <div id="passwordChangeSection" class="password-section">

                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">

                    <!-- Old Password -->
                    <div class="col-sm-6  input-group mb-3">
                        <span class="input-group-text" style="color:#146a92;">
                            <svg class="icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                            </svg>
                        </span>
                        <input class="form-control @error('oldpassword') is-invalid @enderror" type="text" name="oldpassword" 
                               value="{{ old('oldpassword') }}" placeholder="{{ __('Old password') }}">
                        @error('oldpassword')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <!-- New Password -->
                                        <!-- New Password -->
                    <div class="col-sm-6  input-group mb-3">
                        <span class="input-group-text" style="color:#146a92;">
                            <svg class="icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}" ></use>
                            </svg>
                        </span>
                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" 
                               value="{{ old('password') }}" placeholder="{{ __('New password') }}">
                        <span class="input-group-text toggle-password" data-target="password">
                            <i class="fa fa-eye" style="color:#146a92;"></i>
                        </span>
                        @error('password')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-sm-6  input-group mb-3">
                        <span class="input-group-text">
                            <svg class="icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                            </svg>
                        </span>
                        <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" 
                               value="{{ old('password_confirmation') }}" placeholder="{{ __('Confirm new password') }}">
                        <span class="input-group-text toggle-password" data-target="password_confirmation">
                            <i class="fa fa-eye" style="color:#146a92;"></i>
                        </span>
                    </div>
                    <div id="password-match" class="mt-2" style="font-size: 14px; font-weight: 600;"></div>

                    <!-- Submit Button -->
                    <div class="col-sm-6 text-end">
                        <button class="btn submit-btn changepass" type="submit">{{ __('Update') }}</button>
                    </div>


        </div>
    </form>
</div>
<script>
/*document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const passwordMatchText = document.getElementById('password-match');
    const submitButton = document.getElementById('submit-button');
    const timerElement = document.getElementById('timer');

    // Check if passwords match
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (password && confirmPassword) {
            if (password === confirmPassword) {
                passwordMatchText.textContent = '✅ Passwords match!';
                passwordMatchText.style.color = 'green';
                submitButton.disabled = false;
            } else {
                passwordMatchText.textContent = '❌ Passwords do not match.';
                passwordMatchText.style.color = 'red';
                submitButton.disabled = true;
            }
        } else {
            passwordMatchText.textContent = '❗ Password fields cannot be empty.';
            passwordMatchText.style.color = 'orange';
            submitButton.disabled = true;
        }
    }

    //passwordInput.addEventListener('input', checkPasswordMatch);
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);

});*/

    document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const passwordMatchText = document.getElementById('password-match');
    const submitButton = document.getElementById('submit-button');

    function validatePassword(password) {
        const minLength = 6;
        const numberRegex = /\d/; // At least one number
        const specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/; // At least one special character

        if (password.length < minLength) {
            return '❌ Password must be at least 6 characters.';
        }
        if (!numberRegex.test(password)) {
            return '❌ Password must contain at least one number.';
        }
        if (!specialCharRegex.test(password)) {
            return '❌ Password must contain at least one special character (!@#$%^&* etc.).';
        }
        return ''; // Valid password
    }

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const validationError = validatePassword(password);

        if (validationError) {
            passwordMatchText.textContent = validationError;
            passwordMatchText.style.color = 'red';
            submitButton.disabled = true;
            return;
        }

        if (confirmPassword) {
            if (password === confirmPassword) {
                passwordMatchText.textContent = '✅ Password is strong and matches!';
                passwordMatchText.style.color = 'green';
                submitButton.disabled = false;
            } else {
                passwordMatchText.textContent = '❌ Passwords do not match.';
                passwordMatchText.style.color = 'red';
                submitButton.disabled = true;
            }
        } else {
            passwordMatchText.textContent = '❗ Please confirm your password.';
            passwordMatchText.style.color = 'orange';
            submitButton.disabled = true;
        }
    }

    passwordInput.addEventListener('input', checkPasswordMatch);
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
});


  $(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click','.changepass', function(e){
        e.preventDefault();
        $('.changepass').html('updating...');
        $.ajax({
            url: "{{ route('profile.update') }}",
            type: "post",
            data: $('#updateForm').serialize(),

            success: function (response) {
           
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.isConfirmed) {
                                window.location.href = "{{ route('login') }}"; // Redirect to the login page
                            } // Delay for 1.5 seconds before redirect
                        
                      });
                  }
                  else{
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                    });

                }
                  $('.changepass').html('update');
                  
            },
            error: function (xhr) {
                
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                    });
                     $('.changepass').html('update');
                
                }
        });
    });
});

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".toggle-password").forEach(function(toggle) {
            toggle.addEventListener("click", function() {
                let target = document.getElementById(this.getAttribute("data-target"));
                if (target.type === "password") {
                    target.type = "text";
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>'; // Change icon
                } else {
                    target.type = "password";
                    this.innerHTML = '<i class="fa fa-eye"></i>'; // Change icon
                }
            });
        });
    });


</script>



@endsection
