@if ($paginator->hasPages())
    <div class="pagination-container">
        <nav class="pagination-next-prev">
            <ul>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="prev" aria-disabled="true" aria-label="@lang('pagination.previous')">Previous</li>
                @else
                    <li>
                        <a class="prev" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" style="margin-top: 40px">Previous</a>
                    </li>
                @endif
            </ul>
        </nav>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            <nav class="pagination">
                <ul>
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="blank" aria-disabled="true">{{ $element }}</li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="blank" aria-current="page">{{ $page }}</li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </nav>
        @endforeach

        {{-- Next Page Link --}}
        <nav class="pagination-next-prev">
            <ul>
                @if ($paginator->hasMorePages())
                    <li><a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</a>
                    </li>
                @else
                    <li class="blank" aria-disabled="true" aria-label="@lang('pagination.next')">Next</li>
                @endif
            </ul>
        </nav>
    </div>
@endif