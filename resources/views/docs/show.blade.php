@extends('docs.layout')

@php
    /**
     * @var LinkLocationDto $nowLink
     * @var LinkLocationDto $prevLink
     * @var LinkLocationDto $nextLink
     */use App\Services\Navigator\Dto\LinkLocationDto;
@endphp

@section('title', '라라벨 '. $version. (!empty($nowLink->title)?" - ".$nowLink->title:"" ))

{{-- 구글 검색시 문서 파편화 현상 제거를 위해 canonical url을 최신 버전으로 통일 시키는 것을 고민중 --}}
@section('canonical', route('docs.show',[$version,$doc]))
@section('meta.url', url()->current())
@section('meta.title', '라라벨 '. $version. (!empty($nowLink->title)?" - ".$nowLink->title:"" ))
@section('meta.description', '라라벨 한글 메뉴얼 '. $version. (!empty($nowLink->title)?" - ".$nowLink->title:"" ))

@section('head')
    <link href='https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/tomorrow-night.min.css'
          rel='stylesheet' type='text/css'>
    <link href='{{ mix('css/docs.css') }}' rel='stylesheet' type='text/css'>
@endsection

@section('sidebar')
    {!! $tableContent !!}
@endsection

@section('aside')
    {!! $subTableContent !!}
@endsection

@section('last-modify')
    <div style="width:100%">

        @if($enUpdated)
        최종 수정일 - &nbsp;
        <a href="https://laravel.com/docs/{{$version}}/{{$doc}}" target="_blank" style="cursor: pointer;"
           title="{{$enUpdated}}"> 영어 : {{$enTimeAgoUpdate}} </a>
        &nbsp;/&nbsp;
        <a style="cursor: pointer;" title="{{$krUpdated}}"> 한글 : {{$krTimeAgoUpdate}} </a>

        <a class="btn btn-outline-danger btn-sm pull-right" href="https://laravel.com/docs/{{$version }}/{{ $doc }}"
           target="_blank">
            영어 원문보기
            <i class="fa fa-external-link" aria-hidden="true"></i>
        </a>
        <span class="btn btn-outline-primary btn-sm pull-right" id="show-eng-docs">영문같이보기</span>
        @endif
    </div>
@endsection

@section('content')
    <div class="row docs-content-panel">
        <div class="col-lg-12">
            <div class="card docs-content">
                <div class="row">
                    <div class="col-lg-12">
                        <article class="card-body" id="kr-article">
                            {!! $krContent !!}
                        </article>
                    </div>
                    <div class="col-lg-6" style="display: none;">
                        <article class="card-body" id="en-article">
                            {!! $enContent !!}
                        </article>
                    </div>
                </div>
                <div class="card-body page-navigator">
                    @if($prevLink)
                        <a href="{{ route('docs.show', [$version, $prevLink->doc]) }}" class="btn btn-light pull-left">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                            {{ $prevLink->title }}
                        </a>
                    @endif
                    @if($nextLink)
                        <a href="{{ route('docs.show', [$version, $nextLink->doc]) }}" class="btn btn-light pull-right">
                            {{ $nextLink->title }}
                            <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
                <div class="card-footer">
                    @include('docs.contributors')
                </div>
                <div class="card-footer">
                    @include('docs.disqus')
                </div>
            </div>
        </div>
    </div>
    <span id="back-to-top" class="text-info">
        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
    </span>
    <span id="kakao-open-chat">
        <a href="https://open.kakao.com/o/g3dWlf0" target="_blank" data-toggle="tooltip" data-placement="left"
           title="혼자 공부하기 힘들 땐?">
            <img src="{{ asset('assets/images/kakao.png') }}" alt="라라벨 카카오톡 오픈채팅">
        </a>
    </span>
@endsection

@section('footerScript')
    <script src="/assets/vendor/coreui/js/jquery.cookie.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/anchor-js/4.1.1/anchor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <script src="{{ mix('js/docs.js') }}"></script>

    @if(!empty($notificationMessage))
        <script>
            toastr.options = {
                "positionClass": "toast-top-full-width",
            };
            toastr.error('{!! addslashes($notificationMessage) !!}', {});
        </script>
    @endif
@endsection
