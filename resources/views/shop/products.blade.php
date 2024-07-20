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
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item d-none d-md-block">
                        <h4>Products</h4>
                        <ul class="sidebar__list">

                            @foreach($subCategory as $product => $item)
                            <li>
                                <a href="{{ route('shop.products', ['subCategory' => $product]) }}" class="category-link {{ request('subCategory') == $product ? 'active' : '' }}" data-category-id="{{ $product }}">
                                    {{ $product }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-md-none" id="productSidebarToggle">
                        <div class="bg-primary px-5 py-3 rounded text-light">
                            <i class="fa fa-bars mr-2"></i>
                            <span>Products</span>
                            <span style="position: absolute; right: 50px; top: 20px;"><i class="fa fa-caret-down "></i></span>
                        </div>
                        <ul>
                            @foreach($subCategory as $product => $item)
                            <li style="display: none; text-decoration: none;">
                                <a href="{{ route('shop.products', ['subCategory' => $product]) }}" class="category-link {{ request('subCategory') == $product ? 'active' : '' }}" data-category-id="{{ $product }}">{{ $product }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7">
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <!-- <span>Sort By</span>
                                <select>
                                    <option value="0">Default</option>
                                    <option value="0">Default</option>
                                </select> -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                @if(request('query'))
                                <h6 style="margin-bottom: 10px;">Search Results for "{{ request('query') }}"</h6>
                                @endif
                                @if($inventory->count() > 0)
                                @if(request('category'))
                                <h6>Showing <span>{{ $inventory->count() }} of {{ $inventory->total() }}</span> results</h6>
                                @else
                                <h6>{{ $inventory->total() }} products found</h6>
                                @endif
                                @else
                                <h6>No products found</h6>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <h6 style="color: #696cff;"><strong>Page {{ $inventory->currentPage() }} of {{ $inventory->lastPage() }}</strong></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($inventory as $item)
                    <div class="col-lg-4 col-md-6 col-sm-6 product-item" data-category-id="{{ $item->category_id }}">

                        <div class="product__item">
                            <div class="product__item__pic set-bg text-center product_onDisplay" data-item-id="{{ $item->id }}" data-price="{{ $item->price }}" data-quantity="{{ $item->quantity }}">
                                <p class="rounded p-2 text-light bg-success onCartBanner" style="position: absolute; top: 0; left: 0; display: none;" data-item-id="{{ $item->id }}">On Cart</p>
                                <p class="rounded p-2 text-light bg-danger outOfStockBanner" style="width: 100%; position: absolute; top: 50%; left: 0; border-radius: 5px; text-align: center; display: none;" data-quantity="{{ $item->quantity }}" data-item-id="{{ $item->id }}">Out of Stock</p>
                                <img src="{{ asset('storage/' . $item->product_img) }}" alt="item" style="width: 270px; height: 270px;">

                                <ul class="product__item__pic__hover">
                                    <!-- <li><a href="#"><i class="fa fa-heart" style="color: #696cff;"></i></a></li>
                                    <li><a href="{{ route('shop.details', ['id' => $item->id]) }}"><i class="fa fa-info-circle" style="color: #696cff;"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart" style="color: #696cff;"></i></a></li> -->
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a>{{ $item->product_name }}</a></h6>
                                @if($item->variant)
                                <h6><a>{{ $item->variant }}</a></h6>
                                @else
                                <h6><a>(No Variant)</a></h6>
                                @endif
                                <h5>₱{{ $item->price }}.00</h5>
                                <h6 style="margin-top: 9px; text-align: center;">{{ $item->category->category_name }}</h6>
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
                <div class="product__pagination">
                    {{ $inventory->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@include('shop.floatingTotal')

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var productSidebarToggle = document.querySelector('#productSidebarToggle');
        var productSidebarShowed = false;

        productSidebarToggle.addEventListener('click', function() {
            var productLists = productSidebarToggle.querySelectorAll('li');
            var listDisplayStat = ''

            if (productSidebarShowed == false) {
                listDisplayStat = "block";
                productSidebarShowed = true;
            } else {
                listDisplayStat = "none";
                productSidebarShowed = false;
            }

            productLists.forEach(function(product) {

                product.style.display = listDisplayStat;
            })
        })
    })
</script>