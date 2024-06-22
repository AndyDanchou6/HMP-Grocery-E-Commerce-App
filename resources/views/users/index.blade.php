@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Users</h4>
            <form action="{{ route('users.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </form>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add New</a>
        </div>
        @include('layouts.sweetalert')
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Avatar</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>More Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->count() > 0)
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($user->role == 'Admin')
                            <span class="badge bg-label-success me-1">Admin</span>
                            @elseif($user->role == 'Courier')
                            <span class="badge bg-label-info me-1">Courier</span>
                            @else
                            <span class="badge bg-label-primary me-1">Customer</span>
                            @endif
                        </td>
                        <td>
                            @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" style="width: 45px; height: 45px" alt="User Avatar" class="rounded-circle">
                            @else
                            <img src="{{ asset('assets/img/user.png') }}" style="width: 45px; height: 45px" alt="Default Avatar" class="rounded-circle">
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a class="bx bx-message-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$user->id}}">
                            </a>
                            @include('users.modal.moreInfo')
                        </td>
                        <td>
                            <a class="bx bx-edit-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}">
                            </a>
                            @include('users.modal.edit')
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            @include('users.modal.delete')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No User found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Pagination and Results Display -->
            @include('users.pagination')
        </div>
    </div>
</div>

@include('users.modal.create')

@endsection