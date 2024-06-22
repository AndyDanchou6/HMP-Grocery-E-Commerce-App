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
                    <div class="sidebar__item">
                        <h4>Department</h4>
                        <ul class="sidebar__list">
                            <li>
                                <a href="{{ route('shop.products') }}" class="category-link {{ request('category') ? '' : 'active' }}" data-category-id="">
                                    All
                                </a>
                            </li>
                            @foreach($category as $item)
                            <li>
                                <a href="{{ route('shop.products', ['category' => $item->id]) }}" class="category-link {{ request('category') == $item->id ? 'active' : '' }}" data-category-id="{{ $item->id }}">
                                    {{ $item->category_name }}
                                </a>
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
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($inventory as $item)
                    <div class="col-lg-4 col-md-6 col-sm-6 product-item" data-category-id="{{ $item->category_id }}">
                        <div class="product__item product_onDisplay" data-item-id="{{ $item->id }}" data-price="{{ $item->price }}">
                            <div class="product__item__pic set-bg text-center">
                                <img src="{{ asset('storage/' . $item->product_img) }}" alt="item" style="width: 270px; height: 270px;">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart" style="color: #696cff;"></i></a></li>
                                    <li><a href="{{ route('shop.details', ['id' => $item->id]) }}"><i class="fa fa-info-circle" style="color: #696cff;"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart" style="color: #696cff;"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">{{ $item->product_name }}</a></h6>
                                <h5>₱{{ $item->price }}.00</h5>
                                <h6 style="margin-top: 9px; text-align: center;">{{ $item->category->category_name }}</h6>
                            </div>
                            <div class="product__details__quantity" style="display: flex; align-items: center; justify-content: center; margin-top: 10px;">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" name="items[{{ $item->id }}]" value="1" id="quantity" style="width: 50px; padding: 4px; text-align: center; font-size: 14px;">
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