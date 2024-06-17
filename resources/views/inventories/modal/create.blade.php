<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Create New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row mb-3">
            <label for="category_id" class="col-sm-3 col-form-label">Category</label>
            <div class="col-sm-9">
              <select class="form-select" name="category_id" id="category_id">
                <option value="" selected disabled>Choose Category</option>
                @foreach($categories as $id => $category_name)
                <option value="{{ $id }}">{{ $category_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label for="product_img" class="col-sm-3 col-form-label">Image</label>
            <div class="col-sm-9">
              <input type="file" class="form-control" id="product_img" name="product_img">
            </div>
          </div>
          <div class="row mb-3">
            <label for="product_name" class="col-sm-3 col-form-label">Product Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="product_name" name="product_name">
            </div>
          </div>
          <div class="row mb-3">
            <label for="price" class="col-sm-3 col-form-label">Price</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" id="price" name="price">
            </div>
          </div>
          <div class="row mb-3">
            <label for="quantity" class="col-sm-3 col-form-label">Quantity</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" id="quantity" name="quantity">
            </div>
          </div>
          <div class="row mb-3">
            <label for="information" class="col-sm-3 col-form-label">Information</label>
            <div class="col-sm-9">
              <textarea maxlength="1000" id="information" name="information" class="form-control" placeholder="Enter Information"></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <label for="description" class="col-sm-3 col-form-label">Description</label>
            <div class="col-sm-9">
              <textarea maxlength="1000" id="description" name="description" class="form-control" placeholder="Enter Information"></textarea>
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