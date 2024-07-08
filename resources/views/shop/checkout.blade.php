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
                        @if($orderType != 'pickup')
                        <div class="checkout__input">
                            <p>Address<span></span></p>
                            <textarea name="address" id="address" class="form-control" required></textarea>
                        </div>
                        @endif
                        <div class="checkout__input">
                            <p>Phone<span></span></p>
                            <input type="text" name="phone" required>
                        </div>
                        <div class="checkout__input">
                            <p>Fb Link<span></span></p>
                            <textarea name="fb_link" id="fb_link" class="form-control" required></textarea>
                        </div>
                        <div class="reminder-box d-none" id="gcash_reminder" style="background-color: #f8f9fa; padding: 15px; border: 1px solid #ced4da; margin-top: 50px; margin-bottom: 20px;">
                            <label>For Gcash</label>
                            <p style="margin: auto 0;">Send your payment in this number <strong style="color: #696cff; font-size: 24px;">+{{ $phone->phone }}</strong></p>
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

    })
</script>
@endsection