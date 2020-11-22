<?php

namespace App\Models;


use Carbon\Carbon;

/**
 * @property string title
 * @property string link
 * @property Carbon expired_at
 * @property Carbon started_at
 */
class Notice
{

    static public function getAll()
    {
        $notice = new self();
        $notice->title = env('NOTICE_TITLE');
        $notice->link = env('NOTICE_LINK');
        $notice->started_at = new Carbon(env('NOTICE_STARTED_AT'));
        $notice->expired_at = new Carbon(env('NOTICE_EXPIRED_AT'));

        if(empty($notice->title) || empty($notice->link))
            return [];

        return collect([$notice]);
    }

}
