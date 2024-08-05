<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>e-Mart</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('index/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('index/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('index/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('index/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('index/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('index/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('index/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('index/css/style.css') }}" type="text/css">
    <link rel="icon" type="image/x-icon" href="{{ asset('index/img/favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


</head>

<body>

    <!-- Hamburger Menu -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="{{ route('shop.index') }}"><img src="{{ asset('index/img/e.png') }}" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='fa fa-cube'></i><span> Pending Orders</span>">
                    <a href="{{ route('customers.pending_orders') }}"><i class="fa fa-cube"></i> <span style="background-color: #696cff;" id="forPendingOrdersCount1" class="d-none"></span>
                    </a>
                </li>
                <li data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<i class='fa fa-cart-plus'></i><span> Carts</span>">
                    <a href="{{ route('shop.carts') }}"><i class="fa fa-cart-plus"></i> <span style="background-color: #696cff;" id="cartsCounting1" class="d-none"></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="humberger__menu__widget">
            @if(Auth::check())
            @if(Auth::user()->role == 'Admin')
            <div class="header__top__right__auth" style="margin-right: 10px;">
                <a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
            </div>
            @elseif(Auth::user()->role == 'Customer')
            <div class="header__top__right__auth" style="margin-right: 10px;">
                <a href="{{ route('customer.home') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
            </div>
            @endif
            <div class="header__top__right__auth">
                <a onclick="Logout()"><i class="fa fa-sign-out"></i>Logout</a>
                @include('shop.layouts.logoutAlert')
            </div>
            @endif
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li><a href="{{ route('shop.index') }}">Home</a></li>
                <li><a href="{{ route('shop.products') }}">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="{{ route('shop.carts') }}">Shopping Cart</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('shop.contacts') }}">Contact</a></li>
                <li><a onclick="ERROR()">Blog</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            @foreach (['fb_link' => 'fa-facebook', 'instagram_link' => 'fa-instagram', 'twitter_link' => 'fa-twitter', 'youtube_link' => 'fa-youtube'] as $key => $iconClass)
            @if(!empty($settings[$key]))
            <a href="{{ $settings[$key] }}"><i class="fa {{ $iconClass }}"></i></a>
            @else
            <a onclick="MAINTENANCE()"><i class="fa {{ $iconClass }}"></i></a>
            @endif
            @endforeach
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-user"></i>Hello! {{ Auth::user()->name }}</li>
                <li>Welcome to e-Mart </li>
            </ul>
        </div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        @include('shop.layouts.header')

    </header>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    @include('shop.layouts.sidebar')

    @yield('content')



    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="{{ route('shop.index') }}"><img src="{{ asset('index/img/e.png') }}" alt=""></a>
                        </div>
                        <ul>
                            <li style="white-space: nowrap;">Address: {{ $settings['address'] ?? '' }}</li>
                            <li>Phone: +63 {{ $settings['phone'] ?? '' }}</li>
                            <a href="{{ $settings['fb_link'] ?? ''}}">
                                <li style="white-space: nowrap;">Facebook page: {{ $settings['fb_page'] ?? '' }}</li>
                            </a>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget" onclick="MAINTENANCE()">
                        <h6>Useful Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">About Our Shop</a></li>
                            <li><a href="#">Secure Shopping</a></li>
                            <li><a href="#">Delivery infomation</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Our Sitemap</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Who We Are</a></li>
                            <li><a href="#">Our Services</a></li>
                            <li><a href="#">Projects</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Innovation</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Join Our Newsletter Now</h6>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#">
                            <input type="text" placeholder="Enter your mail">
                            <button type="submit" class="site-btn" style="background-color: #696cff;" onclick="MAINTENANCE()">Subscribe</button>
                        </form>
                        <div class="footer__widget__social">
                            @foreach (['fb_link' => 'fa-facebook', 'instagram_link' => 'fa-instagram', 'twitter_link' => 'fa-twitter', 'youtube_link' => 'fa-youtube'] as $key => $iconClass)
                            @if(!empty($settings[$key]))
                            <a href="{{ $settings[$key] }}"><i class="fa {{ $iconClass }}"></i></a>
                            @else
                            <a onclick="MAINTENANCE()"><i class="fa {{ $iconClass }}"></i></a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                &copy; <script>
                                    document.write(new Date().getFullYear());
                                </script> e-Mart Grocery | All Rights Reserved
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    @include('layouts.sweetalert')
    <!-- Initialize tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <script src="{{ asset('index/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('index/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('index/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('index/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('index/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('index/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('index/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('index/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch("{{ route('shop.count') }}")
                .then(response => response.json())
                .then(data => {
                    var pendingOrdersCount = document.getElementById('forPendingOrdersCount');
                    if (data.pendingOrders > 0) {
                        pendingOrdersCount.textContent = data.pendingOrders;
                        pendingOrdersCount.classList.remove('d-none');
                    } else {
                        pendingOrdersCount.classList.add('d-none');
                    }

                    var cartsCounting = document.getElementById('cartsCounting');
                    if (data.cartsCount > 0) {
                        cartsCounting.textContent = data.cartsCount;
                        cartsCounting.classList.remove('d-none');
                    } else {
                        cartsCounting.classList.add('d-none');
                    }

                    var pendingOrdersCount1 = document.getElementById('forPendingOrdersCount1');
                    if (data.pendingOrders > 0) {
                        pendingOrdersCount1.textContent = data.pendingOrders;
                        pendingOrdersCount1.classList.remove('d-none');
                    } else {
                        pendingOrdersCount1.classList.add('d-none');
                    }

                    var cartsCounting1 = document.getElementById('cartsCounting1');
                    if (data.cartsCount > 0) {
                        cartsCounting1.textContent = data.cartsCount;
                        cartsCounting1.classList.remove('d-none');
                    } else {
                        cartsCounting1.classList.add('d-none');
                    }
                })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.set-bg').each(function() {
                var bg = $(this).data('setbg');
                $(this).css('background-image', 'url(' + bg + ')');
            });
        });

        function totalItemCost() {
            var itemSelected = sessionStorage.getItem('selectedItems');

            if (itemSelected != null) {

                var parsedItems = JSON.parse(itemSelected);
                var totalCost;

                Object.keys(parsedItems).forEach(key => {
                    var itemPrice = parsedItems[key].item_price;
                    var itemQuantity = parsedItems[key].item_quantity;

                    if (totalCost != null) {
                        totalCost += itemPrice * itemQuantity;
                    } else {
                        totalCost = itemPrice * itemQuantity;
                    }
                });

                return totalCost;
            }

            return 0;
        }


        function updateAmountSelected(quantityFields) {
            quantityFields.forEach(function(fields) {

                var storedSelectedItems = sessionStorage.getItem('selectedItems');
                var parsedSelectedItems = JSON.parse(storedSelectedItems);

                var itemIdentifier = 'item_' + fields.getAttribute('data-item-id');

                if (parsedSelectedItems) {
                    if (parsedSelectedItems[itemIdentifier]) {
                        fields.value = parsedSelectedItems[itemIdentifier].item_quantity;
                    }
                }
            });
        }

        function onCartBanner() {
            var onCartBannerField = document.querySelectorAll('.onCartBanner');

            onCartBannerField.forEach(function(banner) {

                var bannerItemId = banner.getAttribute('data-item-id');
                var uniqueItemId = 'item_' + bannerItemId;
                var stashedItems = sessionStorage.getItem('selectedItems');
                var parsedItems = JSON.parse(stashedItems);

                if (parsedItems) {
                    if (parsedItems[uniqueItemId] && parsedItems[uniqueItemId].item_quantity != 0) {
                        banner.style.display = 'inline-block';
                    } else {
                        banner.style.display = 'none';
                    }
                }
            })
        }

        function outOfStockBanner(outOfStockBanner, operation = null) {

            var itemId = outOfStockBanner.getAttribute('data-item-id');
            var quantityField = document.querySelector('#quantity' + itemId);
            var productAdjustBtn = document.querySelector('.productAdjustButton[data-item-id="' + itemId + '"]')

            var productOnDisplay = document.querySelector('.product_onDisplay[data-item-id="' + itemId + '"]');
            var stock = productOnDisplay.getAttribute('data-quantity');
            var quantityFieldValue = parseInt(quantityField.value);

            if (operation == 'decrement') {
                quantityFieldValue -= 1;
            } else if (operation == 'increment') {
                quantityFieldValue += 1;
            }

            if (quantityFieldValue >= parseInt(stock) || parseInt(stock) == 0) {
                outOfStockBanner.style.display = 'block';

                if (parseInt(stock) == 0) {
                    productAdjustBtn.style.display = "none";
                }
            } else {

                outOfStockBanner.style.display = "none";
                productAdjustBtn.style.display = "block";
            }
        }


        function stashItemsSelected(itemPrice, itemId, operation) {

            var key = 'item_' + itemId;
            var storeItem = {
                [key]: {
                    'item_id': itemId,
                    'item_price': itemPrice,
                    'item_quantity': 1
                }
            };

            var alreadySelected = sessionStorage.getItem('selectedItems');
            var selectedQuantity = document.querySelector('#quantity' + itemId);

            // Store in session storage an object with items selected (converted to string)
            // Check if there are selected items
            if (alreadySelected == null) {
                sessionStorage.setItem('selectedItems', JSON.stringify(storeItem));
            } else { // If item is stashed already

                var parsedSelected = JSON.parse(alreadySelected);
                if (parsedSelected[key] != null) {

                    var stocksAvailable = parseInt(selectedQuantity.value) + 1;
                    if (parsedSelected[key].item_quantity >= stocksAvailable && operation != 'decrement') {
                        parsedSelected[key].item_quantity = stocksAvailable;
                        sessionStorage.setItem('selectedItems', JSON.stringify(parsedSelected));
                        // console.log(parseFloat(selectedQuantity.value) + 1);
                    } else {

                        // Check if item is selected already and increment
                        if (operation == 'increment') {
                            parsedSelected[key].item_quantity += 1;
                            sessionStorage.setItem('selectedItems', JSON.stringify(parsedSelected));
                            // console.log(parseFloat(selectedQuantity.value) + 1);
                        }

                        // Check if item is selected already and decrement
                        if (operation == 'decrement') {
                            parsedSelected[key].item_quantity -= 1;
                            sessionStorage.setItem('selectedItems', JSON.stringify(parsedSelected));
                            // console.log(parseFloat(selectedQuantity.value) - 1);
                        }
                    }
                } else { // Item not stashed
                    if (operation == 'increment') {

                        parsedSelected[key] = {
                            'item_id': itemId,
                            'item_price': itemPrice,
                            'item_quantity': 1
                        };
                        sessionStorage.setItem('selectedItems', JSON.stringify(parsedSelected));
                        // console.log(parseFloat(selectedQuantity.value) + 1);
                    }
                }
            }
        }

        async function updateStocks() {
            const availableStocksApi = '/availableStocks';

            try {
                const response = await fetch(availableStocksApi);
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }
                const data = await response.json();

                if (data.status != 200) {
                    throw new Error('Error fetching available stocks.');
                }

                var availableStocks = data.data;

                availableStocks.forEach(function(stocks) {

                    var itemId = stocks.id;
                    var quantity = stocks.quantity;

                    var product_onDisplay = document.querySelector('.product_onDisplay[data-item-id="' + itemId + '"]');

                    if (product_onDisplay) {
                        var dataQuantity = product_onDisplay.getAttribute('data-quantity');
                        product_onDisplay.setAttribute('data-quantity', quantity.toString());
                    }

                    var stashedSelected = sessionStorage.getItem('selectedItems');
                    var parsedStashedItems = JSON.parse(stashedSelected);
                    var parsedKey = 'item_' + itemId;

                    if (parsedStashedItems && parsedStashedItems[parsedKey]) {

                        if (quantity <= parsedStashedItems[parsedKey].item_quantity) {

                            parsedStashedItems[parsedKey].item_quantity = quantity;
                            sessionStorage.setItem('selectedItems', JSON.stringify(parsedStashedItems));
                        }
                    }
                });

                const itemQuantityFields = document.querySelectorAll('.quantityInput');
                updateAmountSelected(itemQuantityFields);

                var outOfStockBanners = document.querySelectorAll('.outOfStockBanner');
                outOfStockBanners.forEach(function(outOfStock) {

                    outOfStockBanner(outOfStock);
                })

                var totalField = document.querySelector('#floating-total input');
                if (totalField) {
                    // Loads the Total cost
                    totalField.value = totalItemCost();
                }

                onCartBanner();

                setTimeout(updateStocks, 5000);
            } catch (error) {
                console.error('Error fetching data:', error.message);
                await new Promise(resolve => setTimeout(resolve, 3000));
                updateStocks();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

            updateStocks();

            var totalField = document.querySelector('#floating-total input');
            if (totalField) {
                // Loads the Total cost
                totalField.value = totalItemCost();
            }

            // Loads the amount of selected items
            const itemQuantityFields = document.querySelectorAll('.quantityInput');
            updateAmountSelected(itemQuantityFields);
            onCartBanner();

            // Display Out of Stock Products
            var outOfStockBanners = document.querySelectorAll('.outOfStockBanner');
            outOfStockBanners.forEach(function(outOfStock) {

                outOfStockBanner(outOfStock);
            })

            // Clicks on image adds to cart
            const clickedItems = document.querySelectorAll('.product_onDisplay');
            clickedItems.forEach(function(clickedItem) {
                // Listens to every click on items
                clickedItem.addEventListener('click', function() {

                    var itemId = clickedItem.getAttribute('data-item-id');
                    var itemPrice = clickedItem.getAttribute('data-price');
                    var itemSelected = clickedItem.querySelector('product_onDisplay[data-item-quantity="' + itemId + '"]');
                    var quantity = clickedItem.getAttribute('data-quantity');

                    var currentAmount = parseFloat(document.querySelector(".quantityInput[data-item-id='" + itemId + "']").value) + 1;
                    var outOfStock = document.querySelector('.outOfStockBanner[data-item-id="' + itemId + '"]');

                    if (quantity != 0 && currentAmount <= quantity) {

                        outOfStockBanner(outOfStock, 'increment');
                        if (currentAmount > parseInt(quantity)) {

                            currentAmount = currentAmount;
                        } else {
                            // Stores the selected item
                            stashItemsSelected(itemPrice, itemId, 'increment');
                            // Loads a new total after clicking item
                            totalField.value = totalItemCost();
                            updateAmountSelected(itemQuantityFields);
                            onCartBanner();
                        }
                    }
                });
            });

            // Adjust selected items with buttons
            const quantityButton = document.querySelectorAll('.productAdjustButton');
            quantityButton.forEach(function(quantity) {

                var itemId = quantity.getAttribute('data-item-id');
                var itemPrice = quantity.getAttribute('data-item-price');

                var outOfStock = document.querySelector('.outOfStockBanner[data-item-id="' + itemId + '"]');
                var operation = '';

                var incrementBtn = quantity.querySelector('.inc');
                var decrementBtn = quantity.querySelector('.dec');

                incrementBtn.addEventListener('click', function() {

                    var inputValue = document.querySelector('#quantity' + itemId);
                    var itemDisplay = document.querySelector('.product_onDisplay[data-item-id="' + itemId + '"]');
                    var itemDataQuantity = itemDisplay.getAttribute('data-quantity');

                    if (parseInt(inputValue.value) + 1 <= itemDataQuantity) {

                        stashItemsSelected(itemPrice, itemId, 'increment');
                        outOfStockBanner(outOfStock, 'increment');
                        onCartBanner();
                    } else {

                        inputValue.value = parseFloat(itemDataQuantity) - 1;
                    }

                    totalField.value = totalItemCost(); // total field is defined globally above
                })

                decrementBtn.addEventListener('click', function() {
                    var input = document.querySelector('#quantity' + itemId);
                    var currentInputValue = parseInt(input.value) - 1;

                    var itemDisplay = document.querySelector('.product_onDisplay[data-item-id="' + itemId + '"]');
                    var itemDataQuantity = itemDisplay.getAttribute('data-quantity');

                    if (currentInputValue >= 0) {

                        stashItemsSelected(itemPrice, itemId, 'decrement');
                        outOfStockBanner(outOfStock, 'decrement');
                        onCartBanner();
                        totalField.value = totalItemCost(); // total field is defined globally above
                    }
                });
            });

            // Store selected items then display them
            var toCartButton = document.querySelector('#toCartButton');

            if (toCartButton) {
                toCartButton.addEventListener('click', function() {

                    var stashedItems = sessionStorage.getItem('selectedItems')
                    var parsedItems = JSON.parse(stashedItems)

                    if (parsedItems) {
                        var parsedItemId = Object.keys(parsedItems)
                        var tempItemStorage = {};


                        parsedItemId.forEach(function(parsedId) {

                            var [prefix, rawId] = parsedId.split('_')

                            if (parsedItems[parsedId] && parsedItems[parsedId].item_quantity != 0) {

                                tempItemStorage[rawId] = parsedItems[parsedId].item_quantity
                            }
                        })

                        toCartItems = {
                            'items': tempItemStorage
                        }

                        const storeCartApi = "/carts"

                        fetch(storeCartApi, {
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(toCartItems)
                        }).then(res => {
                            if (!res.ok) {
                                throw new Error('Network Response is Bad')
                            }
                            return res.json()
                        }).then(data => {
                            if (data.status == 200) {
                                location.href = "/shop/carts"
                            }
                        })
                    }
                })
            }
        });
    </script>
    <script src="{{ asset('index/sweetalert.min.js') }}"></script>
</body>

</html>