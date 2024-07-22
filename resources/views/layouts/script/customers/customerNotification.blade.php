    @section('script')
    <script>
        function fetchAndDisplayUserNotifications() {
            fetch('{{ route("customers.userNotification") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {

                    if (Array.isArray(data.notifications)) {

                        const previousNotifications = JSON.parse(sessionStorage.getItem('customerNotificationsStorage')) || [];

                        // Reverse the new notifications and limit to the latest 10
                        const reversedNotifications = [...data.notifications].reverse().slice(0, 10);

                        // Fetch the notification at index 0
                        const notificationAtIndex0 = reversedNotifications[0];

                        // Check if there are new notifications that differ from the previous notifications
                        const hasNewNotifications = !previousNotifications.length ||
                            !reversedNotifications.every((item, index) => item === previousNotifications[index]);

                        if (notificationAtIndex0 && hasNewNotifications) {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-right',
                                showDuration: '300',
                                hideDuration: '1000',
                                timeOut: '10000',
                                showEasing: 'swing',
                                hideEasing: 'linear',
                                showMethod: 'fadeIn',
                                hideMethod: 'fadeOut'
                            };

                            toastr.info(`<strong>${notificationAtIndex0}</strong>`);
                        }

                        // Update sessionStorage with the limited reversed notifications
                        sessionStorage.setItem('customerNotificationsStorage', JSON.stringify(reversedNotifications));

                        // Update the notification list in the HTML
                        const notificationList = document.getElementById('notificationList');
                        if (notificationList) {
                            const html = reversedNotifications.length > 0 ?
                                reversedNotifications.map((msg, index) => `<li><a class="text-wrap dropdown-item${index === 0 ? ' text-danger' : ''}" href="#">${msg}</a></li>`).join('') :
                                '<li><a class="dropdown-item">No notifications found at the moment....</a></li>';
                            notificationList.innerHTML = html;
                        } else {
                            console.error('notificationList element not found');
                        }
                    } else {
                        console.error('Notifications are not an array or empty');
                    }
                })
                .catch(error => {
                    console.error('Error fetching latest notifications:', error);
                })
                .finally(() => {
                    // Long polling: Call the function again after 5 seconds
                    setTimeout(fetchAndDisplayUserNotifications, 5000);
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchAndDisplayUserNotifications();
        });
    </script>
    @endsection