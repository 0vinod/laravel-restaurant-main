@extends('layouts.admin')

@section('title', 'Admin - Menu Management')

@section('content')
<div class="main-panel">
    <div class="content-wrapper p-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
            <div class="row">
                    <div class="col-md-12 justify-content-start">
                        <h3>Menu</h3><span>
                            Craft Your Digital Menu </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 justify-content-end">
                        <a href="{{route('admin.sample_menu_import')}}" class="btn btn-success">Import Menu</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <!-- Add New Button and Info Box -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <button class="btn btn-success add-menu-btn">+ Add New</button>
                    <div class="alert alert-info mb-0 p-2">
                        Go to Store settings to connect your favorite menu
                    </div>
                </div>

                <!-- Card Grid -->
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    <!-- Sample Menu Card -->
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <img src="{{ asset('images/menu-icon.png') }}" class="mb-3" alt="Menu Icon" style="width:50px;">
                                <h5 class="card-title">Sample menu name</h5>
                                <span class="badge bg-success">Connected</span>
                            </div>
                        </div>
                    </div> -->

                    <!-- Dinning Menu Card -->
                    @foreach ($menuType as $menu)
                    <div class="col-md-3 col-sm-6 col-12" id="menu-card-{{ $menu->id }}">
                        <div class="card h-100 text-center">
                            <div class="card-header text-end">
                                <button class="btn btn-primary btn-sm edit-menu-btn" data-id="{{ $menu->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-menu-btn" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <a href="{{route('admin.menus.index',[$menu])}}">
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="mb-3" style="width:50px;">
                                    <h5 class="card-title">{{ $menu->name }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Add New Card -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="card h-100 d-flex justify-content-center align-items-center add-menu-btn" style="min-height: 180px;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="RestaurantMenuIcon">
                                <path d="m8.1 13.34 2.83-2.83L3.91 3.5c-1.56 1.56-1.56 4.09 0 5.66l4.19 4.18zm6.78-1.81c1.53.71 3.68.21 5.27-1.38 1.91-1.91 2.28-4.65.81-6.12-1.46-1.46-4.2-1.1-6.12.81-1.59 1.59-2.09 3.74-1.38 5.27L3.7 19.87l1.41 1.41L12 14.41l6.88 6.88 1.41-1.41L13.41 13l1.47-1.47z"></path>
                            </svg>
                            <button class="btn btn-success btn-lg rounded-circle " type="button">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas for Adding/Editing Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Add New Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="menu-type-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="menu_id">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" required>
                    <div class="error text-danger"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                    <div class="error text-danger"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" id="menu-image">
                    <div class="error text-danger"></div>

                    <!-- Current image preview (for edit) -->
                    <div id="current-image-container" style="display: none;" class="mt-2">
                        <label>Current Image:</label>
                        <img src="" id="current-image-preview" width="100" class="d-block">
                    </div>

                    <!-- New image preview -->
                    <div id="new-image-container" style="display: none;" class="mt-2">
                        <label>New Image:</label>
                        <img src="" id="new-image-preview" width="100" class="d-block">
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100" id="saveMenuBtn">
                    Create Menu
                </button>
            </form>
        </div>
    </div>



    <!-- Bootstrap JS Bundle -->
    @include('partials.admin.footer')

    @endsection

    @push('scripts')
    <script src="{{ asset('/assets/js/menu_management.js') }}"></script>
    @endpush