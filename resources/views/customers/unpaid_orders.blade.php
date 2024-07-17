<td>
    @if($user['payment_condition'] != 'paid')
    @if($user['payment_type'] == 'G-cash')
    <a class="bi bi-receipt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#paymentProof{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
    @include('selectedItems.modal.customerPaymentProof')
    @endif
    @endif
</td>