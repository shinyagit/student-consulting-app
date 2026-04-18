@if ($paginator->hasPages())
    <nav class="ui-pagination" role="navigation" aria-label="ページネーション">

        <ul class="ui-pagination__list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="ui-pagination__item ui-pagination__item--disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="ui-pagination__link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="ui-pagination__item">
                    <a
                        href="{{ $paginator->previousPageUrl() }}"
                        class="ui-pagination__link"
                        rel="prev"
                        aria-label="@lang('pagination.previous')"
                    >
                        &lsaquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Three Dots Separator --}}
                @if (is_string($element))
                    <li class="ui-pagination__item ui-pagination__item--dots" aria-disabled="true">
                        <span class="ui-pagination__link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="ui-pagination__item ui-pagination__item--active" aria-current="page">
                                <span class="ui-pagination__link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="ui-pagination__item">
                                <a href="{{ $url }}" class="ui-pagination__link" aria-label="Go to page {{ $page }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="ui-pagination__item">
                    <a
                        href="{{ $paginator->nextPageUrl() }}"
                        class="ui-pagination__link"
                        rel="next"
                        aria-label="@lang('pagination.next')"
                    >
                        &rsaquo;
                    </a>
                </li>
            @else
                <li class="ui-pagination__item ui-pagination__item--disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="ui-pagination__link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>

        <div class="ui-pagination__summary">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
        
    </nav>
@endif