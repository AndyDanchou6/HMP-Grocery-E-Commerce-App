@extends('shop.layouts.layout')

@section('content')
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<section class="breadcrumb-section set-bg" data-setbg="{{ asset('index/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('shop.index') }}">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <form id="update-cart-form" action="{{ route('carts.updateQty') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($carts->count() > 0)
                                @foreach($carts as $item)
                                <tr class="itemsRow">
                                    <td class="shoping__cart__item">
                                        <img src="{{ asset('storage/' . $item->inventory->product_img) }}" alt="" style="width: 100px; height: 100px">
                                        @if($item->inventory->variant)
                                        <h5>{{ $item->inventory->product_name }} [{{ $item->inventory->variant }}]</h5>
                                        @else
                                        <h5>{{ $item->inventory->product_name }}</h5>
                                        @endif
                                    </td>
                                    <td class="shoping__cart__price">
                                        ₱{{ number_format($item->inventory->price, 2) }}
                                    </td>
                                    @if($item->quantity != 0)
                                    <td class="shoping__cart__quantity" data-item-id="cart_{{ $item->inventory->id }}" data-price="{{ $item->inventory->price }}">
                                        <div class="quantity">
                                            <div class="pro-qty cartAdjustButton" data-item-id="cart_{{ $item->inventory->id }}">
                                                <input type="text" name="quantities[{{ $item->id }}]" id="cartQuantity{{$item->inventory->id}}" value="{{ $item->quantity }}" min="1" max="{{ $item->inventory->quantity }}" class="item-quantity" data-price="{{ $item->inventory->price }}" data-quantity="{{ $item->inventory->quantity }}" readonly>
                                            </div>
                                        </div>
                                    </td>
                                    @endif

                                    <td class="shoping__cart__total" data-item-id="cart_{{ $item->inventory->id }}">
                                        ₱<span class="item-subtotal">{{ number_format($item->inventory->price * $item->quantity, 2) }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="shoping__cart__item__close delete-button" data-action="{{ route('carts.destroy', $item->id) }}" data-item-id="{{ $item->inventory->id }}">
                                            <span class="icon_close"></span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">No carts found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{ route('shop.products') }}" class="primary-btn cart-btn continue-shop-btn" style="background-color: #696cff; color: white;">CONTINUE SHOPPING</a>
                    <button type="submit" form="update-cart-form" class="primary-btn cart-btn cart-btn-right updateCartBtn">
                        <span class="icon_loading"></span> Update Cart
                    </button>
                </div>
            </div>
            <div class="col-lg-6">
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span id="subtotal">₱{{ number_format($subtotal, 2) }}</span></li>
                        <li>Total <span id="total">₱{{ number_format($total, 2) }}</span></li>
                    </ul>
                    <div class="text-end mt-3" style="margin-right: 10px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label for="orderRetrievalType" class="col-form-label">Order Retrieval Type:</label>
                            </div>
                            <div class="col-auto">
                                <select id="orderRetrievalType" class="form-select">
                                    <option value="" selected disabled>Choose..</option>
                                    <option value="delivery">Delivery</option>
                                    <option value="pickup">Pick-up</option>
                                </select>
                                <small class="text-danger">* Please select order retrieval type before proceeding to checkout.</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3" style="margin-right: 10px; margin-bottom: 10px;">
                        <button id="checkoutButton" class="primary-btn">PROCEED TO CHECKOUT</button>
                    </div>
                    @if($forCheckoutStatus == 'forCheckout')
                    <div class="text-end mt-3" style="margin-right: 10px;">
                        <a href="{{ route('shop.checkout') }}" class="primary-btn">GO BACK TO CHECKOUT</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.item-subtotal').forEach(function(subtotalElement) {
                subtotal += parseFloat(subtotalElement.textContent.replace('₱', '').replace(',', ''));
            });

            let total = subtotal;

            document.getElementById('subtotal').textContent = '₱' + formatAmount(subtotal);
            document.getElementById('total').textContent = '₱' + formatAmount(total);
        }

        function formatAmount(amount) {
            return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        document.querySelectorAll('.item-quantity').forEach(function(element) {
            element.addEventListener('change', function() {
                updateTotal();
            });
        });

        updateTotal();

        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function() {
                let actionUrl = this.getAttribute('data-action');
                fetch(actionUrl, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                }).then(response => {
                    if (response.ok) {

                        var buttonId1 = button.getAttribute('data-item-id');
                        // let [prefix1, identifier1] = buttonId.split('_');

                        var sessionStoredItems1 = sessionStorage.getItem('selectedItems');

                        if (sessionStoredItems1) {
                            var parsedStoredItems1 = JSON.parse(sessionStoredItems1);
                            var sessionItemsId1 = 'item_' + buttonId1;

                            parsedStoredItems1[sessionItemsId1].item_quantity = 0;

                            sessionStorage.setItem('selectedItems', JSON.stringify(parsedStoredItems1));
                        }

                        window.location.reload();
                    } else {
                        throw new Error('Failed to delete item.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the item.');
                });
            });
        });

        // Store initial quantities
        const initialQuantities = {};
        document.querySelectorAll('.item-quantity').forEach(function(input) {
            initialQuantities[input.name] = input.value;
        });

        document.getElementById('checkoutButton').addEventListener('click', function() {
            let orderRetrievalType = document.getElementById('orderRetrievalType').value;
            let cartItemsCount = document.querySelectorAll('.shoping__cart__item').length;

            if (cartItemsCount === 0) {
                swal({
                    title: "Oops",
                    text: "Your cart is empty. Please add items to the cart before proceeding to checkout.",
                    icon: "error",
                    button: "Ok",
                });
                let swalContainer = document.querySelector('.swal-modal');
                if (swalContainer) {
                    let swalText = swalContainer.querySelector('.swal-text');
                    if (swalText) {
                        swalText.style.textAlign = 'center';
                    }
                }
                return;
            }

            if (!orderRetrievalType) {
                swal({
                    title: "Oops",
                    text: "Please select order retrieval type before proceeding to checkout.",
                    icon: "error",
                    button: "Ok",
                });
                return;
            }

            let quantitiesChanged = false;
            document.querySelectorAll('.item-quantity').forEach(function(input) {
                if (initialQuantities[input.name] != input.value) {
                    quantitiesChanged = true;
                }
            });

            if (quantitiesChanged) {
                swal({
                    title: "Are you sure?",
                    text: "You have changed the quantities but have not updated the cart. Do you want to proceed without updating the cart?",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "",
                            closeModal: true,
                        },
                        confirm: {
                            text: "Proceed",
                            value: true,
                            visible: true,
                            closeModal: true
                        }
                    },
                    dangerMode: true,
                }).then((willProceed) => {
                    if (willProceed) {
                        proceedToCheckout(orderRetrievalType);
                    } else {
                        window.location.forward();
                    }
                });
            } else {
                proceedToCheckout(orderRetrievalType);
            }
            let swalContainer = document.querySelector('.swal-modal');
            if (swalContainer) {
                let swalText = swalContainer.querySelector('.swal-text');
                if (swalText) {
                    swalText.style.textAlign = 'center';
                }
            }
        });

        function proceedToCheckout(orderRetrievalType) {
            fetch('{{ route("carts.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    orderRetrievalType: orderRetrievalType
                })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    window.location.href = "{{ route('shop.checkout') }}";
                }
            }).catch(error => {
                console.error('Error:', error);
                swal({
                    title: "Error",
                    text: "An error occurred while proceeding to checkout. Please try again.",
                    icon: "error",
                    button: "Ok",
                });
            });
        }

        var updateCartButton = document.querySelector('.updateCartBtn');
        const quantityButtons = document.querySelectorAll('.cartAdjustButton');

        // Update Stashed Selected Items Via Update Cart
        updateCartButton.addEventListener('click', function(event) {

            quantityButtons.forEach(function(quantityButton) {

                var buttonId = quantityButton.getAttribute('data-item-id');
                let [prefix, identifier] = buttonId.split('_');

                var sessionStoredItems = sessionStorage.getItem('selectedItems');

                if (sessionStoredItems) {
                    var parsedStoredItems = JSON.parse(sessionStoredItems);
                    var sessionItemsId = 'item_' + identifier;

                    var inputs = quantityButton.querySelector('input').value

                    parsedStoredItems[sessionItemsId].item_quantity = parseFloat(inputs);

                    sessionStorage.setItem('selectedItems', JSON.stringify(parsedStoredItems));
                }
            })
        })

        var originalQuantities = [];
        var currentValues = [];
        var untouched = true;

        // Limit purchase based on available stock
        quantityButtons.forEach(function(qButton) {

            var qtyBtn2 = qButton.querySelectorAll('.qtybtn')
            var cartItemId = qButton.getAttribute('data-item-id')
            let idNumber = cartItemId.substring(5);

            originalQuantities[cartItemId] = qButton.querySelector('input').value;

            qtyBtn2.forEach(function(qtyBtn1) {

                qtyBtn1.addEventListener('click', function() {

                    var inputField = document.querySelector('#cartQuantity' + idNumber)
                    var availableStock = inputField.getAttribute('data-quantity')

                    if (qtyBtn1.classList.contains('inc')) {
                        if (parseFloat(inputField.value) >= parseFloat(availableStock) - 1) {

                            inputField.value = availableStock - 1
                        }
                        currentValues[cartItemId] = parseFloat(inputField.value) + 1;
                    } else {
                        currentValues[cartItemId] = parseFloat(inputField.value) - 1;
                    }

                    Object.keys(currentValues).forEach(function(key) {
                        if (currentValues[cartItemId] == originalQuantities[key]) {
                            untouched = true;
                        } else {
                            untouched = false;
                        }
                    })

                    if (untouched == true) {
                        let buttonUpdate = document.querySelector('.updateCartBtn');
                        buttonUpdate.removeAttribute('style');
                    } else {
                        let buttonUpdate = document.querySelector('.updateCartBtn');
                        buttonUpdate.style.color = 'white';
                        buttonUpdate.style.backgroundColor = '#696cff';
                    }
                })
            })
        });

        // Automatic total if item quantity is changed
        var shoping__cart__quantity = document.querySelectorAll('.shoping__cart__quantity');

        shoping__cart__quantity.forEach(function(individualItemQuantity) {

            var itemQuantityInput = individualItemQuantity.querySelector('input');
            var itemId = individualItemQuantity.getAttribute('data-item-id');
            var itemPrice = individualItemQuantity.getAttribute('data-price');
            var buttons = individualItemQuantity.querySelectorAll('.qtybtn');

            buttons.forEach(function(button) {
                button.addEventListener('click', function() {

                    var itemQuantityValue = parseInt(itemQuantityInput.value);
                    var totalField = document.querySelector('.shoping__cart__total[data-item-id="' + itemId + '"] span')
                    if (button.classList.contains('inc')) {

                        var incrementedValue = itemQuantityValue + 1;
                        var incrementedTotal = incrementedValue * parseFloat(itemPrice);
                        totalField.textContent = incrementedTotal.toFixed(2);
                    }
                    if (button.classList.contains('dec')) {

                        var decrementedValue = itemQuantityValue - 1;
                        if (decrementedValue >= 1) {

                            var decrementedTotal = decrementedValue * parseFloat(itemPrice);
                            totalField.textContent = decrementedTotal.toFixed(2);
                        } else {

                            itemQuantityInput.value = 2;
                        }
                    }
                    updateTotal();
                })
            });
        })

        // Continue shopping unfinished cart
        if (shoping__cart__quantity.length > 0) {

            var continueShopBtn = document.querySelector('.continue-shop-btn');

            continueShopBtn.addEventListener('click', function(event) {

                var shopingCartQuantities = document.querySelectorAll('.shoping__cart__quantity');
                shopingCartQuantities.forEach(function(shopingCartQuantity) {

                    var stashedSelectedItems = JSON.parse(sessionStorage.getItem('selectedItems'));

                    var itemId = shopingCartQuantity.getAttribute('data-item-id');
                    var rawId = itemId.substring(5).trim();
                    var stashedId = 'item_' + rawId;
                    var itemPrice = shopingCartQuantity.getAttribute('data-price');
                    var quantity = shopingCartQuantity.querySelector('input').value;

                    // Stashed unfinished carts
                    if (!stashedSelectedItems) {
                        var continueShop = {
                            [stashedId]: {
                                'item_id': rawId,
                                'item_quantity': quantity,
                                'item_price': itemPrice,
                            }
                        }

                        sessionStorage.setItem('selectedItems', JSON.stringify(continueShop));
                    } else {
                        stashedSelectedItems[stashedId] = {
                            'item_id': rawId,
                            'item_quantity': quantity,
                            'item_price': itemPrice,
                        }

                        sessionStorage.setItem('selectedItems', JSON.stringify(stashedSelectedItems));
                    }
                })
            })
        }
    })
</script>

@endsection