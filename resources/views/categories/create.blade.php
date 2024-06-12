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
              <label for="category_name" class="form-label">Category Name</label>
              <input type="text" id="category_name" name="category_name" class="form-control" placeholder="Enter Category" />
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="description" class="form-label">Description</label>
              <textarea id="description" name="description" class="form-control" placeholder="Enter Description"></textarea>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createFormElement').addEventListener('submit', function(event) {
      event.preventDefault();

      const formData = new FormData(this);
      fetch('/api/category', {
          method: 'POST',
          body: formData,
          headers: {
            Accept: 'application/json',
            Authorization: 'Bearer ' + localStorage.getItem('token'),
          }
        })
        .then(response => {
          return response.json();
        })
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