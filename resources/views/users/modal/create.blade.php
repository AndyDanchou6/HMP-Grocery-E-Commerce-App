<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">User Creation Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center align-items-center" style="margin-bottom: 30px;">
                    <div class="col-auto text-center">
                        <img src="{{ asset('assets/img/user.png') }}" id="avatarPreview" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; border-radius: 50%;">
                        <div style="margin-top: 5px;"><label>Avatar</label></div>
                    </div>
                </div>
                <form action="{{ route('users.store') }}" method="POST" id="createFormElement" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="role" name="role" value="Courier" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="userAvatar" name="avatar">
                            <small id="userAvatarFileError" class="form-text text-danger" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Username">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editAvatarInput = document.getElementById('userAvatar');
        const uploadAvatarButton = document.getElementById('avatarPreview');

        if (editAvatarInput) {
            editAvatarInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadAvatarButton.src = e.target.result;
                };
                reader.readAsDataURL(file);

            });
        }

        const editProfileForm = document.getElementById('editProfileForm');
        if (editProfileForm) {
            editProfileForm.addEventListener('submit', function(event) {
                uploadAvatarButton.disabled = true;
            });
        }
    });

    document.getElementById('userAvatar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const errorMessage = document.getElementById('userAvatarFileError');

        if (file && file.size > 2 * 1024 * 1024) {
            errorMessage.style.display = 'block';
            event.target.value = '';
        } else {
            errorMessage.style.display = 'none';
        }
    });
</script>