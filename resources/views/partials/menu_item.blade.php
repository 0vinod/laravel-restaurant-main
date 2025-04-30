<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="b-1-category"><small>Category /</small><small id="selected-category-name">{{ $categoryName ?? 'Select a Category' }}</small></div>
    <div class="d-flex gap-2">
        <input type="text" id="menu-search" class="form-control form-control-sm" placeholder="Search menus..." style="width:200px;">

        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            + Add Menu
        </button>
    </div>
</div>

<div id="menu-list" class="list-group">
   
    @forelse($menus as $menu)
    <div class="list-group-item ">
        <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('storage/' . $menu->image) }}" alt="Menu Image" width="40" class="rounded">
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
                data-price="{{ $menu->price }}"
                data-category_id="{{ $menu->category_id }}"
                data-bs-toggle="modal"
                data-bs-target="#editModal">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </button>
            <button class="m-1 btn btn-danger btn-sm delete-btn"
                data-id="{{ $menu->id }}"
                data-bs-toggle="modal"
                data-bs-target="#deleteModal">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
        </div>
    </div>
    @empty
    <p>No menus available for this category.</p>
    @endforelse
</div>