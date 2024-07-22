@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Set Service Fees</h4>
            <form action="{{ route('serviceFee.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search Schedule..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </form>
            @if(Auth::user()->role == 'Admin')
            <a href="#" class="btn btn-primary my-auto ms-2 ml-2s" data-bs-toggle="modal" data-bs-target="#createModal">Add Fee</a>

            @include('serviceFee.modal.create')
            @endif
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fee Name</th>
                        <th>Location</th>
                        <th>Value</th>
                        @if(Auth::user()->role == 'Admin')
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($serviceFee->count() > 0)
                    @foreach ($serviceFee as $fee)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @if($fee->fee_name)
                        <td>{{ $fee->fee_name }}</td>
                        @else
                        <td>Not Specified</td>
                        @endif
                        <td>{{ $fee->location }}</td>
                        <td>₱ {{ $fee->fee }}</td>
                        @if(Auth::user()->role == 'Admin')
                        <td>

                            <a class="bx bx-edit-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{$fee->id}}"></a>
                            @include('serviceFee.modal.edit')
                            <a href="#" class="bx bx-trash me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{$fee->id}}"></a>
                            @include('serviceFee.modal.delete')

                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">No service fee found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
@include('layouts.sweetalert')

@endsection