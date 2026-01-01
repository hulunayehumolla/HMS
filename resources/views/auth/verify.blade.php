@extends('guestHeader')

@section('content')
<style>
    /* Navbar styles */
    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        height: 50px;
        background-color: #005f6a;
    }

    .nav-links {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        flex: 1;
        justify-content: flex-start;
    }

    .nav-links li {
        margin: 0 15px;
    }

    .nav-links .text-end {
        margin-left: auto;
    }

    .nav-links a {
        text-decoration: none;
        color: #007bff;
        font-weight: 500;
    }

    .nav-links a:hover {
        text-decoration: underline;
    }

    .cta {
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        text-decoration: none;
    }

    .cta:hover {
        background-color: #0056b3;
    }

    /* Login card styles */
    .login-card {
        max-width: 400px;
        width: 100%;
        background: #fff;
        border-radius: 8px;
        padding: 40px 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 10px auto;
        border: 0.1px solid #0c7a97;
        
    }

    .login-card img {
        width: 80px;
        height:80px;
        border-radius: 50%;
        margin-bottom: 20px;

    }

    .btn-primary {
        width: 100%;
        background-color: #005f6a;
        border: none;
        padding: 12px;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 8px;
        color: #fff;
        transition: background 0.3s;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #004080;
    }

    .form-check-label {
        font-size: 0.9rem;
        color: #555;
    }

    .forgot-password a {
        font-size: 0.9rem;
        //color: #0055A2;
        color: 003366;
        text-decoration: none;
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }

    #togglePassword{
       width: 12%;
       border: 1px solid #0c7a97;
       border-radius: 2px;  
    }
    #remember{
        border-color: #0055A2;
        color:#0055A2;
    }

    input.form-control {
        border: 1px solid #0c7a97; /* Customize the border color */
        border-radius: 4px;       /* Optional: Add rounded corners */
        padding: 10px;           /* Optional: Add padding for better appearance */
    }

    /* Add focus effect for inputs */
    input.form-control:focus {
        border-color: #0056b3;   /* Change border color when focused */
        outline: none;          /* Remove the default outline */
        box-shadow: 0 0 5px rgba(0, 86, 179, 0.5); /* Add a glowing effect */
    }


</style>

<nav class="nav" role="banner">
    <div class="menu-toggle" id="mobileMenu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <ul class="nav-links">
        <li><a href="{{route('welcome')}}">Home</a></li>
    </ul>
</nav>
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 600px; border-radius: 10px; background-color: #f9f9f9;">
        <div class="text-center mb-3">
            <h5 style="color: #666;">Enter the reset code sent to your email.</h5>
            
        </div>

        <!-- Display Status Message -->
        @if (session('status'))
            <div class="text-success text-center" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Display Errors -->
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Reset Code and Password Form -->
        <form id="reset-password-form" action="{{ route('password.verifyCode') }}" method="POST" class="mb-4 pb-3">
            @csrf
            <!-- Reset Code -->
            <div class="row col-sm-12 mb-3">
                <div class="col-sm-9">
                    <label for="code" class="form-label" style="color: #555; font-weight: 600;">Reset Code</label>
                    <input type="text" name="code" id="code" class="form-control form-control-sm" placeholder="Enter reset code" required style="border-radius: 5px; border: 1px solid #ddd;">
                </div>
                <div class="col-sm-3 mt-4 text-left">
                    <label id="timer" class="mt-3" style="color: #f00; font-weight: bold; "></label>
                </div>
            </div>

            <!-- New Password -->
            <div class="row col-sm-12 mb-3">
                <div class="col-sm-12">
                    <label for="password" class="form-label" style="color: #555; font-weight: 600;">New Password</label>
                    <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Enter new password" required style="border-radius: 5px; border: 1px solid #ddd;">
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="row col-sm-12 mb-3">
                <div class="col-sm-12">
                    <label for="password_confirmation" class="form-label" style="color: #555; font-weight: 600;">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-sm" placeholder="Confirm your password" required style="border-radius: 5px; border: 1px solid #ddd;">
                    <div id="password-match" class="mt-2" style="font-size: 14px; font-weight: 600;"></div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100" style="border-radius: 5px;" id="submit-button" disabled>Reset Password</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
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

    let timeRemaining = 120; // 5 minutes in seconds

    // Function to delete the reset code when time expires
    function deleteResetCode() {
        fetch("{{ route('password.deleteCode') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ email: "{{ session('password_reset_email') }}" })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  Swal.fire({
                           icon: 'warning',
                           title: 'Reset Code Expired',
                           text: 'Your password reset code has expired. Please request a new one.',
                           confirmButtonText: 'Okay',
                           confirmButtonColor: '#3085d6', // Change button color
                           background: '#fefefe', // Background color of the modal
                           allowOutsideClick: false
                        }).then(() => {
                           window.location.href = "{{ route('password.request') }}";
                        });

              } else {
                  console.log("Failed to delete reset code.");
              }
          });
    }

    // Update the timer
    function updateTimer() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;

        timerElement.textContent = `Time: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeRemaining > 0) {
            timeRemaining -= 1;
            setTimeout(updateTimer, 1000);
        } else {
            timerElement.textContent = 'Reset code expired.';
            timerElement.style.color = 'red';
            submitButton.disabled = true; // Disable submission when timer expires

            // Call backend to delete the code
            deleteResetCode();
        }
    }

    updateTimer();

    // Handle the form submission with AJAX
    const form = document.getElementById('reset-password-form');
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form);
        
        // Submit the form using AJAX
        fetch("{{ route('password.verifyCode') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
           if (data.status === 'success') {
                // Show success message, and then redirect to login
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message,
                    confirmButtonText: 'Okay'
                }).then(() => {
                    window.location.href = "{{ route('login') }}"; // Redirect to login page
                });
            } else {
                // Handle error messages
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
@endsection

                    