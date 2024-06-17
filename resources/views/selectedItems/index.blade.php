@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Selected Items</h4>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Reference Number </th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if($users->count() > 0)
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->referenceNo }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$user->id}}" data-user-id="{{ $user->id }}"></a>
                            @include('selectedItems.modal.moreInfo')
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

            var tempSubTotal = [];
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

        var checkboxes = document.querySelectorAll('.checked');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var isChecked = this.checked;
                var itemId = this.getAttribute('data-item-id');
                var itemRow = document.querySelector('.item-row[data-item-id="' + itemId + '"]');

                if (isChecked) {
                    console.log(itemId);
                    // Perform any other actions needed when item is packed
                } else {
                    console.log(itemId);
                    // Perform any other actions needed when item is not packed
                }
            });
        });
    });
</script>
@endsection