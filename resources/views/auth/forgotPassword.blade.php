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
    <div class="card shadow-lg p-3" style="width: 100%; max-width: 600px; border-radius: 10px; background-color: #f9f9f9;">
        <div class="text-center mb-2">
            <h4 style="color: #333;">Reset Your Password</h4>
        </div>
            <p style="color: #666;">Enter your email to receive a reset code</p>

             <!-- Display Errors -->
        @if ($errors->any())
            <div class="alert text-danger" role="alert">
                
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                
            </div>
        @endif

        <!-- Email Form -->
        <form action="{{ route('password.sendCode') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label" style="color: #555; font-weight: 600;">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required style="border-radius: 5px; border: 1px solid #ddd;">
            </div>
            <button type="submit" class="btn btn-primary w-100" style="border-radius: 5px;">Send Code</button>
        </form>
    </div>
</div>


@endsection
