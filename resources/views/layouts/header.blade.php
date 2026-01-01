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

<!-- offline packeges -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/bulma.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/dataTables.bulma.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/jquery.dataTables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/css/colReorder.dataTables.min.css')}}" />
  <!-- end for script files --> 
  <link href="{{ asset('assets/bootstrap-5.3.1/css/bootstrap.min.css')}}"  rel="stylesheet" /> 
<!-- custom for data table style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/customDatatable.css')}}"/> 


    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}" />
    <!-- Theme style -->
 


<link rel="stylesheet"  href="{{ asset('assets/font-awesome-6.4.2/all.min.css')}}" />
   


<script type="text/javascript" src="{{asset('assets/bootstrap-5.3.1/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/jquery-3.7.0.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/jquery.dataTables.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.bulma.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.buttons.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/jszip.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/pdfmake.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/buttons.colVis.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.colReorder.min.js' )}}"></script>


<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>  --> 

<script type="text/javascript" src="{{ asset('assets/datatables/js/vfs_fonts.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/buttons.html5.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/buttons.print.min.js' )}}"></script>


<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.select.js' )}}"></script>


<!-- end of Offile -->

   <script src="{{asset('js/sweetAlert.js')}}"></script> 

<!-- end of Offile -->
   
 

 <script src="{{asset('js/toaster.js')}}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script  src="{{asset('js/toaster.min.js')}}"  crossorigin="anonymous" referrerpolicy="no-referrer"> </script>

<!-- new added -->
<!-- Bootstrap CSS -->
<link href="{{asset('assets/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/bootstrap-icons.css')}}" rel="stylesheet">



<!-- Bootstrap Bundle JS (includes Popper.js) -->
<script src="{{asset('assets/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('js/poper.js')}}"></script>

<link rel="stylesheet" href="{{asset('css/bootstrap-icons.css')}}">


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


 <link rel="stylesheet" type="text/css" href="{{asset('css/lightbox.min.css')}}">
