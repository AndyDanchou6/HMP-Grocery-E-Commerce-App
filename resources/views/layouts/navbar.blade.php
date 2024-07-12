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
            return `<li><a class="dropdown-item text-danger new-notification" href="{{ route('selectedItems.forPackaging') }}">${msg}</a></li>`;
          } else {
            return `<li><a class="dropdown-item" href="{{ route('selectedItems.forPackaging') }}">${msg}</a></li>`;
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

            notificationIcon.classList.add('bx-tada');
            notificationIcon.classList.add('text-danger');

            const newCount = 1;
            sessionStorage.setItem('notificationCount', newCount);
            if (notificationCountElement) {
              notificationCountElement.textContent = newCount;
              notificationCountElement.classList.remove('d-none');
            }

            setTimeout(() => {
              sessionStorage.setItem('notificationBellState', 'inactive');
              notificationIcon.classList.remove('bx-tada');
              notificationIcon.classList.remove('text-danger');
              sessionStorage.setItem('notificationCount', 0);
              notificationCountElement.textContent = 0;
              notificationCountElement.classList.add('d-none');
            }, 5000);

          } else {
            sessionStorage.setItem('notificationBellState', 'inactive');
            notificationIcon.classList.remove('bx-tada');
            notificationIcon.classList.remove('text-danger');
          }
        })
        .catch(error => {
          console.error('Error fetching latest notifications:', error);
        });
    }

    initializeNotificationState();
    showNotifications();
    fetchAndDisplayNotifications();

    setInterval(fetchAndDisplayNotifications, 5000);

    // Event listener for bell icon click to reset notifications
    notificationIcon.addEventListener('click', function() {
      sessionStorage.setItem('notificationBellState', 'inactive');
      sessionStorage.setItem('notificationCount', 0);
      initializeNotificationState();
    });
  });
</script> 
