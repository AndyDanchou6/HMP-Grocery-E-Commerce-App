<div class="header__top">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="header__top__left">
                    <ul>
                        <li><i class="fa fa-user"></i>Hello! {{ Auth::user()->name }}</li>
                        <li>Welcome to e-Mart </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="header__top__right">
                    <div class="header__top__right__social">
                        @foreach (['fb_link' => 'fa-facebook', 'instagram_link' => 'fa-instagram', 'twitter_link' => 'fa-twitter', 'youtube_link' => 'fa-youtube'] as $key => $iconClass)
                        @if(!empty($settings[$key]))
                        <a href="{{ $settings[$key] }}"><i class="fa {{ $iconClass }}"></i></a>
                        @else
                        <a onclick="MAINTENANCE()"><i class="fa {{ $iconClass }}"></i></a>
                        @endif
                        @endforeach
                    </div>
                    @if(Auth::user()->role == 'Admin')
                    <div class="header__top__right__auth" style="margin-right: 10px;">
                        <a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </div>
                    @elseif(Auth::user()->role == 'Customer')
                    <div class="header__top__right__auth" style="margin-right: 10px;">
                        <a href="{{ route('customer.home') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </div>
                    @endif
                    <div class="header__top__right__auth">
                        <a data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fa fa-sign-out"></i>Logout</a>
                        @include('shop.layouts.logoutModal')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="header__logo">
                <a href="{{ route('shop.index') }}"><img src="{{ asset('index/img/e.png') }}" alt="way logo"></a>
            </div>
        </div>
        <div class="col-lg-6">
            <nav class="header__menu">
                <ul>
                    <li class="">
                        <a href="{{ route('shop.index') }}">Home</a>
                    </li>
                    <li class="">
                        <a href="{{ route('shop.products') }}">Shop</a>
                    </li>
                    <li class="">
                        <a href="#">Pages</a>
                        <ul class="header__menu__dropdown">
                            <!-- <li><a href="shop-details.html">Shop Details</a></li> -->
                            <li><a href="{{ route('shop.carts') }}">Shopping Cart</a></li>
                            <!-- <li><a href="checkout.html">Checkout</a></li> -->
                            <!-- <li><a href="blog-details.html">Blog Details</a></li> -->
                        </ul>
                    </li>
                    <li><a href="{{ route('shop.contacts') }}">Contact</a></li>
                    <li><a onclick="ERROR()">Blog</a></li>
                </ul>
            </nav>
        </div>

        <div class="col-lg-3">
            <div class="header__cart">
                <ul>
                    <li data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='fa fa-cube'></i><span> Pending Orders</span>">
                        <a href="{{ route('customers.pending_orders') }}">
                            <i class="fa fa-cube col-4"></i>
                            <span style="background-color: #696cff;" id="forPendingOrdersCount" class="d-none"></span>
                        </a>
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='fa fa-cart-plus'></i><span> Carts</span>">
                        <a href="{{ route('shop.carts') }}">
                            <i class="fa fa-cart-plus"></i>
                            <span style="background-color: #696cff;" id="cartsCounting" class="d-none"></span>
                        </a>
                    </li>
                </ul>
                <!-----item------>
                <div class=" header__cart__price"><span></span>
                </div>
            </div>
        </div>
    </div>
    <div class="humberger__open">
        <i class="fa fa-bars"></i>
    </div>
</div>