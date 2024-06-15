<div class="modal fade" id="messages{{$user['id']}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryTitle">{{ $user['username'] }}'s more information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editFormElement">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user['phone'] }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="fb_link" class="col-sm-2 col-form-label">Facebook Link</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user['fb_link'] }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" readonly>{{ $user['address'] }}</textarea>
                        </div>
                    </div>

                    <div>
                        <h5>Purchased Item</h5>
                    </div>

                    @foreach($user['items'] as $item)
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Item Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $item['item']->product_name }}" readonly>
                        </div>
                        <label for="phone" class="col-sm-2 col-form-label">Item Price</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $item['item']->price }}" readonly>
                        </div>

                        <label for="phone" class="col-sm-2 col-form-label">Amount</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $item['count'] }}" readonly>
                        </div>
                        <label for="phone" class="col-sm-2 col-form-label">Total</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $item['total'] }}" readonly>
                        </div>
                    </div>
                    @endforeach
                    <div class="modal-footer">
                        <label for="phone" class="col-sm-2 col-form-label">Total</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $user['grossTotal'] }}" readonly>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>