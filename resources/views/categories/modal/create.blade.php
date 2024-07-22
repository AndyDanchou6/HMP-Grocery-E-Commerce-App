<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Category Creation Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center align-items-center" style="margin-bottom: 30px;">
          <div class="col-auto text-center">
            <img src="{{ asset('assets/img/category.png') }}" id="categoryPreview" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; border-radius: 50%;">
          </div>
        </div>
        <form action="{{ route('categories.store') }}" method="POST" id="createFormElement" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="category_img" class="form-label">Image</label>
            <input type="file" id="category_img" name="category_img" class="form-control" placeholder="Enter Category Image">
            <small id="categoryFileSizeError" class="form-text text-danger text-wrap" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
          </div>
          <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" id="category_name" name="category_name" class="form-control" placeholder="Enter Category Name">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" placeholder="Enter Description"></textarea>
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const category_img = document.getElementById('category_img');
    const categoryPreview = document.getElementById('categoryPreview');

    if (category_img) {
      category_img.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
          categoryPreview.src = e.target.result;
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

  category_img.addEventListener('change', function() {
    const file = event.target.files[0];
    const errorMessage = document.getElementById('categoryFileSizeError');

    if (file && file.size > 2 * 1024 * 1024) {
      errorMessage.style.display = 'block';
      event.target.value = '';
    } else {
      errorMessage.style.display = 'none';
    }
  })
</script>