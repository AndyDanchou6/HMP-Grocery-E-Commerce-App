<div class="modal fade" id="editModal{{$review->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col mb-3">
                            <label for="editreview" class="form-label">Image</label>
                            <input type="file" name="review_img" id="editreview" class="form-control" value="{{ $review->review_name }}" placeholder="Enter review">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="editreview" class="form-label">review Name</label>
                            <input type="text" name="review_name" id="editreview" class="form-control" value="{{ $review->review_name }}" placeholder="Enter review">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea name="description" id="editDescription" class="form-control" placeholder="Enter Description">{{ $review->description }}</textarea>
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