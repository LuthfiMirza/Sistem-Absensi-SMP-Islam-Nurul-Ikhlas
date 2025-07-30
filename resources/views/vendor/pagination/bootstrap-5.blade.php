@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center align-items-center">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link rounded-start">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">Sebelumnya</span>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-start" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">Sebelumnya</span>
                        </a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link rounded-end" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            <span class="d-none d-sm-inline me-1">Selanjutnya</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link rounded-end">
                            <span class="d-none d-sm-inline me-1">Selanjutnya</span>
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-center">
            <div class="d-flex align-items-center">
                <ul class="pagination pagination-sm mb-0 shadow-sm">
                    {{-- First Page Link --}}
                    @if ($paginator->currentPage() > 3)
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url(1) }}" title="Halaman Pertama">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" title="Halaman Sebelumnya">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">{{ $element }}</span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link bg-primary border-primary fw-bold">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}" title="Halaman {{ $page }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" title="Halaman Selanjutnya">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    @endif

                    {{-- Last Page Link --}}
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" title="Halaman Terakhir">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <style>
        .pagination {
            --bs-pagination-padding-x: 0.75rem;
            --bs-pagination-padding-y: 0.5rem;
            --bs-pagination-font-size: 0.875rem;
            --bs-pagination-color: #6c757d;
            --bs-pagination-bg: #fff;
            --bs-pagination-border-width: 1px;
            --bs-pagination-border-color: #dee2e6;
            --bs-pagination-border-radius: 0.375rem;
            --bs-pagination-hover-color: #0d6efd;
            --bs-pagination-hover-bg: #e9ecef;
            --bs-pagination-hover-border-color: #dee2e6;
            --bs-pagination-focus-color: #0d6efd;
            --bs-pagination-focus-bg: #e9ecef;
            --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            --bs-pagination-active-color: #fff;
            --bs-pagination-active-bg: #0d6efd;
            --bs-pagination-active-border-color: #0d6efd;
            --bs-pagination-disabled-color: #6c757d;
            --bs-pagination-disabled-bg: #fff;
            --bs-pagination-disabled-border-color: #dee2e6;
        }

        .pagination .page-link {
            transition: all 0.2s ease-in-out;
            border: 1px solid var(--bs-pagination-border-color);
            margin: 0 2px;
            border-radius: 6px !important;
        }

        .pagination .page-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--bs-pagination-hover-bg);
            border-color: var(--bs-pagination-hover-border-color);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-sm .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        @media (max-width: 576px) {
            .pagination .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
                margin: 0 1px;
            }
        }
    </style>
@endif
