<?php
/**
 * Created by IntelliJ IDEA.
 * User: connor
 * Date: 23/06/2019
 * Time: 11:05 AM
 */

namespace App\Services\Markdown;

use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class AsideMenuBar
{
    protected $asideMenuBar;

    /*
     * Main Aside Bar
     */
    protected $mainMenu = [
        '/home' => ['Text' => 'Home', 'Attribute' => [], 'dep' => 1],
        'https://wiki.modernpug.org/display/LAR/questions/all' => ['Text' => 'QNA', 'Attribute' => []],
        'https://github.com/laravelkr/website/issues/2' => ['Text' => '라라벨로 만든 사이트', 'Attribute' => []],
        'https://github.com/laravelkr/website/issues/3' => ['Text' => '기타 학습자료', 'Attribute' => []],
        'https://github.com/laravelkr/website/issues/4' => ['Text' => '스터디/행사', 'Attribute' => []],

    ];

    /*
     * Sub Aside bar
     */
    protected $subMenu = [
        // submenu
        'https://www.facebook.com/groups/laravelkorea/' => ['Text' => '라라벨 코리아', 'Attribute' => ['target', '_blank']],
        'https://www.facebook.com/groups/655071604594451/' => ['Text' => '모던 PHP 유저 그룹', 'Attribute' => ['target', '_blank']],
        'https://open.kakao.com/o/g3dWlf0/' => ['Text' => '카카오 오픈채팅', 'Attribute' => ['target', '_blank']],
    ];

    public function __construct(Menu $asideMenuBar)
    {
        $this->asideMenuBar = $asideMenuBar;

    }

    public function getAsidelist()
    {
        $this->asideMenuBar::build($this->mainMenu, function ($menu, $label, $link) {
            $menu->add(link::to($link, $label['Text'])->addClass('nav-link'));
        }, $this->asideMenuBar);


        $this->asideMenuBar->submenu('<a>유저모임</a>',
            Menu::build($this->subMenu, function ($menu, $label, $link) {
                $menu->add(link::to($link, $label['Text'])->addClass('nav-link')
                        ->setAttribute($label['Attribute'][0], $label['Attribute'][1]));
            })
        );

        return $this->asideMenuBar->render();
    }
}
