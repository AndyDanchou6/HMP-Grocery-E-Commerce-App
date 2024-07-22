<!-- Modal Content -->
<div class="modal fade" id="forDelivery{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
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
                    @if($user['fb_link'])
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user['fb_link'] }}" readonly>
                    </div>
                    @else
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="No information" readonly>
                    </div>
                    @endif
                </div>

                <div>
                    <h5>Purchased Items</h5>
                </div>
                @foreach($user['items'] as $item)
                <div class="row item-row" data-item-id="{{ $item->id }}">

                    <div class="col-12 mb-3">
                        <label for="item_name" class="col-12 col-sm-6 col-md-4 col-form-label">Item Name</label>
                        <input type="text" class="form-control" value="{{ $item->inventory->product_name }}" readonly>
                    </div>

                    <div class="col-8 col-sm-4 mb-3">
                        <label for="item_price" class="col-form-label">Item Price</label>
                        <input type="text" class="form-control item-price" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="₱{{ number_format($item->inventory->price, 2) }}" readonly>
                    </div>

                    <div class="col-4 col-sm-3 mb-3">
                        <label for="quantity" class="col-form-label">Quantity</label>
                        <input type="number" class="form-control item-quantity" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="{{ $item->quantity }}" readonly>
                    </div>
                    <div class="col-12 col-sm-5 mb-3">
                        <label for="subtotal" class="col-form-label">SubTotal</label>
                        <input type="text" class="form-control item-sub-total" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="0" readonly>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                    </div>

                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <div class="row row-cols-1 row-cols-md-2 align-items-center" style="position: relative; width: 95%; margin: auto;">
                    <div class="mb-3">
                        <label for="total" class="col-form-label">Total</label>
                        <input type="text" name="total" class="form-control purchase-total" id="purchase-total{{ $user['referenceNo'] }}" data-total-id="{{ $user['referenceNo'] }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="reference" class="col-form-label">Reference No.</label>
                        <input type="text" name="reference" class="form-control" value="{{ $user['referenceNo'] }}" readonly>
                    </div>

                    <div class="w-100 mb-3">
                        <label for="order_date" class="col-form-label">Order Date</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($user['created_at'])->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}" readonly>
                    </div>
                </div>

                <div style="position: relative; width: 90%; margin: auto;">
                    <form action="{{ route('selected-items.update', ['referenceNo' => $user['referenceNo']]) }}" method="POST" enctype="multipart/form-data" style="position: relative; width: 100%">
                        @csrf
                        @method('POST')

                        <!-- Courier and Delivery Date -->
                        <div class="row row-cols-md-2 mb-3 item-row">
                            <div class="mb-3" id="courier{{ $user['referenceNo'] }}" data-item-id="{{ $item->id }}">
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

                            <div class="mb-3">
                                <label for="order_retrieval" class="col-form-label">Order Retrieval</label>
                                <div>
                                    <select class="form-select order_retrieval" name="order_retrieval" data-item-id="{{ $user['id'] }}" data-user-reference="{{ $user['referenceNo'] }}">
                                        <option value="" selected disabled>Choose Order Retrieval</option>
                                        <option value="pickup" {{ $user['order_retrieval'] == 'pickup'  ? 'selected' : ''}}>Pick Up</option>
                                        <option value="delivery" {{ $user['order_retrieval'] == 'delivery'  ? 'selected' : ''}}>Delivery</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3" id="delivery{{ $user['referenceNo'] }}" data-item-id="{{ $item->id }}">
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

                            @if($user['delivery_date'] && $user['courier_id'])
                            <div class="col-12 mb-3" id="proof-of-delivery{{ $user['referenceNo'] }}">
                                <label for="" class="col-form-label">Proof of Delivery:</label>
                                <input type="file" id="proofOfDelivery" class="form-control" name="proof_of_delivery">
                                <small id="proofSizeError" class="form-text text-danger" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
                            </div>
                            @endif
                        </div>

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 align-items-center">
                            <div class="mb-3">
                                <label for="" class="col-form-label">Payment Type</label>
                                <div>
                                    <select class="form-select payment_type" id="payment_type{{ $user['referenceNo'] }}" name="payment_type" data-item-id="{{ $item->id }}">
                                        <option value="" selected disabled>Choose Payment</option>
                                        <option value="G-cash" {{ $user['payment_type'] == 'G-cash'  ? 'selected' : ''}}>G-Cash</option>
                                        <option class="payment_type cod" value="COD" {{ $user['payment_type'] == 'COD'  ? 'selected' : ''}}>Cash On Delivery</option>
                                        <option class="payment_type in-store" value="In-store" {{ $user['payment_type'] == 'In-store'  ? 'selected' : ''}}>In-store</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Payment Status</label>
                                <select name="payment_condition" id="payment_condition" class="form-select">
                                    <option value="" selected disabled>Choose Payment Type</option>
                                    <option value="paid" {{ $user['payment_condition'] == 'paid' ? 'selected' : ''}}>Paid</option>
                                    <option value="" {{ $user['payment_condition'] == '' ? 'selected' : ''}}>Unpaid</option>
                                </select>

                            </div>

                            <div class="mb-3 w-100" id="dropOff{{ $user['referenceNo'] }}">
                                <label for="" class="py-2">Delivery Address</label>
                                <div class="w-100">
                                    <select class="w-100 py-2 rounded form-select delivery-address" name="service_fee_id" data-item-id="{{ $user['id'] }}" data-user-reference="{{ $user['referenceNo'] }}" required>
                                        <option value="" selected disabled>Choose Drop-off</option>
                                        @foreach($dropOffPoints as $dropOffPoint)
                                        @if(isset($user['address']))
                                        <option value="{{ $dropOffPoint->id }}" data-fee="{{ $dropOffPoint->fee }}" {{ $user['address'] == $dropOffPoint->location  ? 'selected' : ''}}>{{ $dropOffPoint->location }}</option>
                                        @else
                                        <option value="{{ $dropOffPoint->id }}" data-fee="{{ $dropOffPoint->fee }}">{{ $dropOffPoint->location }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 service-fee" id="service-fee{{ $user['referenceNo'] }}" data-item-id="{{ $user['id'] }}">
                                <label for="" class="col-form-label">Service Fee</label>
                                @if(isset($item->serviceFee->fee))
                                <input type="text" class="form-control" step="0.01" min="0.01" name="service_fee" placeholder="0.00" value="{{ $item->serviceFee->fee }}" readonly>
                                @else
                                <input type="text" class="form-control" step="0.01" min="0.01" name="service_fee" placeholder="0.00" value="0.00" readonly>
                                @endif
                            </div>

                            @if($user['order_retrieval'] == 'delivery')
                            <div class="mb-3 total-with-fee" id="total-with-fee{{ $user['referenceNo'] }}" data-total-id="{{ $user['referenceNo'] }}">
                                <label for="" class="col-form-label">Total w/ Fee</label>
                                <input type="text" class="form-control" step="0.01" min="0.01" placeholder="0.00" value="0.00" readonly>
                            </div>
                            @endif

                        </div>

                        <div class="mb-3 col-12 denial-reason" id="denial-reason{{ $user['referenceNo'] }}" style="display: none;">
                            <label for="#" class="col-form-label">Reason for Denial</label>
                            <div>
                                <textarea class="form-control col-12" rows="5" name="reasonForDenial" placeholder="Reason for denial of order ..."></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-danger me-2 denyBtn" name="deny" value="true" data-user-reference="{{ $user['referenceNo'] }}">Deny</button>

                            @if($user['delivery_date'] && $user['courier_id'])
                            <button type="submit" class="btn btn-outline-success me-2" id="finishedBtn{{ $user['referenceNo'] }}">Update</button>
                            @else
                            <button type="submit" class="btn btn-outline-primary me-2" id="finishedBtn{{ $user['referenceNo'] }}">Update</button>
                            @endif
                            <button type="button" class="btn btn-outline-primary me-2" id="cancelDenyBtn{{ $user['referenceNo'] }}" style="display: none;">Cancel Deny</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>

                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function hideOptions(userReference, orderRetrieval) {
            var paymentTypeSelect = document.querySelector('#payment_type' + userReference);
            var options = paymentTypeSelect.querySelectorAll('.payment_type');


            options.forEach(function(option) {
                if (orderRetrieval == 'delivery') {
                    if (option.classList.contains('cod')) {
                        option.style.display = 'block';
                    }
                    if (option.classList.contains('in-store')) {
                        option.style.display = 'none';
                    }
                } else if (orderRetrieval == 'pickup') {
                    if (option.classList.contains('cod')) {
                        option.style.display = 'none';
                    }
                    if (option.classList.contains('in-store')) {
                        option.style.display = 'block';
                    }
                }
            })
        }

        function toggleReceiptSubmission(userReference, retrieval) {
            var proofForm = document.querySelector('#proof-of-delivery' + userReference);

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

        function toggleDeliveryOptions(userReference, retrieval) {
            let courierOptions = document.querySelector('#courier' + userReference);
            let deliveryOptions = document.querySelector('#delivery' + userReference);

            if (retrieval == 'delivery') {
                courierOptions.style.display = 'block';
                deliveryOptions.style.display = 'block';
            } else if (retrieval == 'pickup') {
                courierOptions.style.display = 'none';
                deliveryOptions.style.display = 'none';
            }
        }

        function toggleDropOff(userReference, retrievalValue) {

            var totalWithFee = document.querySelector('#total-with-fee' + userReference);
            var dropOff = document.querySelector('#dropOff' + userReference);
            var serviceFee = document.querySelector('#service-fee' + userReference);
            var serviceFeeInput = serviceFee.querySelector('input');

            if (retrievalValue == 'delivery') {

                totalWithFee.style.display = 'block';
                dropOff.style.display = 'block';
                dropOff.querySelector('select').setAttribute('required', 'required');
                serviceFee.style.display = 'block';
                serviceFeeInput.setAttribute('required', 'required');
            }

            if (retrievalValue == 'pickup') {

                totalWithFee.style.display = 'none';
                dropOff.querySelector('select').removeAttribute('required');
                dropOff.style.display = 'none';
                serviceFee.style.display = 'none';
                serviceFeeInput.removeAttribute('required');
            }
        }

        //     // Hide delivery options if retrieval is pickup
        var orderRetrievals = document.querySelectorAll('.order_retrieval');

        orderRetrievals.forEach(function(orderRetrieval) {

            let userReference = orderRetrieval.getAttribute('data-user-reference');
            var paymentTypeSelect = document.querySelector('#payment_type' + userReference);

            hideOptions(userReference, orderRetrieval.value);
            toggleReceiptSubmission(userReference, orderRetrieval.value);
            toggleDeliveryOptions(userReference, orderRetrieval.value);
            toggleDropOff(userReference, orderRetrieval.value);

            orderRetrieval.addEventListener('change', function() {

                hideOptions(userReference, orderRetrieval.value);
                toggleDeliveryOptions(userReference, orderRetrieval.value);
                toggleReceiptSubmission(userReference, orderRetrieval.value);
                toggleDropOff(userReference, orderRetrieval.value);

                paymentTypeSelect.classList.add('text-danger');
                paymentTypeSelect.classList.add('border-danger');

                paymentTypeSelect.addEventListener('change', function() {

                    paymentTypeSelect.classList.remove('text-danger');
                    paymentTypeSelect.classList.remove('border-danger');
                });
            });
        });

        //     // toggle proof of delivery form
        //     // var paymentConditions = document.querySelectorAll('.payment-condition');

        //     // paymentConditions.forEach(function(paymentCondition) {

        //     //     let itemId = paymentCondition.getAttribute('data-item-id');

        //     //     if (orderRetrievalValue == 'delivery') {
        //     //         toggleReceiptSubmission(itemId, paymentCondition.value);
        //     //     }

        //     //     paymentCondition.addEventListener('change', function() {
        //     //         if (orderRetrievalValue == 'delivery') {
        //     //             toggleReceiptSubmission(itemId, paymentCondition.value);
        //     //         }
        //     //     });
        //     // });

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

        var denyBtns = document.querySelectorAll('.denyBtn');
        var clickedDeny = false;

        denyBtns.forEach(function(deny) {

            var userReference = deny.getAttribute('data-user-reference');
            var denialInputs = document.querySelector('#denial-reason' + userReference);
            var serviceFee = document.querySelector('#service-fee' + userReference);
            var finishedBtn = document.querySelector('#finishedBtn' + userReference);
            var cancelDenyBtn = document.querySelector('#cancelDenyBtn' + userReference);
            var deliveryAddress = document.querySelector('.delivery-address[data-user-reference="' + userReference + '"]')

            deny.addEventListener('click', function() {

                if (clickedDeny == false) {
                    denialInputs.style.display = 'block';
                    denialInputs.setAttribute('required', 'required');
                    finishedBtn.style.display = 'none';
                    deliveryAddress.removeAttribute('required');

                    if (serviceFee) {

                        serviceFee.querySelector('input').removeAttribute('required');
                        serviceFee.style.display = 'none';
                    }

                    if (cancelDenyBtn) {

                        cancelDenyBtn.style.display = 'block';
                    }

                    clickedDeny = true;
                } else {

                    var reasonNotNull = denialInputs.querySelector('textarea');

                    if (reasonNotNull.value.trim() !== '') {

                        deny.setAttribute('type', 'submit');
                    }
                }
            })

            if (cancelDenyBtn) {
                cancelDenyBtn.addEventListener('click', function() {

                    denialInputs.style.display = 'none';
                    denialInputs.removeAttribute('required');
                    finishedBtn.style.display = 'block';
                    deny.setAttribute('type', 'button');
                    cancelDenyBtn.style.display = 'none';
                    deliveryAddress.setAttribute('required', 'required');

                    if (serviceFee) {

                        serviceFee.querySelector('input').setAttribute('required', 'required');
                        serviceFee.style.display = 'block';
                    }

                    clickedDeny = false;
                })
            }
        })

    });
</script>
<script>
    var proofOfDelivery = document.getElementById('proofOfDelivery');

    if (proofOfDelivery) {
        proofOfDelivery.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const errorMessage = document.getElementById('proofSizeError');

            if (file && file.size > 2 * 1024 * 1024) {
                errorMessage.style.display = 'block';
                errorMessage.style.whiteSpace = 'normal';
                event.target.value = '';
            } else {
                errorMessage.style.display = 'none';
            }
        });
    }
</script>