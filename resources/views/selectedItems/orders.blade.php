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
                        <th>Reference No.</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Cost</th>
                        <th>Order Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if($selectedItems->count() > 0)
                    @foreach ($selectedItems as $user)
                    <tr>
                        <td style="display: none;" class="id-field">{{ $user->id }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge bg-label-primary me-1">{{ $user->referenceNo }}</span>
                        </td>
                        <td>{{ $user->inventory->product_name }}</td>
                        <td>₱{{ number_format($user->inventory->price, 2) }}</td>
                        <td>{{ $user->quantity }}</td>
                        <td>₱{{ number_format($user->inventory->price * $user->quantity, 2) }}</td>
                        <td>
                            @if($user->order_retrieval == 'delivery')
                            <span class="badge bg-label-info me-1">Delivery</span>
                            @else
                            <span class="badge bg-label-primary me-1">Pickup</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status == 'forPackage')
                            <span class="badge bg-label-danger me-1">Pending</span>
                            @elseif($user->status == 'readyForRetrieval')
                            <span class="badge bg-label-warning me-1">To receive</span>
                            @elseif($user->status == 'delivered' || $user->status == 'pickedUp')
                            <span class="badge bg-label-success me-1">Completed</span>
                            @endif
                        </td>
                        <td></td>
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
    document.addEventListener('DOMContentLoaded', function() {

        var subTotalField = document.querySelectorAll('.item-sub-total');
        var totalContainer = {};

        subTotalField.forEach(function(subtotal) {
            var itemReferenceNo = subtotal.getAttribute('data-item-id');
            var [referenceNo, itemId] = itemReferenceNo.split('_');

            var price = parseFloat(document.querySelector('.item-price[data-item-id="' + itemReferenceNo + '"]').value.replace(/[^0-9.-]+/g, ""));
            var quantity = parseInt(document.querySelector('.item-quantity[data-item-id="' + itemReferenceNo + '"]').value);
            var userSubTotalField = document.querySelector('.item-sub-total[data-item-id="' + itemReferenceNo + '"]');

            var tempSubTotal = price * quantity;
            userSubTotalField.value = tempSubTotal.toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP'
            });

            if (!totalContainer[referenceNo]) {
                totalContainer[referenceNo] = tempSubTotal;
            } else {
                totalContainer[referenceNo] += tempSubTotal;
            }
        });

        var totals = document.querySelectorAll('.purchase-total');

        totals.forEach(function(total) {
            var totalId = total.getAttribute('data-total-id');
            total.value = totalContainer[totalId].toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP'
            });
        });
    });
</script>
@endsection