    @extends('app')

    @section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center mb-4">
                <h4 style="margin: auto 0;">For Delivery Orders</h4>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Reference No.</th>
                            <th>Payment Type</th>
                            <th>Delivery Schedule</th>
                            <th>Items</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="tableBody">
                        @if(count($forDelivery) > 0)
                        @foreach ($forDelivery as $user)
                        <tr>
                            <td style="display: none;" class="id-field">{{ $user['id'] }}</td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['referenceNo'] }}</td>
                            <td>{{ $user['payment_type'] }}</td>
                            @if($user['delivery_date'])
                            <td>{{ \Carbon\Carbon::parse($user['delivery_date'])->format('l, F j, Y g:i A') }}</td>
                            @else
                            <td>Not Scheduled Yet</td>
                            @endif
                            
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$user['referenceNo']}}" data-user-id="{{ $user['referenceNo'] }}"></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No Selected Items found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(count($forDelivery) > 0)
@foreach ($forDelivery as $user)
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
                                        <!-- <input type="text" class="form-control" value="{{ ucwords($item->order_retrieval) }}" readonly> -->
                                        <select class="form-select" name="payment_type" id="payment_type">
                                            <option value="" disabled>Choose Payment Type</option>
                                            <option class="payment_type" id="gcash" value="G-Cash" {{ $user['payment_type'] == 'G-cash' ? 'selected' : ''}}>G-Cash</option>
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
                                    @if($user['delivery_date'] && $user['courier_id'])
                                    <div class="col-12 mb-3" id="proof-of-delivery{{ $item->id }}">
                                        <label for="" class="col-form-label">Proof of Delivery:</label>
                                        <input type="file" class="form-control" name="proof_of_delivery">
                                    </div>
                                    @endif

                                </div>

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
@endforeach
@endif

@endsection

@section('customScript')
<script>
    function hideOptions(orderRetrieval) {
        var options = document.querySelectorAll('.payment_type');

        options.forEach(function(option) {
            if (orderRetrieval == 'delivery') {
                if (option.classList.contains('instore')) {
                    option.style.display = 'none';
                }
                if (option.classList.contains('cod')) {
                    option.style.display = 'block';
                }
            } else if (orderRetrieval == 'pickup') {
                if (option.classList.contains('cod')) {
                    option.style.display = 'none';
                }
                if (option.classList.contains('instore')) {
                    option.style.display = 'block';
                }
            }
        });
    }

    function toggleReceiptSubmission(itemId, retrieval) {
        var proofForm = document.querySelector('#proof-of-delivery' + itemId);

        if (proofForm) {
            if (retrieval == 'delivery') {
                proofForm.style.display = 'block';
                // proofForm.querySelector('input[type="file"]').setAttribute('required', 'required');
            } else {
                proofForm.style.display = 'none';
                // proofForm.querySelector('input[type="file"]').removeAttribute('required')
            }
        }
    }

    function toggleDeliveryOptions(itemId, retrieval) {
        let courierOptions = document.querySelector('#courier' + itemId);
        let deliveryOptions = document.querySelector('#delivery' + itemId);

        if (retrieval == 'delivery') {
            courierOptions.style.display = 'block';
            deliveryOptions.style.display = 'block';
        } else if (retrieval == 'pickup') {
            courierOptions.style.display = 'none';
            deliveryOptions.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Hide delivery options if retrieval is pickup

        var orderRetrievals = document.querySelectorAll('.order_retrieval');
        var orderRetrievalValue = '';

        orderRetrievals.forEach(function(orderRetrieval) {

            let itemId = orderRetrieval.getAttribute('data-item-id');

            // orderRetrievalValue = orderRetrieval.value;
            hideOptions(orderRetrieval.value);
            toggleReceiptSubmission(itemId, orderRetrieval.value);

            // console.log(itemId);

            toggleDeliveryOptions(itemId, orderRetrieval.value);

            orderRetrieval.addEventListener('change', function() {

                // orderRetrievalValue = orderRetrieval.value;
                hideOptions(orderRetrieval.value);
                toggleDeliveryOptions(itemId, orderRetrieval.value);
                toggleReceiptSubmission(itemId, orderRetrieval.value);

            });
        });


        // toggle proof of delivery form
        // var paymentConditions = document.querySelectorAll('.payment-condition');

        // paymentConditions.forEach(function(paymentCondition) {

        //     let itemId = paymentCondition.getAttribute('data-item-id');

        //     if (orderRetrievalValue == 'delivery') {
        //         toggleReceiptSubmission(itemId, paymentCondition.value);
        //     }

        //     paymentCondition.addEventListener('change', function() {
        //         if (orderRetrievalValue == 'delivery') {
        //             toggleReceiptSubmission(itemId, paymentCondition.value);
        //         }
        //     });
        // });

        var subTotalField = document.querySelectorAll(".item-sub-total");
        var totalContainer = {};

        subTotalField.forEach(function(subtotal) {
            var itemReferenceNo = subtotal.getAttribute("data-item-id");
            var [referenceNo, itemId] = itemReferenceNo.split("_");

            var price = parseFloat(
                document
                .querySelector(
                    '.item-price[data-item-id="' + itemReferenceNo + '"]'
                )
                .value.replace(/[^0-9.-]+/g, "")
            );
            var quantity = parseInt(
                document.querySelector(
                    '.item-quantity[data-item-id="' + itemReferenceNo + '"]'
                ).value
            );

            if (quantity < 0) {
                alert("Quantity cannot be negative.");
                quantity = 0;
                document.querySelector(
                    '.item-quantity[data-item-id="' + itemReferenceNo + '"]'
                ).value = 0;
            }

            var userSubTotalField = document.querySelector(
                '.item-sub-total[data-item-id="' + itemReferenceNo + '"]'
            );

            var tempSubTotal = price * quantity;
            userSubTotalField.value = tempSubTotal.toLocaleString("en-PH", {
                style: "currency",
                currency: "PHP",
            });

            if (!totalContainer[referenceNo]) {
                totalContainer[referenceNo] = tempSubTotal;
            } else {
                totalContainer[referenceNo] += tempSubTotal;
            }
        });

        var totals = document.querySelectorAll(".purchase-total");

        totals.forEach(function(total) {
            var totalId = total.getAttribute("data-total-id");
            total.value = totalContainer[totalId].toLocaleString("en-PH", {
                style: "currency",
                currency: "PHP",
            });
        });
    });
</script>
@endsection
