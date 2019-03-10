<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 28
 * Time: 오후 2:00
 */

namespace App\Services\Markdown;


class Beautifier
{

    public static function beautifyNavigation(string $html): string
    {


        $html = preg_replace('/<ul>/', '<ul class="nav">', $html, 1);
        $html = str_replace('<ul>', '<ul class="nav-item">', $html);
        $html = str_replace('<li><a href=', '<li ><a class="nav-link" href=', $html);
        $html = preg_replace('/(href="\/api.*)<\/a>/',
            'target="_blank" \1 <i class="fa fa-external-link" aria-hidden="true"></i></a>', $html);
        $html = str_replace('<li>', '<li class="nav-title">', $html);

        return $html;
    }

    public static function beautifyArticle(string $html): string
    {

        $html = str_replace('<table>', '<table class="table table-hover">', $html);
        $html = preg_replace("/(<h[1-9]{1})>(.*)(<\\/h[1-9]{1}>)/",
            '\1 id="\2">\2\3', $html);
        return $html;
    }

}