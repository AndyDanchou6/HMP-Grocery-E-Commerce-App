<!-- Modal Content -->
<div class="modal fade" id="readyMessages{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
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

                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label for="item_name" class="col-12 col-sm-6 col-md-4 col-form-label">Item Name</label>
                        <input type="text" class="form-control" value="{{ $item->inventory->product_name }}" readonly>
                    </div>

                    <div class="col-6 col-sm-3 col-md-2 mb-3">
                        <label for="item_price" class="col-6 col-sm-3 col-md-2 col-form-label">Item Price</label>
                        <input type="text" class="form-control item-price" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="₱{{ number_format($item->inventory->price, 2) }}" readonly>
                    </div>

                    <div class="col-6 col-sm-3 col-md-3 mb-3">
                        <label for="quantity" class="col-6 col-sm-3 col-md-3 col-form-label">Quantity</label>
                        <input type="number" class="form-control item-quantity" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="{{ $item->quantity }}" readonly>
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
                        <label for="order_date" class="col-form-label">Date</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($user['created_at'])->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}" readonly>
                    </div>
                </div>

                <div style="position: relative; width: 90%; margin: auto;">
                    <form action="{{ route('selected-items.update', ['referenceNo' => $user['referenceNo']]) }}" method="POST" style="position: relative; width: 100%">
                        @csrf
                        @method('POST')
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 align-items-center">
                            <div class="mb-3">
                                <label for="" class="col-form-label">Payment Type</label>
                                <div>
                                    <select class="form-select payment_type" name="payment_type" data-item-id="{{ $item->id }}">
                                        <option value="" selected disabled>Choose Payment</option>
                                        <option value="G-cash" {{ $user['payment_type'] == 'G-cash'  ? 'selected' : ''}}>G-Cash</option>
                                        <option class="payment_type cod" value="COD" {{ $user['payment_type'] == 'COD'  ? 'selected' : ''}}>Cash On Delivery</option>
                                        <option class="payment_type in-store" value="In-store" {{ $user['payment_type'] == 'In-store'  ? 'selected' : ''}}>In-store</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="order_retrieval" class="col-form-label">Order Retrieval</label>
                                <div>
                                    <select class="form-select order_retrieval" name="order_retrieval" data-item-id="{{ $user['id'] }}">
                                        <option value="" selected disabled>Choose Order Retrieval</option>
                                        <option value="pickup" {{ $user['order_retrieval'] == 'pickup'  ? 'selected' : ''}}>Pick Up</option>
                                        <option value="delivery" {{ $user['order_retrieval'] == 'delivery'  ? 'selected' : ''}}>Delivery</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 service-fee" id="service-fee{{ $user['id'] }}" data-item-id="{{ $user['id'] }}">
                                <label for="" class="col-form-label">Service Fee</label>
                                <input type="number" class="form-control" step="0.01" min="0.01" name="service_fee" placeholder="0.00">
                            </div>

                        </div>

                        <div class="mb-3 col-12 denial-reason" id="denial-reason{{ $user['id'] }}" data-item-id="{{ $user['id'] }}" style="display: none;">
                            <label for="#" class="col-form-label">Reason for Denial</label>
                            <div>
                                <textarea class="form-control col-12" rows="5" name="reasonForDenial" placeholder="Reason for denial of order ..."></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-danger me-2 denyBtn" name="deny" value="true" data-item-id="{{ $user['id'] }}">Deny</button>
                            <button type="submit" class="btn btn-outline-primary me-2" id="finishedBtn{{ $user['id'] }}">Finished</button>
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
        function hideOptions(orderRetrieval) {
            var options = document.querySelectorAll('.payment_type');

            options.forEach(function(option) {
                if (orderRetrieval == 'delivery') {
                    if (option.classList.contains('cod')) {
                        option.style.display = 'block';
                    }
                    if (option.classList.contains('in-store')) {
                        option.style.display = 'none';
                    }
                }

                if (orderRetrieval == 'pickup') {
                    if (option.classList.contains('cod')) {
                        option.style.display = 'none';
                    }
                    if (option.classList.contains('in-store')) {
                        option.style.display = 'block';
                    }
                }
            });
        }

        function toggleServiceFee(itemId, retrievalValue) {
            var serviceFee = document.querySelector('#service-fee' + itemId);
            var serviceFeeInput = serviceFee.querySelector('input');

            if (retrievalValue == 'delivery') {

                serviceFee.style.display = 'block';

                serviceFeeInput.setAttribute('required', 'required');
            }

            if (retrievalValue == 'pickup') {

                serviceFee.style.display = 'none';

                serviceFeeInput.removeAttribute('required');
            }
        }

        var subTotalField = document.querySelectorAll('.item-sub-total');
        var totalContainer = {};

        subTotalField.forEach(function(subtotal) {
            var itemReferenceNo = subtotal.getAttribute('data-item-id');
            var [referenceNo, itemId] = itemReferenceNo.split('_');

            var price = parseFloat(document.querySelector('.item-price[data-item-id="' + itemReferenceNo + '"]').value.replace(/[^0-9.-]+/g, ""));
            var quantity = parseInt(document.querySelector('.item-quantity[data-item-id="' + itemReferenceNo + '"]').value);
            var userSubTotalField = document.querySelector('.item-sub-total[data-item-id="' + itemReferenceNo + '"]');

            var tempSubTotal = price * quantity;
            userSubTotalField.value = tempSubTotal.toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP'
            });

            if (!totalContainer[referenceNo]) {
                totalContainer[referenceNo] = tempSubTotal;
            } else {
                totalContainer[referenceNo] += tempSubTotal;
            }
        });

        var totals = document.querySelectorAll('.purchase-total');

        totals.forEach(function(total) {
            var totalId = total.getAttribute('data-total-id');
            total.value = totalContainer[totalId].toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP'
            });
        });

        var orderRetrievals = document.querySelectorAll('.order_retrieval');

        orderRetrievals.forEach(function(orderRetrieval) {

            let itemId = orderRetrieval.getAttribute('data-item-id');

            toggleServiceFee(itemId, orderRetrieval.value);
            hideOptions(orderRetrieval.value);

            orderRetrieval.addEventListener('change', function() {

                toggleServiceFee(itemId, orderRetrieval.value);
                hideOptions(orderRetrieval.value);
                // console.log(itemId);
            });
        });

        // Deny order
        var denyBtns = document.querySelectorAll('.denyBtn');

        denyBtns.forEach(function(deny) {

            deny.addEventListener('click', function() {

                var itemId = deny.getAttribute('data-item-id');
                var denialInputs = document.querySelector('#denial-reason' + itemId);
                var serviceFee = document.querySelector('#service-fee' + itemId);
                var finishedBtn = document.querySelector('#finishedBtn' + itemId);

                denialInputs.style.display = 'block';
                denialInputs.setAttribute('required', 'required');
                serviceFee.querySelector('input').removeAttribute('required');
                serviceFee.style.display = 'none';

                var reasonNotNull = denialInputs.querySelector('textarea');

                reasonNotNull.addEventListener('change', function() {
                    deny.setAttribute('type', 'submit');
                    finishedBtn.style.display = 'none';

                    if (reasonNotNull.value == '') {
                        deny.setAttribute('type', 'button');
                        finishedBtn.style.display = 'block';
                        denialInputs.removeAttribute('required');
                        denialInputs.style.display = 'none';
                    }
                })
            })
        })
    })
</script>