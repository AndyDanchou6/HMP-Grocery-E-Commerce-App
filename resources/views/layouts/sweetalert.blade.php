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
        }
    });
</script>

<style>
    .swal-wide {
        width: 500px !important;
    }
</style>