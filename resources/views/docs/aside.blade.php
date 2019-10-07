<aside class="aside-menu" id="aside-menu">

    @if(config('algoria.docsearch.apiKey'))
    <div>
        <strong>
            <i class="fa fa-search" aria-hidden="true"></i>
            Search
        </strong>
        <div id="docsearch-form">
            <input type="search" class="form-control" id="docsearch-input" placeholder="Search..." aria-label="Search for..." autocomplete="off">
        </div>
    </div>
    @endif

    <div class="aside-contents">
        <strong>
            <i class="fa fa-list" aria-hidden="true"></i>
            Contents
        </strong>
        <ul>
            @yield('aside')
        </ul>
    </div>
    <div class="d-xl-none">
        <strong>
            <i class="fa fa-list" aria-hidden="true"></i>
            PageList
        </strong>
        {!! $asidePageList !!}
    </div>
</aside>
