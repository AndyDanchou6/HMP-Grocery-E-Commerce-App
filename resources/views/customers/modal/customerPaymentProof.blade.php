<div class="modal fade" id="paymentProof{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $user['name'] }}'s Gcash Payment</h5>
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

                <form id="paymentProofForm{{$user['referenceNo']}}" action="{{ route('selected-items.updatePaymentCondition', ['referenceNo' => $user['referenceNo']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <label for="payment_proof{{$user['referenceNo']}}" class="col-sm-3 col-form-label">Upload New Proof:</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="payment_proof{{$user['referenceNo']}}" name="payment_proof" accept="image/*">
                            <small id="fileErrorSize" class="form-text text-danger" style="display: none;">The selected file exceeds 2 MB. Please choose a smaller file.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-warning" id="pendingButton{{$user['referenceNo']}}">Pending</button>
                        <button type="submit" class="btn btn-outline-primary" id="uploadButton{{$user['referenceNo']}}" style="display: none;">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('payment_proof{{$user["referenceNo"]}}');
        const uploadButton = document.getElementById('uploadButton{{$user["referenceNo"]}}');
        const pendingButton = document.getElementById('pendingButton{{$user["referenceNo"]}}');
        if (fileInput) {
            fileInput.addEventListener('change', function(event) {
                var file = event.target.files[0];
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

                if (file) {
                    uploadButton.style.display = 'block';
                    pendingButton.style.display = 'none';
                } else {
                    uploadButton.style.display = 'none';
                    pendingButton.style.display = 'block';
                }

            });
        }
    });
</script>
<script>
    document.getElementById('payment_proof{{$user["referenceNo"]}}').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const errorMessage = document.getElementById('fileErrorSize');

        if (file && file.size > 2 * 1024 * 1024) {
            errorMessage.style.display = 'block';
            event.target.value = '';
        } else {
            errorMessage.style.display = 'none';
        }
    });
</script>