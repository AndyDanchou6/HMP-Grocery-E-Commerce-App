<div class="modal fade" id="messages{{$inventory->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryTitle">{{ $inventory->product_name }}</h5>
                <button type=" button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="message" class="col-sm-3 col-form-label">Information</label>
                    <div class="col-sm-9">
                        <textarea maxlength="1000" id="message" name="information" class="form-control" placeholder="Enter Description" readonly>{{ $inventory->information }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="message" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea maxlength="1000" id="message" name="description" class="form-control" placeholder="Enter Description" readonly>{{ $inventory->description }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
</script>