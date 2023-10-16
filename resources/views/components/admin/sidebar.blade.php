
@php
    $user = auth()->user();
    $userRole = $user->type;
@endphp


<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="" class="app-brand-link">
        <span class="app-brand-logo demo">

        </span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2"><img src="https://webeesocial.ca/wp-content/uploads/2022/12/logo-tm.png" width="120" height="auto"></span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
     

       {{---To-do's---}}


       {{-- <li class="menu-item @if(request()->routeIs('task-index') || request()->routeIs('task-create') || request()->routeIs('task-edit')) active @endif">
        <a href="{{ route('task-index')}}" class="menu-link ">
          <i class="menu-icon bx bx-grid "></i>
          <div data-i18n="Layouts">To-do's</div>
        </a>
      </li> --}}


      <li class="menu-item @if(request()->routeIs('task-index') || request()->routeIs('task-create') || request()->routeIs('task-edit')) active @endif">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div class="text-truncate" data-i18n="Dashboards">To-do's</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item active">
            <a href="{{ route('task-index')}}" class="menu-link">
              <div class="text-truncate" data-i18n="Analytics">My To-do's</div>
            </a>
          </li>


          @if($userRole == 2 || $userRole == 1)       
          <li class="menu-item">
            <a href="{{ route('team-members')}}" class="menu-link">
              <div class="text-truncate" data-i18n="CRM">Team To-do's</div>
            </a>
          </li>
          @endif
        </ul>
      </li>
      


      @if($userRole == 1 )
  
      {{-- Employee--}}
      <li class="menu-item @if(request()->routeIs('user-index') || request()->routeIs('user-create') || request()->routeIs('user-edit')) active @endif">
        <a href="{{ route('user-index') }}" class="menu-link">
          <i class="menu-icon bx bxs-user-account"></i>
          <div data-i18n="Layouts">Employees</div>
        </a>
      </li>
      
      
      {{-- Teams --}}

      <li class="menu-item @if(request()->routeIs('teams-index') || request()->routeIs('teams-create') || request()->routeIs('teams-edit')) active @endif">
        <a href="{{ route('teams-index') }}" class="menu-link ">
          <i class='menu-icon bx bxl-microsoft-teams'></i>
          
          <div data-i18n="Layouts">Teams</div>
        </a>
      </li>
      @endif

      {{-- Activities --}}

      <li class="menu-item @if(request()->routeIs('activity-index') || request()->routeIs('activity-create') || request()->routeIs('activity-edit')) active @endif">
        <a href="{{ route('activity-index') }}" class="menu-link ">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Activities</div>
        </a>
      </li> 


     
    </ul>
  </aside>