@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Shopping Cart</h4>
            <form action="{{ route('categories.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Select All
                                </label>
                            </div>
                        </th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($carts->count() > 0)
                    @foreach ($carts as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input cart-checkbox" type="checkbox" value="{{ $item->id }}" data-price="{{ $item->inventory->price }}">
                            </div>
                        </td>
                        <td>{{ $item->inventory->product_name }}</td>
                        <td>{{ $item->inventory->price }}</td>
                        <td class="item-total">{{ $item->quantity }}</td>
                        <td>₱{{ $item->inventory->price * $item->quantity }}</td>
                        <td>
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                <i class="fas fa-trash"></i>
                            </a>
                            @include('carts.modal.delete')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No carts found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Display total -->
            <div id="cartTotal" class="text-end mt-3">
                Total Cost: ₱0.00 <!-- Placeholder, will be updated dynamically -->
            </div>

            <!-- Order Retrieval Type -->
            <div class="text-end mt-3">
                <label for="orderRetrievalType">Order Retrieval Type:</label>
                <select id="orderRetrievalType" class="form-select d-inline-block w-auto">
                    <option value="delivery">Delivery</option>
                    <option value="pickup">Pick-up</option>
                </select>
            </div>

            <!-- Proceed to Checkout Button -->
            <div class="text-end mt-3">
                <button id="checkoutButton" class="btn btn-primary">Proceed to Checkout</button>
            </div>
        </div>
    </div>
</div>
@include('layouts.sweetalert')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.cart-checkbox:checked').forEach(function(checkbox) {
                let itemTotal = parseFloat(checkbox.getAttribute('data-price')) * parseFloat(checkbox.closest('tr').querySelector('.item-total').textContent);
                total += itemTotal;
            });
            document.getElementById('cartTotal').textContent = 'Total Cost: ₱' + total.toFixed(2);
            document.getElementById('cartTotal').style.marginRight = '10px';
        }

        document.getElementById('selectAll').addEventListener('change', function() {
            let isChecked = this.checked;
            document.querySelectorAll('.cart-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
            updateTotal();
        });

        document.querySelectorAll('.cart-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateTotal();
            });
        });

        updateTotal();

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
                        window.location.href = '{{ route("carts.index") }}';
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