<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    @if(Auth::user()->role == 'Admin')
    <a href="{{ route('admin.home') }}" class="app-brand-link">
      @elseif(Auth::user()->role == 'Customer')
      <a href="{{ route('customer.home') }}" class="app-brand-link">
        @else
        <a href="{{ route('courier.home') }}" class="app-brand-link">
          @endif
          <span class="app-brand-logo demo">
          </span>

          <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: none;"><img src="{{asset('logo/4.png')}}" alt=""></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>

  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @if(Auth::user()->role == 'Admin')
    <li id="dashboard" class="menu-item">
      <a href="{{ route('admin.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    @elseif(Auth::user()->role == 'Customer')
    <li id="dashboard" class="menu-item">
      <a href="{{ route('customer.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    @else
    <li id="dashboard" class="menu-item">
      <a href="{{ route('courier.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    @endif
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li>

    @if(Auth::user()->role == 'Admin')
    <li id="tables" class="menu-item">
      <a href="{{ route('users.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Tables">Users</div>
      </a>
    </li>

    <li id="tables" class="menu-item">
      <a href="{{ route('inventories.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div data-i18n="Tables">Inventory</div>
      </a>
    </li>

    <li id="tables" class="menu-item">
      <a href="{{ route('categories.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-ul "></i>
        <div data-i18n="Tables">Category</div>
      </a>
    </li>
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.forPackaging') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-box-seam "></i>
        <div data-i18n="Tables">For Packaging</div>
      </a>
    </li>
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.forDelivery') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-truck "></i>
        <div data-i18n="Tables">For Delivery</div>
      </a>
    </li>
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.forPickup') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-bag "></i>
        <div data-i18n="Tables">For Pickup</div>
      </a>
    </li>
    @endif
    @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Customer')
    <li id="tables" class="menu-item">
      <a href="{{ route('reviews.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-chat-left"></i>
        <div data-i18n=" Tables">Reviews</div>
      </a>
    </li>
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.orders') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-ul "></i>
        <div data-i18n="Tables">Orders</div>
      </a>
    </li>
    @endif
    @if(Auth::user()->role == 'Courier')
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.courierDashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-ul "></i>
        <div data-i18n="Tables">Delivery Request</div>
      </a>
    </li>
    @endif
</aside>