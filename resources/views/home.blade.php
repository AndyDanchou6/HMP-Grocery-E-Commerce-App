@extends('app')

@section('content')
@if(Auth::user()->role == 'Admin')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-primary mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-box-seam me-2"></i>
                        <h5 class="card-title mb-0">Package</h5>
                        <span class="badge bg-primary ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">{{ $package }}</span>
                    </div>
                    <a href="{{ route('selectedItems.forPackaging') }}">
                        <button class="btn btn-primary btn-sm mt-3">View here</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-success mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck me-2"></i>
                        <h5 class="card-title mb-0">Delivery</h5>
                        <span class="badge bg-success ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">{{ $delivery }}</span>
                    </div>
                    <a href="{{ route('selectedItems.forDelivery') }}">
                        <button class="btn btn-success btn-sm mt-3">View here</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-info mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-bag me-2"></i>
                        <h5 class="card-title mb-0">Pickup</h5>
                        <span class="badge bg-info ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">{{ $pickup }}</span>
                    </div>
                    <a href="{{ route('selectedItems.forPickup') }}">
                        <button class="btn btn-info btn-sm mt-3">View here</button>
                    </a>
                </div>
            </div>
        </div>



        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                    <h4 style="margin: auto 0; color: red;">Critical Products</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                @if(Auth::user()->role == 'Admin')
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="tableBody">
                            @if($inventories->count() > 0)
                            @foreach ($inventories as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>
                                    @if($item->quantity)
                                    <span class="badge bg-label-danger me-1">{{ $item->quantity}}</span>
                                    @elseif($item->quantity == 0)
                                    <span class="badge bg-label-danger me-1">0</span>
                                    @endif
                                </td>
                                @if(Auth::user()->role == 'Admin')
                                <td>
                                    <a class="bx bx-edit-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{$item->id}}">
                                    </a>
                                    @include('inventories.modal.edit')
                                    <a href="{{ route('inventories.index') }}" class="bi bi-arrow-right-short me-1"></a>
                                    <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="9" class="text-center">No critical products found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @include('inventories.pagination')
            </div>
        </div>
    </div>
</div>
@elseif(Auth::user()->role == 'Courier')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-info mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck me-2"></i>
                        <h5 class="card-title mb-0">Delivery Request</h5>
                        <span class="badge bg-info ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">{{ $deliveryRequest }}</span>
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
                        <span class="badge bg-success ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">{{ $delivered }}</span>
                    </div>
                    <button class="btn btn-success btn-sm mt-3">View here</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection