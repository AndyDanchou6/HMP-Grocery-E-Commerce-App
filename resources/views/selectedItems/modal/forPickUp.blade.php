<!-- Modal Content -->
<div class="modal fade" id="forPickUp{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-wrap" id="categoryTitle">{{ $user['name'] }}'s purchases</h5>
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

                    <div class="col-md-3 mb-3 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('storage/'. $item->inventory->product_img) }}" alt="" class="img-fluid">
                    </div>

                    <div class="col-md-9 mb-3 row">
                        <div class="col-12 mb-3">
                            <label for="item_name" class="col-12 col-sm-6 col-md-4 col-form-label">Item Name</label>
                            @if(isset($item->inventory->variant))
                            <span><input type="text" class="form-control" value="{{ $item->inventory->product_name }} [{{ $item->inventory->variant }}]" readonly></span>
                            @else
                            <span><input type="text" class="form-control" value="{{ $item->inventory->product_name }}" readonly></span>
                            @endif
                        </div>

                        <div class="col-8 col-sm-4 mb-3">
                            <label for="item_price" class="col-6 col-sm-3 col-md-3 col-form-label">Item Price</label>
                            <span><input type="text" class="form-control item-price" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="₱{{ number_format($item->inventory->price, 2) }}" readonly></span>
                        </div>

                        <div class="col-4 col-sm-3 mb-3">
                            <label for="quantity" class="col-6 col-sm-3 col-md-2 col-form-label">Quantity</label>
                            <span><input type="number" class="form-control item-quantity" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="{{ $item->quantity }}" readonly></span>
                        </div>

                        <div class="col-12 col-sm-5 mb-3">
                            <label for="subtotal" class="col-12 col-sm-4 col-md-3 col-form-label">SubTotal</label>
                            <span><input type="text" class="form-control item-sub-total" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="₱{{ number_format($item->inventory->quantity * $item->inventory->price, 2) }}" readonly></span>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                    </div>

                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <div class="row row-cols-1 row-cols-md-2 align-items-center" style="margin-bottom: 10px; margin-right: 50px;">
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
                        <input type="text" class="form-control" value="{{ ucwords($user['order_retrieval']) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="order_date" class="col-form-label">Date Ordered</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($user['created_at'])->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}" readonly>
                    </div>
                </div>

                <div style="position: relative; width: 90%; margin: auto;">
                    <form action="{{ route('selected-items.update', ['referenceNo' => $user['referenceNo']]) }}" method="POST" style="position: relative; width: 100%">
                        @csrf
                        @method('POST')

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 align-items-center">

                            <div class="mb-3">
                                <label for="order_retrieval" class="col-form-label">Order Retrieval</label>
                                <div>
                                    <select class="form-select order_retrieval" name="order_retrieval" data-item-id="{{ $item->id }}" data-user-reference="{{ $user['referenceNo'] }}">
                                        <option value="" selected disabled>Choose Order Retrieval</option>
                                        <option value="pickup" {{ $user['order_retrieval'] == 'pickup'  ? 'selected' : ''}}>Pick Up</option>
                                        <option value="delivery" {{ $user['order_retrieval'] == 'delivery'  ? 'selected' : ''}}>Delivery</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="col-form-label">Payment Type</label>
                                <div>
                                    <select class="form-select payment_type" name="payment_type" id="payment_type{{ $user['referenceNo'] }}" data-item-id="{{ $item->id }}" data-user-reference="{{ $user['referenceNo'] }}">
                                        <option value="" selected disabled>Choose Payment</option>
                                        <option value="G-cash" {{ $user['payment_type'] == 'G-cash'  ? 'selected' : ''}}>G-Cash</option>
                                        <option class="payment_type cod" value="COD" {{ $user['payment_type'] == 'COD'  ? 'selected' : ''}}>Cash On Delivery</option>
                                        <option class="payment_type in-store" value="In-store" {{ $user['payment_type'] == 'In-store'  ? 'selected' : ''}}>In-store</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Payment Status</label>
                                <select name="payment_condition" id="payment_condition" class="form-select payment_condition" data-item-id="{{ $item->id }}" data-user-reference="{{ $user['referenceNo'] }}">
                                    <option value="" selected disabled>Choose Payment Type</option>
                                    <option value="paid" {{ $user['payment_condition'] == 'paid' ? 'selected' : ''}}>Paid</option>
                                    <option value="" {{ $user['payment_condition'] == '' ? 'selected' : ''}}>Unpaid</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 col-12 denial-reason" id="denial-reason{{ $user['referenceNo'] }}" style="display: none;">
                            <label for="#" class="col-form-label">Reason for Denial</label>
                            <div>
                                <textarea class="form-control col-12" rows="5" name="reasonForDenial" placeholder="Reason for denial of order ..."></textarea>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end">
                            <button type="button" class="btn btn-outline-danger me-2 mb-2 denyBtn" name="deny" data-user-reference="{{ $user['referenceNo'] }}" value="true">Deny</button>
                            <button type="button" class="btn btn-outline-primary me-2 mb-2 w-auto" id="cancelDenyBtn{{ $user['referenceNo'] }}" style="display: none;">Cancel Deny</button>
                            <button type="submit" class="btn btn-outline-success me-2 mb-2 w-auto" id="pickedUpBtn{{ $user['referenceNo'] }}" name="pickedUp" value="true">Picked Up</button>
                            <button type="submit" class="btn btn-outline-primary me-2 mb-2 w-auto" id="updateBtn{{ $user['referenceNo'] }}" style="display: none;">Update</button>
                            <button type="button" class="btn btn-outline-secondary me-2 mb-2 w-auto" data-bs-dismiss="modal">Close</button>
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

        var paymentTypes = document.querySelectorAll('.payment_type');
        var paymentConditions = document.querySelectorAll('.payment_condition');
        var orderRetrievals = document.querySelectorAll('.order_retrieval');

        orderRetrievals.forEach(function(orderRetrieval) {

            let userReference = orderRetrieval.getAttribute('data-user-reference');
            var paymentTypeSelect = document.querySelector('#payment_type' + userReference);

            hideOptions(userReference, orderRetrieval.value);

            orderRetrieval.addEventListener('change', function() {

                // change buttons (update data or change status to picked up)
                document.querySelector('#pickedUpBtn' + userReference).style.display = 'none';
                document.querySelector('#updateBtn' + userReference).style.display = 'block';

                // change payment options based on retrieval
                hideOptions(userReference, orderRetrieval.value);

                // Warn if retrieval is changed
                paymentTypeSelect.classList.add('text-danger');
                paymentTypeSelect.classList.add('border-danger');

                paymentTypeSelect.addEventListener('change', function() {

                    paymentTypeSelect.classList.remove('text-danger');
                    paymentTypeSelect.classList.remove('border-danger');
                });
            });
        });

        paymentConditions.forEach(function(paymentCondition) {

            let userReference = paymentCondition.getAttribute('data-user-reference');
            paymentCondition.addEventListener('change', function() {

                // change buttons (update data or change status to picked up)
                document.querySelector('#pickedUpBtn' + userReference).style.display = 'none';
                document.querySelector('#updateBtn' + userReference).style.display = 'block';
            })
        })

        paymentTypes.forEach(function(paymentType) {

            let userReference = paymentType.getAttribute('data-user-reference');
            paymentType.addEventListener('change', function() {

                // change buttons (update data or change status to picked up)
                document.querySelector('#pickedUpBtn' + userReference).style.display = 'none';
                document.querySelector('#updateBtn' + userReference).style.display = 'block';
            })
        })

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

        denyBtns.forEach(function(deny) {

            var secondDenyClick = false;
            var userReference = deny.getAttribute('data-user-reference');
            var denialInputs = document.querySelector('#denial-reason' + userReference);
            var pickedUpBtn = document.querySelector('#pickedUpBtn' + userReference);
            var updateBtn = document.querySelector('#updateBtn' + userReference);
            var cancelDenyBtn = document.querySelector('#cancelDenyBtn' + userReference);

            deny.addEventListener('click', function() {

                if (secondDenyClick == false) {
                    denialInputs.style.display = 'block';
                    denialInputs.setAttribute('required', 'required');

                    if (pickedUpBtn) {

                        pickedUpBtn.style.display = 'none';
                    } else if (updateBtn) {

                        updateBtn.style.display = 'none';
                    }

                    if (cancelDenyBtn) {

                        cancelDenyBtn.style.display = 'block';
                    }

                    secondDenyClick = true;
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
                    deny.setAttribute('type', 'button');
                    cancelDenyBtn.style.display = 'none';

                    if (pickedUpBtn) {

                        pickedUpBtn.style.display = 'block';
                    } else if (updateBtn) {

                        updateBtn.style.display = 'block'
                    }

                    secondDenyClick = false;
                })
            }
        })
    });
</script>