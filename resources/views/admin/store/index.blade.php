@extends('layouts.admin')
@section('title', 'Admin - Menu Management')

@section('content')
<style>
    .sidebar-store {
        width: 200px;
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .nav-tabs .nav-link.active {
        background-color: #e9f5f0;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .table-box {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        min-height: 120px;
        position: relative;
    }

    .table-box .icons {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 10px;
    }

    .table-box input[type="checkbox"] {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .table-box-input .row:first-child {
        background: #ced7df;
        padding: 3px;
    }

    .dropzone {
        border: 2px dashed #38b2ac;
        padding: 2rem;
        text-align: center;
        border-radius: 8px;
        color: #4a5568;
        cursor: pointer;
    }

    .dropzone:hover {
        background-color: #f8f9fa;
    }

    .dropdown-menu {
        z-index: 1000;
        min-width: 120px;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="row">
                    <div class="col-md-12 justify-content-start"><span>Menus ds</span></div>
                </div>
                <div class="row">
                    <div class="col-md-12 justify-content-end">
                        <a href="{{ route('admin.menus.dashboard') }}"><i class="bi bi-arrow-left"></i>Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="d-flex">
                    <!-- Sidebar -->
                    <div class="sidebar-store p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong>Stores</strong>
                            <button class="btn btn-sm btn-success add-store">+</button>
                        </div>
                        <ul class="list-group">
                            @foreach($stores as $key => $store)
                            <li class="list-group-item {{ $key == 0 ? 'active' : '' }}" data-store-id="{{$store->id}}">
                                <div class="table-box position-relative" style="min-height: 10px;">
                                    <div class="icons">
                                        <div class="dropdown">
                                            <span class="action-menu" style="cursor:pointer;">⋮</span>
                                            <div class="dropdown-menu d-none position-absolute bg-white border rounded shadow p-2">
                                                <a href="#" class="dropdown-item edit-store" data-store-id="{{ $store->id }}">✏️ Edit</a>
                                                <a href="#" class="dropdown-item delete-store text-danger" data-store-id="{{ $store->id }}">🗑️ Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="text-center mt-2">{{$store->name}}</h5>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Main Content -->
                    <div class="flex-grow-1 p-3">
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Tables</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Opening Hours</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Social Accounts</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">WiFi</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Location Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
                        </ul>

                        <input type="hidden" value="" id="store_id">
                        <section id="adding-table">
                            <!-- Actions -->
                            <div class="d-flex gap-2 mb-3">
                                <button class="btn btn-success add-table-section table-body-box table-body-box-section">+ Add New</button>
                                <button class="btn btn-outline-success table-body-box table-body-box-section">Customize QR Code</button>
                            </div>

                            <!-- Table Cards -->
                            <div class="table-box-input" style="display: none;">

                                <div class="row g-2 mb-3">
                                    <div class="col-1">
                                        <button class="btn btn-success add-table-back-button"><i class="bi bi-arrow-left">Back</i></button>
                                    </div>
                                    <div class="col-4">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Table</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">AddTable</li>
                                            </ol>
                                        </nav>
                                    </div>
                                    <div class="col-7 text-right">
                                        <button class="btn btn-primary save-table">+Save</button>
                                    </div>

                                </div>
                                <div class="row mt-3 add-input-for-table">
                                    <div class="col-7">
                                        <div class="input-group ">
                                            <span class="input-group-text" id="basic-addon1">Name</span>
                                            <input type="text" class="form-control table_name" placeholder="Table Name" aria-label="Table Name" aria-describedby="basic-addon1">
                                            <button class="btn btn-primary add-table">+</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @foreach($stores as $key=> $store)
                            @if(($store->storeTables)->isNotEmpty())
                            <div class="row g-3 table-body-box table-body-box-grid" data-store-id="{{ $store->id }}" style="{{ $key != 0 ? 'display:none' : '' }}">
                                @foreach($store->storeTables as $table)
                                <div class="col-md-4 ">
                                    <div class="table-box position-relative" data-table-id="{{ $table->id }}">
                                        <input type="checkbox">
                                        <div class="icons">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-outline-primary btn-sm qr-action">
                                                    <i class="fa fa-qrcode" aria-hidden="true"></i>
                                                </button>
                                                <div class="dropdown-menu position-absolute bg-white border rounded shadow p-2 `qr-action-tab`">
                                                    {!! QrCode::size(200)->generate(url('restaurant-view'.'?rest='.str_replace(' ', '_', $table->id))) !!}
                                                </div>
                                            </div>
                                            <button type="button">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown">
                                                <span class="action-menu" style="cursor:pointer;">⋮</span>
                                                <div class="dropdown-menu position-absolute bg-white border rounded shadow p-2 action-menu-tab">
                                                    <a href="#" class="dropdown-item edit-table">✏️ Edit</a>
                                                    <a href="#" class="dropdown-item delete-table text-danger">🗑️ Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center mt-2">{{ $table->name }}</h5>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @endforeach
                        </section>

                        <section class="adding-store" style="display: none;">
                            <div class="container-fluid">
                                <div class="d-flex justify-content-between align-items-center mb-3" style=" background: #ced7df;padding: 3px;">
                                    <h5><button class="btn btn-outline-secondary btn-sm me-2">←</button> Store / <span class="text-primary">Add Store</span></h5>
                                    <button class="btn btn-success submit_store">Save</button>
                                </div>

                                <ul class="nav nav-tabs" id="storeTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="store-tab" data-bs-toggle="tab" data-bs-target="#store" type="button" role="tab">🏪 Store</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="localize-tab" data-bs-toggle="tab" data-bs-target="#localize" type="button" role="tab">🌐 Localize</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="storeTabsContent">
                                    <div class="tab-pane fade show active" id="store" role="tabpanel">
                                        <form id="storeForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" placeholder="Enter store name" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="address" placeholder="Enter store address" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Phone number <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">📞</span>
                                                    <input type="tel" class="form-control" name="phone" placeholder="+91 1234567890" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Store logo</label>
                                                <div class="dropzone" onclick="document.getElementById('logoInput').click()">
                                                    <p>Preferred size is 400px × 300px</p>
                                                    <p>Drag ‘n’ drop some files here, or click to select files</p>
                                                </div>
                                                <input type="file" id="logoInput" name="logo" class="d-none" accept="image/*">
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="localize" role="tabpanel">
                                        <p>Localization settings will go here...</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>


            </div>
        </div>
    </div>


    @include('partials.admin.footer')
    @endsection

    @push('scripts')

    <script>
        $(document).ready(function() {

            $('.add-table-section').on('click', function() {
                $('.table-box-input').show();
                $('.table-body-box').hide();
            });

            $(document).on('click', '.save-table', function() {
                let tableNames = [];

                // Collect all table names
                $('.table_name').each(function() {
                    let name = $(this).val().trim();
                    if (name !== '') {
                        tableNames.push(name);
                    }
                });

                if (tableNames.length === 0) {
                    alert('Please enter at least one table name.');
                    return;
                }

                $.ajax({
                    url: "{{ route('stores.tableCreateOrUpdate') }}",
                    method: 'POST',
                    data: {
                        table_names: tableNames,
                        store_id: $('#store_id').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            success('Added One More table.');
                            $('.table-body-box-grid').html(response.tables);
                            $('.table-box-input').hide();
                            $('.table-body-box').show()
                        } else {
                            error('Save failed. Try again.');
                        }
                    },
                    error: function() {
                        alert('Something went wrong.');
                    }
                });
            });

            $(document).on('click', '.add-table', function() {
                let $parentRow = $(this).closest('.add-input-for-table');

                // Change this "+Add" button to a Remove button
                $(this)
                    .removeClass('add-table btn-primary')
                    .addClass('remove-table btn-danger')
                    .text('-');

                // Clone a new row
                let $newRow = $parentRow.clone();

                // Reset the input field and button
                $newRow.find('input.table_name').val('');
                $newRow.find('button')
                    .removeClass('remove-table btn-danger')
                    .addClass('add-table btn-primary')
                    .text('+');

                // Append the new row after current one
                $parentRow.after($newRow);
            });

            // Remove table input row
            $(document).on('click', '.remove-table', function() {
                $(this).closest('.add-input-for-table').remove();
            });


            $('.add-store, .edit-store').on('click', function() {
                $('section').hide();

                $('.adding-store').show()

                if ($(this).hasClass('edit-store')) {
                    const storeId = $(this).data('store-id');

                    $.ajax({
                        url: `/admin/stores/${storeId}/edit`,
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                const store = response.store;

                                // Show the store form
                                $('.adding-store').show();
                                $('.table-body-box').hide();

                                // Fill form inputs
                                $('input[name="name"]').val(store.name);
                                $('input[name="address"]').val(store.address);
                                $('input[name="phone"]').val(store.phone);

                                // Save store ID for update
                                $('#storeForm').append(`<input type="hidden" name="store_id" value="${store.id}" />`);
                            }
                        },
                        error: function() {
                            alert('Failed to fetch store data');
                        }
                    });
                }
            })

            $('.submit_store').on('click', function() {
                $('#storeForm').submit();
            });

            $('#storeForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('stores.storeCreateOrUpdate') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            if ($('.sidebar-store .list-group .list-group-item').length > 0) {
                                $('.sidebar-store .list-group .list-group-item').removeClass('active');
                            }

                            const storeId = response.store.id;
                            const storeName = response.store.name;

                            let existingItem = $(`.sidebar-store .list-group .list-group-item[data-store-id="${storeId}"]`);

                            if (existingItem.length > 0) {
                                // If exists, update its name and make it active
                                existingItem.addClass('active');
                                existingItem.find('h5').text(storeName); // for structure with <h5>
                            } else {
                                $('#store_id').val(response.store.id);

                                $('.sidebar-store .list-group').append(`<li class="list-group-item active" data-store-id="${response.store.id}"><div class="table-box position-relative" style="min-height: 10px;">
                                    <div class="icons">
                                        <div class="dropdown">
                                            <span class="action-menu" style="cursor:pointer;">⋮</span>
                                            <div class="dropdown-menu d-none position-absolute bg-white border rounded shadow p-2">
                                                <a href="#" class="dropdown-item edit-store" data-store-id="${response.store.id}">✏️ Edit</a>
                                                <a href="#" class="dropdown-item delete-store text-danger" data-store-id="${response.store.id}">🗑️ Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="text-center mt-2">${response.store.name}</h5>
                                </div>
                            </li>`)

                            }
                            success('Store saved successfully!');

                            $('section').show();

                            $('.adding-store').hide()

                            $('#storeForm')[0].reset();
                        } else {
                            alert('Failed to save store.');
                        }
                    },
                    error: function(xhr) {
                        alert('Validation error: ' + xhr.responseJSON.message);
                    }
                });
            });

            $('.sidebar-store .list-group').on('click', '.list-group-item', function() {
                // Remove active from all, add to clicked one
                $('.list-group-item').removeClass('active');
                $(this).addClass('active');

                // Get store ID
                const storeId = $(this).data('store-id');
                $('#store_id').val(storeId)
                // Hide all table boxes, then show only selected
                $('.table-body-box').hide();
                $('.table-body-box-section').show();
                $(`.table-body-box[data-store-id="${storeId}"]`).show();
            });


            // Toggle dropdown menu
            $(document).on('click', '.action-menu', function(e) {
                e.stopPropagation(); // Prevent click bubbling
                $('.action-menu-tab').addClass('d-none'); // Close others
                $(this).siblings('.action-menu-tab').toggleClass('d-none');
                $(this).siblings('.action-menu-tab').show()
            });

        $(document).on('click', '.qr-action', function(e) {
                e.stopPropagation(); // Prevent click bubbling

                $(this).siblings('.qr-action-tab').toggle('show')
            });

                $(document).on('click', function() {
                $('.dropdown-menu').addClass('d-none');
            });
            // Hide dropdown on document click
      

            // Edit table
            $(document).on('click', '.edit-table', function(e) {
                e.preventDefault();
                let $box = $(this).closest('.table-box');
                let currentName = $box.find('h5').text().trim();
                let newName = prompt('Edit Table Name:', currentName);
                if (newName && newName !== currentName) {
                    $.ajax({
                        url: "{{ route('stores.tableCreateOrUpdate') }}",
                        method: 'POST',
                        data: {
                            table_names: [newName],
                            table_id: $box.data('table-id'),
                            store_id: $('#store_id').val(),
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $box.find('h5').text(newName);
                                success('Table updated successfully');
                            } else {
                                error('Update failed');
                            }
                        },
                        error: function() {
                            alert('Something went wrong');
                        }
                    });
                }
            });

            // Delete table
            $(document).on('click', '.delete-table', function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete this table?')) return;

                let $box = $(this).closest('.table-box');

                $.ajax({
                    url: "{{ route('stores.tableDelete') }}", // Create this route
                    method: 'DELETE',
                    data: {
                        table_id: $box.data('table-id'),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $box.closest('.col-md-4').remove();
                            success('Table deleted successfully');
                        } else {
                            error('Delete failed');
                        }
                    },
                    error: function() {
                        alert('Something went wrong');
                    }
                });
            });

        });
    </script>

    @endpush