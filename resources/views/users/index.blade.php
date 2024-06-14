@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Users</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Product</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Avatar</th>
                        <th>Username</th>
                        <th>Email</th>
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
                            @else
                            <span class="badge bg-label-primary me-1">Customer</span>
                            @endif
                        </td>
                        <td>
                            @if($user->avatar)
                            <img src="{{asset('storage/' . Auth()->user()->avatar)}}" id="user_avatar_modal" alt="User Avatar" class="w-px-40 h-auto rounded-circle" />
                            @else
                            <img src="{{ asset('assets/img/user.png') }}" id="user_avatar_modal" alt="User Avatar" class="w-px-40 h-auto rounded-circle" />
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>
                        <td>
                            <a class="bx bx-edit-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}">
                                <i class=" bi bi-pencil"></i>
                            </a>
                            @include('users.edit')
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="text-center">No User found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('users.create')
@endsection