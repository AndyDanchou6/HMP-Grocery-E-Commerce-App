@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Inventory</h4>
            <form action="{{ route('inventories.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search product..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </form>
            @if(Auth::user()->role == 'Admin')
            <a href="#" class="btn btn-primary my-auto ms-2" data-bs-toggle="modal" data-bs-target="#createModal">Add Product</a>
            @endif
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>More Info</th>
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
                        <td><span class="badge bg-label-primary me-1">{{ $item->category->category_name }}</span></td>
                        <td>
                            <img src="{{ asset('storage/' . $item->product_img) }}" style="width: 45px; height: 45px" alt="Product Image" class="rounded-circle">
                        </td>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-dark">₱{{ number_format($item->price, 2) }}</td>
                        <td>
                            @if($item->quantity <= 10) <span class="badge bg-label-danger me-1">{{ $item->quantity }}</span>
                                @elseif($item->quantity <= 20) <span class="badge bg-label-warning me-1">{{ $item->quantity }}</span>
                                    @else <span class="badge bg-label-success me-1">{{ $item->quantity }}</span>
                                    @endif
                        <td>
                            @if($item->quantity !== 0)
                            <span class="badge bg-label-success me-1">Available</span>
                            @else
                            <span class="badge bg-label-danger me-1">Out of stock</span>
                            @endif
                        </td>
                        <td>
                            <a class="bx bx-message-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$item->id}}">
                            </a>
                            @include('inventories.modal.information')
                        </td>
                        @if(Auth::user()->role == 'Admin')
                        <td>
                            <a class="bx bx-edit-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{$item->id}}">
                            </a>
                            @include('inventories.modal.edit')
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            @include('inventories.modal.delete')
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="9" class="text-center">No Products found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @include('inventories.pagination')
    </div>
</div>

@include('inventories.modal.create')

@endsection