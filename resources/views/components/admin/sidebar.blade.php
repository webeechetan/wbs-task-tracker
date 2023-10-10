
@php
    $user = auth()->user();
    $userType = $user->type;
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
      <!-- Dashboard -->
      <li class="menu-item @if(request()->routeIs('dashboard')) active @endif">
        <a href="" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>


      @if($userType === 1|| $userType === 2)
  
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


      {{---To-do's---}}


      <li class="menu-item @if(request()->routeIs('task-index') || request()->routeIs('task-create') || request()->routeIs('task-edit')) active @endif">
        <a href="{{ route('task-index')}}" class="menu-link ">
          <i class="menu-icon bx bx-grid "></i>
          <div data-i18n="Layouts">To-do's</div>
        </a>
      </li>

    </ul>
  </aside>