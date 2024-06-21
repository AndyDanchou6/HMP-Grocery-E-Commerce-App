@extends('shop.layouts.layout')

@section('content')

<section class="breadcrumb-section set-bg" data-setbg="{{ asset('index/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>e-Mart Grocery</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('shop.index') }}">Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hero Section End -->
<div class="section-title" style="margin-top: 20px;">
    <h2>Categories</h2>
</div>
<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                @foreach($category as $item)
                <div class="col-lg-3">
                    <div class="categories__item {{ 'background-color-' . $loop->iteration }} text-center d-flex flex-column align-items-center">
                        <img src="{{ asset('storage/' . $item->category_img) }}" alt="{{ $item->category_name }}" style="width: 270px; height: 270px;">
                        <h5 class="mt-3"><a href="{{ route('shop.products', ['category' => $item->id]) }}" data-category-id="{{ $item->id }}">{{ $item->category_name }}</a></h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Product</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="category-filter-btn active" data-filter="*" data-filter-id="all">All</li>
                        @foreach(App\Models\Category::inRandomOrder()->limit(4)->get() as $cat)
                        <li class="category-filter-btn" data-filter=".{{ $cat->slug }}" data-filter-id="{{ $cat->id }}">{{ $cat->category_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter" id="featuredFilter">
            @foreach(App\Models\Inventory::inRandomOrder()->take(8)->get() as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mix-categories {{ $item->category->slug }}" data-category-id="{{ $item->category_id }}" data-filter=".{{ $item->category->slug }}">
                <div class="featured__item product_onDisplay" data-item-id="{{ $item->id }}" data-price="{{ $item->price }}">
                    <div class="featured__item__pic set-bg d-flex justify-content-center align-items-center">
                        <img src="{{ asset('storage/' . $item->product_img) }}" alt="{{ $item->product_name }}" style="width: 270px; height: 270px;">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart" style="color: #696cff;"></i></a></li>
                            <li><a href="{{ route('shop.details', ['id' => $item->id]) }}"><i class="fa fa-info-circle" style="color: #696cff;"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart" style="color: #696cff;"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text text-center mt-3">
                        <h6><a href="#">{{ $item->product_name }}</a></h6>
                        <h5>₱{{ number_format($item->price, 2) }}</h5>
                        <h6 style="margin-top: 9px;">{{ $item->category->category_name }}</h6>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Latest Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        @php
                        $chunkedProducts = $inventory->chunk(3);
                        @endphp
                        @foreach ($chunkedProducts as $chunk)
                        <div class="latest-prdouct__slider__item">
                            @foreach ($chunk as $product)
                            <a href="{{ route('shop.details', ['id' => $product->id]) }}" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="{{ asset('storage/' . $product->product_img) }}" alt="{{ $product->product_name }}" style="width: 110px; height: 110px;">
                                </div>
                                <div class=" latest-product__item__text">
                                    <h6>{{ $product->product_name }}</h6>
                                    <span>₱{{ number_format($item->price, 2) }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Top Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-1.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-3.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-1.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-3.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Top Rated Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        @foreach ($inventory->chunk(3) as $chunk)
                        <div class="latest-prdouct__slider__item">
                            @foreach ($chunk as $product)
                            <a href="{{ route('shop.details', ['id' => $product->id]) }}" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="{{ asset('storage/' . $product->product_img) }}" alt="{{ $product->product_name }}" style="width: 110px; height: 110px;">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>{{ $product->product_name }}</h6>
                                    <span>₱{{ number_format($item->price, 2) }}</span>
                                    <div style="color: #696cff;">Rating: {{ $product->reviews->avg('rating') ?: 'N/A' }}</div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Latest Product Section End -->

<!-- Blog Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="index/img/blog/blog-1.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">Cooking tips make cooking simple</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="index/img/blog/blog-2.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="index/img/blog/blog-3.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">Visit the clean farm in the US</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

@include('shop.floatingTotal')

@endsection