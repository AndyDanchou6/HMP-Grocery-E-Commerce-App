<div class="modal fade bd-example-modal-lg" id="editProfileModal{{ Auth::user()->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">{{Auth::user()->name }}'s profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
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
                            <label for="edit_avatar" class="form-label">Avatar</label>
                            <input type="file" id="edit_avatar" name="avatar" class="form-control" />
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