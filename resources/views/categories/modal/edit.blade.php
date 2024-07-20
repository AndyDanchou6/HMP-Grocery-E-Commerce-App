<div class="modal fade" id="editModal{{$category->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center align-items-center" style="margin-bottom: 30px;">
                    <div class="col-auto text-center">
                        <img src="{{ $category->category_img ? asset('storage/' . $category->category_img) : asset('assets/img/category.png') }}" id="change_categoryImg{{ $category->id }}" alt="Profile Picture" class="rounded-circle" style="width: 200px; height: 200px; border-radius: 50%;">
                    </div>
                </div>
                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col mb-3">
                            <label for="editCategory{{ $category->id }}" class="form-label">Image</label>
                            <input type="file" name="category_img" id="editCategory{{ $category->id }}" class="form-control">
                            <small id="userAvatarFileError{{ $category->id }}" class="form-text text-danger" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="editCategoryName{{ $category->id }}" class="form-label">Category Name</label>
                            <input type="text" name="category_name" id="editCategoryName{{ $category->id }}" class="form-control" value="{{ $category->category_name }}" placeholder="Enter Category">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="editDescription{{ $category->id }}" class="form-label">Description</label>
                            <textarea name="description" id="editDescription{{ $category->id }}" class="form-control" placeholder="Enter Description">{{ $category->description }}</textarea>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"][id^="editCategory"]');
        const imageElements = document.querySelectorAll('img[id^="change_categoryImg"]');

        fileInputs.forEach(input => {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const categoryId = input.id.replace('editCategory', '');
                const errorMessage = document.getElementById('userAvatarFileError' + categoryId);
                const imageElement = document.getElementById('change_categoryImg' + categoryId);

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