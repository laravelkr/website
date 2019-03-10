@extends('layout.sub')

@section('head')
    <link rel="stylesheet" type="text/css" href="/assets/css/sign.css" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><em>환영합니다!</em></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12 ">
                                <div class="login" style="display:block">
                                    <p class="text-center">간편한 소셜 로그인을 통해서 손쉽게 로그인 할 수 있습니다.</p>
                                    <a href="{{route('social.login','github')}}" target="_top">
                                        <i class="fonti um-github um-2x"></i>깃허브 계정으로 로그인</a>
                                    <a href="{{route('social.login','naver')}}" target="_top" class="login_naver">
                                        <i class="fonti um-naver um-2x"></i>네이버 계정으로 로그인</a>
                                    <a href="{{route('social.login','facebook')}}" target="_top" class="login_face">
                                        <i class="fonti um-facebook um-2x"></i>페이스북 계정으로 로그인
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
