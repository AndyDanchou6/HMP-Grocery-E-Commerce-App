<div class="modal fade" id="addVariantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="newVariantForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container" id="addedSuccessfully">
                        <p class="text-success fs-3">New Product Added Successfully.</p>
                    </div>
                    <div class="container" id="variantProduct">
                        <div>
                            <p class="fs-3 text-align-justify">New product matches existing old products. Add as variant?</p>
                        </div>
                        <div class="mb-3">
                            <label for="subCategory">Add as variant of:</label>
                            <select name="subCategory" id="subCategory" class="form-select">

                            </select>
                        </div>
                        <div class="variantName">
                            <label for="variantName">Variant Name</label>
                            <input type="text" class="form-control" name="variant" id="variantName" placeholder="Add variant name for product" required>
                        </div>

                        <input type="text" name="currentlyAdded" id="currentlyAdded" hidden>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" id="closeBtn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="proceedBtn">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var closeBtn = document.querySelector('#closeBtn');

    closeBtn.addEventListener('click', function() {
        location.reload();
    })
</script>