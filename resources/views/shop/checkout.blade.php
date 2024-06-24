@extends('shop.layouts.layout')

@section('content')

<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Delivery Details</h4>
            <form action="{{ route('shop.placeOrder') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="checkout__input">
                            <p>Address<span></span></p>
                            <textarea name="address" id="address" class="form-control" required></textarea>
                        </div>
                        <div class="checkout__input">
                            <p>Phone<span></span></p>
                            <input type="text" name="phone" requiredx>
                        </div>
                        <div class="checkout__input">
                            <p>Fb Link<span></span></p>
                            <textarea name="fb_link" id="fb_link" class="form-control" required></textarea>
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
                            @if($item->order_retrieval == 'delivery')
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Cash on delivery(COD)
                                    <input type="checkbox" name="payment_type" id="payment" value="COD">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    G-cash
                                    <input type="checkbox" name="payment_type" id="paypal" value="G-cash">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @else
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    G-cash
                                    <input type="checkbox" name="payment_type" id="payment" value="G-cash">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    In-store
                                    <input type="checkbox" name="payment_type" id="paypal" value="In-store">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @endif
                            <button type="submit" class="site-btn" style="background-color: #696cff;">PLACE ORDER</button>
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
@endsection