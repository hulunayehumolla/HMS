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

<!-- //ROMS// -->
        @canany(['add-rooms','update-rooms','delete-rooms'])
            <li class="nav-group" aria-expanded="false">
                <a href="#" class="nav-link nav-group-toggle" id="parent-link">
                    <i class="mx-2 fa-solid fa-bed" style="color: #fff;"></i>
                    {{ __('Rooms') }}
                </a>
                <ul class="nav-group-items ml-1">
                    @can('add-rooms')
                    <li class="nav-item">
                        <a id="child-link" href="{{ route('rooms.create') }}" class="nav-link">
                            <i class="nav-icon fa-solid fa-door-open" style="color: #fff;"></i>
                            Add Rooms
                        </a>
                    </li>
                    @endcan
                    
                    @can('view-rooms')
                    <li class="nav-item">
                        <a id="child-link" href="{{ route('rooms.index') }}" class="nav-link">
                            <i class="nav-icon fa-solid fa-list-ul" style="color: #fff;"></i>
                            View Rooms
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

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