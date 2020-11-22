<?php
/**
 * @var \App\Models\Notice[]|\Illuminate\Support\Collection $notices
 */

$today = now();
?>
<div id="notice">

    @foreach($notices as $notice)
        @if($notice->started_at <= $today && $notice->expired_at >= $today)
            <a href="{{ $notice->link }}" target="_blank">{{ $notice->title }}</a>
        @endif
    @endforeach
</div>
