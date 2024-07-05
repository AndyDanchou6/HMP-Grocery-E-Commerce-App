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
        <ul id="notificationList" class="list-unstyled mb-0"></ul> <!-- Changed to ul with id notificationList -->
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

<!-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    const notificationIcon = document.getElementById('notificationIcon');
    const notificationList = document.getElementById('notificationList'); // Assuming this is where notifications will be displayed
    const notificationCountElement = document.getElementById('notificationCount'); // Element to display notification count

    // Initialize sessionStorage variables if they don't already exist
    if (!sessionStorage.getItem('notificationCount')) {
      sessionStorage.setItem('notificationCount', 0);
    }
    if (!sessionStorage.getItem('notificationBellState')) {
      sessionStorage.setItem('notificationBellState', 'inactive');
    }
    if (!sessionStorage.getItem('previousNotificationMessage')) {
      sessionStorage.setItem('previousNotificationMessage', '');
    }

    // Function to handle initial state setup
    function initializeNotificationState() {
      const notificationBellState = sessionStorage.getItem('notificationBellState');
      const notificationCount = sessionStorage.getItem('notificationCount');
      if (notificationBellState === 'active') {
        notificationIcon.classList.add('bx-tada');
        notificationIcon.classList.add('text-danger'); // Apply red color or any style for active state
      } else {
        notificationIcon.classList.remove('bx-tada');
        notificationIcon.classList.remove('text-danger'); // Remove red color or any style for inactive state
      }
      if (notificationCountElement) {
        notificationCountElement.textContent = notificationCount;
        if (parseInt(notificationCount) > 0) {
          notificationCountElement.classList.remove('d-none'); // Show count if there are notifications
        } else {
          notificationCountElement.classList.add('d-none'); // Hide count if there are no notifications
        }
      }
    }

    function triggerPopupAnimation() {

    }

    // Function to display notifications in the dropdown menu
    function showNotifications() {
      const previousNotificationMessage = sessionStorage.getItem('previousNotificationMessage');
      if (notificationList) {
        const html = previousNotificationMessage.split('.').filter(msg => msg.trim() !== '')
          .map(msg => `<li><a class="dropdown-item" href="#">${msg}</a></li>`).join('');
        notificationList.innerHTML = html;
      } else {
        console.error('Error: notificationList element not found.');
      }
    }

    // Initialize notification state and show previous notifications on page load
    initializeNotificationState();
    showNotifications();

    // Variable to track whether the bell icon has been animated or turned red
    let hasAnimated = false;

    // Function to fetch latest notifications and update sessionStorage
    function fetchAndDisplayNotifications() {
      fetch('{{ route("selectedItems.notification") }}')
        .then(response => response.json())
        .then(data => {
          console.log('Received notifications:', data);

          const previousNotificationMessage = sessionStorage.getItem('previousNotificationMessage');
          const currentNotificationMessage = data.notification_message;

          // Check if there are new notifications
          if (currentNotificationMessage && currentNotificationMessage.trim() !== '' && currentNotificationMessage !== previousNotificationMessage) {
            const messages = currentNotificationMessage.split('.').filter(msg => msg.trim() !== '');
            sessionStorage.setItem('previousNotificationMessage', currentNotificationMessage); // Update previous notification message
            showNotifications(); // Update displayed notifications
            triggerPopupAnimation(currentNotificationMessage);

            // Update the notification count to 1 (since we're counting new notifications as 1 each)
            const newCount = 1;
            sessionStorage.setItem('notificationCount', newCount);
            if (notificationCountElement) {
              notificationCountElement.textContent = newCount;
              notificationCountElement.classList.remove('d-none'); // Show count if there are notifications
            }

            // Toggle bell icon to active state only if not already animated
            if (!hasAnimated) {
              sessionStorage.setItem('notificationBellState', 'active');
              notificationIcon.classList.add('bx-tada');
              notificationIcon.classList.add('text-danger'); // Apply red color and animation
              hasAnimated = true; // Set flag to true after first animation
            }

            // Reset inactive state and count after 5 seconds
            setTimeout(() => {
              sessionStorage.setItem('notificationBellState', 'inactive');
              notificationIcon.classList.remove('bx-tada');
              notificationIcon.classList.remove('text-danger'); // Remove red color and animation
              hasAnimated = false; // Reset animation flag

              // Reset notification count to 0 when no new notifications
              sessionStorage.setItem('notificationCount', 0);
              if (notificationCountElement) {
                notificationCountElement.textContent = 0;
                notificationCountElement.classList.add('d-none'); // Hide count when reset to 0
              }
            }, 5000);

          } else {
            // No new notifications, toggle to inactive state
            sessionStorage.setItem('notificationBellState', 'inactive');
            notificationIcon.classList.remove('bx-tada');
            notificationIcon.classList.remove('text-danger'); // Remove red color and animation
            hasAnimated = false; // Reset animation flag

            // Reset notification count to 0 when no new notifications
            sessionStorage.setItem('notificationCount', 0);
            if (notificationCountElement) {
              notificationCountElement.textContent = 0;
              notificationCountElement.classList.add('d-none'); // Hide count when reset to 0
            }
          }
        })
        .catch(error => {
          console.error('Error fetching latest notifications:', error);
        });
    }

    // Initialize notification state and fetch latest notifications on page load
    initializeNotificationState();
    showNotifications();
    fetchAndDisplayNotifications();

    // Set a setInterval to periodically fetch and display notifications
    setInterval(fetchAndDisplayNotifications, 5000);
  });
