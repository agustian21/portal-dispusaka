@if ($paginator->hasPages())
    <nav class="bp-pagination" aria-label="Navigasi halaman berita">
        @if ($paginator->onFirstPage())
            <span class="bp-page-control bp-page-control--disabled" role="link" aria-disabled="true">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i><span>Sebelumnya</span>
            </span>
        @else
            <a class="bp-page-control" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i><span>Sebelumnya</span>
            </a>
        @endif

        <ul class="bp-page-numbers">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="bp-page-gap" aria-hidden="true">…</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span class="bp-page-number bp-page-number--current" aria-current="page" aria-label="Halaman {{ $page }}, saat ini">{{ $page }}</span>
                            @else
                                <a class="bp-page-number" href="{{ $url }}" aria-label="Ke halaman {{ $page }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>

        @if ($paginator->hasMorePages())
            <a class="bp-page-control" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <span>Selanjutnya</span><i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        @else
            <span class="bp-page-control bp-page-control--disabled" role="link" aria-disabled="true">
                <span>Selanjutnya</span><i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </span>
        @endif
    </nav>
@endif
