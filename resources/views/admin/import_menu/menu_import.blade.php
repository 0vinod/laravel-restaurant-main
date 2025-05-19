@extends('layouts.admin')

@section('title', 'Admin - Menu Management')

@section('content')
<!-- Add in your layout file head -->

<div class="main-panel">
    <div class="content-wrapper p-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

            </div>
            <div class="card-body p-3">
                <div class="container py-4">
                    <!-- Top Bar -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h6 class="text-muted m-0">Import menu from template</h6>
                        <a href="{{route('import.menu.upload.view')}}" class="btn btn-success">Next</a>
                    </div>

                    <!-- Step Progress -->
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-success text-white d-inline-block" style="width: 25px; height: 25px; line-height: 25px;">1</div>
                            <div class="fw-bold mt-1">Download</div>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-inline-block" style="width: 25px; height: 25px; line-height: 25px;">2</div>
                            <div class="mt-1">Upload</div>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-inline-block" style="width: 25px; height: 25px; line-height: 25px;">3</div>
                            <div class="mt-1">Review</div>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-inline-block" style="width: 25px; height: 25px; line-height: 25px;">4</div>
                            <div class="mt-1">Finish</div>
                        </div>
                    </div>

                    <!-- Centered Illustration -->
                    <div class="text-center">
                        <img src="{{ asset('images/import-illustration.png') }}" alt="Illustration" class="mb-4" style="max-width: 200px;">

                        <h5 class="fw-bold">Please download the sample sheet below and fill it with your items</h5>
                        <p class="text-muted">You may skip if you already have the sample sheet</p>

                        <a href="{{ route('import.sample.download') }}" class="btn btn-outline-success">
                            <i class="fas fa-download me-1"></i> Download template
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap JS Bundle -->
    @include('partials.admin.footer')

    @endsection

    @push('scripts')
    <script src="{{ asset('/assets/js/menu_management.js') }}"></script>
    @endpush