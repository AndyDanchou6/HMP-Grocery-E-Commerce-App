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
                        <a href="{{ route('shop.products', ['category' => $item->id]) }}" data-category-id="{{ $item->id }}"><img src="{{ asset('storage/' . $item->category_img) }}" alt="{{ $item->category_name }}" style="width: 270px; height: 270px;"></a>
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
            @foreach(App\Models\Inventory::inRandomOrder()->take(20)->get() as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mix-categories {{ $item->category->slug }}" data-category-id="{{ $item->category_id }}" data-filter=".{{ $item->category->slug }}">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg d-flex justify-content-center align-items-center product_onDisplay" data-item-id="{{ $item->id }}" data-price="{{ $item->price }}" data-quantity="{{ $item->quantity }}">
                        <p class="rounded p-2 text-light bg-success onCartBanner" style="position: absolute; top: 0; left: 0; border-radius: 5px; display: none;" data-item-id="{{ $item->id }}">On Cart</p>
                        <p class="rounded p-2 text-light bg-danger outOfStockBanner" style="width: 100%; position: absolute; top: 50%; left: 0; border-radius: 5px; text-align: center; display: none;" data-quantity="{{ $item->quantity }}" data-item-id="{{ $item->id }}">Out of Stock</p>
                        <img src="{{ asset('storage/' . $item->product_img) }}" alt="{{ $item->product_name }}" style="width: 270px; height: 270px;">
                    </div>
                    <div class="featured__item__text text-center mt-3">
                        <h6><a>{{ $item->product_name }}</a></h6>
                        @if($item->variant)
                        <h6><a>{{ $item->variant }}</a></h6>
                        @else
                        <h6><a>(No Variant)</a></h6>
                        @endif
                        <h5 class="d-block">₱{{ number_format($item->price, 2) }}</h5>
                        <h6 style="margin-top: 9px;">{{ $item->category->category_name }}</h6>
                    </div>
                    <div class="product__details__quantity" style="display: flex; align-items: center; justify-content: center; margin-top: 10px;">
                        <div class="quantity" data-item-id="{{ $item->id }}">
                            <div class="pro-qty productAdjustButton" data-item-id="{{ $item->id }}" data-item-price="{{ $item->price }}" data-quantity="{{ $item->quantity }}">
                                <input type="text" name="items[{{ $item->id }}]" value="0" id="quantity{{$item->id}}" class="quantityInput" data-item-id="{{ $item->id }}" style="width: 50px; padding: 4px; text-align: center; font-size: 14px;" readonly>
                            </div>
                        </div>
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
        <div class="row" onclick="MAINTENANCE()">
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