@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Category</h4>
            <form action="{{ route('categories.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($carts->count() > 0)
                    @foreach ($carts as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->inventory->product_name }}</td>
                        <td>{{ $item->inventory->price }}</td>
                        <td>
                            {{ $item->quantity }}
                        </td>
                        <td>${{ $item->inventory->price * $item->quantity }}</td>
                        <td> <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            @include('carts.modal.delete')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">No carts found.</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Total: {{ $cartTotal }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
        </div>
    </div>
</div>
@include('layouts.sweetalert')

@endsection