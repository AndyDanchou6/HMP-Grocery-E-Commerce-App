@extends('shop.layouts.layout')

@section('content')

<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="{{ route('shop.placeOrder') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="checkout__input">
                            <p>Full name<span></span></p>
                            <input type="text" name="name" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="checkout__input">
                            <p>Address<span></span></p>
                            <textarea name="address" id="address" class="form-control" readonly>{{ $user->address }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span></span></p>
                                    <input type="text" name="phone" value="{{ $user->phone }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span></span></p>
                                    <input type="text" name="email" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Fb Link<span></span></p>
                            <textarea name="fb_link" id="fb_link" class="form-control" readonly>{{ $user->fb_link }}</textarea>
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
                            <!-- <div class="checkout__order__subtotal">Subtotal <span>₱{{ number_format($subtotal, 2) }}</span></div>   -->
                            <div class="checkout__order__total">Total <span>₱{{ number_format($total, 2) }}</span></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn" style="background-color: #696cff;">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<style>
    .checkout__order__products {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .checkout__order__products th,
    .checkout__order__products td {
        border: 1px solid #ddd;
        padding: 7px;
    }

    .checkout__order__products th {
        background-color: #f2f2f2;
        text-align: left;
    }

    .checkout__order__products td {
        font-weight: normal;
    }
</style>
@endsection