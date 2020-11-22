<?php


namespace App\Models;


/**
 * Class Banner
 * @package App
 * @property string code
 * @property string url
 * @property string $imageUrl
 * @property string expiredAt
 */
class Banner
{


    static public function getAll()
    {

        $return = collect();


        $banner = new self();
        $banner->code = 'brich';
        $banner->url = 'https://recruit.brich.co.kr/';
        $banner->imageUrl = "/assets/images/banners/brich.jpg";

        $return->push($banner);

        $banner = new self();
        $banner->code = 'candleworks';
        $banner->url = 'https://candleworks.co.kr/board/notice/post/1106';
        $banner->imageUrl = "/assets/images/banners/candleworks.jpg";
        $banner->expiredAt = '2019-07-31';

        if (date('Y-m-d') < $banner->expiredAt)
            $return->push($banner);

        return $return;
    }
}
