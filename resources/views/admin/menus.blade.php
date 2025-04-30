@extends('layouts.admin')

@push('styles')
    <!-- base:css -->
    <link rel="stylesheet" href="/admin_resources/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="/admin_resources/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin_resources/css/vertical-layout-light/style.css">

    <!-- Add Font Awesome if you're using its icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@section('title', 'Admin - Menu Management')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @include('partials.message-bag')

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Menus ({{ $categories->sum(fn($category) => $category->menus->count()) }})</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left Sidebar for Categories -->
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>Categories</h5>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModalcategory">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <ul class="list-group">
                                @foreach ($categories as $category)
                                    <li class="list-group-item category-item {{ $loop->first ? 'active' : '' }}"
                                        data-category-id="{{ $category->id }}" 
                                        data-category-name="{{ $category->name }}"
                                        style="cursor: pointer;">
                                        {{ $category->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Right Side for Menus -->
                        <div class="col-md-9" id="menuItemGet">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="b-1-category">
                                    <small>Category /</small>
                                    <small id="selected-category-name">{{ $categories->first()->name ?? 'Select a Category' }}</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <input type="text" id="menu-search" class="form-control form-control-sm"
                                        placeholder="Search menus..." style="width:200px;">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                                        <i class="fa fa-plus"></i> Add Menu
                                    </button>
                                </div>
                            </div>

                            <div id="menu-list" class="list-group">
                                @if($categories->first())
                                    @forelse ($categories->first()->menus as $menu)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                                                    width="40" class="rounded trigger-lightbox" data-bs-toggle="modal" 
                                                    data-bs-target="#imageModal" data-image="{{ asset('storage/' . $menu->image) }}"
                                                    style="cursor: pointer;">
                                                <div class="ml-2">
                                                    <div>{{ $menu->name }}</div>
                                                    <small>{{ $menu->description }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <strong>{!! $site_settings->currency_symbol !!} {{ $menu->price }}</strong>
                                                <button class="m-1 btn btn-primary btn-sm edit-btn"
                                                    data-id="{{ $menu->id }}" 
                                                    data-name="{{ $menu->name }}"
                                                    data-description="{{ $menu->description }}"
                                                    data-price="{{ $menu->price_options }}"
                                                    data-category_id="{{ $menu->category_id }}" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="m-1 btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $menu->id }}" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <p>No menus available for this category.</p>
                                    @endforelse
                                @else
                                    <p>No categories available. Please create a category first.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Category Modal -->
            <div class="modal fade" id="createModalcategory" tabindex="-1" aria-labelledby="createModalcategoryLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalcategoryLabel">Add New Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="name">Category Name</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea rows="3" name="description" class="form-control" id="description"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lightbox Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Menu Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="" alt="menu image" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Menu Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Add Menu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="add-name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="add-name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add-description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="add-description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Price Options</label>
                                    <div id="add-price-options-container">
                                        <div class="row price-option mb-2">
                                            <div class="col-md-5">
                                                <select name="price_options[0][name]" class="form-control">
                                                    <option value="small">Small</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="large">Large</option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="number" step="0.01" name="price_options[0][price]"
                                                    class="form-control"
                                                    placeholder="Price ({{ $site_settings->currency_symbol }})">
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center">
                                                <button type="button" class="btn btn-success btn-sm add-price-option">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info" role="alert">
                                    <i class="fa fa-info-circle"></i> Recommended image size is <strong>500 x 400</strong>. 
                                    Uploaded images will be cropped to recommended size.
                                </div>

                                <div class="mb-3">
                                    <label for="add-image" class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control" id="add-image" accept="image/*" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="add-category_id" class="form-label">Category</label>
                                    <select name="category_id" class="form-control" id="add-category_id" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Menu Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Menu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="editName" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="editName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editDescription" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="editDescription" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Price Options</label>
                                    <div id="edit-price-options-container">
                                        <div class="row price-option mb-2">
                                            <div class="col-md-5">
                                                <select name="price_options[0][name]" class="form-select price-name-select">
                                                    <option value="small">Small</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="large">Large</option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="number" step="0.01" name="price_options[0][price]" class="form-control"
                                                    placeholder="Price ({{ $site_settings->currency_symbol }})">
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center">
                                                <button type="button" class="btn btn-success btn-sm add-price-option">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info" role="alert">
                                    <i class="fa fa-info-circle"></i> Recommended image size is <strong>500 x 400</strong>. 
                                    Uploaded images will be cropped to recommended size.
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editImage" class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control" id="editImage" accept="image/*">
                                    <small class="text-muted">Leave empty to keep current image</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editCategory" class="form-label">Category</label>
                                    <select name="category_id" class="form-control" id="editCategory" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Menu Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Menu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this menu?</p>
                                <p class="text-danger"><i class="fa fa-exclamation-triangle"></i> This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        @include('partials.admin.footer')
    </div>
@endsection

@push('scripts')
    <!-- Core JS files -->
    <script src="/admin_resources/vendors/js/vendor.bundle.base.js"></script>
    <script src="/admin_resources/js/off-canvas.js"></script>
    <script src="/admin_resources/js/hoverable-collapse.js"></script>
    <script src="/admin_resources/js/template.js"></script>
    <script src="/admin_resources/js/settings.js"></script>
    <script src="/admin_resources/js/todolist.js"></script>
    
    <!-- Plugin JS -->
    <script src="/admin_resources/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="/admin_resources/vendors/chart.js/Chart.min.js"></script>
    <script src="/admin_resources/js/dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
    <script>
        $(document).ready(function() {

            
            // Edit Modal
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let description = $(this).data('description');
                // Expected structure: price is an array of objects with 'name' and 'price' properties
                let price = $(this).data('price_options');

                console.log(price);
                if (Array.isArray(price) && price.every(item => item.name && item.price)) {
                    $('#edit-price-options-container').empty();
                    price.forEach((option, index) => {
                        const priceOptionRow = `
                            <div class="row price-option mb-2">
                                <div class="col-md-5">
                                    <select name="price_options[${index}][name]" class="form-control">
                                        <option value="small" ${option.name === 'small' ? 'selected' : ''}>Small</option>
                                        <option value="medium" ${option.name === 'medium' ? 'selected' : ''}>Medium</option>
                                        <option value="large" ${option.name === 'large' ? 'selected' : ''}>Large</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" step="0.01" name="price_options[${index}][price]" class="form-control" 
                                           placeholder="Price ({{ $site_settings->currency_symbol }})" value="${option.price}">
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-price-option">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>`;
                        $('#edit-price-options-container').append(priceOptionRow);
                    });
                } else {
                    $('#edit-price-options-container').empty();
                }
                // Assuming price is an array of objects with name and price properties
                // You might need to handle this differently based on your backend structure
                // If you have multiple price options, you might want to loop through them
                let category_id = $(this).data('category_id');

                let actionUrl = "{{ route('admin.menus.update', ':id') }}".replace(':id', id);

                $('#editName').val(name);
                $('#editDescription').val(description);
                $('#editCategory').val(category_id);
                $('#editForm').attr('action', actionUrl);
                
                // For price options, we'll need to load them via AJAX or predefine them
                // This depends on how your backend handles price options
            });

            // Delete Modal
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                let actionUrl = "{{ route('admin.menus.destroy', ':id') }}".replace(':id', id);
                $('#deleteForm').attr('action', actionUrl);
            });

            // Menu Search
            $(document).on('input', '#menu-search', function() {
                const keyword = $(this).val().toLowerCase().trim();
                
                $('#menu-list .list-group-item').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(keyword));
                });
            });
            
            // Image Lightbox
            $(document).on('click', '.trigger-lightbox', function() {
                const imageUrl = $(this).data('image');
                $('#modalImage').attr('src', imageUrl);
            });

            // Category Selection
            $('.category-item').on('click', function() {
                // Remove active class from all categories
                $('.category-item').removeClass('active');
                
                // Add active class to clicked category
                $(this).addClass('active');
                
                const categoryId = $(this).data('category-id');
                const categoryName = $(this).data('category-name');
                
                // Update selected category name
                $('#selected-category-name').text(categoryName);
                
                // Set the default category in the add menu form
                $('#add-category_id').val(categoryId);
                
                // Fetch menus for selected category via AJAX
                $.ajax({
                    url: `menus-by-category/${categoryId}`,
                    type: 'GET',
                    success: function(response) {
                        $('#menuItemGet').html(response);
                        
                        // Re-initialize any JS components that might be in the response
                        initializeEventHandlers();
                    },
                    error: function(xhr) {
                        console.error('Error loading menus:', xhr.responseText);
                    }
                });
            });



            // Set up price option management
            let index = 1;
            
            function getNewRow(i) {
                return `
                <div class="row price-option mb-2">
                    <div class="col-md-5">
                        <select name="price_options[${i}][name]" class="form-control">
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="large">Large</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="number" step="0.01" name="price_options[${i}][price]" class="form-control" 
                               placeholder="Price ({{ $site_settings->currency_symbol }})">
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm remove-price-option">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>`;
            }
            
            // Function to initialize event handlers for dynamically loaded content
            function initializeEventHandlers() {
                // Initialize any JS components that might be in dynamically loaded content
                $('.trigger-lightbox').on('click', function() {
                    const imageUrl = $(this).data('image');
                    $('#modalImage').attr('src', imageUrl);
                });
            }

            $(document).on('click', '.add-price-option', function() {
                const container = $(this).closest('.modal-body').find('[id$=price-options-container]');
                const $newRow = $(getNewRow(index));
                container.append($newRow);
              
                index++;
            });

            // Remove price option row
            $(document).on('click', '.remove-price-option', function() {
                $(this).closest('.price-option').remove();
            });
             
        });
    </script>
@endpush