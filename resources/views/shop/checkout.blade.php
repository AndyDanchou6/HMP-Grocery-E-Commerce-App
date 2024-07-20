@extends('shop.layouts.layout')

@section('content')
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            @if($orderType == 'delivery')
            <h4>Delivery Details</h4>
            @else
            <h4>Order Details</h4>
            @endif
            <form action="{{ route('shop.placeOrder') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">

                        @if($orderType == 'delivery')
                        <div class="checkout__input">
                            <p>Delivery Address<span></span></p>
                            <div class="dropOffPoint">
                                <select class="w-100 mb-3" name="service_fee_id" id="dropOffPoint" required>
                                    @if($serviceFee->count() > 0)
                                    <option disabled selected>Choose Drop-Off Location ---</option>
                                    @foreach($serviceFee as $dropOff)
                                    <option value="{{ $dropOff->id }}" data-fee="{{ $dropOff->fee }}">{{ $dropOff->location }} --- ₱{{ $dropOff->fee }}</option>
                                    @endforeach
                                    @else
                                    <option value="null">No drop-off point assigned</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="checkout__input">
                            <p>Phone Number<span></span></p>
                            <input type="text" name="phone" required>
                        </div>
                        <div class="checkout__input">
                            <p>Facebook Name/Link<span></span></p>
                            <textarea name="fb_link" id="fb_link" class="form-control" placeholder="Optional"></textarea>
                        </div>

                        <div class="reminder-box d-none" id="gcash_reminder" style="background-color: #f8f9fa; padding: 15px; border: 1px solid #ced4da; margin-bottom: 20px;">
                            <label>GCash Payment Reminder</label>
                            <p style="margin: auto 0;">Please remit your payment to <strong style="color: #696cff; font-size: 20px;">{{ $phone->phone }}</strong> using GCash. Include your <strong style="color: #696cff; font-size: 20px;">order reference number</strong> in the message. Thank you!</p>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <table class="checkout__order__products">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selectedItems as $item)
                                    <tr>
                                        <td>{{ $item->inventory->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₱{{ number_format($item->inventory->price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="checkout__order__subtotal">Subtotal <span>₱{{ number_format($subtotal, 2) }}</span></div>
                            <div class="checkout__order__subtotal" id="checkoutDeliveryFee">Delivery Fee <span>₱0.00</span></div>
                            <div class="checkout__order__total">Total <span>₱{{ number_format($total, 2) }}</span></div>
                            <p>Choose your payment</p>
                            @if($selectedItems->first()->order_retrieval == 'delivery')
                            <div class="checkout__input__radio">
                                <input type="radio" name="payment_type" id="payment_gcash" value="G-cash" required>
                                <span class="checkmark"></span>
                                <label for="payment_gcash">
                                    G-cash
                                </label>
                            </div>
                            <div class="checkout__input__radio">
                                <input type="radio" name="payment_type" id="payment_cod" value="COD" required>
                                <span class="checkmark"></span>
                                <label for="payment_cod">
                                    Cash on delivery (COD)
                                </label>
                            </div>
                            @else
                            <div class="checkout__input__radio">
                                <input type="radio" name="payment_type" id="payment_gcash" value="G-cash" required>
                                <span class="checkmark"></span>
                                <label for="payment_gcash">
                                    G-cash
                                </label>
                            </div>
                            <div class="checkout__input__radio">
                                <input type="radio" name="payment_type" id="payment_instore" value="In-store" required>
                                <span class="checkmark"></span>
                                <label for="payment_instore">
                                    In-store
                                </label>
                            </div>
                            @endif
                            <button type="submit" class="site-btn placeOrderBtn" style="background-color: #696cff;">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('shop.cancelCheckout') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="site-btn" style="background-color: #ff6961;">CANCEL CHECKOUT</button>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const placeOrderBtn = document.querySelector('.placeOrderBtn');

        placeOrderBtn.addEventListener('click', function(event) {
            var sessionStoredItems2 = sessionStorage.getItem('selectedItems');
            if (sessionStoredItems2) {
                sessionStorage.removeItem('selectedItems');
            }
        });

        const gcashPopup = document.getElementById('payment_gcash');
        const storePopup = document.getElementById('payment_instore');
        const paymentPopup = document.getElementById('payment_cod');
        const gcashReminder = document.getElementById('gcash_reminder');

        if (gcashPopup) {
            gcashPopup.addEventListener('click', function(event) {
                gcashReminder.classList.remove('d-none');
            });
        }

        if (storePopup) {
            storePopup.addEventListener('click', function(event) {
                gcashReminder.classList.add('d-none');
            });
        }

        if (paymentPopup) {
            paymentPopup.addEventListener('click', function(event) {
                gcashReminder.classList.add('d-none');
            });
        }

        var options = document.querySelectorAll('.option');
        var checkout__order__total = document.querySelector('.checkout__order__total');
        var total = checkout__order__total.querySelector('span');
        var totalValue = total.textContent;
        var indexOfPeso = totalValue.indexOf('₱');
        var stringTotalValue = totalValue.substring(indexOfPeso + 1).trim();
        var floatTotalValue = parseFloat(stringTotalValue);
        var totalBeforeFee = floatTotalValue;

        var checkout__order__fee = document.querySelector('#checkoutDeliveryFee');
        var feeField = checkout__order__fee.querySelector('span');

        options.forEach(function(selected) {
            selected.addEventListener('click', function() {

                var index = selected.textContent.indexOf('₱');
                var stringFeeValue = selected.textContent.substring(index + 1).trim();

                if (parseFloat(stringFeeValue)) {

                    var floatFeeValue = parseFloat(stringFeeValue);
                    var newTotalValue = floatFeeValue + totalBeforeFee;

                    total.textContent = '₱' + newTotalValue.toFixed(2);
                    feeField.textContent = '₱' + floatFeeValue.toFixed(2);
                }
            })
        })

    })
</script>
@endsection