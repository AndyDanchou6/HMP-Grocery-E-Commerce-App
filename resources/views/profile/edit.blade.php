<div class="modal fade bd-example-modal-lg" id="editProfileModal{{ Auth::user()->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">{{ Auth::user()->name }}'s profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center align-items-center">
                    <div class="col-auto text-center">
                        @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" id="change_avatar" alt="Profile Picture" class="rounded-circle" style="width: 200px; height: 200px; border-radius: 50%;">
                        <div style="margin-top: 5px;"><label>Avatar</label></div>
                        @else
                        <img src="{{ asset('assets/img/user.png') }}" id="change_avatar" alt="Profile Picture" class="rounded-circle" style="width: 200px; height: 200px; border-radius: 50%;">
                        <div style="margin-top: 5px;"><label>Avatar</label></div>
                        @endif
                    </div>
                </div>
                <form id="editProfileForm" action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <input type="text" id="edit_role" name="role" class="form-control" value="{{ Auth::user()->role }}" disabled />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_avatar_input" class="form-label">Avatar</label>
                            <input type="file" id="edit_avatar_input" name="avatar" class="form-control" />
                            <small id="fileSizeErrorr" class="form-text text-danger" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="editName" class="form-label">Username</label>
                            <input type="text" id="editName" name="name" class="form-control" value="{{ Auth::user()->name }}" placeholder="Enter Username">
                        </div>
                        <div class="col mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" id="editEmail" name="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="editPhone" class="form-label">Phone</label>
                            <input type="text" id="editPhone" name="phone" class="form-control" value="{{ Auth::user()->phone }}" placeholder="Enter Phone Number">
                        </div>
                        <div class="col mb-3">
                            <label for="editFbLink" class="form-label">Facebook Link</label>
                            <input type="text" id="editFbLink" name="fb_link" class="form-control" value="{{ Auth::user()->fb_link }}" placeholder="Enter Facebook Link">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <textarea id="editAddress" name="address" class="form-control" rows="3" placeholder="Enter Address">{{ Auth::user()->address }}</textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editAvatarInput = document.getElementById('edit_avatar_input');
        const changeAvatarImg = document.getElementById('change_avatar');
        const uploadAvatarButton = document.getElementById('uploadAvatarButton');

        if (editAvatarInput) {
            editAvatarInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    changeAvatarImg.src = e.target.result;
                };
                reader.readAsDataURL(file);

                uploadAvatarButton.style.display = 'block';
            });
        }

        const editProfileForm = document.getElementById('editProfileForm');
        if (editProfileForm) {
            editProfileForm.addEventListener('submit', function(event) {
                uploadAvatarButton.disabled = true;
            });
        }
    });
</script>
<script>
    document.getElementById('edit_avatar_input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const errorMessage = document.getElementById('fileSizeErrorr');

        if (file && file.size > 2 * 1024 * 1024) {
            errorMessage.style.display = 'block';
            event.target.value = '';
        } else {
            errorMessage.style.display = 'none';
        }
    });
</script>