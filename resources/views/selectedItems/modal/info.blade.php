<div class="modal fade" id="messages{{ $referenceNo }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-wrap" id="categoryTitle">{{ $user['name'] }}'s purchases</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach($user['items'] as $item)
                <div class="row mb-3 item-row" data-item-id="{{ $item->id }}">

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
                <div class="modal-footer">
                    <div class="row row-cols-1 row-cols-md-2 align-items-center mb-3">
                        <div class="mb-3">
                            <label for="total" class="col-form-label">Total</label>
                            <input type="text" name="total" class="form-control purchase-total" data-total-id="{{ $user['referenceNo'] }}" value="₱{{ number_format(collect($user['items'])->sum(fn($item) => $item->quantity * $item->price), 2) }}" readonly>
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
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}" readonly>
                        </div>
                    </div>
                    @if($user['order_retrieval'] == 'delivery')
                    <div class="row align-items-center mb-3">

                        @if($user['delivery_date'])
                        <div class="col-md-6">
                            <label for="" class="col-form-label">Delivery Schedule:</label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($user['delivery_date'])->format('l, F j, Y g:i A') }}" readonly>
                        </div>
                        @else
                        <div class="col-md-6">
                            <label for="" class="col-form-label">Delivery Schedule:</label>
                            <input type="text" class="form-control" value="Not Schedule Yet" readonly>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <label for="" class="col-form-label">Courier Name:</label>
                            <input type="text" class="form-control" value="{{ $user['courier_id'] }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="col-form-label">Payment Type:</label>
                            <input type="text" class="form-control" value="{{ $user['payment_type'] }}" readonly>
                        </div>
                        @if($item->serviceFee != null)
                        <div class="col-md-6">
                            <label for="" class="col-form-label">Service Fee:</label>
                            <input type="text" class="form-control" id="service_fee{{ $user['referenceNo'] }}" value="{{ $item->serviceFee->fee }}" readonly>
                        </div>
                        @endif
                        @if($user['order_retrieval'] == 'delivery')
                        <div class="mb-3 total-with-fee">
                            <label for="" class="col-form-label">Total w/ Fee</label>
                            <input type="text" class="form-control text-danger" step="0.01" id="total-with-fee{{ $user['referenceNo'] }}" min="0.01" placeholder="0.00" value="0.00" readonly>
                        </div>
                        @endif
                    </div>
                    @elseif($user['order_retrieval'] == 'pickup')
                    <div class="row mb-3 p-0">
                        <div class="col-sm-3">
                            <label for="payment_type" class="col-form-label" style="margin-right: 40px;">Payment Type:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $user['payment_type'] }}" readonly>
                        </div>
                    </div>
                    @endif

                    @if($user['status'] == 'denied')
                    <div class="container">
                        <div class="mb-3 col-12">
                            <label for="order_retrieval" class="col-form-label">Reason For Denial</label>
                            <div>
                                <textarea class="form-control text-danger col-12" rows="5" readonly>{{ $user['reasonForDenial'] }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="container">
                        <div class="mb-3 col-12">
                            <h3 class="text-danger text-wrap d-none cancel-warning" data-user-ref="{{ $user['referenceNo'] }}">This is not reversible. Are you sure you want to cancel this order?</h3>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end flex-wrap">
                    @if($user['status'] == "forPackage" && Auth::user()->role == 'Customer')
                    <form action="{{ route('customer.cancelOrder', $user['referenceNo']) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger mx-1 mb-2 cancel-order" data-user-ref="{{ $user['referenceNo'] }}">Cancel Order</button>
                        <button type="button" class="btn btn-outline-success mx-1 mb-2 d-none keep-order" data-user-ref="{{ $user['referenceNo'] }}">Keep Order</button>
                    </form>
                    @endif
                    <button type="button" class="btn btn-outline-secondary mx-1 mb-2 close-modal" data-bs-dismiss="modal" data-user-ref="{{ $user['referenceNo'] }}">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var subTotalFields = document.querySelectorAll('.item-sub-total');
        var totalContainer = {};

        subTotalFields.forEach(function(subtotalField) {
            var itemReferenceNo = subtotalField.getAttribute('data-item-id');
            var [referenceNo] = itemReferenceNo.split('_');

            var price = parseFloat(document.querySelector('.item-price[data-item-id="' + itemReferenceNo + '"]').value.replace(/[^0-9.-]+/g, ""));
            var quantity = parseInt(document.querySelector('.item-quantity[data-item-id="' + itemReferenceNo + '"]').value);
            var tempSubTotal = price * quantity;

            subtotalField.value = tempSubTotal.toLocaleString('en-PH', {
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

        totals.forEach(function(totalField) {
            var totalId = totalField.getAttribute('data-total-id');
            var totalValue = totalContainer[totalId] || 0;

            totalField.value = totalValue.toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP'
            });

            var serviceFeeElement = document.querySelector('#service_fee' + totalId);
            var totalWithFeeField = document.querySelector('#total-with-fee' + totalId);

            var serviceFee = 0;
            if (serviceFeeElement) {
                serviceFee = parseFloat(serviceFeeElement.value.replace(/[^0-9.-]+/g, "")) || 0;
            }

            if (totalWithFeeField) {
                var totalWithFee = totalValue + serviceFee;

                totalWithFeeField.value = totalWithFee.toLocaleString('en-PH', {
                    style: 'currency',
                    currency: 'PHP'
                });
            }
        });

        var cancelOrderBtn = document.querySelectorAll('.cancel-order');

        cancelOrderBtn.forEach(function(cancelBtn) {

            var btnIdentifier = cancelBtn.getAttribute('data-user-ref');
            var closeModalBtn = document.querySelector('.close-modal[data-user-ref="' + btnIdentifier + '"]');
            var keepOrderBtn = document.querySelector('.keep-order[data-user-ref="' + btnIdentifier + '"]');
            var warningMessage = document.querySelector('.cancel-warning[data-user-ref="' + btnIdentifier + '"]');

            var clickedCancelOrder = false;

            cancelBtn.addEventListener('click', function() {

                closeModalBtn.classList.add('d-none');
                keepOrderBtn.classList.remove('d-none');
                cancelBtn.textContent = 'Proceed';
                warningMessage.classList.remove('d-none');

                if (clickedCancelOrder) {

                    cancelBtn.setAttribute('type', 'submit');
                }

                clickedCancelOrder = true;
            })

            keepOrderBtn.addEventListener('click', function() {
                if (clickedCancelOrder) {

                    cancelBtn.setAttribute('type', 'button');
                    closeModalBtn.classList.remove('d-none');
                    keepOrderBtn.classList.add('d-none');
                    cancelBtn.textContent = 'Cancel Order';
                    warningMessage.classList.add('d-none');
                    clickedCancelOrder = false;

                }
            })
        })
    });
</script>