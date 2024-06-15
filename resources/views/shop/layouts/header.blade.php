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
                    @if (Route::has('login'))
                    @auth
                    <div class="header__top__right__auth">
                        <a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </div>
                    @else
                    <div class="header__top__right__auth">
                        <a href="#"><i class="fa fa-user"></i>Login</a>
                    </div>
                    @endauth
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
                <a href="./index.html"><img src="img/logo.png" alt=""></a>
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
                    <li>
                        <a href="#">Pages</a>
                        <ul class="header__menu__dropdown">
                            <li><a href="shop-details.html">Shop Details</a></li>
                            <li><a href="shopping-cart.html">Shopping Cart</a></li>
                            <li><a href="checkout.html">Checkout</a></li>
                            <li><a href="blog-details.html">Blog Details</a></li>
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
                    <li><a href="#"><i class="fa fa-heart"></i> <span style="background-color: #696cff;">1</span></a></li>
                    <li><a href=" #"><i class="fa fa-shopping-bag"></i> <span style="background-color: #696cff;">3</span></a></li>
                </ul>
                <div class=" header__cart__price">item: <span>$150.00</span>
                </div>
            </div>
        </div>
    </div>
    <div class="humberger__open">
        <i class="fa fa-bars"></i>
    </div>
</div>