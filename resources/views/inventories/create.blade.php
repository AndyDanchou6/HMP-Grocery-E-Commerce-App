<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Create New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="createFormElement">
          <div class="row">
            <div class="col mb-3">
              <label for="category_id" class="form-label">Category</label>
              <select class="form-select" name="category_id" id="category_id">
                <!-- Options will be dynamically added here -->
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="product_img" class="form-label">Avatar</label>
              <input type="file" id="product_img" name="product_img" class="form-control" placeholder="Enter Image" />
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Enter Product" />
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="price" class="form-label">Price</label>
              <input type="number" id="price" name="price" class="form-control" placeholder="Enter Price" />
            </div>
            <div class="col mb-0">
              <label for="quantity" class="form-label">Quantity</label>
              <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Enter Quantity" />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/categoryAllData', {
      method: 'GET',
      headers: {
        Accept: 'application/json',
        Authorization: 'Bearer ' + localStorage.getItem('token'),
      }
    }).then(response => {
      return response.json();
    }).then(data => {
      const categorySelect = document.getElementById('category_id');
      categorySelect.innerHTML = '';

      for (let i = 0; i < data.length; i++) {
        categorySelect.innerHTML += `<option value="" selected disabled>Choose Category</option>
                                      <option value="${data[i].id}">${data[i].category_name}</option>
                                      `;
      }
    })

    document.getElementById('createFormElement').addEventListener('submit', function(event) {
      event.preventDefault();

      const formData = new FormData(this);
      fetch('/api/inventory', {
          method: 'POST',
          body: formData,
          headers: {
            Accept: 'application/json',
            Authorization: 'Bearer ' + localStorage.getItem('token'),
          }
        })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          if (data.status) {
            location.reload();
          }
        })
        .catch(error => {
          console.error('Error:', error);
          swal({
            title: 'Error',
            text: 'There was an error creating the product',
            icon: 'error',
            button: 'Try Again'
          });
        });
    });
  });
</script>