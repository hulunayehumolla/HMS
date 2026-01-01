<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | ZaresLay</title>

    <link href="{{ asset('assets/bootstrap-5.3.1/css/bootstrap.min.css')}}" rel="stylesheet" /> 
    <link rel="stylesheet" href="{{ asset('assets/font-awesome-6.4.2/all.min.css')}}" />

    <style>
        /* ----------------- Global Body Setup (FIXED FOR FULL-PAGE BACKGROUND) ----------------- */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif, "Segoe UI";
            min-height: 100vh;
            width: 100vw;
            position: relative;
            overflow-y: auto; 
            overflow-x: hidden;

            /* Background image setup */
            background-image: url("{{ asset('images/background.png') }}"); 
            background-size: cover; 
            background-position: center center; 
            background-repeat: no-repeat; 
            background-color: #0d47a1; 
            transition: background-image 1s ease-in-out; 
        }

        /* --- NEW WRAPPER FOR CENTERING CONTENT BELOW FIXED NAV --- */
        .page-wrapper {
            width: 100%;
            /* Add padding to account for the fixed nav bar */
            padding-top: 50px; 
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically on the remaining space */
            min-height: 100vh; /* Use full height */
            flex-grow: 1;
        }

        /* ----------------- Navbar styles (FIXED POSITION) ----------------- */
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0 20px;
            height: 50px;
            background-color: #005f6a;
            /* --- FIX: Make the navbar stick to the top --- */
            position: fixed; 
            top: 0;
            z-index: 100;
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
            color: #fff;
            font-weight: 500;
        }

        .nav-links a:hover {
            text-decoration: underline;
            color: #007bff;
        }
        
        .menu-toggle {
            display: none;
        }
        
        /* ----------------- Login Card styles ----------------- */
        .login-card {
            max-width: 400px;
            width: 100%;
            background: #fff;
            border-radius: 8px;
            padding: 40px 30px; 
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            /* Margin set to 0 for vertical centering by .page-wrapper, but add auto for horizontal centering */
            margin: 0 auto; 
            border: 0.1px solid #0c7a97;
            position: relative;
        }

        .login-card p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 25px;
        }

        .login-card img {
            width: 80px;
            height:80px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .input-wrapper {
            padding: 0 10px;
        }

        input.form-control {
            border: 1px solid #0c7a97; 
            border-radius: 4px; 
            padding: 10px; 
            width: 100%;
        }

        input.form-control:focus {
            border-color: #0056b3;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }

        .mb-2.input-group {
            display: flex;
            width: 100%;
        }
        
        #togglePassword{
            width: auto;
            padding: 0 10px;
            background-color: #fff;
            border: 1px solid #0c7a97;
            border-left: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        
        #togglePassword i {
            color: #0c7a97;
            font-size: 1.1rem;
        }
        
        #passWord {
            border-right: none !important; 
            border-radius: 4px 0 0 4px !important;
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
        
        .form-check {
            justify-content: flex-start;
            margin-bottom: 10px;
            margin-top: 10px;
        }
        
        .form-check-label {
            font-size: 0.9rem;
            color: #003366 !important;
        }

        .forgot-password {
            text-align: right;
        }

        .forgot-password a {
            font-size: 0.9rem;
            color: #003366;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .alert {
            margin: 15px 0;
            padding: 10px;
            border-radius: 4px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            font-size: 0.9rem;
            text-align: left;
        }
        .alert.text-danger {
            color: #721c24 !important;
        }

        #remember {
            border-color: #0055A2;
        }
    </style>
</head>
<body>

<!-- <nav class="nav" role="banner">
    <div class="menu-toggle" id="mobileMenu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <ul class="nav-links">
        <li><a href="{{route('welcome')}}">Home</a></li>
    </ul>
</nav> -->

<div class="page-wrapper">
    <div class="login-card">
        <img src="{{ asset('logo/logo3.png') }}" alt="INU Logo">
        <p>Log in to access your account</p>

        @if (session('message'))
            <div class="alert text-danger" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert text-danger" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form id="loginForm" action="{{ route('login') }}" method="POST" autocomplete="off">
            @csrf
            
            <div class="input-wrapper">
                <div class="mb-3">
                    <input id="userName" class="form-control" type="text" name="userName" placeholder="Username" required aria-label="Username" autofocus autocomplete="username">
                </div>
            </div>

            <div class="input-wrapper">
                <div class="mb-2 input-group">
                    <input id="passWord" class="form-control" type="password" name="passWord" placeholder="Password" onpaste="return false" required aria-label="Password" autocomplete="current-password">
                    <button id="togglePassword" type="button" aria-label="Toggle Password Visibility">
                        <i class="fa fa-eye-slash" id="passwordIcon" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="row align-items-center justify-content-between mx-0">
                <div class="col-6 form-check d-flex align-items-center p-0">
                    <input class="form-check-input form-check-input-lg ms-0" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label ms-2 mt-1" for="remember">Remember Me</label>
                </div>
                
                <div class="col-6 forgot-password p-0">
                    <a href="{{route('password.request')}}">Reset Password?</a>
                </div>
            </div>

            <button id="loginSubmit" type="submit" class="btn btn-primary mt-3">Login</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passWord');
        const passwordIcon = document.getElementById('passwordIcon');

        // Toggle password visibility
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            
            // Update icon classes
            passwordIcon.classList.toggle('fa-eye-slash', !isPassword);
            passwordIcon.classList.toggle('fa-eye', isPassword); 

            // Update ARIA label for accessibility
            togglePassword.setAttribute('aria-label', isPassword ? 'Hide Password' : 'Show Password');
        });

        // Disable the button on form submission
        const loginSubmit = document.getElementById('loginSubmit');
        document.getElementById('loginForm').addEventListener('submit', () => {
            loginSubmit.innerText = "Logging in...";
            loginSubmit.disabled = true;
        });
    });
</script>

</body>
</html>