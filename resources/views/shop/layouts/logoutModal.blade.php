<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Logout</h5>
                <!-- Remove the btn-close class from here -->
                <button type="button" class="custom-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: left;">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .custom-close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5rem;
        color: #000;
        background-color: transparent;
        border: none;
        padding: 0;
        cursor: pointer;
        outline: none;
    }

    .primary {
        background-color: #696cff;
    }

    .custom-close-btn:hover {
        color: #555;
        text-decoration: none;
    }
</style>