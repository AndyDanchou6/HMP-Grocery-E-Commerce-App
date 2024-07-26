<div class="modal fade" id="restock{{$item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('inventories.restock', $item->id) }}" method="POST" enctype="multipart/form-data" id="editFormElement">
            @csrf
            @method('PUT')
            <div class="modal-header">
                    @if ($item->variant)
                    <h5 class="modal-title" id="categoryTitle">{{ $item->product_name }} [{{ $item->variant }}]</h5>
                    @else
                    <h5 class="modal-title" id="categoryTitle">{{ $item->product_name }} [Non-variant]</h5>
                    @endif
                    <button type=" button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="column">
                            <label for="restock-quantity" class="mb-3">Quantity</label>
                            <input type="number" name="quantity" id="restock-quantity" class="form-control" placeholder="Add decided amount">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success">Restock</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>