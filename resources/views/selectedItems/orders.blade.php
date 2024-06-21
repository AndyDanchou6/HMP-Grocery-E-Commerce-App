@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Purchased</h4>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th>Order Type</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if($selectedItems->count() > 0)
                    @foreach ($selectedItems as $user)
                    <tr>
                        <td style="display: none;" class="id-field">{{ $user->id }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->inventory->product_name }}</td>
                        <td>{{ $user->inventory->price }}</td>
                        <td>{{ $user->quantity }}</td>
                        <td>{{ $user->inventory->price * $user->quantity }}</td>
                        <td>
                            @if($user->status == 'forPackage')
                            <span class="badge bg-label-danger me-1">Pending</span>
                            @elseif($user->status == 'readyForRetrieval')
                            <span class="badge bg-label-warning me-1">To receive</span>
                            @elseif($user->status == 'delivered' || $user->status == 'pickedUp')
                            <span class="badge bg-label-success me-1">Completed</span>
                            @endif
                        </td>
                        <td>
                            @if($user->order_retrieval == 'delivery')
                            <span class="badge bg-label-info me-1">Delivery</span>
                            @else
                            <span class="badge bg-label-primary me-1">Pickup</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No Selected Items found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            @include('selectedItems.pagination')
        </div>
    </div>
</div>

@endsection

@section('customScript')
<script>
    addEventListener('DOMContentLoaded', function() {

        var subTotalField = document.querySelectorAll('.item-sub-total');
        var totalContainer = [];

        subTotalField.forEach(function(subtotal) {

            var itemUserId = subtotal.getAttribute('data-item-id');
            var toSplit = itemUserId;
            var [itemId, userId] = toSplit.split('_');

            var price = document.querySelector('.item-price[data-item-id="' + itemUserId + '"]').value;
            var quantity = document.querySelector('.item-quantity[data-item-id="' + itemUserId + '"]').value;
            var userSubTotalField = document.querySelector('.item-sub-total[data-item-id="' + itemUserId + '"]');

            var tempSubTotal;
            tempSubTotal = price * quantity;
            userSubTotalField.value = tempSubTotal;

            if (totalContainer[userId] == null) {
                totalContainer[userId] = tempSubTotal;
            } else {
                totalContainer[userId] += tempSubTotal;
            }
        });


        var totals = document.querySelectorAll('.purchase-total');

        totals.forEach(function(total) {

            var totalId = total.getAttribute('data-total-id');

            total.querySelector('.purchase-total[data-total-id="' + totalId + '"]');

            total.value = totalContainer[totalId];
        });
    });
</script>
@endsection