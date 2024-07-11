<!-- Modal Template -->
<div class="modal fade" id="proof{{$user['referenceNo']}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryTitle">{{ $user['name'] }}'s Delivery Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user['phone'] }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fb_link" class="col-sm-2 col-form-label">Facebook Link</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user['fb_link'] }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" readonly>{{ $user['address'] }}</textarea>
                    </div>
                </div>
                <div class="col-sm-12">
                    <hr>
                </div>
                @foreach($user['items'] as $item)
                @endforeach
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Proof of Delivery:</label>
                    <div class="col-sm-10 text-center">
                        @if($user['proof_of_delivery'])
                        <img src="{{ asset('storage/' . $item['proof_of_delivery']) }}" class="img-fluid mx-auto d-block" alt="Proof of Delivery" style="max-width: 100%; max-height: 400px;">
                        @else
                        <p>No proof of delivery available.</p>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="courier_id" class="col-form-label">Courier Name:</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $user['courier_id'] }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="payment_type" class="col-form-label">Payment Type:</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $user['payment_type'] }}" readonly>
                    </div>
                </div>
                @if($user['proof_of_delivery'])
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="payment_type" class="col-form-label">Date Delivered:</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($item->updated_at)->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}" readonly>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    @if($item['payment_proof'] != NULL)
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
    </div>
    @endif
</div>