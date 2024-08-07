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

                    <div class=" hero__search__phone">
                        <div class="hero__search__phone__icon" style="display: flex; justify-content: center; align-items: center;">
                            <i class="fa fa-phone" style="color: #696cff;"></i>

                        </div>
                        <div class="hero__search__phone__text flex-wrap w-auto">
                            @if(!empty($settings['phone']))
                            <h5>+63 {{ $settings['phone'] }}</h5>
                            @else
                            <h5 class="text-danger">Phone not available</h5>
                            @endif

                            @if(!empty($openingTime) && !empty($closingTime))
                            <span>
                                {{ $openingTime ?? 'N/A' }} - {{ $closingTime ?? 'N/A'}}
                            </span>
                            @else
                            <span class="text-danger">Opening/Closing time not set</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
