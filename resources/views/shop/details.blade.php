@extends('shop.layouts.layout')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('index/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>e-Mart Grocery</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('shop.index') }}">Home</a>
                        <a href="{{ route('shop.products') }}">Shop</a>
                        <span>Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large" src="{{ asset('storage/' . $product->product_img) }}" style="width: 100px; height: 580px;" alt="">
                    </div>
                    <div class="product__details__pic__slider owl-carousel">
                        <img data-imgbigurl="index/img/product/details/product-details-2.jpg" src="index/img/product/details/thumb-1.jpg" alt="">
                        <img data-imgbigurl="index/img/product/details/product-details-3.jpg" src="index/img/product/details/thumb-2.jpg" alt="">
                        <img data-imgbigurl="index/img/product/details/product-details-5.jpg" src="index/img/product/details/thumb-3.jpg" alt="">
                        <img data-imgbigurl="index/img/product/details/product-details-4.jpg" src="index/img/product/details/thumb-4.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>{{ $product->product_name }}</h3>
                    <div class="product__details__rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <span>(18 reviews)</span>
                    </div>
                    <div class="product__details__price">₱{{ $product->price }}.00</div>
                    <p>{{ $product->description }} </p>
                    <div class="product__details__quantity">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="text" value="1">
                            </div>
                        </div>
                    </div>
                    <a href="" class="primary-btn" onclick="maintenance()">ADD TO CART</a>
                    <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                    <ul>
                        <li>
                            @if($product->quantity > 0)
                            <div class="availability-badge">
                                <b>Availability</b> <span class="badge bg-success text-light">In - Stock</span>
                            </div>
                            @else
                            <div class="availability-badge">
                                <b>Availability</b> <span class="badge bg-danger text-light">Unavailable</span>
                            </div>
                            @endif
                        </li>
                        <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                        <li><b>Share on</b>
                            <div class="share" onclick="maintenance()">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Description</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews <span>(1)</span></a>
                        </li> -->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>
                                    {{ $product->information }}
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Description</h6>
                                <p>
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>More Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach(App\Models\Inventory::inRandomOrder()->where('id', '!=', $product->id)->take(8)->get() as $item)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg">
                        <img src="{{ asset('storage/' . $item->product_img) }}" alt="{{ $item->product_img }}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="{{ route('shop.details', ['id' => $item->id]) }}"><i class="fa fa-info-circle"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">{{ $item->product_name }}</a></h6>
                        <h5>₱{{ $item->price }}.00</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Related Product Section End -->
@endsection