<!-- Edit Profile Modal -->
<div class="modal fade bd-example-modal-lg" id="editUserModal{{ Auth::user()->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-wrap" id="editModalTitle">{{ Auth::user()->name }}'s profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center align-items-center">
                    <div class="col-auto text-center">
                        @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" id="change_user_avatar" alt="Profile Picture" class="rounded-circle" style="width: 200px; height: 200px;">
                        @else
                        <img src="{{ asset('assets/img/user.png') }}" id="change_user_avatar" alt="Profile Picture" class="rounded-circle" style="width: 200px; height: 200px;">
                        @endif
                        <div style="margin-top: 5px;"><label>Avatar</label></div>
                    </div>
                </div>
                <form id="editProfileForm" action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <input type="text" id="edit_role" name="role" class="form-control" value="{{ Auth::user()->role }}" disabled />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_avatar" class="form-label">Change Avatar</label>
                            <input type="file" id="edit_avatar" name="avatar" class="form-control" accept="image/*" />
                            <small id="fileSizeError" class="form-text text-danger text-wrap" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
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
                    @if(Auth::check() && Auth::user()->phone && Auth::user()->address && Auth::user()->fb_link)
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
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">Address</label>
                        <textarea id="editAddress" name="address" class="form-control" rows="3" placeholder="Enter Address">{{ Auth::user()->address }}</textarea>
                    </div>
                    @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updateAvatar">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editAvatarInput = document.getElementById('edit_avatar');
        const changeAvatarImg = document.getElementById('change_user_avatar');

        if (editAvatarInput) {
            editAvatarInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    changeAvatarImg.src = e.target.result;
                };
                reader.readAsDataURL(file);

                updateAvatar.style.display = 'inline-block';
            });
        }
    });
</script>
<script>
    document.getElementById('edit_avatar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const errorMessage = document.getElementById('fileSizeError');

        if (file && file.size > 2 * 1024 * 1024) {
            errorMessage.style.display = 'block';
            event.target.value = '';
        } else {
            errorMessage.style.display = 'none';
        }
    });
</script>