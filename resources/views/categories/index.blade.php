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
            @if(Auth::user()->role == 'Admin')
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Category</a>
            @endif
            @include('categories.modal.create')
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        @if(Auth::user()->role == 'Admin')
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($categories->count() > 0)
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($category->category_img)
                            <img src="{{ asset('storage/' . $category->category_img) }}" style="width: 45px; height: 45px" alt="Category Image" class="rounded-circle">
                            @else
                            <img src="{{ asset('assets/img/user.png') }}" style="width: 45px; height: 45px" alt="Default Image" class="rounded-circle">
                            @endif
                        </td>
                        <td>{{ $category->category_name }}</td>
                        <td>
                            <a class="bx bx-message-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$category->id}}">
                            </a>
                            @include('categories.modal.description')
                        </td>
                        @if(Auth::user()->role == 'Admin')
                        <td>
                            <a class="bx bx-edit-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{$category->id}}">
                            </a>
                            @include('categories.modal.edit')
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$category->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            @include('categories.modal.delete')
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">No categories found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Pagination -->
            @include('categories.pagination')
        </div>
    </div>
</div>
@include('layouts.sweetalert')

@endsection