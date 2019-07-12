<aside class="aside-menu" id="aside-menu">
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
