@if(session('message'))
<input type="hidden" id="sessionTypes" value="success">
<input type="hidden" id="sessionMessages" value="{{ session('message') }}">
@endif

@if(session('success'))
<input type="hidden" id="sessionType" value="success">
<input type="hidden" id="sessionMessage" value="{{ session('success') }}">
@elseif(session('update'))
<input type="hidden" id="sessionType" value="warning">
<input type="hidden" id="sessionMessage" value="{{ session('update') }}">
@elseif(session('error'))
<input type="hidden" id="sessionType" value="error">
<input type="hidden" id="sessionMessage" value="{{ session('error') }}">
@endif


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sessionTypeInput = document.getElementById('sessionType');
        let sessionMessageInput = document.getElementById('sessionMessage');
        let sessionTypeInputs = document.getElementById('sessionTypes');
        let sessionMessageInputs = document.getElementById('sessionMessages');

        if (sessionTypeInput && sessionMessageInput) {
            let sessionType = sessionTypeInput.value;
            let sessionMessage = sessionMessageInput.value;

            swal({
                icon: sessionType,
                title: sessionMessage,
                showConfirmButton: false,
                timer: 1500,
                className: 'swal-wide'
            });
        } else if (sessionTypeInputs && sessionMessageInputs) {
            let sessionType = sessionTypeInputs.value;
            let sessionMessage = sessionMessageInputs.value;

            swal({
                icon: sessionType,
                title: sessionMessage,
                buttons: {
                    continueShopping: {
                        text: "Continue Shopping",
                        className: 'swal-button--continue-shopping'
                    },
                    dashboard: {
                        text: "Dashboard",
                        className: 'swal-button--dashboard'
                    }
                },
            }).then((value) => {
                if (value === "continueShopping") {
                    window.history.forward();
                } else if (value === "dashboard") {
                    window.location.href = "{{ route('selectedItems.orders') }}";
                }
            });
        }
    });
</script>

<style>
    .swal-wide {
        width: 500px !important;
    }

    .swal-button--continue-shopping {
        background-color: #4CAF50;
        color: white;
    }

    .swal-button--dashboard {
        background-color: #007BFF;
        color: white;
    }
</style>