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
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Product</a>
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
                        @if(Auth::user()->role == 'Admin')
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if($inventories->count() > 0)
                    @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $inventory->category->category_name }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $inventory->product_img) }}" style="width: 45px; height: 45px" alt="Product Image" class="rounded-circle">
                        </td>
                        <td>{{ $inventory->product_name }}</td>
                        <td>{{ $inventory->price }}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>
                            @if($inventory->quantity !== 0)
                            <span class="badge bg-label-success me-1">Available</span>
                            @else
                            <span class="badge bg-label-danger me-1">Out of stock</span>
                            @endif
                        </td>
                        @if(Auth::user()->role == 'Admin')
                        <td>
                            <a class="bx bx-edit-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{$inventory->id}}">
                            </a>
                            @include('inventories.modal.edit')
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$inventory->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            @include('inventories.modal.delete')
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No Products found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('inventories.modal.create')

@endsection