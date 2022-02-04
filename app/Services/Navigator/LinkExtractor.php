<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 28
 * Time: 오후 2:48
 */

namespace App\Services\Navigator;


use App\Services\Navigator\Dto\LinkLocationDto;

class LinkExtractor
{

    public function extractToArray(string $html): array
    {
        //API 문서링크는 의도적으로 제외
        preg_match_all('/href="\\/(.*)\\/(.*)\\/(?P<doc>[a-zA-Z-]*)">(?P<name>.*)<\\/a>/', $html, $matches);


        $return = [];
        for ($i = 0, $count = count($matches[0]); $i < $count; $i++) {
            $return[] = new LinkLocationDto($matches['name'][$i], $matches['doc'][$i]);
        }

        return $return;
    }

}
