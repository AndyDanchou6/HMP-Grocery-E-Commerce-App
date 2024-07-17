@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-info mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck me-2"></i>
                        <h5 class="card-title mb-0">Delivery Request</h5>
                        <span class="badge bg-info ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" id="deliveryRequest"></span>
                    </div>
                    <a href="{{ route('selectedItems.courierDashboard') }}">
                        <button class="btn btn-info btn-sm mt-3">View here</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-success mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck me-2"></i>
                        <h5 class="card-title mb-0">Complete Delivery</h5>
                        <span class="badge bg-success ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" id="completeDelivery"></span>
                    </div>
                    <button class="btn btn-success btn-sm mt-3">View here</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setInterval(updatePackageCount, 5000);

        function updatePackageCount() {
            fetch('{{ route("selectedItems.courierCount") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    document.getElementById('deliveryRequest').textContent = data.deliveryRequest || '0';
                    document.getElementById('completeDelivery').textContent = data.delivered || '0';
                })
                .catch(error => {
                    console.error('Error fetching counts:', error);
                });
        }

        updatePackageCount();
    });
</script>


@endsection