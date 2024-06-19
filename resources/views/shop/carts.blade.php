@extends('shop.layouts.layout')

@section('content')

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
                    <form id="update-cart-form" action="{{ route('carts.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label" for="selectAll">
                                            </label>
                                        </div>
                                    </th>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($carts->count() > 0)
                                @foreach($carts as $item)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input cart-checkbox" type="checkbox" name="selected_items[]" value="{{ $item->id }}" data-price="{{ $item->inventory->price }}">
                                        </div>
                                    </td>
                                    @if($item->order_retrieval == 'delivery')
                                    <td class="shoping__cart__item">
                                        <img src="{{ asset('storage/' . $item->inventory->product_img) }}" alt="" style="width: 100px; height: 100px">
                                        <h5>{{ $item->inventory->product_name }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ₱{{ number_format($item->inventory->price, 2) }}
                                    </td>
                                    @else
                                    <td class="shoping__cart__item">
                                        <img src="{{ asset('storage/' . $item->inventory->product_img) }}" alt="" style="width: 100px; height: 100px">
                                        <h5>{{ $item->inventory->product_name }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ₱{{ number_format($item->inventory->price, 2) }}
                                    </td>
                                    @endif
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1" class="item-quantity" data-price="{{ $item->inventory->price }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        ₱<span class="item-subtotal">{{ number_format($item->inventory->price * $item->quantity, 2) }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="shoping__cart__item__close delete-button" data-action="{{ route('carts.destroy', $item->id) }}">
                                            <span class="icon_close"></span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No carts found.</td>
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
                    <a href="{{ route('shop.products') }}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <button type="submit" form="update-cart-form" class="primary-btn cart-btn cart-btn-right">
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
                        <li>Subtotal <span id="subtotal">₱0.00</span></li>
                        <li>Total <span id="total">₱0.00</span></li>
                    </ul>
                    <div class="text-end mt-3" style="margin-right: 10px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label for="orderRetrievalType" class="col-form-label">Order Retrieval Type:</label>
                            </div>
                            <div class="col-auto">
                                <select id="orderRetrievalType" class="form-select">
                                    <option value="delivery">Delivery</option>
                                    <option value="pickup">Pick-up</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3" style="margin-right: 10px; margin-bottom: 10px;">
                        <button id="checkoutButton" class="primary-btn">PROCEED TO CHECKOUT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.cart-checkbox:checked').forEach(function(checkbox) {
                let price = parseFloat(checkbox.getAttribute('data-price'));
                let quantity = parseFloat(checkbox.closest('tr').querySelector('.item-quantity').value);
                let itemTotal = price * quantity;
                subtotal += itemTotal;
            });

            let total = subtotal;

            document.getElementById('subtotal').textContent = '₱' + formatAmount(subtotal);;
            document.getElementById('total').textContent = '₱' + formatAmount(total);
        }

        function formatAmount(amount) {
            return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        document.getElementById('selectAll').addEventListener('change', function() {
            let isChecked = this.checked;
            document.querySelectorAll('.cart-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
            updateTotal();
        });

        document.querySelectorAll('.cart-checkbox, .item-quantity').forEach(function(element) {
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

        document.getElementById('checkoutButton').addEventListener('click', function() {
            let selectedItems = [];
            document.querySelectorAll('.cart-checkbox:checked').forEach(function(checkbox) {
                selectedItems.push(checkbox.value);
            });

            let orderRetrievalType = document.getElementById('orderRetrievalType').value;

            if (selectedItems.length > 0) {
                fetch('{{ route("carts.checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        items: selectedItems,
                        orderRetrievalType: orderRetrievalType
                    })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('shop.checkout') }}";
                    } else {
                        alert('An error occurred during checkout.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during checkout.');
                });
            } else {
                alert('Please select at least one item to proceed to checkout.');
            }
        });
    });
</script>

@endsection