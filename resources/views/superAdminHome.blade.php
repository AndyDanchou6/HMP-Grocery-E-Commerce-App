@extends('app')

@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card shadow-none bg-transparent border border-primary mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-user me-2"></i>
                            <h5 class="card-title mb-0">Total Users Registered</h5>
                            <span class="badge bg-primary ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">{{ $user }}</span>
                        </div>
                        <a href="{{ route('users.index') }}">
                            <button class="btn btn-primary btn-sm mt-3">View here</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection