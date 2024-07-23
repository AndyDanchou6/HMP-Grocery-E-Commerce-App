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
                            closeButton: true,
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
                            newestOnTop: true,
                            preventDuplicates: true,
                            iconClass: 'custom-toast-icon',
                            toastClass: 'custom-toast modern-toast'
                        };

                        const notificationType = notificationAtIndex0.type;
                        if (notificationType === 'success') {
                            toastr.success(notificationAtIndex0.message);
                        } else if (notificationType === 'info') {
                            toastr.info(notificationAtIndex0.message);
                        } else if (notificationType === 'warning') {
                            toastr.warning(notificationAtIndex0.message);
                        } else if (notificationType === 'error') {
                            toastr.error(notificationAtIndex0.message);
                        } else {
                            toastr.info(notificationAtIndex0.message);
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