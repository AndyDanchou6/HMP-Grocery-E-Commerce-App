<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Create New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center align-items-center" style="margin-bottom: 30px;">
          <div class="col-auto text-center">
            <img src="{{ asset('assets/img/category.png') }}" id="inventoryPreview" alt="Profile Picture" class="rounded-circle d-none" style="width: 200px; height: 200px; border-radius: 50%;">
            <div style="margin-top: 5px; display: none;" id="previewImageInventory"><label>Preview Image</label></div>
          </div>
        </div>
        <form class="createNewProduct" enctype="multipart/form-data">
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
              <small id="inventoryImageFileError" class="form-text text-danger text-wrap" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
            </div>
          </div>
          <div class="row mb-3">
            <label for="product_name" class="col-sm-3 col-form-label">Product Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="product_name" name="product_name">
            </div>
          </div>
          <div class="row mb-3">
            <label for="variant" class="col-sm-3 col-form-label">Variant Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="variant" name="variant">
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {

    var createNewProductForm = document.querySelector('.createNewProduct');

    createNewProductForm.addEventListener('submit', async function(event) {
      event.preventDefault();

      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      var formData = new FormData();
      formData.append('category_id', createNewProductForm.category_id.value);
      formData.append('product_name', createNewProductForm.product_name.value);
      formData.append('price', createNewProductForm.price.value);
      formData.append('quantity', createNewProductForm.quantity.value);
      formData.append('variant', createNewProductForm.variant.value);

      var productImgFile = createNewProductForm.product_img.files[0];
      if (productImgFile) {
        formData.append('product_img', productImgFile, productImgFile.name);
      }

      async function sendNewProductRequest(formData) {
        const validateNewProductApi = '/admin/inventories';
        var addOns = {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
          },
          body: formData,
        };

        try {
          var response = await fetch(validateNewProductApi, addOns);

          if (!response.ok) {
            throw new Error('Network response was not ok.');
          }

          var data = await response.json();

          if (data.status == 200) {

            var addedSuccessfully = document.querySelector('#addedSuccessfully');
            var variantProduct = document.querySelector('#variantProduct');
            var proceedBtn = document.querySelector('#proceedBtn');

            showVariantModal();

            if (!data.matches) {

              addedSuccessfully.style.display = 'block';
              variantProduct.style.display = 'none';
              proceedBtn.style.display = 'none';
            } else {

              addedSuccessfully.style.display = 'none';
              proceedBtn.style.display = 'block';
              variantProduct.style.display = 'block'

              var subCategory = document.querySelector('#subCategory');
              var variantName = document.querySelector('#variantName');
              var currentlyAdded = document.querySelector('#currentlyAdded');

              currentlyAdded.value = data.addedProductId;

              var existingProducts = data.matches;

              subCategory.innerHTML = '';

              existingProducts.forEach(function(product) {

                var option = '<option value="' + product.id + '">' + product.product_name + '</option>';

                subCategory.innerHTML += option;
              })

              const newVariantForm = document.querySelector('#newVariantForm');

              newVariantForm.addEventListener('submit', async function(event) {
                event.preventDefault();

                async function sendNewVariant() {
                  const addNewVariantApi = '/addAsVariant';
                  var body = {
                    'subCategory': subCategory.value,
                    'currentlyAdded': currentlyAdded.value,
                    'variant': variantName.value,
                  };
                  var addOns = {
                    method: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken,
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(body),
                  }

                  var response = await fetch(addNewVariantApi, addOns);

                  var data = await response.json();

                  if (data) {
                    location.reload();
                  }
                }

                sendNewVariant();
              })
            }
          }

        } catch (error) {
          console.error('Error sending request:', error.message);
        }
      }

      function showVariantModal() {

        var addVariantModal = new bootstrap.Modal(document.getElementById('addVariantModal'));

        addVariantModal.show();
      }

      // Call the function to send the request
      await sendNewProductRequest(formData);
    });
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const product_img = document.getElementById('product_img');
    const inventoryPreview = document.getElementById('inventoryPreview');
    const previewImageInventory = document.getElementById('previewImageInventory');

    if (product_img) {
      product_img.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
          inventoryPreview.src = e.target.result;
          inventoryPreview.classList.remove('d-none');
          previewImageInventory.style.display = 'block';
        };
        reader.readAsDataURL(file);

      });
    }

    const editProfileForm = document.getElementById('editProfileForm');
    if (editProfileForm) {
      editProfileForm.addEventListener('submit', function(event) {
        uploadAvatarButton.disabled = true;
      });
    }
  });

  product_img.addEventListener('change', function() {
    const file = event.target.files[0];
    const errorMessage = document.getElementById('inventoryImageFileError');

    if (file && file.size > 2 * 1024 * 1024) {
      errorMessage.style.display = 'block';
      event.target.value = '';
    } else {
      errorMessage.style.display = 'none';
    }
  })
</script>