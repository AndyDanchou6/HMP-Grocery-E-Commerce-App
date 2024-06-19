@extends('shop.layouts.layout')

@section('content')

<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="#">
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
                        <!-- <div class="checkout__input__checkbox">
                            <label for="acc">
                                Create an account?
                                <input type="checkbox" id="acc">
                                <span class="checkmark"></span>
                            </label>
                        </div> -->
                        <!-- <p>Create an account by entering the information below. If you are a returning customer
                            please login at the top of the page</p> -->
                        <!-- <div class="checkout__input">
                            <p>Account Password<span></span></p>
                            <input type="text" name="password">
                        </div> -->
                        <!-- <div class="checkout__input">
                            <p>Order notes<span>*</span></p>
                            <input type="text" placeholder="Notes about your order, e.g. special notes for delivery.">
                        </div> -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                @foreach($selectedItems as $item)
                                <li>{{ $item->inventory->product_name }} <span>₱{{ number_format($item->inventory->price, 2) }}</span></li>
                                @endforeach
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>$750.99</span></div>
                            <div class="checkout__order__total">Total <span>$750.99</span></div>
                            <!-- <div class="checkout__input__checkbox"> -->
                            <!-- <label for="acc-or">
                                    Create an account?
                                    <input type="checkbox" id="acc-or">
                                    <span class="checkmark"></span>
                                </label> -->
                            <!-- </div> -->
                            <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua.</p>
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

@endsection