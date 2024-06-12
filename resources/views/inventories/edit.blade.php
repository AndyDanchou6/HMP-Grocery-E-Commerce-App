<!-- Edit Product Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editFormElement">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" name="category_id" id="edit_category_id">
                                <!-- Options will be dynamically added here -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="product_img" class="form-label">Avatar</label>
                            <input type="file" id="edit_product_img" name="product_img" class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" name="product_name" id="editProductName" class="form-control" placeholder="Enter Product Name">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" name="price" id="editPrice" class="form-control" placeholder="Enter Price">
                        </div>
                        <div class="col mb-0">
                            <label for="editQuantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="editQuantity" class="form-control" placeholder="Enter Quantity">
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



<script src="{{ asset('assets/js/crud/inventories/edit.js') }}"> </script>