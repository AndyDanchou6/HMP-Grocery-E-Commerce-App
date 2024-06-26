<!-- Modal Template -->
<div class="modal fade" id="messages{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryTitle">{{ $user['name'] }}'s purchases</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                    <h5>Purchased Items</h5>
                </div>
                @foreach($user['items'] as $item)
                <div class="row item-row" data-item-id="{{ $item->id }}">

                    <div class="col-sm-12 mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Item Name</label>
                        <span><input type="text" class="form-control" value="{{ $item->product_name }}" readonly></span>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                        <span><input type="number" class="form-control item-quantity" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="{{ $item->quantity }}" readonly></span>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="item_price" class="col-sm-2 col-form-label">Item Price</label>
                        <span><input type="text" class="form-control item-price" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="₱{{ number_format($item->price, 2) }}" readonly></span>
                    </div>


                    <div class="col-sm-4 mb-3">
                        <label for="subtotal" class="col-sm-2 col-form-label">SubTotal</label>
                        <span><input type="text" class="form-control item-sub-total" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="0" readonly></span>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                    </div>
                </div>
                @endforeach

                <div class="modal-footer">
                    <div class="row row-cols-1 row-cols-md-2 align-items-center mb-3">
                        <div class="mb-3">
                            <label for="total" class="col-form-label">Total</label>
                            <input type="text" name="total" class="form-control purchase-total" data-total-id="{{ $user['referenceNo'] }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="reference" class="col-form-label">Reference No.</label>
                            <input type="text" name="reference" class="form-control" value="{{ $user['referenceNo'] }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="order_retrieval" class="col-form-label">Order Retrieval</label>
                            <input type="text" class="form-control" value="{{ ucwords($item->order_retrieval) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="order_date" class="col-form-label">Date</label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Manila')->format('l, F j, Y') }}" readonly>
                        </div>
                    </div>
                    @if($item->order_retrieval == 'delivery')
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-3">
                            <label for="courier_id" class="col-form-label">Courier Name:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $user['courier_id'] }}" readonly>
                        </div>
                        <div class="row mb-3" style="margin-top: 10px;">
                            <div class="col-sm-3">
                                <label for="payment_type" class="col-form-label">Payment Type:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $user['payment_type'] }}" style="margin-left: 7px;" readonly>
                            </div>
                        </div>
                    </div>
                    @elseif($item->order_retrieval == 'pickup')
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="payment_type" class="col-form-label" style="margin-right: 40px;">Payment Type:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $item['payment_type'] }}" readonly>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>