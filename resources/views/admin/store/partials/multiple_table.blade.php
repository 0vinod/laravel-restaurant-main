@foreach($stores as $table)
<div class="col-md-4">
    <div class="table-box position-relative">
        <input type="checkbox">
        <div class="icons">
            <div class="dropdown">
                <button type="button" class="btn btn-outline-primary btn-sm qr-action">
                    <i class="fa fa-qrcode" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu position-absolute bg-white border rounded shadow p-2">
                  {!! QrCode::size(200)->generate(url('restaurant-view'.'?rest='.str_replace(' ', '_', $table->id))) !!}
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm">

                <i class="fa fa-qrcode" aria-hidden="true"></i>
            </button>
            <button type="button">
                <i class="fa fa-download" aria-hidden="true"></i>
            </button>
            <div class="dropdown">
                <span class="action-menu" style="cursor:pointer;">⋮</span>
                <div class="dropdown-menu d-none position-absolute bg-white border rounded shadow p-2">
                    <a href="#" class="dropdown-item edit-table">✏️ Edit</a>
                    <a href="#" class="dropdown-item delete-table text-danger">🗑️ Delete</a>
                </div>
            </div>
        </div>
        <h5 class="text-center mt-2">{{ $table->name }}</h5>
    </div>
</div>


@endforeach