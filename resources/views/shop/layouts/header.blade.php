<div class="header__top">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="header__top__left">
                    <ul>
                        <li><i class="fa fa-envelope"></i>Hello! {{ Auth::user()->name }}</li>
                        <li>Welcome to e-Mart </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="header__top__right">
                    <div class="header__top__right__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                        <a href="#"><i class="fa fa-pinterest-p"></i></a>
                    </div>
                    @if(Auth::user()->role == 'Admin')
                    <div class="header__top__right__auth">
                        <a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </div>
                    @elseif(Auth::user()->role == 'Customer')
                    <div class="header__top__right__auth">
                        <a href="{{ route('customer.home') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </div>
                    @endif
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
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>

        <div class="col-lg-3">
            <div class="header__cart">
                <ul>
                    <li><a href="{{ route('selectedItems.orders') }}"><i class="fa fa-list"></i> <span style="background-color: #696cff;"></span></a></li>
                    <li><a href="{{ route('shop.carts') }}"><i class="fa fa-shopping-cart"></i> <span style="background-color: #696cff;"></span></a></li>
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