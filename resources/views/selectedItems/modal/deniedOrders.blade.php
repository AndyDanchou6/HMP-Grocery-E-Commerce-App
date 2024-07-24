<!-- Modal Content -->
<div class="modal fade" id="readyMessages{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
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
                    <label for="fb_link" class="col-sm-2 col-form-label">Facebook Link</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user['fb_link'] }}" readonly>
                    </div>
                </div>

                @if(isset($user['address']))
                <div class="row mb-3">
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" readonly>{{ $user['address'] }}</textarea>
                    </div>
                </div>
                @endif

                <div>
                    <h5>Purchased Items</h5>
                </div>
                @foreach($user['items'] as $item)
                <div class="row item-row" data-item-id="{{ $item->id }}">

                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label for="item_name" class="col-12 col-sm-6 col-md-4 col-form-label">Item Name</label>
                        @if(isset($item->inventory->variant))
                        <input type="text" class="form-control" value="{{ $item->inventory->product_name }} [{{ $item->inventory->variant }}]" readonly>
                        @else
                        <input type="text" class="form-control" value="{{ $item->inventory->product_name }}" readonly>
                        @endif
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
                        <label for="order_date" class="col-form-label">Date Ordered</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($user['created_at'])->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}" readonly>
                    </div>
                </div>

                <div class="mb-3 col-12">
                    <label for="order_retrieval" class="col-form-label">Reason For Denial</label>
                    <div>
                        <textarea class="form-control col-12" rows="5" placeholder="{{ $user['reasonForDenial'] }}" readonly></textarea>
                    </div>
                </div>

                <div style="position: relative; width: 90%; margin: auto;">
                    <form action="{{ route('selected-items.update', ['referenceNo' => $user['referenceNo']]) }}" method="POST" style="position: relative; width: 100%">
                        @csrf
                        @method('POST')
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 align-items-center order-retrieval-details">
                            <div class="mb-3">
                                <label for="" class="col-form-label">Payment Type</label>
                                <div>
                                    <select class="form-select payment_type" name="payment_type" id="payment_type{{ $user['referenceNo'] }}" data-item-id="{{ $item->id }}">
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
                                    <select class="form-select order_retrieval" name="order_retrieval" data-item-id="{{ $user['id'] }}" data-user-reference="{{ $user['referenceNo'] }}">
                                        <option value="" selected disabled>Choose Order Retrieval</option>
                                        <option value="pickup" {{ $user['order_retrieval'] == 'pickup'  ? 'selected' : ''}}>Pick Up</option>
                                        <option value="delivery" {{ $user['order_retrieval'] == 'delivery'  ? 'selected' : ''}}>Delivery</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div>
                            <h4 class="text-danger m-3" style="display: none;" id="delete{{ $user['id'] }}">Are you sure you want to delete this order?</h4>
                            <h4 class="text-success m-3" style="display: none;" id="restore{{ $user['id'] }}">Are you sure you want to restore this order?</h4>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-danger me-2 deleteBtn" id="delete-btn{{ $user['id'] }}" data-item-id="{{ $user['id'] }}" name="delete" value="true">Delete</button>
                            <button type="button" class="btn btn-outline-success me-2 restoreBtn" id="restore-btn{{ $user['id'] }}" data-item-id="{{ $user['id'] }}" name="restore" value="true">Restore</button>
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


        var orderRetrievals = document.querySelectorAll('.order_retrieval');

        orderRetrievals.forEach(function(orderRetrieval) {

            let userReference = orderRetrieval.getAttribute('data-user-reference');
            var paymentTypeSelect = document.querySelector('#payment_type' + userReference);

            hideOptions(userReference, orderRetrieval.value);

            orderRetrieval.addEventListener('change', function() {

                hideOptions(userReference, orderRetrieval.value);

                paymentTypeSelect.classList.add('text-danger');
                paymentTypeSelect.classList.add('border-danger');

                paymentTypeSelect.addEventListener('change', function() {

                    paymentTypeSelect.classList.remove('text-danger');
                    paymentTypeSelect.classList.remove('border-danger');
                });
            });
        });

        var deleteClickCount = 0;
        var restoreClickCount = 0;

        var restoreBtns = document.querySelectorAll('.restoreBtn');

        restoreBtns.forEach(function(restoreBtn) {

            restoreBtn.addEventListener('click', function() {

                var itemId = restoreBtn.getAttribute('data-item-id');
                var restoreWarning = document.querySelector('#restore' + itemId);
                var deleteWarning = document.querySelector('#delete' + itemId);
                var deleteBtn = document.querySelector('#delete-btn' + itemId);

                deleteBtn.setAttribute('type', 'button');
                restoreWarning.style.display = 'block';
                deleteWarning.style.display = 'none';

                restoreClickCount++;
                deleteClickCount = 0;

                if (restoreClickCount > 1) {
                    restoreBtn.setAttribute('type', 'submit');
                }
            })
        })

        var deleteBtns = document.querySelectorAll('.deleteBtn');

        deleteBtns.forEach(function(deleteBtn) {

            deleteBtn.addEventListener('click', function() {

                var itemId = deleteBtn.getAttribute('data-item-id')
                var restoreWarning = document.querySelector('#restore' + itemId);
                var deleteWarning = document.querySelector('#delete' + itemId);
                var restoreBtn = document.querySelector('#restore-btn' + itemId);

                restoreBtn.setAttribute('type', 'button');
                deleteWarning.style.display = 'block';
                restoreWarning.style.display = 'none';

                restoreClickCount = 0;
                deleteClickCount++;

                if (deleteClickCount > 1) {
                    deleteBtn.setAttribute('type', 'submit');
                }
            })
        })

    })
</script>