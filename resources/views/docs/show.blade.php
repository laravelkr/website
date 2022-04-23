@extends('docs.layout')

@php
    /**
     * @var LinkLocationDto $nowLink
     * @var LinkLocationDto $prevLink
     * @var LinkLocationDto $nextLink
     * @var \App\Services\ModernPug\Dto\Response $recruits
     * @var \App\Services\ModernPug\Dto\ResponseData $recruit
     */
 use App\Services\Navigator\Dto\LinkLocationDto;
@endphp

@section('title', '라라벨 '. $version. (!empty($nowLink->title)?" - ".$nowLink->title:"" ))

{{-- 구글 검색시 문서 파편화 현상 제거를 위해 canonical url을 최신 버전으로 통일 시키는 것을 고민중 --}}
@section('canonical', route('docs.show',[$version,$doc]))
@section('meta.url', url()->current())
@section('meta.title', '라라벨 '. $version. (!empty($nowLink->title)?" - ".$nowLink->title:"" ))
@section('meta.description', '라라벨 한글 메뉴얼 '. $version. (!empty($nowLink->title)?" - ".$nowLink->title:"" ))


@section('head')
    <meta name="docsearch:version" content="{{ $version }}"/>
    <meta name="docsearch:language" content="{{ app()->getLocale() }}"/>

    @if(config('algoria.docsearch.apiKey'))
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.css"/>
    @endif

    <style>
        article img {
            max-width: 100%;
        }
    </style>
@endsection

@section('sidebar')
    {!! $tableContent !!}
@endsection

@section('aside')
    {!! $subTableContent !!}
@endsection

@section('last-modify')
    <div class="col-lg-12">
        @if($enUpdated)
            최종 수정일 -
            <a href="https://laravel.com/docs/{{$version}}/{{$doc}}" target="_blank" title="{{$enUpdated}}">
                영어 : {{$enTimeAgoUpdate}}
            </a>
            /
            <span style="cursor: pointer;" title="{{$krUpdated}}"> 한글 : {{$krTimeAgoUpdate}}</span>
        @endif

        <div class="pull-right">
                <span class="btn btn-outline-primary btn-sm" id="show-eng-docs">
                    <i class="fa fa-book"></i>
                    영문 같이보기
                </span>
            <a class="btn btn-outline-danger btn-sm"
               href="https://laravel.com/docs/{{$version }}/{{ $doc }}"
               target="_blank">
                <i class="fa fa-external-link"></i>
                영어 원문보기
            </a>
            <a href="https://modernpug.org/recruits" class="btn btn-sm btn-outline-dark" target="_blank">
                <i class="fa fa-external-link"></i>
                채용공고 더보기/등록하기
            </a>
        </div>
    </div>

    <div class="col-lg-12">
        @foreach(collect($recruits->data)->shuffle()->take(5) as $recruit)
            <a href="{{ $recruit->link }}" target="_blank"
               class="btn btn-sm btn-outline-dark mt-1 d-sm-inline-block @if($loop->first) d-block @else d-none @endif ">
                <i class="fa fa-external-link"></i>
                {{ $recruit->title }}
                <small>
                    by
                    {{ $recruit->company_name }}
                </small>
            </a>
        @endforeach
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
@endsection

@section('footerScript')
    @if(!empty($notificationMessage))
        <script>
            toastr.options = {
                "positionClass": "toast-top-full-width",
            };
            toastr.error('{!! addslashes($notificationMessage) !!}', {});
        </script>
    @endif


    @if(config('algoria.docsearch.apiKey'))
        <!-- at the end of the BODY -->
        <script type="text/javascript"
                src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script>
        <script type="text/javascript"> docsearch({
                apiKey: '{{ config('algoria.docsearch.apiKey') }}',
                indexName: '{{ config('algoria.docsearch.indexName') }}',
                inputSelector: '#docsearch-input',
                algoliaOptions: {
                    facetFilters: ["version:{{ $version }}", "language:ko"],
                    hitsPerPage: 8
                },
                debug: false // Set debug to true if you want to inspect the dropdown
            });
        </script>
    @endif

@endsection
