<style>
    .pagination li{
        list-style-type: none;
        float: left;
        margin-left: 10px;
    }
    .pagination li span {
        color: #000;
    }
    .pagination li a {
        color: #000;
        text-decoration: none;
    }
</style>


@if ($paginator->hasPages())

    <ul class="pagination">
        @if ($paginator->onFirstPage())

            <li class="disabled"><span>&laquo;</span></li>

        @else

            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>

        @endif
        @foreach ($elements as $element)
            @if (is_string($element))

                <li class="disabled"><span>{{ $element }}</span></li>

            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())

                        <li class="active"><span>{{ $page }}</span></li>

                    @else

                        <li><a href="{{ $url }}">{{ $page }}</a></li>

                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())

            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>

        @else

            <li class="disabled"><span>&raquo;</span></li>

        @endif
    </ul>


@endif