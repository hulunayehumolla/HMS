<!DOCTYPE html>
<html lang="en"
      x-data="{ theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') }"
      :class="theme"
>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="{{ asset('logo/logo3.jpg')}} ">
<title>{{ env('APP_NAME') }}</title>

<!-- OFFLINE PACKAGES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/bulma.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/dataTables.bulma.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/jquery.dataTables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/colReorder.dataTables.min.css')}}" />

<link href="{{ asset('assets/bootstrap-5.3.1/css/bootstrap.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/customDatatable.css')}}"/>

<link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/font-awesome-6.4.2/all.min.css')}}" />

<script type="text/javascript" src="{{asset('assets/bootstrap-5.3.1/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/jquery-3.7.0.js' )}}"></script>

<script src="{{asset('js/sweetAlert.js')}}"></script> 
<script src="{{asset('js/toaster.js')}}"></script>
<script src="{{asset('js/toaster.min.js')}}"></script>

<link href="{{asset('assets/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/bootstrap-icons.css')}}" rel="stylesheet">
<script src="{{asset('assets/bootstrap.bundle.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('css/bootstrap-icons.css')}}">
<link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
<script src="{{asset('js/lightbox.min.js')}}"></script>

<script src="{{asset('assets/multipleValueChoosen/multiple_choosen.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/multipleValueChoosen/multiple_choosen.css')}}" />

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>

</head>

<body class="bg-primary-bg text-primary-text">

<!-- TOP INFO BAR -->
<div class="w-full bg-secondary-bg border-b border-gray-300">
    <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col sm:flex-row justify-between items-center text-sm">

        <!-- LEFT — HOSPITAL INFO -->
        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-1">
                <i class="fa-solid fa-location-dot"></i>
                <span>Injibara, Ethiopia</span>
            </div>
            <div class="flex items-center space-x-1">
                <i class="fa-solid fa-phone"></i>
                <a href="tel:+251922209427" class="hover:text-zare-orange">
                    +251 92 220 9427
                </a>
            </div>
        </div>

        <!-- RIGHT — SOCIAL -->
        <div class="flex items-center space-x-4 mt-2 sm:mt-0">
            <a href="#" class="hover:text-zare-orange"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="hover:text-zare-orange"><i class="fa-brands fa-instagram"></i></a>
        </div>

    </div>
</div>

<!-- NAVBAR -->
<nav x-data="{ open: false }"
class="sticky top-0 z-50 shadow-lg text-white"
style="background-color:#1370C2;">

<div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

    <!-- LOGO -->
    <a href="{{route('welcome')}}" class="flex items-center space-x-3">
<!--         <img src="{{ asset('logo/logo3.jpg') }}"
             alt="{{ config('app.name') }}" width="100" height="100"
             class="rounded-full object-cover shadow-md"> -->
        <span class="text-xl font-bold tracking-wide">
            {{ config('app.name') }}
        </span>
    </a>

    <!-- DESKTOP MENU -->
    <div class="hidden md:flex space-x-8 text-sm font-medium">
        <a href="#rooms" class="hover:text-zare-orange">Wards</a>
        <a href="#foods" class="hover:text-zare-orange">Medical Services</a>
        <a href="#amenities" class="hover:text-zare-orange">Facilities</a>
        <a href="#restaurant" class="hover:text-zare-orange">Laboratory</a>
        <a href="#gallery" class="hover:text-zare-orange">Gallery</a>
        <a href="#about" class="hover:text-zare-orange">About Hospital</a>
        <a href="#contact" class="hover:text-zare-orange">Contact</a> 
        <a href="#Login" class="hover:text-zare-orange">Login</a>            
        <a href="{{route('news.view.public')}}" class="hover:text-zare-orange">Health News</a>
    </div>

    <!-- ACTION -->
    <div class="flex items-center space-x-4">
        <a href="#booking"
           class="px-4 py-2 rounded-xl bg-zare-orange text-white font-semibold shadow">
            Book Appointment
        </a>

        <button class="md:hidden p-2" @click="open = !open">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </div>
</div>

<!-- MOBILE MENU -->
<div x-show="open" x-cloak
class="md:hidden shadow-xl border-t text-white"
style="background-color:#1370C2;">
    <div class="px-4 py-4 space-y-2 text-center">
        <a href="#rooms" class="block py-2 hover:text-zare-orange">Wards</a>
        <a href="#foods" class="block py-2 hover:text-zare-orange">Medical Services</a>
        <a href="#amenities" class="block py-2 hover:text-zare-orange">Facilities</a>
        <a href="#restaurant" class="block py-2 hover:text-zare-orange">Laboratory</a>
        <a href="#gallery" class="block py-2 hover:text-zare-orange">Gallery</a>
        <a href="#contact" class="block py-2 hover:text-zare-orange">Contact</a>
        <a href="#Login" class="block py-2 hover:text-zare-orange">Login</a>  

        <a href="#booking"
           class="block mt-3 py-2 rounded-lg bg-zare-orange text-white font-semibold">
            Book Appointment
        </a>
    </div>
</div>
</nav>

<div class="px-1">
    @yield('content')
</div>

<!-- FOOTER -->
<footer class="relative py-12 overflow-hidden"
style="background-color:#1370C2;">

<div class="max-w-7xl mx-auto px-4">

<div class="grid grid-cols-2 md:grid-cols-5 gap-8 border-b pb-8 mb-8 text-sm">

<!-- LOGO -->
<div class="col-span-2 space-y-2">
<img src="{{ asset('logo/logo3.jpg') }}"
     alt="{{ config('app.name') }}"
     width="150" height="150"
     class="rounded-full shadow-md">

<p class="text-white/90 text-sm leading-relaxed">
Providing quality healthcare, modern medical services, and compassionate care at
<span class="font-semibold">{{ config('app.name') }}</span>.
</p>
</div>

<!-- QUICK LINKS -->
<div>
<h4 class="font-semibold mb-3 text-white">Explore</h4>
<ul class="space-y-2 text-white/80">
<li><a href="#rooms" class="hover:text-zare-orange">Wards</a></li>
<li><a href="#foods" class="hover:text-zare-orange">Medical Services</a></li>
<li><a href="#amenities" class="hover:text-zare-orange">Facilities</a></li>
<li><a href="#gallery" class="hover:text-zare-orange">Gallery</a></li>
</ul>
</div>

<!-- PATIENT SERVICES -->
<div>
<h4 class="font-semibold mb-3 text-white">Patient Services</h4>
<ul class="space-y-2 text-white/80">
<li><a href="#booking" class="hover:text-zare-orange">Book Appointment</a></li>
<li><a href="#faq" class="hover:text-zare-orange">FAQs</a></li>
<li><a href="#policies" class="hover:text-zare-orange">Hospital Policies</a></li>
</ul>
</div>

<!-- CONTACT -->
<div>
<h4 class="font-semibold mb-3 text-white">Contact</h4>
<ul class="space-y-2 text-white/80">
<li><i class="fa-solid fa-location-dot mr-1"></i> Injibara, Ethiopia</li>
<li><i class="fa-solid fa-phone mr-1"></i> +251 92 220 9427</li>
<li><i class="fa-solid fa-envelope mr-1"></i> info@injibarahospital.com</li>
</ul>
</div>

</div>

<!-- COPYRIGHT -->
<div class="text-center text-sm font-semibold text-white">
&copy; {{ date('Y') }} {{ config('app.name') }} — Injibara Hospital. All Rights Reserved.
</div>

</div>
</footer>

</body>
</html>
