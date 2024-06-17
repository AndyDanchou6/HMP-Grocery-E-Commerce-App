<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Create New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('reviews.store') }}" method="POST" id="createFormElement" enctype="multipart/form-data">
          @csrf
          <!-- <div class="mb-3">
            <label for="category_img" class="form-label">Image</label>
            <input type="file" id="category_img" name="category_img" class="form-control" placeholder="Enter Category Image">
          </div> -->
          <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <select class="form-select" name="product_id" id="product_id">
              <option value="" selected disabled>Choose Product</option>
              @foreach($products as $id => $product_name)
              <option value="{{ $id }}">{{ $product_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="number" name="rating" placeholder="Enter rating" class="form-control">
          </div>
          <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea id="comment" name="comment" class="form-control" placeholder="Enter comment here...."></textarea>
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