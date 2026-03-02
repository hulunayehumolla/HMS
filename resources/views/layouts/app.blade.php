<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('logo/logo3.jpg')}} ">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @vite('resources/sass/app.scss')

<!-- offline packeges -->
   <!-- <script src="{{asset('assets/query-3.6.0.min.js')}}"></script> -->
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
    <!-- Google Font: Source Sans Pro -->
 <!--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" /> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}" />
    <!-- Theme style -->
 
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />  -->
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



<style type="text/css">
    .footer {
    height: 60px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
}

html, body {
    height: 100%;
    margin: 0;
}

.wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.content {
    flex: 1;
}

.footer {
    position: sticky;
    bottom: 0;
    width: 100%;
}


</style>
</head>
<body>
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar" >
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt=" Logo">
            <img src="{{asset('logo/logo3.jpg')}}" height="50" width="50" style="border-radius: 50%;" /> 
           
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt=" Logo">
            
        </svg>
    </div>
    @include('layouts.navigation')
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable" style="z-index: 999;"></button>
</div>
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                
                <i class="fa-solid fa-bars fa-xl" style="color: #056994;"></i>
            </button>
            <a class="header-brand d-md-none" href="#">
                <img src="{{asset('logo/logo3.jpg')}}" height="50" width="50" style="border-radius: 50%;" /> 
            </a>
            <ul class="header-nav d-none d-md-flex ml-auto">
                <li class="nav-item"><h3> {{__('PerLang.Title') }} </h3></li>
            </ul>
            <ul class="header-nav ms-auto">
                
            </ul>

  <!--  End header Language switch Localization----->
      
            <ul class="header-nav ms-3">
                <li class="nav-item dropdown">
                    <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                         
                               
                       @php($language = ['en' => 'English', 'am' => 'አማርኛ'])
                        <div>{{__('PerLang.LangSelected') }} : {{ $language[Session('locale', 'en')] }}</div>
                             
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <!--<a href="javascript:void(0)"  class="dropdown-item" style="cursor: none; color: #065699; "> 
                            <strong></strong>
                         </a>-->
                        <a class="dropdown-item" href="{{ route('lang.change', ['lang' => 'en']) }}">
                            
                            {{__('PerLang.English')}}
                         </a>
                      
                            <a class="dropdown-item" href="{{ route('lang.change', ['lang' => 'am']) }}">
                                
                            {{__('PerLang.Amharic')}}
                            </a>
                      
                    </div>
                </li>
            </ul>

                        <!--  End header Language switch Localization----->

            <ul class="header-nav ms-3">
                <li class="nav-item dropdown">
                    <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                         <h5 > <i class="fa-solid fa-user-graduate" style="color: #114c5f;"></i> 
                           <strong style="padding: 4px 4px 4px 4px; color:#065699; border-radius: 33%; background-color: #DBE3EE;">
                           

                             {{ Str::of(preg_replace('/^Dr\.\s*/i', '', $firstName))->substr(0, 1) }}{{ Str::of(trim($middleName))->substr(0, 1) }}

                             <!-- to remove Space from start and end of the names -->
                             </strong> 
                            </h5>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <a href="javascript:void(0)"  class="dropdown-item" style="cursor: none; color: #065699; "> 
                            <strong>{{ $firstName}}  {{ $middleName }}</strong>
                         </a>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="fa-regular fa-user"></i>
                            {{ __('My profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                {{ __('Logout') }}
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <div class="body flex-grow-1  mb-5">
        <div class="container-md">
            @yield('content')
        </div>
    </div>



<!-- Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="contactModalLabel">Contact Support Team</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center" style="color:#1f597a; font-weight: bold; text-decoration: underline;">If you encounter any issues or need support, please contact our Technical support team.</p>
                <div class="row">
                    <!-- Contact Card 1 -->
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 p-3 rounded-3">
                            <h5 class="mb-2 " style="color:#206d8a;">Mr. Andualem Muche</h5>
                            <p><strong>Phone:</strong> <a href="tel:+251918344760" class="text-decoration-none text-dark">+251-918-344-760</a></p>
                            <p><strong>Email:</strong> <a href="mailto:andualem.muche@inu.edu.et" class="text-decoration-none text-primary">andualem.muche@inu.edu.et</a></p>
                        </div>
                    </div>
                    <!-- Contact Card 2 -->
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 p-3 rounded-3">
                            <h5 class="mb-2 " style="color:#206d8a;">Mr. Ahmed Mohamed</h5>
                            <p><strong>Phone:</strong> <a href="tel:+251943549543" class="text-decoration-none text-dark">+251-943-549-543</a></p>
                            <p><strong>Email:</strong> <a href="mailto:ahmed.mohamed@inu.edu.et" class="text-decoration-none text-primary">ahmed.mohamed@inu.edu.et</a></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <!-- Contact Card 4 -->
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 p-3 rounded-3">
                            <h5 class="mb-2 " style="color:#206d8a;">Mr. Hulunayehu Molla</h5>
                            <p><strong>Phone:</strong> <a href="tel:+251918569686" class="text-decoration-none text-dark">+251-908-931-408</a></p>
                            <p><strong>Email:</strong> <a href="mailto:demeke.alene@inu.edu.et" class="text-decoration-none text-primary">Hulunayehu.molla@inu.edu.et</a></p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 p-3 rounded-3">
                            <h5 class="mb-2 " style="color:#206d8a;">Mr. Abraham Sewnet</h5>
                            <p><strong>Phone:</strong> <a href="tel:+251973790061" class="text-decoration-none text-dark">+251-973-790-061</a></p>
                            <p><strong>Email:</strong> <a href="mailto:abraham.sewnet@inu.edu.et" class="text-decoration-none text-primary">abraham.sewnet@inu.edu.et</a></p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer d-flex justify-content-between align-items-center py-4 px-5 bg-light border-top">
    <!-- Left: University Name & Copyright -->
    <div class="fw-bold" style="color:#13566f;">INJIBARA UNIVERSITY &copy; 2018 ዓ.ም.</div>

    <!-- Center: Help Center (Emphasized) -->
    <div class="text-center flex-grow-1">
        <label class="fw-semibold me-2">For any support:</label>
        <a href="#" class="fw-bold text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#contactModal">Help Center</a>
    </div>

    <!-- Right: Designed By -->
    <div class="ms-auto">
        <span class="fw-bold">Designed by &nbsp;</span>
        <span class="fw-bold" style="color: #0e6a83;">CS Staff</span>
    </div>
</footer>


<!-- Add Bootstrap JS script (make sure to include this in your project) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->



</div>
<script type="text/javascript" src="{{asset('assets/bootstrap-5.3.1/js/bootstrap.bundle.min.js')}}"></script>

<!-- <script type="text/javascript" src="{{asset('assets/bootstrap-5.3.1/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/jquery-3.7.0.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/jquery.dataTables.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.bulma.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.buttons.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/jszip.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/pdfmake.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/buttons.colVis.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.colReorder.min.js' )}}"></script>

<script type="text/javascript" src="{{ asset('assets/datatables/js/vfs_fonts.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/buttons.html5.min.js' )}}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/buttons.print.min.js' )}}"></script>

<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.select.js' )}}"></script>  -->

<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>


<script type="text/javascript">
    
/*    document.addEventListener('contextmenu', (event) => event.preventDefault());
document.addEventListener('keydown', (event) => {
    if (event.key === 'F12' || (event.ctrlKey && event.shiftKey && event.key === 'I')) {
        event.preventDefault();
    }
});*/



document.addEventListener("DOMContentLoaded", function () {
    // Find the highlighted menu item
    const highlighted = document.querySelector(".highlighted");

    // If there's a highlighted item, scroll it into view
    if (highlighted) {
        highlighted.scrollIntoView({
            behavior: "smooth", // Smooth scrolling animation
            block: "center",    // Center the element in the viewport
        });
    }
});




</script>


</body>
</html>
