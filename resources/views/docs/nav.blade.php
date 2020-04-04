<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/">
        <img src="/assets/images/laravel-korea-logo.png" style="height: 32px;">

    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
        <li class="nav-item px-3">
            <a class="nav-link" href="https://wiki.modernpug.org/display/LAR/questions/all" target="_blank">
                QNA
            </a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="https://github.com/laravelkr/website/issues/2" target="_blank">
                라라벨로 만든 사이트
            </a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="https://github.com/laravelkr/website/issues/3" target="_blank">
                기타 학습자료
            </a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="https://github.com/laravelkr/website/issues/4" target="_blank">
                스터디/행사
            </a>
        </li>
        <!-- Dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                유저 모임
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="https://www.facebook.com/groups/laravelkorea/"
                   target="_blank">
                    라라벨 코리아
                </a>
                <a class="dropdown-item" href="https://www.facebook.com/groups/655071604594451/"
                   target="_blank">
                    모던 PHP 유저 그룹
                </a>
                <a class="dropdown-item" href="https://open.kakao.com/o/g3dWlf0/"
                   target="_blank">
                    카카오톡 오픈채팅
                </a>

            </div>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class=" btn btn-primary btn-block" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">

                @foreach(array_reverse(config('docs.versions')) as $supportVersion => $versionStatus)
                    @if($version == $supportVersion)
                        @php
                            $deprecated = $versionStatus['deprecatedAt']<$today;
                            $documentStatus = [];
                            if($versionStatus['lts'])
                                $documentStatus[]="LTS";
                            if($versionStatus['in_translation'])
                                $documentStatus[]="번역중";
                            if($deprecated)
                                $documentStatus[]="지원종료";
                        @endphp
                        <strong id="selected_version" data-version="{{ $version }}"
                                class="{{ $deprecated?"deprecated":"" }} {{ $supportVersion == config('docs.default')?"default":"" }}">
                            {{ $supportVersion }}
                            @if(count($versionStatus))
                                ({{ implode(", ", $documentStatus) }})
                            @endif
                        </strong>
                    @endif

                @endforeach
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                @foreach(array_reverse(config('docs.versions')) as $supportVersion => $versionStatus)

                    @php
                        $deprecated = $versionStatus['deprecatedAt']<$today;
                        $documentStatus = [];
                        if($versionStatus['lts'])
                            $documentStatus[]="LTS";
                        if($versionStatus['in_translation'])
                            $documentStatus[]="번역중";
                        if($deprecated)
                            $documentStatus[]="지원종료";
                    @endphp

                    <a class="dropdown-item {{ $deprecated?"deprecated":"" }} {{ $supportVersion == config('docs.default')?"default":"" }} {{ $versionStatus['in_translation']?"disabled":"" }}"
                       href="{{ $versionStatus['in_translation']?"#":route('docs.show', [$supportVersion, $doc]) }}">
                        @if($version == $supportVersion)
                            <strong>
                                {{ $supportVersion }}
                                @if(count($versionStatus))
                                    ({{ implode(", ", $documentStatus) }})
                                @endif
                            </strong>
                        @else
                            {{ $supportVersion }}
                            @if(count($versionStatus))
                                ({{ implode(", ", $documentStatus) }})
                            @endif
                        @endif
                    </a>
                @endforeach
            </div>
        </li>
    </ul>
    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>
