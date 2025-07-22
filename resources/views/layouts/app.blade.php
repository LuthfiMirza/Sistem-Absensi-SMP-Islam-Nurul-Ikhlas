@extends('layouts.base')

@push('style')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('base')

@include('partials.navbar')

@include('partials.sidebar')

<main class="main-content">
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div>
                <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        @if(!request()->routeIs('dashboard.*'))
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                @yield('buttons')
            </div>
        </div>

        <!-- Page Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
</main>

<!-- Profile Modal for Employees/Teachers -->
@if(auth()->user()->isUser())
    @include('partials.profile-modal')
@endif

@endsection