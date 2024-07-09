<div class="modal fade" id="messages{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryTitle">{{ $user['name'] }}'s purchases</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @if($user['order_retrieval'] == 'delivery')
                <div class="row mb-3">
                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user['phone'] }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fb_link" class="col-sm-2 col-form-label">Facebook</label>
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
                @endif

                @foreach($user['items'] as $item)
                <div class="row mb-3 item-row" data-item-id="{{ $item->id }}">

                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label for="phone" class="col-12 col-sm-6 col-md-4 col-form-label">Item Name</label>
                        <input type="text" class="form-control" value="{{ $item->product_name }}" readonly>
                    </div>

                    <div class="col-6 col-sm-3 col-md-2 mb-3">
                        <label for="quantity" class="col-6 col-sm-3 col-md-2 col-form-label">Quantity</label>
                        <input type="number" class="form-control item-quantity" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="{{ $user['quantity'] }}" readonly>
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
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3">
                            <label for="total" class="col-form-label">Total</label>
                            <input type="text" name="total" class="form-control purchase-total" data-total-id="{{ $user['referenceNo'] }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="reference" class="col-form-label">Reference No.</label>
                            <input type="text" name="reference" class="form-control" value="{{ $user['referenceNo'] }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="order_date" class="col-form-label">Date</label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($user['created_at'])->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}" readonly>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <hr>
                    </div>

                    <div style="position: relative; width: 100%;">
                        <form action="{{ route('selected-items.update', ['referenceNo' => $user['referenceNo']]) }}" method="POST" class="mb-3" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="column align-items-center">


                                <!-- Display Only  -->

                                <!-- End -->

                                <div class="row mb-3 item-row" data-item-id="{{ $item->id }}">

                                    <div class="col-md-4 mb-3">
                                        <label for="" class="col-form-label">Order Retrieval:</label>
                                        <select class="form-select order_retrieval" name="order_retrieval" id="order_retrieval" data-item-id="{{ $item->id }}">
                                            <option value="" selected disabled>Choose Order Retrieval</option>
                                            <option value="pickup" {{ $user['order_retrieval'] == 'pickup' ? 'selected' : ''}}>Pick Up</option>
                                            <option value="delivery" {{ $user['order_retrieval'] == 'delivery' ? 'selected' : ''}}>Delivery</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="payment_type" class="col-form-label">Payment Type</label>
                                        <select class="form-select" name="payment_type" id="payment_type">
                                            <option value="" disabled>Choose Payment Type</option>
                                            <option class="payment_type" id="gcash" value="G-cash" {{ $user['payment_type'] == 'G-cash' ? 'selected' : ''}}>G-Cash</option>
                                            <option class="payment_type cod" value="COD" {{ $user['payment_type'] == 'COD' ? 'selected' : ''}}>Cash On Delivery</option>
                                            <option class="payment_type instore" value="In-store" {{ $user['payment_type'] == 'In-store' ? 'selected' : ''}}>In-store</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="" class="col-form-label">Payment Condition:</label>
                                        <select class="form-select payment-condition" name="payment_condition" id="payment-condition{{ $item->id }}" data-item-id="{{ $item->id }}">
                                            <option value="" selected disabled>Choose Payment Type</option>
                                            <option value="paid" {{ $user['payment_condition'] == 'paid' ? 'selected' : ''}}>Paid</option>
                                            <option value="" {{ $user['payment_condition'] == '' ? 'selected' : ''}}>Unpaid</option>
                                        </select>
                                    </div>

                                    <!-- For Delivery -->
                                    @if($user['order_retrieval'] == 'delivery')
                                    @if($user['delivery_date'] && $user['courier_id'])
                                    <div class="col-12 mb-3" id="proof-of-delivery{{ $item->id }}">
                                        <label for="" class="col-form-label">Proof of Delivery:</label>
                                        <input type="file" class="form-control" name="proof_of_delivery">
                                    </div>
                                    @endif
                                    @endif

                                </div>

                                @if($user['order_retrieval'] == 'delivery')
                                <div class="row row-cols-md-2 mb-3 item-row">
                                    <div class="mb-3" id="courier{{ $item->id }}" data-item-id="{{ $item->id }}">
                                        <label for="" class="col-form-label">Courier</label>
                                        <div>
                                            <select class="form-select" name="courier_id">
                                                <option value="" selected disabled>Choose Courier</option>
                                                @foreach($couriers as $courier)
                                                <option value="{{ $courier->id }}" {{ $user['courier_id'] == $courier->id  ? 'selected' : ''}}>{{ $courier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3" id="delivery{{ $item->id }}" data-item-id="{{ $item->id }}">
                                        <label for="" class="col-form-label">Deliver On</label>
                                        <div>
                                            <select class="form-select" name="delivery_schedule">

                                                @if($user['delivery_date'] == NULL)
                                                <option value="" selected disabled>Choose Schedule</option>

                                                @foreach($schedules as $schedule)
                                                <option value="{{ $schedule->id }}">{{ $schedule->day }}
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}-
                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                                </option>
                                                @endforeach

                                                @else
                                                @foreach($schedules as $schedule)
                                                <option value="{{ $schedule->id }}" {{ \Carbon\Carbon::parse($user['delivery_date'])->format('l') === $schedule->day ? 'selected' : ''}}>{{ $schedule->day }}
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}-
                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
