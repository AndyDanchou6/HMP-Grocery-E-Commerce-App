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
          <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: none;">
            <img src="{{ asset('logo/4.png') }}" alt="">
          </span>
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
    @elseif(Auth::user()->role == 'Courier')
    <li id="dashboard" class="menu-item">
      <a href="{{ route('courier.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    @elseif(Auth::user()->role == 'SuperAdmin')
    <li id="dashboard" class="menu-item">
      <a href="{{ route('superAdmin.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    @else
    <li id="dashboard" class="menu-item">
      <a href="{{ route('customer.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    @endif
    @if(Auth::user()->role == 'SuperAdmin')
    <li class="menu-header small text-uppercase"><span class="menu-header-text">SuperAdmin Section</span></li>
    <li id="user-tables" class="menu-item">
      <a href="{{ route('users.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Tables">Users</div>
      </a>
    </li>
    @endif
    @if(Auth::user()->role == 'Admin')
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Admin Section</span></li>
    <li id="user-tables" class="menu-item">
      <a href="{{ route('users.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Tables">Users</div>
      </a>
    </li>
    <li id="inventory-tables" class="menu-item">
      <a href="{{ route('inventories.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div data-i18n="Tables">Inventory</div>
      </a>
    </li>
    <li id="category-tables" class="menu-item">
      <a href="{{ route('categories.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-ul"></i>
        <div data-i18n="Tables">Category</div>
      </a>
    </li>
    <li id="service_fee-tables" class="menu-item">
      <a href="{{ route('serviceFee.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-map"></i>
        <div data-i18n="Tables">Service Fees</div>
      </a>
    </li>
    <li id="forPackaging" class="menu-item">
      <a href="{{ route('selectedItems.forPackaging') }}" class="menu-link" style="position: relative;">
        <i class="menu-icon tf-icons bi bi-box-seam"></i>
        <span data-i18n="For Packaging">For Packaging</span>
        <span id="forPackagingCount" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
      </a>
    </li>
    <li id="forDelivery-tables" class="menu-item">
      <a href="{{ route('selectedItems.forDelivery') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-truck"></i>
        <span data-i18n="Tables">For Delivery</span>
        <span id="forDeliveryCount" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
      </a>
    </li>
    <li id="forPickup-tables" class="menu-item">
      <a href="{{ route('selectedItems.forPickup') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-bag"></i>
        <span data-i18n="Tables">For Pickup</span>
        <span id="forPickupCount" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
      </a>
    </li>
    <li class="menu-item" id="payment-menu">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bi bi-cash"></i>
        <div data-i18n="Form Elements">Payments</div>
        <i id="paymentAlert" class="bi bi-dot fs-1" style="position: absolute; left: 175px;"></i>
      </a>
      <ul class="menu-sub">
        <li class="menu-item" id="menu-gcash">
          <a href="{{ route('selectedItems.forGcashPayments') }}" class="menu-link">
            <div data-i18n="Basic Inputs">G-cash</div>
            <span id="forPaymentProof" class="badge bg-warning rounded-pill" style="color: white; position: absolute; top: 30%; left: 160px;"></span>
            <span id="forGcashPayments" class="badge bg-danger rounded-pill" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
          </a>
        </li>
        <li class=" menu-item" id="menu-cod">
          <a href="{{ route('selectedItems.forCODPayments') }}" class="menu-link">
            <div data-i18n="Input groups">COD</div>
            <span id="forCODPayments" class="badge bg-danger rounded-pill" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
          </a>
        </li>
        <li class="menu-item" id="menu-instore">
          <a href="{{ route('selectedItems.forInStorePayments') }}" class="menu-link">
            <div data-i18n="Input groups">In-store</div>
            <span id="forInStorePayments" class="badge bg-danger rounded-pill" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
          </a>
        </li>
      </ul>
    </li>
    <li id="forDeniedOrders-tables" class="menu-item">
      <a href="{{ route('selectedItems.deniedOrders') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-cart-x"></i>
        <span data-i18n="Tables">Denied Orders</span>
        <span id="deniedOrders" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 30%; left: 190px;"></span>
      </a>
    </li>
    @include('layouts.script.admin.countOrders')
    @endif
    @if(Auth::user()->role == 'Customer')
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Customer Section</span></li>
    <li id="forUnpaidOrders-tables" class="menu-item">
      <a href="{{ route('customers.unpaid_orders') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-cash"></i>
        <div data-i18n="Tables">Unpaid Orders</div>
        <span id="forUnpaidOrders" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 30%; left: 195px;"></span>
      </a>
    </li>
    <li id="forPendingOrders-tables" class="menu-item">
      <a href="{{ route('customers.pending_orders') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-box-seam"></i>
        <div data-i18n="Tables">Pending Orders</div>
        <span id="forPendingOrders" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 30%; left: 195px;"></span>
      </a>
    </li>
    <li id="forDeliveryOrders-tables" class="menu-item">
      <a href="{{ route('customers.delivery_retrieval') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-truck"></i>
        <div data-i18n="Tables">Orders to Delivery</div>
        <span id="forDeliveryOrders" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 30%; left: 195px;"></span>
      </a>
    </li>
    <li id="forPickupOrders-tables" class="menu-item">
      <a href="{{ route('customers.pickup_retrieval') }}" class="menu-link">
        <i class="menu-icon tf-icons bi bi-bag"></i>
        <div data-i18n="Tables">Orders to Pickup</div>
        <span id="forPickupOrders" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 30%; left: 195px;"></span>
      </a>
    </li>
    @include('layouts.script.customers.countOrders')
    @endif
    @if(Auth::user()->role == 'Courier')
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Courier Section</span></li>
    <li id="tables" class="menu-item">
      <a href="{{ route('selectedItems.courierDashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-ul"></i>
        <div data-i18n="Tables">Delivery Request</div>
        <span id="courierCount" class="badge badge-center rounded-pill bg-danger" style="color: white; position: absolute; top: 20%; left: 200px;"></span>
      </a>
    </li>
    <script src="{{ asset('assets/js/menu.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        function courierTaskCount() {
          fetch('{{ route("selectedItems.courierCount") }}', {
              method: 'GET',
              headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json',
                'Accept': 'application/json'
              },
              credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
              const courierCount = document.getElementById('courierCount');
              if (courierCount) {
                courierCount.textContent = data.deliveryRequest;
                courierCount.style.display = data.deliveryRequest ? 'block' : 'none';
              }
            })
            .catch(error => {
              console.error('Error fetching counts:', error);
            }).finally(() => {
              setTimeout(courierTaskCount, 5000)
            });
        }

        courierTaskCount();
      })
    </script>
    @endif
  </ul>
</aside>