<script type="text/javascript" src="{{asset('js/lightbox.min.js')}}"></script>

   <script type="text/javascript" src="{{asset('assets/multipleValueChoosen/multiple_choosen.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/multipleValueChoosen/multiple_choosen.css')}}" />






    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>

    <style>
        /* --- 1. Custom Theme Variables (CSS Variables for Color Switching) --- */
        :root {
            --bg-primary: #FFFFFF;
            --bg-secondary: #F8FAFC;
            --text-primary: #212121;
            --color-blue: #1976D2; /* Brand Blue - Light */
            --color-orange: #FF9800;
            
            /* Light Mode Colors for Hero Gradient */
            --hero-color-1-light: 255, 248, 220; /* Creamy Yellow */
            --hero-color-2-light: 255, 165, 0;   /* Bright Orange Glow */
            --hero-color-3-light: 25, 118, 210;  /* Brand Sky Blue (RGB of #1976D2) */
        }
        .dark {
            --bg-primary: #121212;
            --bg-secondary: #1E1E1E;
            --text-primary: #E0E0E0;
            --color-blue: #90CAF9; /* Brand Blue - Dark */
            --color-orange: #FFB74D;
            
            /* Dark Mode Colors for Hero Gradient */
            --hero-color-1-dark: 17, 24, 39;    /* Deep Navy */
            --hero-color-2-dark: 144, 202, 249; /* Brand Sky Blue Highlight (RGB of #90CAF9) */
            --hero-color-3-dark: 255, 179, 102; /* Muted Orange Glow */
        }

        /* --- 2. Base & Utility Classes --- */
        body {
            transition: background-color 0.5s ease, color 0.5s ease;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* Hero Section BG - Natural Sunrise/Sunset Dynamic Background */
        .hero-bg {

            
            background: linear-gradient(135deg,
                rgba(var(--hero-color-3-light), 1.0) 0%, 
                rgba(var(--hero-color-2-light), 0.8) 60%, 
                rgba(var(--hero-color-1-light), 0.9) 100% 
            );
            background-size: 200% 200%;
        }
        .dark .hero-bg {
            background: linear-gradient(135deg,
                rgba(var(--hero-color-3-dark), 0.5) 0%, 
                rgba(var(--hero-color-2-dark), 0.4) 40%, 
                rgba(var(--hero-color-1-dark), 1.0) 100% 
            );
            background-size: 200% 200%;
            animation: gradientShift 15s ease infinite; /* Dark mode uses animation for deeper feel */
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Map CSS variables to Tailwind classes */
        .bg-primary-bg { background-color: var(--bg-primary); }
        .bg-secondary-bg { background-color: var(--bg-secondary); }
        .text-primary-text { color: var(--text-primary); }
        .text-zare-blue { color: var(--color-blue); }
        .bg-zare-blue { background-color: var(--color-blue); }
        .text-zare-orange { color: var(--color-orange); }
        .bg-zare-orange { background-color: var(--color-orange); }

        /* Alpine x-cloak utility for preventing flash of unstyled content */
        [x-cloak] { display: none !important; }
    </style>

    <script>
        // Tailwind configuration for custom brand colors (required for CDN mode)
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'primary-bg': 'var(--bg-primary)',
                        'secondary-bg': 'var(--bg-secondary)',
                        'primary-text': 'var(--text-primary)',
                        'zare-blue': 'var(--color-blue)',
                        'zare-orange': 'var(--color-orange)',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-primary-bg text-primary-text">




<div class="w-full bg-secondary-bg border-b border-gray-300 dark:border-[#282828]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2
                flex flex-col sm:flex-row justify-between items-center text-sm">

        <!-- LEFT — HOTEL INFO -->
        <div class="flex items-center space-x-6 text-primary-text">
            <div class="flex items-center space-x-1">
                <i class="fa-solid fa-location-dot"></i>
                <span>Addis Ababa, Ethiopia</span>
            </div>
            <div class="flex items-center space-x-1">
                <i class="fa-solid fa-phone"></i>
                <a href="tel:+251922209427" class="hover:text-zare-orange">
                    +251 92 220 9427
                </a>
            </div>
        </div>

        <!-- RIGHT — HOTEL ACTIONS -->
        <div class="flex items-center space-x-4 mt-2 sm:mt-0">
            <a href="#" class="hover:text-zare-orange"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="hover:text-zare-orange"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="hover:text-zare-orange"><i class="fa-brands fa-tripadvisor"></i></a>
        </div>

    </div>
</div>




    <!-- Smart Header/Navigation -->
    <nav x-data="{ open: false }"
     class="sticky top-0 z-50 bg-primary-bg backdrop-blur-sm shadow-lg transition-colors duration-500 text-white " style="background-color:#1370C2;">

     <!-- DIAGONAL CORNER STRIP -->
<!--      <div class="pointer-events-none absolute top-0 left-0 w-32 h-32 overflow-hidden">
    <div class="absolute top-6 -left-16 w-48 text-center
                bg-gradient-to-l from-red-600 to-orange-500
                text-white text-xs font-semibold tracking-wider
                -rotate-45 shadow-lg py-1">
        Karned
    </div>
</div>


<div class="pointer-events-none absolute top-0 right-0 w-32 h-32 overflow-hidden">
    <div class="absolute top-6 -right-15 w-48 text-center
                bg-gradient-to-r from-red-600 to-orange-500
                text-white text-xs font-semibold tracking-wider
                rotate-45 shadow-lg py-1">
        Hotel
    </div>
</div>
 -->





    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center  ">

        <!-- LOGO -->
        <a href="{{route('welcome')}}" class="flex items-center space-x-3">
            <img src="{{ asset('logo/logo3.jpg') }}"
                 alt="{{ config('app.name') }}"  alt="{{ config('app.name') }}" width="100" height="100" 
                 class="rounded-full object-cover shadow-md  ">
            <span class="text-xl font-bold tracking-wide">
                {{ config('app.name') }}
            </span>
        </a>

        <!-- DESKTOP MENU -->
        <div class="hidden md:flex space-x-8 text-sm font-medium ">
            <a href="#rooms" class="hover:text-zare-orange">Rooms & Suites</a>
            <a href="#amenities" class="hover:text-zare-orange">Amenities</a>
            <a href="#restaurant" class="hover:text-zare-orange">Restaurant</a>
            <a href="#gallery" class="hover:text-zare-orange">Gallery</a>
            <a href="#about" class="hover:text-zare-orange">About Us</a>
            <a href="#contact" class="hover:text-zare-orange">Contact</a>
            <a href="{{route('news.view.public')}}" class="hover:text-zare-orange">News</a>
        </div>

        <!-- RIGHT ACTIONS -->
        <div class="flex items-center space-x-4">

            <!-- BOOK NOW -->
            <a href="#booking"
               class="px-4 py-2 rounded-xl bg-zare-orange text-white font-semibold shadow hover:opacity-90 transition">
                Book Now
            </a>

            <!-- MOBILE TOGGLE -->
            <button class="md:hidden p-2 rounded-lg hover:bg-secondary-bg"
                    @click="open = !open">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" x-cloak
         class="md:hidden bg-primary-bg shadow-xl border-t border-gray-200 dark:border-[#282828] text-white" style="background-color:#1370C2;">
        <div class="px-4 py-4 space-y-2 text-center">
            <a href="#rooms" class="block py-2 hover:text-zare-orange">Rooms & Suites</a>
            <a href="#amenities" class="block py-2 hover:text-zare-orange">Amenities</a>
            <a href="#restaurant" class="block py-2 hover:text-zare-orange">Restaurant</a>
            <a href="#gallery" class="block py-2 hover:text-zare-orange">Gallery</a>
            <a href="#contact" class="block py-2 hover:text-zare-orange">Contact</a>
            <a href="#booking"
               class="block mt-3 py-2 rounded-lg bg-zare-orange text-white font-semibold">
                Book Now
            </a>
        </div>
    </div>
</nav>



    <div class="px-1">
        
         @yield('content')
       
    </div>

<!-- Hotel Footer -->
<footer class="relative py-12 transition-colors duration-500 overflow-hidden"
        style="background: linear-gradient(135deg, rgba(25,118,210,0.05), rgba(255,152,0,0.05));
               border-top: 8px solid transparent;
               border-image: linear-gradient(to right, var(--color-blue), var(--color-orange), var(--color-blue)) 1;
               background-color: #1370C2;">

    <!-- LEFT DIAGONAL RIBBON -->
    <div class="pointer-events-none absolute top-0 left-0 w-36 h-36 overflow-hidden hidden md:block">
        <div class="absolute top-8 -left-20 w-64 text-center
                    bg-gradient-to-l from-red-600 via-orange-500 to-red-600
                    text-white text-[11px] font-semibold tracking-widest
                    -rotate-45 shadow-lg py-1 opacity-90">
            KARNED
        </div>
    </div>

    <!-- RIGHT DIAGONAL RIBBON -->
    <div class="pointer-events-none absolute top-0 right-0 w-36 h-36 overflow-hidden hidden md:block">
        <div class="absolute top-8 -right-20 w-64 text-center
                    bg-gradient-to-r from-red-600 via-orange-500 to-red-600
                    text-white text-[11px] font-semibold tracking-widest
                    rotate-45 shadow-lg py-1 opacity-90">
            Hotel
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Footer Grid -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8 border-b pb-8 mb-8
                    border-gray-200 dark:border-[#282828] text-sm">

            <!-- Hotel Logo & Tagline -->
            <div class="col-span-2 md:col-span-2 space-y-2">
                <img src="{{ asset('logo/logo3.jpg') }}"
                     alt="{{ config('app.name') }}"
                     width="150" height="150"
                     class="rounded-full object-cover shadow-md">

                <p class="text-primary-text/80 text-sm leading-relaxed">
                    Experience comfort, elegance, and exceptional hospitality at
                    <span class="font-semibold">{{ config('app.name') }}</span>.
                </p>
            </div>

            <!-- Explore -->
            <div>
                <h4 class="font-semibold mb-3 text-primary-text">Explore</h4>
                <ul class="space-y-2">
                    <li><a href="#rooms" class="text-primary-text/70 hover:text-zare-orange transition">Rooms & Suites</a></li>
                    <li><a href="#amenities" class="text-primary-text/70 hover:text-zare-orange transition">Amenities</a></li>
                    <li><a href="#restaurant" class="text-primary-text/70 hover:text-zare-orange transition">Restaurant & Bar</a></li>
                    <li><a href="#gallery" class="text-primary-text/70 hover:text-zare-orange transition">Gallery</a></li>
                </ul>
            </div>

            <!-- Guest Services -->
            <div>
                <h4 class="font-semibold mb-3 text-primary-text">Guest Services</h4>
                <ul class="space-y-2">
                    <li><a href="#booking" class="text-primary-text/70 hover:text-zare-orange transition">Book a Room</a></li>
                    <li><a href="#offers" class="text-primary-text/70 hover:text-zare-orange transition">Special Offers</a></li>
                    <li><a href="#faq" class="text-primary-text/70 hover:text-zare-orange transition">FAQs</a></li>
                    <li><a href="#policies" class="text-primary-text/70 hover:text-zare-orange transition">Hotel Policies</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-semibold mb-3 text-primary-text">Contact</h4>
                <ul class="space-y-2 text-primary-text/70">
                    <li>
                        <i class="fa-solid fa-location-dot mr-1"></i>
                        Addis Ababa, Ethiopia
                    </li>
                    <li>
                        <i class="fa-solid fa-phone mr-1"></i>
                        <a href="tel:+251922209427" class="hover:text-zare-orange transition">
                            +251 92 220 9427
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope mr-1"></i>
                        <a href="mailto:info@zareslay.com" class="hover:text-zare-orange transition">
                            info@zareslay.com
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Copyright -->
        <div class="text-center text-sm font-semibold"
             style="background: linear-gradient(to right, var(--color-blue), var(--color-orange), var(--color-blue));
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>
</footer>


    </body>
    </html>