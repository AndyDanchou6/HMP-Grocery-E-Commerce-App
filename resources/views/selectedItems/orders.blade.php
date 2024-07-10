@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Purchased</h4>
            <div class="alert alert-primary alert-sm" role="alert" style="margin-left: 10px; width: 70%; text-align: justify; animation: fadeEffect 5s ease-in-out 10s infinite;" id="timer">
                Reminder: For GCash payments, kindly remit your payment to <strong>{{ $admin->phone }}</strong>
                and include your <strong>order reference number</strong> in the message. Please provide a screenshot
                or receipt of your payment. You can easily access this by clicking on the receipt icon below. Thank you!
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference No.</th>
                        <th>Items</th>
                        <th>Order Type</th>
                        <th>Payment Type</th>
                        <th>Payment Condition</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($userByReference) > 0)
                    @foreach ($userByReference as $referenceNo => $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-label-primary me-1">{{ $referenceNo }}</span></td>
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.info', ['user' => $user])
                        </td>
                        <td>
                            @if($user['order_retrieval'] == 'delivery')
                            <span class="badge bg-label-info me-1">Delivery</span>
                            @elseif($user['order_retrieval'] == 'pickup')
                            <span class="badge bg-label-primary me-1">Pickup</span>
                            @endif
                        </td>
                        <td>
                            @if($user['payment_type'] == 'COD')
                            <span class="badge bg-label-primary me-1">{{ $user['payment_type'] }}</span>
                            @elseif($user['payment_type'] == 'G-cash')
                            <span class="badge bg-label-info me-1">{{ $user['payment_type'] }}</span>
                            @else
                            <span class="badge bg-label-secondary me-1">{{ $user['payment_type'] }}</span>
                            @endif
                        </td>
                        <td>
                            @if($user['payment_condition'] == 'paid')
                            <span class="badge bg-label-success me-1">Paid</span>
                            @else
                            <span class="badge bg-label-danger me-1">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            @if($user['status'] == 'forPackage')
                            <span class="badge bg-label-danger me-1">Pending</span>
                            @elseif($user['status'] == 'readyForRetrieval')
                            <span class="badge bg-label-warning me-1">To receive</span>
                            @elseif($user['status'] == 'delivered' || $user['status'] == 'pickedUp')
                            <span class="badge bg-label-success me-1">Completed</span>
                            @endif
                        </td>
                        <td>
                            @if($user['proof_of_delivery'] != NULL)
                            @if($user['order_retrieval'] == 'delivery')
                            <a class="bi bi-eye me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#proof{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.proof')
                            @endif
                            @else
                            @if($user['payment_type'] == 'G-cash' && $user['payment_condition'] != 'paid')
                            <a class="bi bi-receipt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#proof{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center">No Package Items found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
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

        // function updateAlertMessage() {
        //     const timer = document.getElementById('timer');
        //     timer.innerHTML = 'Reminder: For GCash payments, kindly send your payment to 0917-123-4567 and include your order reference number. Thank you!';

        //     setTimeout(updateAlertMessage, 3000);
        // }

        // updateAlertMessage();
    });
</script>
@endsection