</script> -->


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const notificationIcon = document.getElementById('notificationIcon');
    const notificationList = document.getElementById('notificationList'); // Assuming this is where notifications will be displayed
    const notificationCountElement = document.getElementById('notificationCount'); // Element to display notification count

    // Initialize sessionStorage variables if they don't already exist
    if (!sessionStorage.getItem('notificationCount')) {
      sessionStorage.setItem('notificationCount', 0);
    }
    if (!sessionStorage.getItem('notificationBellState')) {
      sessionStorage.setItem('notificationBellState', 'inactive');
    }
    if (!sessionStorage.getItem('previousNotificationMessages')) {
      sessionStorage.setItem('previousNotificationMessages', JSON.stringify([])); // Initialize as an empty array
    }

    // Function to handle initial state setup
    function initializeNotificationState() {
      const notificationBellState = sessionStorage.getItem('notificationBellState');
      const notificationCount = sessionStorage.getItem('notificationCount');
      if (notificationBellState === 'active') {
        notificationIcon.classList.add('bx-tada');
        notificationIcon.classList.add('text-danger'); // Apply red color or any style for active state
      } else {
        notificationIcon.classList.remove('bx-tada');
        notificationIcon.classList.remove('text-danger'); // Remove red color or any style for inactive state
      }
      if (notificationCountElement) {
        notificationCountElement.textContent = notificationCount;
        if (parseInt(notificationCount) > 0) {
          notificationCountElement.classList.remove('d-none'); // Show count if there are notifications
        } else {
          notificationCountElement.classList.add('d-none'); // Hide count if there are no notifications
        }
      }
    }

    // Function to display notifications in the dropdown menu
    function showNotifications() {
      const previousNotificationMessages = JSON.parse(sessionStorage.getItem('previousNotificationMessages')) || [];
      if (notificationList) {
        const html = previousNotificationMessages.map(msg => `<li><a class="dropdown-item" href="#">${msg}</a></li>`).join('');
        notificationList.innerHTML = html;
      } else {
        console.error('Error: notificationList element not found.');
      }
    }

    // Initialize notification state and show previous notifications on page load
    initializeNotificationState();
    showNotifications();

    // Variable to track whether the bell icon has been animated or turned red
    let hasAnimated = false;

    function triggerPopupAnimation() {}

    // Function to fetch latest notifications and update sessionStorage
    function fetchAndDisplayNotifications() {
      fetch('{{ route("selectedItems.notification") }}')
        .then(response => response.json())
        .then(data => {
          console.log('Received notifications:', data);

          const previousNotificationMessages = JSON.parse(sessionStorage.getItem('previousNotificationMessages')) || [];
          const currentNotificationMessages = data.notification_message.split('.').filter(msg => msg.trim() !== '');

          // Check if there are new notifications
          if (currentNotificationMessages.length > 0 && JSON.stringify(currentNotificationMessages) !== JSON.stringify(previousNotificationMessages)) {
            sessionStorage.setItem('previousNotificationMessages', JSON.stringify(currentNotificationMessages)); // Update previous notification messages
            showNotifications(); // Update displayed notifications
            triggerPopupAnimation(); // Implement your animation logic here

            // Update the notification count to 1 (since we're counting new notifications as 1 each)
            const newCount = 1;
            sessionStorage.setItem('notificationCount', newCount);
            if (notificationCountElement) {
              notificationCountElement.textContent = newCount;
              notificationCountElement.classList.remove('d-none'); // Show count if there are notifications
            }

            // Toggle bell icon to active state only if not already animated
            if (!hasAnimated) {
              sessionStorage.setItem('notificationBellState', 'active');
              notificationIcon.classList.add('bx-tada');
              notificationIcon.classList.add('text-danger'); // Apply red color and animation
              hasAnimated = true; // Set flag to true after first animation
            }

            // Reset inactive state and count after 5 seconds
            setTimeout(() => {
              sessionStorage.setItem('notificationBellState', 'inactive');
              notificationIcon.classList.remove('bx-tada');
              notificationIcon.classList.remove('text-danger'); // Remove red color and animation
              hasAnimated = false; // Reset animation flag

              // Reset notification count to 0 when no new notifications
              sessionStorage.setItem('notificationCount', 0);
              if (notificationCountElement) {
                notificationCountElement.textContent = 0;
                notificationCountElement.classList.add('d-none'); // Hide count when reset to 0
              }
            }, 5000);

          } else {
            // No new notifications, toggle to inactive state
            sessionStorage.setItem('notificationBellState', 'inactive');
            notificationIcon.classList.remove('bx-tada');
            notificationIcon.classList.remove('text-danger'); // Remove red color and animation
            hasAnimated = false; // Reset animation flag

            // Reset notification count to 0 when no new notifications
            sessionStorage.setItem('notificationCount', 0);
            if (notificationCountElement) {
              notificationCountElement.textContent = 0;
              notificationCountElement.classList.add('d-none'); // Hide count when reset to 0
            }
          }
        })
        .catch(error => {
          console.error('Error fetching latest notifications:', error);
        });
    }

    // Initialize notification state and fetch latest notifications on page load
    initializeNotificationState();
    showNotifications();
    fetchAndDisplayNotifications();

    // Set a setInterval to periodically fetch and display notifications
    setInterval(fetchAndDisplayNotifications, 5000);
  });
</script>
















@include('profile.edit')
@include('profile.editUser')
@include('layouts.modal._logoutModal')
@include('layouts.sweetalert')