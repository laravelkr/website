<h3 id="contributors">이 문서의 번역에 기여해주신 분들</h3>
@foreach($contributors as $contributor)
    <a href="{{ $contributor->userBaseUrl }}" target="_blank">
        <img style="max-width:80px;" src="{{ $contributor->userImage }}"
             title="{{ $contributor->userName }}"
             alt="{{ $contributor->userName }}">
    </a>
@endforeach
<a href="https://github.com/laravelkr/docs/wiki/%EA%B8%B0%EC%97%AC-%EB%B0%A9%EB%B2%95" class="btn btn-outline-primary pull-right" target="_blank">
    <i class="fa fa-pencil"></i>
    기여에 참여하기
</a>
