<?php


namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
    /**
     * This handles Home Page GET request
     * @return string|string[]
     */
    public function mainPage()
    {
        $params = [
            'name' => "Gaming World",
            'currentPage' => "mainPage",
            'galleryImages' => [
                [
                    'img' => 'https://cdn.game.net/image/upload/dpr_auto,f_auto,q_auto/v1/game_img//merch2020/Games/ItTakesTwo/Takes2-db.jpg',
                    'alt' => 'It Takes Two'
                ],
                [
                    'img' => 'https://cdn.game.net/image/upload/dpr_auto,f_auto,q_auto/v1/game_img/merch2021/Campaigns/Sale/Sale50off-db.jpg',
                    'alt' => '50% Sale Off'
                ],
                [
                    'img' => 'https://cdn.game.net/image/upload/dpr_auto,f_auto,q_auto/v1/game_img/merch2021/Games/ResiVillage/ResiVillage-db.jpg',
                    'alt' => 'Resident Evil Village'
                ],
                [
                    'img' => 'https://cdn.game.net/image/upload/dpr_auto,f_auto,q_auto/v1/game_img/merch2020/Games/Returnal/Returnal-db.jpg',
                    'alt' => 'Returnal'
                ],
            ]
        ];
        return $this->render('mainPage', $params);
    }

    public function notFound()
    {
        return $this->render('_404');
    }
}