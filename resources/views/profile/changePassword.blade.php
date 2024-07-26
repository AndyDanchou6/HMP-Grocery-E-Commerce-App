<div class="modal fade bd-example-modal-lg" id="changePassword{{ Auth::user()->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-wrap" id="editModalTitle">{{ Auth::user()->name }}'s profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.changePass', Auth::user()->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="column">
                        <input type="number" name="userId" value="{{ Auth::user()->id }}" hidden>
                        <div class="col mb-3">
                            <label for="lastPassword" class="form-label">Last Password</label>
                            <input type="password" id="lastPassword" name="lastPassword" class="form-control" placeholder="Enter Last Password">
                        </div>
                        <div class="col mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" id="newPassword" name="password" class="form-control" placeholder="Enter New Password">
                        </div>
                        <div class="col mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" id="confirmPassword" name="password_confirmation" class="form-control" placeholder="Re-Enter New Password">
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