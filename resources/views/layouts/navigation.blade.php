<style type="text/css">
.nav-link.active {
    background-color: #3684BA;
    color: #fff;
}

</style>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" style="<?php if (Request::is('dashboard')) echo 'background-color:#155C8C;'; ?>" href="{{ route('dashboard') }}">
            <i class="mx-2 fa-solid fa-home"> </i>
            {{ __('PerLang.Home') }}
        </a>
    </li>
    

    @canany(['create-user', 'edit-user', 'delete-user'])  
      <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" style="<?php if (Request::is('users') || Request::is('Student-User-List') || Request::is('roles') ) echo 'background-color:#155C8C;'; ?>" href="#">
                <i class="mx-2 fa fa-solid fa-user"></i>{{__('PerLang.UserManagment')}}</a>
            <ul class="nav-group-items" >
                <li class="nav-item">
                    <a class="nav-link" style="<?php if(Request::is('users'))echo 'color: #0b9ddd'; ?>" href="{{route('users.index')}}" target="_top">
                            <i class="mx-2 fa fa-solid fa-user-plus"></i>{{__('PerLang.SystemUser')}} </a>
                </li> 
               
                
            @canany(['create-role', 'edit-role', 'delete-role'])  
                <li class="nav-item">
                 <a class="nav-link" style="<?php if(Request::is('roles'))echo 'color: #0b9ddd'; ?>" href=" {{ route('roles.index') }}">
                  <i class=" mx-2 fa fa-solid fa-user-plus"></i>
               {{ __('PerLang.RoleManagment') }}
            </a>
           </li>
              @endcanany
           </ul>
        </li>
         @endcanany



        <!-- // Staff MENU // -->
 @canany(['add-staff','view-staff','update-staff','delete-staff'])
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="mx-2 fa-solid fa-utensils"></i>
      Staff
    </a>

    <ul class="nav-group-items ms-1">

      <!--   @can('add-staff')
        <li class="nav-item">
            <a href="{{ route('staff.create') }}" class="nav-link">
                <i class="mx-2 nav-icon fa-solid fa-plus "></i>
                Add Staff
            </a>
        </li>
        @endcan --> 

        @can('view-staff')
        <li class="nav-item">
            <a href="{{ route('staff.index') }}" class="nav-link">
                <i class="mx-2 nav-icon fa-solid fa-users"></i>
                Staff List
            </a> 
        </li>
        @endcan

        @can('add-Doctor')
        <li class="nav-item">
            <a href="{{ route('doctor.index') }}" class="nav-link">
                <i class="mx-2 nav-icon fa-solid fa-user-doctor"></i>
                 Doctor
            </a>
        </li>
        @endcan

            @can('add-Nurse')
        <li class="nav-item">
            <a href="{{ route('nurse.index') }}" class="nav-link">
                <i class="mx-2 nav-icon fa-solid fa-user-nurse"></i>
                Nurse
            </a>
        </li>
        @endcan

        @can('add-Pharmacist')
        <li class="nav-item">
            <a href="{{ route('pharmacist.index') }}" class="nav-link">
                <i class="mx-2 nav-icon fa-solid fa-pills"></i>
                Pharmacist
            </a>
        </li>
        @endcan 

        @can('add-laboratory')
        <li class="nav-item">
            <a href="{{ route('laboratory.index') }}" class="nav-link">
                <i class="mx-2 nav-icon fa-solid fa-microscope"></i>
                Laboratory
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcanany


      @canany(['create-patient','update-patent','delete-patient'])
        <li class="nav-group" aria-expanded="false">
            <a href="#" class="nav-link nav-group-toggle" id="parent-link">
                <i class="mx-2 fa-solid fa-door-open" style="color: #fff;"></i>
                {{ __('PerLang.Patients') }}
            </a>
            <ul class="nav-group-items ml-1">
            
            @can('add-patients')
                    <li class="nav-item">
                        <a id="child-link" href="{{ route('patients.index') }}" class="nav-link">
                            <i class="mx-0 nav-icon fa-solid fa-door-open" style="color: #fff;"></i>
                            {{__('PerLang.Patients')}}
                        </a>
                    </li>
            @endcan
            </ul>
        </li>
        @endcanany

              @canany(['create-invoice','update-invoice','delete-invoice'])
        <li class="nav-group" aria-expanded="false">
            <a href="#" class="nav-link nav-group-toggle" id="parent-link">
                <i class="mx-2 fa-solid fa-door-open" style="color: #fff;"></i>
                {{('invoice') }}
            </a>
            <ul class="nav-group-items ml-1">
            
            @can('add-invoice')
                    <li class="nav-item">
                        <a id="child-link" href="{{ route('invoice.index') }}" class="nav-link">
                            <i class="mx-0 nav-icon fa-solid fa-door-open" style="color: #fff;"></i>
                            {{('invoice')}}
                        </a>
                    </li>
            @endcan

            @can('add-invoice')
                    <li class="nav-item">
                        <a id="child-link" href="{{ route('invoice_items.index') }}" class="nav-link">
                            <i class="mx-0 nav-icon fa-solid fa-door-open" style="color: #fff;"></i>
                            {{('invoice_items')}}
                        </a>
                    </li>
            @endcan
            </ul>
        </li>
        @endcanany
