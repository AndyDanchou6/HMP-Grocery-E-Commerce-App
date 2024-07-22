<!-- Confirmation Modal -->
<div class="modal fade" id="paidConfirm{{ $referenceNo }}" tabindex="-1" aria-labelledby="confirmationModalLabel{{ $referenceNo }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-wrap" id="confirmationModalLabel{{ $referenceNo }}">Payment Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to mark this payment as paid?
            </div>
            <form action="{{ route('selected-items.updatePaymentCondition', ['referenceNo' => $referenceNo]) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('POST')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="hidden" name="payment_condition" id="payment_condition" value="paid">
                    <button type="submit" class="btn btn-outline-success">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>