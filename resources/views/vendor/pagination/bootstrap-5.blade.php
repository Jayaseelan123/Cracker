@if ($paginator->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3 px-1" style="background:#f8f9fa; border-top:1px solid #e9ecef; border-radius:0 0 6px 6px; padding:10px 16px;">

    {{-- Left: Showing X to Y of Z results --}}
    <div class="text-muted" style="font-size:13.5px;">
        Showing <strong>{{ $paginator->firstItem() }}</strong>
        to <strong>{{ $paginator->lastItem() }}</strong>
        of <strong>{{ $paginator->total() }}</strong> results
    </div>

    {{-- Right: Page Buttons --}}
    <ul class="pagination mb-0" style="gap:3px;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link" style="border-radius:4px; font-size:13px; padding:5px 10px; border-color:#dee2e6; color:#adb5bd;">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="border-radius:4px; font-size:13px; padding:5px 10px; border-color:#dee2e6; color:#495057;">&lsaquo;</a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link" style="border-radius:4px; font-size:13px; padding:5px 10px; border-color:#dee2e6;">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link" style="border-radius:4px; font-size:13px; padding:5px 11px; background:#0d6efd; border-color:#0d6efd; color:#fff; font-weight:600;">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}" style="border-radius:4px; font-size:13px; padding:5px 11px; border-color:#dee2e6; color:#495057;">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="border-radius:4px; font-size:13px; padding:5px 10px; border-color:#dee2e6; color:#495057;">&rsaquo;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link" style="border-radius:4px; font-size:13px; padding:5px 10px; border-color:#dee2e6; color:#adb5bd;">&rsaquo;</span>
            </li>
        @endif

    </ul>
</div>
@endif
