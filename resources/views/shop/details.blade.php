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
                <form action="{{ route('carts.store') }}" method="POST">
                    @csrf
                    <div class="product__details__text">
                        <h3>{{ $product->product_name }}</h3>
                        <div class="product__details__rating">
                            @for ($i = 1; $i <= 5; $i++) <i class="fa fa-star{{ $product->reviews->avg('rating') >= $i ? '' : '-o' }}" style="color: #696cff"></i>
                                @endfor
                                <span>({{ $product->reviews->count() }} reviews)</span>
                        </div>
                        <div class="product__details__price">₱{{ $product->price }}.00</div>
                        <p>{{ $product->description }}</p>

                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" name="items[{{ $product->id }}]" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mt-4">
                            <!-- BUY NOW button -->
                            <a href="{{ route('shop.checkout') }}" class="primary-btn mr-3" style="background-color: #696cff;">
                                <span class="fa fa-shoppin"></span> BUY NOW
                            </a>

                            <!-- Add to Cart button -->
                            <button type="submit" class="primary-btn" style="background-color: #696cff;">
                                <span class="fa fa-shopping-cart"></span> Add to Cart
                            </button>
                        </div>
                    </div>
                </form>
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
                    <h2>More Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach(App\Models\Inventory::inRandomOrder()->where('id', '!=', $product->id)->take(4)->get() as $item)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg">
                        <img src="{{ asset('storage/' . $item->product_img) }}" alt="{{ $item->product_img }}" style="width: 270px; height: 270px;">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart" style="color: #696cff;"></i></a></li>
                            <li><a href="{{ route('shop.details', ['id' => $item->id]) }}"><i class="fa fa-info-circle" style="color: #696cff;"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart" style="color: #696cff"></i></a></li>
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