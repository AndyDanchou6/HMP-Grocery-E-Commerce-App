<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <!-- ...Existing navbar code... -->
  <ul class="navbar-nav flex-row align-items-center ms-auto">
    @if(Auth::user()->role != 'Courier')
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('carts.index') }}">
      <i class="bx bx-cart bx-sm"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('shop.index') }}">
      <i class="bi bi-shop bx-sm"></i>
    </a>
    @endif
    @if(Auth::user()->role == 'Admin')
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('selectedItems.history') }}">
      <i class="bx bx-history bx-sm"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('schedules.index') }}">
      <i class="bx bx-history bx-sm"></i>
    </a>
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
                <span class="fw-semibold d-block" id="user_name">{{ Auth::user()->name }}</span>
                <small class="text-muted" id="user_email">{{ Auth::user()->role }}</small>
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
          <a class="dropdown-item" href="#">
            <span class="d-flex align-items-center align-middle">
              <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
              <span class="flex-grow-1 align-middle">Billing</span>
              <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
            </span>
          </a>
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
<!-- /Navbar -->

@include('profile.edit')
@include('profile.editUser')
@include('layouts.modal._logoutModal')
@include('layouts.sweetalert')