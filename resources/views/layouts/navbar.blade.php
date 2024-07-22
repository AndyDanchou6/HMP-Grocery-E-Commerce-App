<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>
  <ul class="navbar-nav flex-row align-items-center ms-auto">
    @if(Auth::user()->role == 'Customer')
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('shop.index') }}">
      <i class="bi bi-shop bx-sm bx-fade-up-hover"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('customers.orders') }}" id="active-state">
      <i class="bx bx-history bx-sm bx-tada-hover"></i>
    </a>
    @endif
    @if(Auth::user()->role == 'Admin')
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('selectedItems.history') }}">
      <i class="bx bx-history bx-sm bx-tada-hover"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('schedules.index') }}">
      <i class="bx bx-calendar bx-sm bx-tada-hover"></i>
    </a>
    <li class="nav-item dropdown text-primary" id="notification-icon">
      <a class="nav-link px-0 me-xl-4 navbar-icon notification-toggle nav-link-lg" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i id="notificationIcon" class="bx bx-bell bx-sm"></i>
        <span id="notificationCount" class="badge bg-danger d-none">0</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end pullDown" aria-labelledby="notificationDropdown">
        <div class="dropdown-header">Notifications</div>
        <ul id="notificationList" class="list-unstyled mb-0"></ul>
      </ul>
    </li>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const notificationIcon = document.getElementById('notificationIcon');
        const notificationList = document.getElementById('notificationList');
        const notificationCountElement = document.getElementById('notificationCount');

        if (!sessionStorage.getItem('notificationCount')) {
          sessionStorage.setItem('notificationCount', 0);
        }
        if (!sessionStorage.getItem('notificationBellState')) {
          sessionStorage.setItem('notificationBellState', 'inactive');
        }
        if (!sessionStorage.getItem('previousNotificationMessages')) {
          sessionStorage.setItem('previousNotificationMessages', JSON.stringify([]));
        }

        function initializeNotificationState() {
          const notificationBellState = sessionStorage.getItem('notificationBellState');
          const notificationCount = sessionStorage.getItem('notificationCount');

          if (notificationBellState === 'active') {
            notificationIcon.classList.add('bx-tada');
            notificationIcon.classList.add('text-danger');
          } else {
            notificationIcon.classList.remove('bx-tada');
            notificationIcon.classList.remove('text-danger');
          }

          if (notificationCountElement) {
            notificationCountElement.textContent = notificationCount;
            if (parseInt(notificationCount) > 0) {
              notificationCountElement.classList.remove('d-none');
            } else {
              notificationCountElement.classList.add('d-none');
            }
          }
        }

        function showNotifications() {
          const previousNotificationMessages = JSON.parse(sessionStorage.getItem('previousNotificationMessages')) || [];

          if (notificationList) {
            const html = previousNotificationMessages.map((msg, index) => {
              if (index === 0) {
                return `<li><a class="dropdown-item text-danger text-wrap new-notification" href="{{ route('selectedItems.forPackaging') }}">${msg}</a></li>`;
              } else {
                return `<li><a class="dropdown-item text-wrap" href="{{ route('selectedItems.forPackaging') }}">${msg}</a></li>`;
              }
            }).join('');
            notificationList.innerHTML = html;

            setTimeout(() => {
              const newNotifications = document.querySelectorAll('.new-notification');
              newNotifications.forEach(notification => {
                notification.classList.remove('text-danger');
              });
            }, 30000);
          } else {
            console.error('Error: notificationList element not found.');
          }

          if (previousNotificationMessages.length === 0) {
            notificationList.innerHTML += `<li><a class="dropdown-item">No notification found at the moment</a></li>`;
          }
        }

        function removeNotificationByReference(referenceNo) {
          let previousNotificationMessages = JSON.parse(sessionStorage.getItem('previousNotificationMessages')) || [];
          previousNotificationMessages = previousNotificationMessages.filter(msg => !msg.includes(referenceNo));
          sessionStorage.setItem('previousNotificationMessages', JSON.stringify(previousNotificationMessages));
        }

        function fetchAndDisplayNotifications() {
          fetch('{{ route("selectedItems.notification") }}')
            .then(response => response.json())
            .then(data => {
              const previousNotificationMessages = JSON.parse(sessionStorage.getItem('previousNotificationMessages')) || [];
              const currentNotificationMessages = data.notification_message.split('.').filter(msg => msg.trim() !== '');

              if (currentNotificationMessages.length > 0 && JSON.stringify(currentNotificationMessages) !== JSON.stringify(previousNotificationMessages)) {
                sessionStorage.setItem('previousNotificationMessages', JSON.stringify(currentNotificationMessages));
                showNotifications();

                const msg = currentNotificationMessages[0];
                if (!previousNotificationMessages.includes(msg)) {
                  toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    showDuration: '300',
                    hideDuration: '1000',
                    timeOut: '3000',
                    showEasing: 'swing',
                    hideEasing: 'linear',
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut'
                  };

                  toastr.info(`<strong>${msg}</strong>`);

                  if (msg.includes('Finished packaging')) {
                    sessionStorage.setItem('notificationBellState', 'active');
                    notificationIcon.classList.add('bx-tada', 'text-danger');

                    const newCount = parseInt(sessionStorage.getItem('notificationCount')) + 1;
                    sessionStorage.setItem('notificationCount', newCount.toString());
                    if (notificationCountElement) {
                      notificationCountElement.textContent = newCount;
                      notificationCountElement.classList.remove('d-none');
                    }

                    setTimeout(() => {
                      sessionStorage.setItem('notificationBellState', 'inactive');
                      notificationIcon.classList.remove('bx-tada', 'text-danger');
                      sessionStorage.setItem('notificationCount', '0');
                      notificationCountElement.textContent = '0';
                      notificationCountElement.classList.add('d-none');
                    }, 5000);
                  }
                }

              } else {
                sessionStorage.setItem('notificationBellState', 'inactive');
                notificationIcon.classList.remove('bx-tada', 'text-danger');
              }
            })
            .catch(error => {
              console.error('Error fetching latest notifications:', error);
            })
            .finally(() => {
              setTimeout(fetchAndDisplayNotifications, 5000);
            });
        }

        initializeNotificationState();
        showNotifications();
        fetchAndDisplayNotifications();

        notificationIcon.addEventListener('click', function() {
          sessionStorage.setItem('notificationBellState', 'inactive');
          sessionStorage.setItem('notificationCount', '0');
          initializeNotificationState();
        });
      });
    </script>
    @elseif(Auth::user()->role == 'Customer')
    <li class="nav-item dropdown text-primary" id="notification-icon">
      <a class="nav-link px-0 me-xl-4 navbar-icon notification-toggle nav-link-lg" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i id="notificationIcon" class="bx bx-bell bx-sm"></i>
        <span id="notificationCount" class="badge bg-danger d-none">0</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end pullDown " aria-labelledby="notificationDropdown">
        <div class="dropdown-header">Notifications</div>
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