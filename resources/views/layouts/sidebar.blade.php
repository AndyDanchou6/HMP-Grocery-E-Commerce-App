<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    @if(Auth::user()->role == 'Admin')
    <a href="{{ route('admin.home') }}" class="app-brand-link">
      @elseif(Auth::user()->role == 'Customer')
      <a href="{{ route('customer.home') }}" class="app-brand-link">
        @else
        <a href="{{ route('courier.home') }}" class="app-brand-link">
          @endif
          <span class="app-brand-logo demo"></span>
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
    @if(Auth::user()->role == 'Admin')
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Admin Section</span></li>
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
    <li id="forPackaging" class="menu-item">
      <a href="{{ route('selectedItems.forPackaging') }}" class="menu-link" style="position: relative;">
        <i class="menu-icon tf-icons bi bi-box-seam"></i>
        <span data-i18n="For Packaging">For Packaging</span>
        <span id="forPackagingCount" class="badge bg-danger rounded-pill" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
      </a>
    </li>
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.forDelivery') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-truck "></i>
        <span data-i18n="Tables">For Delivery</span>
        <span id="forDeliveryCount" class="badge bg-danger rounded-pill" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
      </a>
    </li>
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.forPickup') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-bag "></i>
        <span data-i18n="Tables">For Pickup</span>
        <span id="forPickupCount" class="badge bg-danger rounded-pill" style="color: white; position: absolute; top: 30%; left: 190px;"></span>

      </a>
    </li>
    @endif
    @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Customer')
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li>
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
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Courier Section</span></li>
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.courierDashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-ul "></i>
        <div data-i18n="Tables">Delivery Request</div>
      </a>
    </li>
    @endif
  </ul>
</aside>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
      cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
      encrypted: true
    });

    var channel = pusher.subscribe('orders');
    channel.bind('order.placed', function(data) {
      // console.log('New order placed:', data);
      updateForPackagingCount();
    });

    function updateForPackagingCount() {
      fetch('{{ route("selectedItems.forPackagingCount") }}')
        .then(response => response.json())
        .then(data => {

          const forPackagingCount = document.getElementById('forPackagingCount');

          if (forPackagingCount) {
            if (data.count1) {
              forPackagingCount.textContent = data.count1;
            } else {
              forPackagingCount.style.display = 'none';
            }
          }

          const forDeliveryCount = document.getElementById('forDeliveryCount');

          if (forDeliveryCount) {
            if (data.count2) {
              forDeliveryCount.textContent = data.count2;
            } else {
              forDeliveryCount.style.display = 'none';
            }
          }

          const forPickupCount = document.getElementById('forPickupCount');

          if (forPickupCount) {
            if (data.count2) {
              forPickupCount.textContent = data.count2;
            } else {
              forPickupCount.style.display = 'none';
            }
          }

        })
        .catch(error => {
          console.error('Error fetching count:', error);
        });
    }

    updateForPackagingCount();
  });
</script>