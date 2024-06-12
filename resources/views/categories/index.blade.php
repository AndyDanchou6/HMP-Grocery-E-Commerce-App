@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Category</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Product</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    <!-- Table rows will be populated here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/crud/categories/index.js') }}"> </script>

@include('categories.create')
@include('categories.edit')
@include('categories.description')

@endsection