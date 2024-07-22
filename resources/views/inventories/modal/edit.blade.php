<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center align-items-center" style="margin-bottom: 30px;">
                    <div class="col-auto text-center">
                        <img src="{{ $item->product_img ? asset('storage/' . $item->product_img) : asset('assets/img/category.png') }}" id="editImageInventory{{ $item->id }}" alt="Invenrtory Picture" class="rounded-circle" style="width: 200px; height: 200px; border-radius: 50%;">
                    </div>
                </div>
                <form action="{{ route('inventories.update', $item->id) }}" method="POST" enctype="multipart/form-data" id="editFormElement">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="edit_category_id" class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="category_id" id="edit_category_id">
                                @foreach($categories as $id => $category_name)
                                <option value="{{ $id }}" {{ $item->category_id == $id ? 'selected' : '' }}>{{ $category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="edit_product_img" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <input type="file" id="edit_product_img{{ $item->id }}" name="product_img" class="form-control" />
                            <small id="editInventoryImageError{{ $item->id }}" class="form-text text-danger text-wrap" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="editProductName" class="col-sm-3 col-form-label">Product Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="product_name" id="editProductName" class="form-control" placeholder="Enter Product Name" value="{{ $item->product_name }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="editVariantName" class="col-sm-3 col-form-label">Variant Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="variant" id="editVariantName" class="form-control" placeholder="Enter Variant Name" value="{{ $item->variant }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="editPrice" class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="number" name="price" id="editPrice" class="form-control" placeholder="Enter Price" value="{{ $item->price }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="editQuantity" class="col-sm-3 col-form-label">Quantity</label>
                        <div class="col-sm-9">
                            <input type="number" name="quantity" id="editQuantity" class="form-control" placeholder="Enter Quantity" value="{{ $item->quantity }}">
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <label for="information" class="col-sm-3 col-form-label">Information</label>
                        <div class="col-sm-9">
                            <textarea name="information" id="editDescription" class="form-control" placeholder="Enter Description">{{ $item->information }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" id="editDescription" class="form-control" placeholder="Enter Description">{{ $item->description }}</textarea>
                        </div>
                    </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"][id^="edit_product_img"]');
        const imageElements = document.querySelectorAll('img[id^="editImageInventory"]');

        fileInputs.forEach(input => {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const inventoryId = input.id.replace('edit_product_img', '');
                const errorMessage = document.getElementById('editInventoryImageError' + inventoryId);
                const imageElement = document.getElementById('editImageInventory' + inventoryId);

                if (!file) return;

                if (file.size > 2 * 1024 * 1024) {
                    if (errorMessage) {
                        errorMessage.textContent = 'The selected file exceeds 2 MB. Please choose a smaller file.';
                        errorMessage.style.display = 'block';
                    }
                    event.target.value = '';
                    return;
                } else {
                    if (errorMessage) {
                        errorMessage.style.display = 'none';
                    }
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (imageElement) {
                        imageElement.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>