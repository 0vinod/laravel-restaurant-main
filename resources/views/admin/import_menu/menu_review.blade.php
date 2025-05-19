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
                        <a href="{{route('import.menu.upload.approve')}}" class="btn btn-success">Next</a>
                    </div>

                    <!-- Step Progress -->
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-inline-block" style="width: 25px; height: 25px; line-height: 25px;">1</div>
                            <div class="fw-bold mt-1">Download</div>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-inline-block" style="width: 25px; height: 25px; line-height: 25px;">2</div>
                            <div class="mt-1">Upload</div>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle bg-success text-white d-inline-block" style="width: 25px; height: 25px; line-height: 25px;">3</div>
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
                        <!-- Add Alpine.js -->
                        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                        <!-- Accordion Menu -->
                        <div x-data="{ openIndex: null }" class="max-w-2xl mx-auto mt-10 space-y-4">

                            @foreach($menu->groupBy('category_id') as $index => $categoryMenus)
                            @php $category = $categoryMenus->first()?->category; @endphp

                            <div class="border border-gray-300 rounded-xl shadow-sm overflow-hidden bg-white">
                                <!-- Category Header -->
                                <button
                                    @click="openIndex === {{ $index }} ? openIndex = null : openIndex = {{ $index }}"
                                    class="w-full flex justify-between items-center px-6 py-4 bg-gradient-to-r from-orange-400 to-yellow-300 text-white text-lg font-semibold rounded-t-xl focus:outline-none transition-all">
                                    <span>{{ $category?->name ?? 'Uncategorized' }}</span>
                                    <svg :class="openIndex === {{ $index }} ? 'rotate-180' : ''"
                                        class="w-5 h-5 transform transition-transform duration-200"
                                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Menu Items -->
                                <div x-show="openIndex === {{ $index }}" x-transition class="px-6 py-4 space-y-2 bg-white">
                                    @foreach($categoryMenus as $item)
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="text-gray-800 font-medium">{{ $item->name }}</span>
                                        {{-- Optional price: <span class="text-sm text-gray-500">${{ $item->price ?? 'N/A' }}</span> --}}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach

                        </div>

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