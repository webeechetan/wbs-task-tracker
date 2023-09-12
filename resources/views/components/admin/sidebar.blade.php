<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
          
        </span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2">WeBeeSocial</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item active">
        <a href="" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>

      <!-- Layouts -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Employees</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('user-index') }}" class="menu-link">
              <div data-i18n="Without menu">All Employees</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('user-create') }}" class="menu-link">
              <div data-i18n="Without menu">New Employees</div>
            </a>
          </li>
        </ul>
      </li>
      {{-- Teams --}}

      <li class="menu-item">
        <a href="{{ route('teams-index') }}" class="menu-link ">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Teams</div>
        </a>
      </li>

      {{-- Clients --}}

      <li class="menu-item">
        <a href="{{ route('clients-index') }}" class="menu-link ">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Clients</div>
        </a>
      </li>

      

    </ul>
  </aside>