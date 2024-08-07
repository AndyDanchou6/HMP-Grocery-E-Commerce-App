<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>
  <ul class="navbar-nav flex-row align-items-center ms-auto">
    @if(Auth::user()->role == 'Admin')
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('settings.index') }}" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='bx bx-cog bx-spin mb-1'></i> <span>Settings</span>">
      <i class="bx bx-cog bx-sm bx-spin-hover"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('selectedItems.history') }}" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='bx bx-box bx-tada mb-1'></i> <span>Package History</span>">
      <i class="bx bx-box bx-sm bx-tada-hover"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('schedules.index') }}" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='bx bx-calendar bx-tada mb-1'></i> <span>Delivery Schedules</span>">
      <i class="bx bx-calendar bx-sm bx-tada-hover"></i>
    </a>
    <li class="nav-item dropdown text-primary" id="notification-icon">
      <a class="nav-link px-0 me-xl-4 navbar-icon notification-toggle nav-link-lg" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i id="notificationIcon" class="bx bx-bell bx-sm"></i>
        <span id="notificationCount" class="badge bg-danger d-none">0</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end pullDown" aria-labelledby="notificationDropdown">
        <div class="dropdown-header">
          <i class="bx bx-bell bx-tada mb-1"></i> Notifications
        </div>
        <ul id="notificationList" class="list-unstyled mb-0"></ul>
      </ul>
    </li>
    @include('layouts.script.admin.adminNotification')
    @elseif(Auth::user()->role == 'Customer')
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('shop.index') }}" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='bx bxs-store bx-tada'></i> <span>Shop</span>">
      <i class="bx bxs-store bx-sm bx-tada-hover"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('customers.orders') }}" id="active-state" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='bx bx-box bx-tada mb-1'></i> <span>Order History</span>">
      <i class="bx bx-box bx-sm bx-tada-hover"></i>
    </a>
    <li class="nav-item dropdown text-primary" id="notification-icon">
      <a class="nav-link px-0 me-xl-4 navbar-icon notification-toggle nav-link-lg" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i id="notificationIcon" class="bx bx-bell bx-sm"></i>
        <span id="notificationCount" class="badge bg-danger d-none">0</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end pullDown" aria-labelledby="notificationDropdown">
        <div class="dropdown-header">
          <i class="bx bx-bell bx-tada mb-1"></i> Notifications
        </div>
        <ul id="notificationList" class="list-unstyled mb-0">
          <li><a class="dropdown-item">No notification found at the moment</a></li>
        </ul>
      </ul>
    </li>
    @include('layouts.script.customers.customerNotification')
    @endif
    <!-- User dropdown -->
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
      <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
          @if(Auth::user()->avatar)
          <img src="{{asset('storage/' . Auth()->user()->avatar)}}" id="user_avatar_modal" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;" />
          @else
          <img src="{{ asset('assets/img/user.png') }}" id="user_avatar_modal" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;" />
          @endif
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#">
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                <div class="avatar avatar-online">
                  @if(Auth::user()->avatar)
                  <img src="{{asset('storage/' . Auth()->user()->avatar)}}" id="user_avatar_modal" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;" />
                  @else
                  <img src="{{ asset('assets/img/user.png') }}" id="user_avatar_modal" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;" />
                  @endif
                </div>
              </div>
              <div class="flex-grow-1">
                <span class="fw-semibold d-block">{{Auth()->user()->name}}</span>
                <small class="text-muted">{{ ucfirst(Auth()->user()->role) }}</small>
              </div>
            </div>
          </a>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          @if(Auth::user()->role == 'Admin')
          <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal{{Auth::user()->id}}">
            <i class="bx bx-user me-2"></i>
            <span class="align-middle">My Profile</span>
          </a>
          @else
          <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal{{Auth::user()->id}}">
            <i class="bx bx-user me-2"></i>
            <span class="align-middle">My Profile</span>
          </a>
          @endif
        </li>
        <li>
          @if(Auth::user()->role == 'Customer')
          <a class="dropdown-item" href="{{ route('customers.unpaid_orders') }}">
            <span class="d-flex align-items-center align-middle">
              <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
              <span class="flex-grow-1 align-middle">Billing</span>
              <span id="unpaidOrders" class="badge badge-center rounded-pill bg-danger"></span>
            </span>
          </a>
          @include('layouts.script.customers.countOrders')
          @endif
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bx bx-power-off me-2"></i>
            <span class="align-middle">Log Out</span>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>


@include('profile.edit')
@include('profile.editUser')
@include('layouts.modal._logoutModal')
@include('layouts.sweetalert')