@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4>All your reviews</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Review</a>
            @include('reviews.modal.create')
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $review->inventory->product_name }}</td>
                        <td>
                            @for ($i = 1; $i <= 5; $i++) <i class="bx bx-star{{ $review->rating >= $i ? '' : '-o' }}" style="color: #696cff"></i>
                                @endfor
                        </td>
                        <td>
                            <a class="bx bx-message-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$review->id}}">
                            </a>
                            @include('reviews.modal.description')
                        </td>
                        <td>
                            <a class="bx bx-edit-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{$review->id}}">
                            </a>
                            @include('reviews.modal.edit')
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$review->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            @include('reviews.modal.delete')
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No reviews found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@include('layouts.sweetalert')
@endsection