<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Edit User Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center align-items-center" style="margin-bottom: 30px;">
                    <div class="col-auto text-center">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/user.png') }}" id="change_userAvatar{{ $user->id }}" alt="Profile Picture" class="rounded-circle" style="width: 200px; height: 200px; border-radius: 50%;">
                        <div style="margin-top: 5px;"><label>Avatar</label></div>
                    </div>
                </div>
                <form action="{{ route('users.update', $user->id) }}" method="POST" id="editProfileForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="role" name="role" value="{{ $user->role }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="edit_user_avatarInput{{ $user->id }}" name="avatar">
                            <small id="userAvatarFileError{{ $user->id }}" class="form-text text-danger text-wrap" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Username" value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $user->email }}">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"][id^="edit_user_avatarInput"]');
        const imageElements = document.querySelectorAll('img[id^="change_userAvatar"]');

        fileInputs.forEach((input, index) => {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const userId = input.id.replace('edit_user_avatarInput', '');
                const errorMessage = document.getElementById('userAvatarFileError' + userId);
                const imageElement = document.getElementById('change_userAvatar' + userId);

                if (!file) return;

                if (file.size > 2 * 1024 * 1024) {
                    if (errorMessage) {
                        errorMessage.textContent = 'The selected file exceeds 2 MB. Please choose a smaller file.';
                        errorMessage.style.display = 'block';
                    }
                    event.target.value = '';
                    return;
                } else {
                    if (errorMessage) {
                        errorMessage.style.display = 'none';
                    }
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (imageElement) {
                        imageElement.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>