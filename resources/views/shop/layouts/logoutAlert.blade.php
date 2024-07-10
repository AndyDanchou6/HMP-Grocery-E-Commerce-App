<script>
    function Logout() {
        swal({
            title: 'Logout Confirmation',
            text: 'Are you sure you want to logout?',
            icon: 'warning',
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                proceed: {
                    text: 'Logout',
                    value: true,
                    className: 'btn-danger'
                },
            },
        }).then(willLogout => {
            if (willLogout) {
                fetch('{{ route("logout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        window.location.href = "{{ route('welcome') }}";
                    }
                }).catch(error => {
                    console.error('Error: ', error);
                })
            }
        });
    }
</script>