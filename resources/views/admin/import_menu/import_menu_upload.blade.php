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
                    <!-- Top Navigation -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('admin.sample_menu_import') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h6 class="text-muted m-0">Import menu from template</h6>
                        <button class="btn btn-secondary" disabled>Next</button>
                    </div>

                    <!-- Step Progress -->
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-success text-white d-inline-block" style="width: 25px; height: 25px;">✔</div>
                            <div class="mt-1">Download</div>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-success text-white d-inline-block" style="width: 25px; height: 25px;">2</div>
                            <div class="fw-bold mt-1">Upload</div>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-inline-block" style="width: 25px; height: 25px;">3</div>
                            <div class="mt-1">Review</div>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-inline-block" style="width: 25px; height: 25px;">4</div>
                            <div class="mt-1">Finish</div>
                        </div>
                    </div>

                    <!-- Upload Drop Zone -->
                    <form action="{{ route('import.menu.upload') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                        @csrf
                        <div class="border border-success border-dashed p-5 text-center" style="border-style: dashed !important;">
                            <input type="file" name="menu_file" id="menu_file" class="d-none" accept=".xlsx">
                            <label for="menu_file" class="cursor-pointer">
                                <i class="fas fa-upload fa-2x text-success mb-2"></i>
                                <div class="fw-bold">Click or drag file to upload</div>
                                <div class="text-muted">Only .xlsx files are supported</div>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    @include('partials.admin.footer')

    @endsection

    @push('scripts')
    <script>
        // Optional: submit form automatically on file selection
        document.getElementById('menu_file').addEventListener('change', function() {
            if (this.files.length > 0) {
                document.getElementById('upload-form').submit();
            }
        });
    </script>
    @endpush