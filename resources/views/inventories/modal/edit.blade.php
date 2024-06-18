<div class="modal fade" id="editModal{{ $inventory->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('inventories.update', $inventory->id) }}" method="POST" enctype="multipart/form-data" id="editFormElement">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="edit_category_id" class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="category_id" id="edit_category_id">
                                @foreach($categories as $id => $category_name)
                                <option value="{{ $id }}" {{ $inventory->category_id == $id ? 'selected' : '' }}>{{ $category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="edit_product_img" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <input type="file" id="edit_product_img" name="product_img" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="editProductName" class="col-sm-3 col-form-label">Product Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="product_name" id="editProductName" class="form-control" placeholder="Enter Product Name" value="{{ $inventory->product_name }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="editPrice" class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="number" name="price" id="editPrice" class="form-control" placeholder="Enter Price" value="{{ $inventory->price }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="editQuantity" class="col-sm-3 col-form-label">Quantity</label>
                        <div class="col-sm-9">
                            <input type="number" name="quantity" id="editQuantity" class="form-control" placeholder="Enter Quantity" value="{{ $inventory->quantity }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="information" class="col-sm-3 col-form-label">Information</label>
                        <div class="col-sm-9">
                            <textarea name="information" id="editDescription" class="form-control" placeholder="Enter Description">{{ $inventory->information }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" id="editDescription" class="form-control" placeholder="Enter Description">{{ $inventory->description }}</textarea>
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