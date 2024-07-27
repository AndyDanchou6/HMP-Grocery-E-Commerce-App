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
                                 progressBar: true,
                                 positionClass: 'toast-top-right',
                                 showDuration: '300',
                                 hideDuration: '1000',
                                 timeOut: '5000',
                                 extendedTimeOut: '1000',
                                 showEasing: 'swing',
                                 hideEasing: 'linear',
                                 showMethod: 'fadeIn',
                                 hideMethod: 'fadeOut',
                                 preventDuplicates: true,
                                 closeButton: true,
                             };

                             toastr.info(`<div><i class="bx bx-bell bx-tada"> </i> <strong> New Purchase Alert</strong><br>${msg}</div>`);

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
 <style>
     .toast-close-button {
         position: absolute !important;
         top: 10px !important;
         right: 10px !important;
         background: none;
         border-radius: 50%;
         padding: 5px;
         cursor: pointer !important;
         color: black !important;
     }
 </style>