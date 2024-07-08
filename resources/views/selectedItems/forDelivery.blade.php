@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">For Delivery Orders</h4>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Reference No.</th>
                        <th>Payment Type</th>
                        <th>Delivery Schedule</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($forDelivery) > 0)
                    @foreach ($forDelivery as $user)
                    <tr>
                        <td style="display: none;" class="id-field">{{ $user['id'] }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['referenceNo'] }}</td>
                        <td>{{ $user['payment_type'] }}</td>
                        @if($user['delivery_date'])
                        <td>{{ \Carbon\Carbon::parse($user['delivery_date'])->format('l, F j, Y g:i A') }}</td>
                        @else
                        <td>Not Scheduled Yet</td>
                        @endif
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$user['referenceNo']}}" data-user-id="{{ $user['referenceNo'] }}"></a>
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
    function hideOptions(orderRetrieval) {

        var subTotalField = document.querySelectorAll(".item-sub-total");
        var totalContainer = {};

        subTotalField.forEach(function(subtotal) {
            var itemReferenceNo = subtotal.getAttribute("data-item-id");
            var [referenceNo, itemId] = itemReferenceNo.split("_");

            var price = parseFloat(
                document
                .querySelector(
                    '.item-price[data-item-id="' + itemReferenceNo + '"]'
                )
                .value.replace(/[^0-9.-]+/g, "")
            );
            var quantity = parseInt(
                document.querySelector(
                    '.item-quantity[data-item-id="' + itemReferenceNo + '"]'
                ).value
            );

            if (quantity < 0) {
                alert("Quantity cannot be negative.");
                quantity = 0;
                document.querySelector(
                    '.item-quantity[data-item-id="' + itemReferenceNo + '"]'
                ).value = 0;
            }

            var userSubTotalField = document.querySelector(
                '.item-sub-total[data-item-id="' + itemReferenceNo + '"]'
            );

            var tempSubTotal = price * quantity;
            userSubTotalField.value = tempSubTotal.toLocaleString("en-PH", {
                style: "currency",
                currency: "PHP",
            });

            if (!totalContainer[referenceNo]) {
                totalContainer[referenceNo] = tempSubTotal;
            } else {
                totalContainer[referenceNo] += tempSubTotal;
            }
        });

        var totals = document.querySelectorAll(".purchase-total");

        totals.forEach(function(total) {
            var totalId = total.getAttribute("data-total-id");
            total.value = totalContainer[totalId].toLocaleString("en-PH", {
                style: "currency",
                currency: "PHP",
            });
        });

        var options = document.querySelectorAll('.payment_type');

        options.forEach(function(option) {
            if (orderRetrieval == 'delivery') {
                if (option.classList.contains('instore')) {
                    option.style.display = 'none';
                }
                if (option.classList.contains('cod')) {
                    option.style.display = 'block';
                }
            } else if (orderRetrieval == 'pickup') {
                if (option.classList.contains('cod')) {
                    option.style.display = 'none';
                }
                if (option.classList.contains('instore')) {
                    option.style.display = 'block';
                }
            }
        });
    }

    function toggleReceiptSubmission(itemId, retrieval) {
        var proofForm = document.querySelector('#proof-of-delivery' + itemId);

        if (proofForm) {
            if (retrieval == 'delivery') {
                proofForm.style.display = 'block';
                // proofForm.querySelector('input[type="file"]').setAttribute('required', 'required');
            } else {
                proofForm.style.display = 'none';
                // proofForm.querySelector('input[type="file"]').removeAttribute('required')
            }
        }
    }

    function toggleDeliveryOptions(itemId, retrieval) {
        let courierOptions = document.querySelector('#courier' + itemId);
        let deliveryOptions = document.querySelector('#delivery' + itemId);

        if (retrieval == 'delivery') {
            courierOptions.style.display = 'block';
            deliveryOptions.style.display = 'block';
        } else if (retrieval == 'pickup') {
            courierOptions.style.display = 'none';
            deliveryOptions.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Hide delivery options if retrieval is pickup

        var orderRetrievals = document.querySelectorAll('.order_retrieval');
        var orderRetrievalValue = '';

        orderRetrievals.forEach(function(orderRetrieval) {

            let itemId = orderRetrieval.getAttribute('data-item-id');

            // orderRetrievalValue = orderRetrieval.value;
            hideOptions(orderRetrieval.value);
            toggleReceiptSubmission(itemId, orderRetrieval.value);

            // console.log(itemId);

            toggleDeliveryOptions(itemId, orderRetrieval.value);

            orderRetrieval.addEventListener('change', function() {

                // orderRetrievalValue = orderRetrieval.value;
                hideOptions(orderRetrieval.value);
                toggleDeliveryOptions(itemId, orderRetrieval.value);
                toggleReceiptSubmission(itemId, orderRetrieval.value);

            });
        });


        // toggle proof of delivery form
        // var paymentConditions = document.querySelectorAll('.payment-condition');

        // paymentConditions.forEach(function(paymentCondition) {

        //     let itemId = paymentCondition.getAttribute('data-item-id');

        //     if (orderRetrievalValue == 'delivery') {
        //         toggleReceiptSubmission(itemId, paymentCondition.value);
        //     }

        //     paymentCondition.addEventListener('change', function() {
        //         if (orderRetrievalValue == 'delivery') {
        //             toggleReceiptSubmission(itemId, paymentCondition.value);
        //         }
        //     });
        // });
    });
</script>
@endsection