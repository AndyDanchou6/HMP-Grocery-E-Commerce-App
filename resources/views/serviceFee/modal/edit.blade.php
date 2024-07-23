<div class="modal fade" id="editModal{{$fee->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Edit Fee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('serviceFee.update', $fee->id) }}" method="POST" id="createFormElement">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fee_name" class="form-label">Fee Name</label>
                        <input type="string" id="fee_name" name="fee_name" class="form-control" placeholder="Optional" value="{{ $fee->fee_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="string" id="location" name="location" class="form-control" placeholder="Enter location" value="{{ $fee->location }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="fee" class="form-label">Fee Amount</label>
                        <input type="number" id="fee" name="fee" class="form-control" placeholder="Enter fee amount" value="{{ $fee->fee }}" required>
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