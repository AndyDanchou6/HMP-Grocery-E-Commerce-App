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
                    <h5>Purchased Item</h5>
                </div>
                @foreach($user['items'] as $item)
                <div class="row mb-3 item-row" data-item-id="{{ $item->id }}">

                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label for="phone" class="col-12 col-sm-6 col-md-4 col-form-label">Item Name</label>
                        <input type="text" class="form-control" value="{{ $item->product_name }}" readonly>
                    </div>

                    <div class="col-6 col-sm-3 col-md-2 mb-3">
                        <label for="quantity" class="col-6 col-sm-3 col-md-2 col-form-label">Quantity</label>
                        <input type="number" class="form-control item-quantity" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="{{ $item->quantity }}" readonly>
                    </div>

                    <div class="col-6 col-sm-3 col-md-3 ">
                        <label for="item_price" class="col-6 col-sm-3 col-md-3 col-form-label">Item Price</label>
                        <input type="text" class="form-control item-price" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="₱{{ number_format($item->price, 2) }}" readonly>
                    </div>

                    <div class="col-12 col-sm-4 col-md-3 mb-3">
                        <label for="subtotal" class="col-12 col-sm-4 col-md-3 col-form-label">SubTotal</label>
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
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}" readonly>
                        </div>
                    </div>

                    <div style="position: relative; width: 100%;">
                        <form action="{{ route('selected-items.update', ['referenceNo' => $user['referenceNo']]) }}" method="POST" class="mb-3" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @if($item->order_retrieval == 'delivery')
                            <div class="column align-items-center">

                                @if($user['courier_id'] != 'Unknown')
                                <div class="mb-3">
                                    <div>
                                        <label for="" class="col-form-label">Courier name:</label>
                                        <input type="text" class="form-control" value="{{ $user['courier_id'] }}" readonly>
                                    </div>
                                    <div>
                                        <label for="" class="col-form-label">Delivery Schedule:</label>
                                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($user['delivery_date'])->format('l, F j, Y g:i A') }}" readonly>
                                    </div>
                                </div>
                                @endif

                                <div class="row row-cols-md-2 mb-3 item-row" data-item-id="{{ $item->id }}">
                                    <div class="mb-3">
                                        <label for="" class="col-form-label">Payment Type:</label>
                                        <input type="text" class="form-control" value="{{ $item->payment_type }}" readonly>
                                    </div>

                                    @if($user['courier_id'] != 'Unknown')
                                    <div class="mb-3">
                                        <label for="" class="col-form-label">Proof of Delivery:</label>
                                        <input type="file" class="form-control" name="proof_of_delivery" id="proof_of_delivery" required>
                                    </div>
                                    @endif

                                </div>

                                @if($user['courier_id'] == 'Unknown')
                                <div class="mb-3">
                                    <label for="" class="col-form-label">Courier</label>
                                    <div>
                                        <select class="form-select" name="courier_id" id="courier_id" required>
                                            <option value="" selected>Choose Courier</option>
                                            @foreach($couriers as $courier)
                                            <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif

                                @if(!$user['delivery_date'])
                                <div class="mb-3">
                                    <label for="" class="col-form-label">Deliver On</label>
                                    <div>
                                        <select class="form-select" name="delivery_schedule" id="delivery_schedule" required>
                                            <option value="" selected>Choose Schedule</option>
                                            @foreach($schedules as $schedule)
                                            <option value="{{ $schedule->id }}">{{ $schedule->day }}
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}-
                                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif

                            </div>

                            @elseif($item->order_retrieval == 'pickup')
                            <div class="row mb-3 item-row" data-item-id="{{ $item->id }}">
                                <label for="payment_type" class="col-md-4 col-form-label">Payment Type:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="{{ $item->payment_type }}" readonly>
                                </div>
                                @endif

                                @if($item->payment_type == 'G-cash' || $item->payment_type == 'In-store')
                                @if($item->payment_condition == NULL && $item->order_retrieval == 'delivery' && $user['courier_id'] != 'Unknown')
                                <label for="payment_type" class="col-md-4 col-form-label">Payment Condition:</label>
                                <select name="payment_condition" id="payment_condition" class="form-select" style="width: 50%;" required>
                                    <option value="">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>

                                @elseif($item->payment_condition == NULL && $item->order_retrieval == 'delivery')
                                <label for="payment_type" class="col-md-4 col-form-label">Payment Condition:</label>
                                <select name="payment_condition" id="payment_condition" class="form-select" style="width: 50%;">
                                    <option value="">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>

                                @elseif($item->payment_condition == 'paid')
                                <label for="payment_type" class="col-md-4 col-form-label">Payment Condition:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="{{ $item->payment_condition }}" id="payment_condition" name="payment_condition" readonly>
                                </div>
                                @endif
                                @endif

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-outline-primary me-2">Finished</button>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>