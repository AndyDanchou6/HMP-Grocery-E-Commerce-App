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
            <!-- Product Image Section -->
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large" src="{{ asset('storage/' . $product->product_img) }}" style="width: 510px; height: 510px;" alt="{{ $product->product_name }}">
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-lg-6 col-md-6">
                <form action="{{ route('carts.store') }}" method="POST">
                @csrf
                <div class="product__details__text">
                    <h3 id="product_id">{{ $product->product_name }}</h3>
                    <div class="product__details__rating">
                        @for ($i = 1; $i <= 5; $i++) <i class="fa fa-star{{ $product->reviews->avg('rating') >= $i ? '' : '-o' }}"></i>
                            @endfor
                            <span>({{ $product->reviews->count() }} reviews)</span>
                    </div>
                    <div class="product__details__price">₱{{ number_format($product->price, 2) }}</div>
                    <p>{{ $product->description }}</p>

                   <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" name="items[{{ $product->id }}]" value="1" id="quantity">
                                </div>
                            </div>
                        </div>

                    <div class="d-flex justify-content-start align-items-center mt-4">

                        <!-- Add to Cart button -->
                        <button type="submit" name="action" value="add_to_cart" class="primary-btn mr-3" style="background-color: #696cff;">
                            <span class="fa fa-shopping-cart"></span> Add to Cart
                        </button>
                        </form>                       
                    </div>
                    <ul>
                        <li>
                            @if($product->quantity > 0)
                            <div class="availability-badge">
                                <b>Availability</b> <span class="badge bg-success text-light">In - Stock</span>
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

            <!-- Product Details Tabs -->
            <div class="col-lg-12 mt-5">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Reviews <span>({{ $product->reviews->count() }})</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Information</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Reviews</h6>
                                @foreach($reviews as $review)
                                <div class="review">
                                    <div class="review__author">
                                        {{ optional($review->users)->name ?? 'Anonymous' }} <small>{{ $review->created_at->format('F j, Y, g:i a') }}</small>
                                    </div>
                                    <div class="review__rating">
                                        @for ($i = 1; $i <= 5; $i++) <i class="fa fa-star{{ $review->rating >= $i ? '' : '-o' }}" style="color: #696cff"></i>
                                            @endfor
                                    </div>
                                    <div class="review__text">{{ $review->comment }}</div>
                                </div>
                                <hr>
                                @endforeach

                                <!-- Pagination links -->
                                <div class="pagination-links">
                                    {{ $reviews->links() }}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Description</h6>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Product Information</h6>
                                <p>{{ $product->information }}</p>
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
                    <h2>More Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach(App\Models\Inventory::inRandomOrder()->where('id', '!=', $product->id)->take(4)->get() as $item)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg text-center">
                        <img src="{{ asset('storage/' . $item->product_img) }}" alt="{{ $item->product_img }}" style="width: 270px; height: 270px;">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart" style="color: #696cff;"></i></a></li>
                            <li><a href="{{ route('shop.details', ['id' => $item->id]) }}"><i class="fa fa-info-circle" style="color: #696cff;"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart" style="color: #696cff"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">{{ $item->product_name }}</a></h6>
                        <h5>₱{{ number_format($item->price, 2) }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Related Product Section End -->
@endsection