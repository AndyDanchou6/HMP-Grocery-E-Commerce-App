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
                        <input type="text" class="form-control" value="{{ $item->product_name }}" readonly>
                    </div>

                    <div class="col-6 col-sm-3 col-md-2 mb-3">
                        <label for="item_price" class="col-6 col-sm-3 col-md-2 col-form-label">Item Price</label>
                        <input type="text" class="form-control item-price" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="₱{{ number_format($item->price, 2) }}" readonly>
                    </div>

                    <div class="col-6 col-sm-3 col-md-3 mb-3">
                        <label for="quantity" class="col-6 col-sm-3 col-md-3 col-form-label">Quantity</label>
                        <input type="number" class="form-control item-quantity" data-item-id="{{ $user['referenceNo'].'_'.$item->id }}" value="{{ $user['quantity'] }}" readonly>
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
                                <input type="text" class="form-control" value="{{ $user['payment_type'] }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Payment Status</label>
                                @if($item->payment_condition == NULL)
                                <select name="payment_condition" id="payment_condition" class="form-select">
                                    <option value="" selected disabled>Choose Payment Type</option>
                                    <option value="paid" {{ $user['payment_condition'] == 'paid' ? 'selected' : ''}}>Paid</option>
                                    <option value="" {{ $user['payment_condition'] == '' ? 'selected' : ''}}>Unpaid</option>
                                </select>
                                @else
                                <input type="text" class="form-control" value="{{ $item->payment_condition }}" id="payment_condition" name="payment_condition" readonly>
                                @endif
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        //     function hideOptions(orderRetrieval) {
        //         var options = document.querySelectorAll('.payment_type');

        //         options.forEach(function(option) {
        //             if (orderRetrieval == 'delivery') {
        //                 if (option.classList.contains('instore')) {
        //                     option.style.display = 'none';
        //                 }
        //                 if (option.classList.contains('cod')) {
        //                     option.style.display = 'block';
        //                 }
        //             } else if (orderRetrieval == 'pickup') {
        //                 if (option.classList.contains('cod')) {
        //                     option.style.display = 'none';
        //                 }
        //                 if (option.classList.contains('instore')) {
        //                     option.style.display = 'block';
        //                 }
        //             }
        //         });
        //     }

        //     function toggleReceiptSubmission(itemId, retrieval) {
        //         var proofForm = document.querySelector('#proof-of-delivery' + itemId);

        //         if (proofForm) {
        //             if (retrieval == 'delivery') {
        //                 proofForm.style.display = 'block';
        //                 // proofForm.querySelector('input[type="file"]').setAttribute('required', 'required');
        //             } else {
        //                 proofForm.style.display = 'none';
        //                 // proofForm.querySelector('input[type="file"]').removeAttribute('required')
        //             }
        //         }
        //     }

        //     function toggleDeliveryOptions(itemId, retrieval) {
        //         let courierOptions = document.querySelector('#courier' + itemId);
        //         let deliveryOptions = document.querySelector('#delivery' + itemId);

        //         if (retrieval == 'delivery') {
        //             courierOptions.style.display = 'block';
        //             deliveryOptions.style.display = 'block';
        //         } else if (retrieval == 'pickup') {
        //             courierOptions.style.display = 'none';
        //             deliveryOptions.style.display = 'none';
        //         }
        //     }


        //     // Hide delivery options if retrieval is pickup

        //     var orderRetrievals = document.querySelectorAll('.order_retrieval');
        //     var orderRetrievalValue = '';

        //     orderRetrievals.forEach(function(orderRetrieval) {

        //         let itemId = orderRetrieval.getAttribute('data-item-id');

        //         // orderRetrievalValue = orderRetrieval.value;
        //         hideOptions(orderRetrieval.value);
        //         toggleReceiptSubmission(itemId, orderRetrieval.value);

        //         // console.log(itemId);

        //         toggleDeliveryOptions(itemId, orderRetrieval.value);

        //         orderRetrieval.addEventListener('change', function() {

        //             // orderRetrievalValue = orderRetrieval.value;
        //             hideOptions(orderRetrieval.value);
        //             toggleDeliveryOptions(itemId, orderRetrieval.value);
        //             toggleReceiptSubmission(itemId, orderRetrieval.value);

        //         });
        //     });


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
    });
</script>