<!-- //ROMS// -->
        @canany(['add-department','update-department','delete-department'])
            <li class="nav-group" aria-expanded="false">
                <a href="#" class="nav-link nav-group-toggle" id="parent-link">
                    <i class="mx-2 fa-solid fa-bed" style="color: #fff;"></i>
                    {{ __('departments') }}
                </a>
                <ul class="nav-group-items ml-1">
                    @can('add-department')
                    <li class="nav-item">
                        <a id="child-link" href="{{ route('departments.index') }}" class="nav-link">
                            <i class="mx-0 nav-icon fa-solid fa-door-open" style="color: #fff;"></i>
                            Add department
                        </a>
                    </li>
                    @endcan
                    
<!--                   @can('view-department')
                    <li class="nav-item">
                        <a id="child-link" href="{{ route('departments.index') }}" class="nav-link">
                            <i class="nav-icon fa-solid fa-list-ul" style="color: #fff;"></i>
                            View department
                        </a>
                    </li>
                    @endcan  -->
                </ul>
            </li>
            @endcanany
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="mx-2 fa-solid fa-utensils"></i>
        {{ __('PerLang.Settings') }}
      
    </a>

    <ul class="nav-group-items ms-1">
      <li class="nav-item">
       <a class="nav-link {{ Request::is('hospitals') ? 'active text-primary ' : '' }}"
          href="{{ route('hospitals.index') }}">
          <i class="mx-2 fa-solid fa-heart-pulse"></i>
          {{ __('PerLang.Hospital') }}
         </a>
       </li>

        <li class="nav-item">
       <a class="nav-link {{ Request::is('backup') ? 'active text-primary ' : '' }}"
          href="{{ route('hospitals.index') }}">
          <i class="mx-2 fa-solid fa-heart-pulse"></i>
          {{ __('PerLang.Backup') }}
         </a>
       </li>
        <li class="nav-item">
       <a class="nav-link {{ Request::is('calendar') ? 'active text-primary ' : '' }}"
          href="{{ route('hospitals.index') }}">
          <i class="mx-2 fa-solid fa-heart-pulse"></i>
          {{ __('PerLang.Calendar') }}
         </a>
       </li>

    </ul>
</li>

      @canany(['create-news','update-news','delete-news'])
        <li class="nav-group" aria-expanded="false">
            <a href="#" class="nav-link nav-group-toggle" id="parent-link">
                <i class="mx-2 fa-solid fa-bullhorn" style="color: #fff;"></i>
                {{ __('News') }}
            </a>
            <ul class="nav-group-items ml-1">
                @can('create-news')
                <li class="nav-item">
                    <a id="child-link" href="{{ route('news.create') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-plus-circle" style="color: #fff;"></i>
                        Create News
                    </a>
                </li>
                @endcan
                   @can('view-news')
                <li class="nav-item">
                    <a id="child-link" href="{{ route('news.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-eye" style="color: #fff;"></i>
                        View News
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

</ul> 