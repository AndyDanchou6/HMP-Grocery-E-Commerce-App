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

                    const reversedNotifications = [...data.notifications].reverse().slice(0, 15);

                    const notificationAtIndex0 = reversedNotifications[0];

                    const hasNewNotifications = !previousNotifications.length ||
                        !reversedNotifications.every((item, index) => JSON.stringify(item) === JSON.stringify(previousNotifications[index]));

                    if (notificationAtIndex0 && hasNewNotifications) {
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

                        const notificationType = notificationAtIndex0.type;
                        if (notificationType === 'success') {
                            toastr.success(`<div><i class="bx bx-bell bx-tada"> </i> <strong> Notification Alert </strong><br>${notificationAtIndex0.message}</div>`);
                        } else if (notificationType === 'info') {
                            toastr.info(`<div><i class="bx bx-bell bx-tada"> </i> <strong> Notification Alert </strong><br>${notificationAtIndex0.message}</div>`);
                        } else if (notificationType === 'warning') {
                            toastr.warning(`<div><i class="bx bx-bell bx-tada"> </i> <strong> Notification Alert </strong><br>${notificationAtIndex0.message}</div>`);
                        } else if (notificationType === 'error') {
                            toastr.error(`<div><i class="bx bx-bell bx-tada"> </i> <strong> Notification Alert </strong><br>${notificationAtIndex0.message}</div>`);
                        } else {
                            toastr.info(`<div><i class="bx bx-bell bx-tada"> </i> <strong> Notification Alert </strong><br>${notificationAtIndex0.message}</div>`);
                        }
                    }

                    sessionStorage.setItem('customerNotificationsStorage', JSON.stringify(reversedNotifications));

                    const notificationList = document.getElementById('notificationList');
                    if (notificationList) {
                        const html = reversedNotifications.length > 0 ?
                            reversedNotifications.map((notification, index) => `<li><a class="text-wrap dropdown-item${index === 0 ? ' text-danger' : ''}">${notification.message}</a></li>`).join('') :
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
                setTimeout(fetchAndDisplayUserNotifications, 5000);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchAndDisplayUserNotifications();
    });
</script>
@endsection