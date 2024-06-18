<div class="modal fade" id="editModal{{$review->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_product_id" class="col-sm-3 col-form-label">Category</label>
                            <select class="form-select" name="product_id" id="edit_product_id">
                                @foreach($products as $id => $product_name)
                                <option value="{{ $id }}" {{ $review->product_id == $id ? 'selected' : '' }}>{{ $product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label><br>
                        <fieldset class="rating" style="margin-left: 10px">
                            <input type="radio" id="star5" name="rating" value="5" {{ $review->rating == 5 ? 'checked' : '' }}>
                            <label for="star5" style="margin-right: 5px">5</label>

                            <input type="radio" id="star4" name="rating" value="4" {{ $review->rating == 4 ? 'checked' : '' }}>
                            <label for="star4" style="margin-right: 5px">4</label>

                            <input type="radio" id="star3" name="rating" value="3" {{ $review->rating == 3 ? 'checked' : '' }}>
                            <label for="star3" style="margin-right: 5px">3</label>

                            <input type="radio" id="star2" name="rating" value="2" {{ $review->rating == 2 ? 'checked' : '' }}>
                            <label for="star2" style="margin-right: 5px">2</label>

                            <input type="radio" id="star1" name="rating" value="1" {{ $review->rating == 1 ? 'checked' : '' }}>
                            <label for="star1" style="margin-right: 5px">1</label>
                        </fieldset>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="editComment" class="form-label">Comment</label>
                            <textarea name="comment" id="editComment" class="form-control" placeholder="Enter Description">{{ $review->comment }}</textarea>
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