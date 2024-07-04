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
      <i class="bx bx-cart bx-sm bx-tada-hover"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('shop.index') }}">
      <i class="bi bi-shop bx-sm bx-fade-up-hover"></i>
    </a>
    @endif
    @if(Auth::user()->role == 'Admin')
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('selectedItems.history') }}">
      <i class="bx bx-history bx-sm bx-tada-hover"></i>
    </a>
    <a class="nav-item nav-link px-0 me-xl-4 navbar-icon" href="{{ route('schedules.index') }}">
      <i class="bx bx-calendar bx-sm bx-tada-hover"></i>
    </a>
    <li class="nav-item dropdown">
      <a class="nav-link px-0 me-xl-4 navbar-icon" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i id="notificationIcon" class="bx bx-bell bx-sm"></i>
        <span id="notificationCount" class="badge bg-danger d-none">0</span> <!-- Hide the count initially -->
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
        <li class="dropdown-header">Notifications</li>
        <li id="notificationListItem"></li>
      </ul>
    </li>



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
<!-- Bootstrap Modal for Notification -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationModalLabel">New Products Purchased!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="notificationModalBody">Loading...</p>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let timeoutId;
    let currentNotificationMessage = '';
    let currentCount = 0;

    function fetchNotifications() {
      fetch('{{ route("selectedItems.notification") }}')
        .then(response => response.json())
        .then(data => {
          if (data.notification_message) {
            showNotifications(data.notification_message);
            if (data.notification_message !== currentNotificationMessage) {
              triggerPopupAnimation(data.notification_message);
              currentNotificationMessage = data.notification_message;
              if (currentCount !== data.count) {
                updateNotificationCount(data.count); // Update notification count only if it has changed
              }
            }
          }
        })
        .catch(error => {
          console.error('Error fetching notifications:', error);
        })
        .finally(() => {
          // Set timeout for next poll
          timeoutId = setTimeout(fetchNotifications, 5000); // Poll every 5 seconds
        });
    }

    function showNotifications(message) {
      const notificationListItem = document.getElementById('notificationListItem');
      const messages = message.split('.').filter(msg => msg.trim() !== ''); // Filter out empty lines
      const html = messages.map(msg => `<a class="dropdown-item" href="#">${msg.trim()}</a>`).join('');
      notificationListItem.innerHTML = html;
    }

    function triggerPopupAnimation(message) {
      // const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
      // document.getElementById('notificationModalBody').textContent = 'New User Puchased New Product';
      // modal.show();
    }

    function updateNotificationCount(count) {
      const notificationCountElement = document.getElementById('notificationCount');
      notificationCountElement.textContent = count;
      if (count > 0) {
        notificationCountElement.classList.remove('d-none'); // Show notification count badge
        document.getElementById('notificationIcon').classList.add('bx-tada');
      } else {
        notificationCountElement.classList.add('d-none'); // Hide notification count badge if count is 0
        document.getElementById('notificationIcon').classList.remove('bx-tada');
      }
      currentCount = count; // Update the current count
    }

    // Handle click event on the bell icon to update notifications and reset count
    const notificationDropdown = document.getElementById('notificationDropdown');
    notificationDropdown.addEventListener('click', function(event) {
      event.preventDefault(); // Prevent default link behavior

      // Reset notification count to 0 when bell icon is clicked
      updateNotificationCount(0);
    });

    // Start fetching notifications
    fetchNotifications();
  });
</script>
@include('profile.edit')
@include('profile.editUser')
@include('layouts.modal._logoutModal')
@include('layouts.sweetalert')