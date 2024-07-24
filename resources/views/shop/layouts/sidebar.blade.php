<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all" style="background-color: #696cff;">
                        <i class="fa fa-bars"></i>
                        <span>All Categories</span>
                    </div>
                    <ul>
                        @foreach($category as $item)
                        <li>
                            <a href="{{ route('shop.products', ['category' => $item->id]) }}" data-category-id="{{ $item->id }}">
                                {{ $item->category_name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="{{ route('shop.products') }}" method="GET">
                            <input type="text" name="query" placeholder="What do you need?" required>
                            <button type="submit" class="site-btn" style="background-color: #696cff;">SEARCH</button>
                        </form>
                    </div>
                    <div class=" hero__search__phone flex-wrap w-auto">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone" style="color: #696cff;"></i>
                        </div>
                        <div class="hero__search__phone__text flex-wrap w-auto">
                            <h5>+63 963 875 3244</h5>
                            <span>8:00 AM - 7:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>