<div class="modal fade" id="deliverInfo{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
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
                    <h5>Purchased Item</h5>
                </div>
                @foreach($user['items'] as $item)


                <div class="row mb-3 item-row" data-item-id="{{ $item->id }}">


                    <div class="col-sm-12 mb-3">
                        <label for="" class="col-sm-2 col-form-label">Item Name</label>
                        <input type="text" class="form-control" value="{{ $item->product_name }}" readonly>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="" class="col-sm-2 col-form-label">Quantity</label>
                        <input type="number" class="form-control item-quantity" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="{{ $item->quantity }}" readonly>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="" class="col-sm-2 col-form-label">Item Price</label>
                        <input type="text" class="form-control item-price" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="₱{{ number_format($item->price, 2) }}" readonly>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="subtotal" class="col-sm-2 col-form-label">SubTotal</label>
                        <input type="text" class="form-control item-sub-total" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="0" readonly>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                    </div>
                </div>
                @endforeach
                <div class="modal-footer">
                    <div class="row row-cols-1 row-cols-md-2 align-items-center">
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

                    <div style="position: relative; width: 100%;">
                        <form action="{{ route('selected-items.update', ['referenceNo' => $user['referenceNo']]) }}" method="POST" class="mb-3" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row align-items-center">
                                <div class="col-sm-6 col-lg-4 mb-3">
                                    <label for="courier_id" class="col-form-label">Courier name:</label>
                                    <input type="text" class="form-control" value="{{ $courierName }}" readonly>
                                    <input type="hidden" name="courier_id" value="{{ $courier->id }}">
                                </div>

                                <div class="col-sm-6 col-lg-4 mb-3">
                                    <label for="courier_id" class="col-form-label">Payment Type:</label>
                                    <input type="text" class="form-control" value="{{ $item->payment_type }}" readonly>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label for="courier_id" class="col-form-label">Proof of Delivery:</label>
                                    <input type="file" class="form-control" name="proof_of_delivery" id="proof_of_delivery" required>
                                </div>

                            </div>
                            @if($item->payment_type == 'COD' || $item->payment_type == 'In-store')
                            @if($item->payment_condition == NULL)
                            <div class="row mb-3 item-row">
                                <label for="payment_type" class="col-sm-2 col-form-label">Payment Condition:</label>
                                <select name="payment_condition" id="payment_condition" class="form-select col-md-4 mb-3">
                                    <option value="">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                                @endif
                                @elseif($item->payment_condition == 'paid')
                                <label for="payment_type" class="col-sm-2 col-form-label">Payment Condition:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control mb-3" value="{{ $item->payment_condition }}" id="payment_condition" name="payment_condition" readonly>
                                </div>
                                @endif
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-outline-primary me-2">Finished</button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>