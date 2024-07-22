<!-- Modal Template for Payment Proof -->
<div class="modal fade" id="paymentProof{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-wrap">{{ $user['name'] }}'s Gcash Payment Proof</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Current Payment Proof:</label>
                    <div class="col-sm-9 text-center">
                        @foreach($user['items'] as $item)
                        @endforeach
                        @if($item['payment_proof'])
                        <img id="paymentProofImage{{$user['referenceNo']}}" src="{{ asset('storage/' . $item['payment_proof']) }}" class="img-fluid mx-auto d-block img-thumbnail" alt="Current Payment Proof" style="max-width: 100%; max-height: 400px; border: 2px solid #696cff;">
                        @else
                        <div id='newPaymentProofImage{{$user["referenceNo"]}}'>
                            No payment proof available.
                        </div>
                        @endif
                    </div>

                </div>
                @if($item['payment_proof'])
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Reference No.</label>
                    <div class="col-sm-9 text-center">
                        <input type="text" class="form-control text-info" name="referenceNo" id="" value="{{ $item['referenceNo'] }}" readonly>
                    </div>
                </div>
                @endif
                <form id="paymentProofForm{{$user['referenceNo']}}" action="{{ route('selected-items.updatePaymentCondition', ['referenceNo' => $user['referenceNo']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        @if($user['payment_proof'])
                        <input type="hidden" name="payment_condition" id="payment_condition" value="paid">
                        <button type="submit" class="btn btn-outline-success">Paid</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('payment_proof{{$user["referenceNo"]}}');
        if (fileInput) {
            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageSrc = e.target.result;
                    const paymentProofImage = document.getElementById('paymentProofImage{{$user["referenceNo"]}}');
                    const newPaymentProofImage = document.getElementById('newPaymentProofImage{{$user["referenceNo"]}}');

                    if (paymentProofImage) {
                        paymentProofImage.src = imageSrc;
                    }

                    if (newPaymentProofImage) {
                        newPaymentProofImage.innerHTML = '<img src="' + imageSrc + '" class="img-fluid mx-auto d-block img-thumbnail" style="max-width: 100%; max-height: 400px; border: 2px solid #696cff;" alt="New Payment Proof">';
                    }
                };
                reader.readAsDataURL(file);
            });
        }
    });
</script>