<?php


namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\model\ItemsModel;
use app\model\ShoppingCartModel;

class SiteController extends Controller
{
    /**
     * This handles Home Page GET request
     * @return string|string[]
     */
    private ItemsModel $itemsModel;

    public function __construct()
    {
        $this->itemsModel = new ItemsModel();
        $this->shoppingCartModel = new ShoppingCartModel();

    }

    public function mainPage(Request $request, $searchQuery = null)
    {   
        
        if ($searchQuery === null) {
            $items = $this->itemsModel->getAll();
        } else {
            $searchParam = $searchQuery['value'];
            $items = $this->itemsModel->search($searchParam);
        }

        $userId = $_SESSION['user_id'];

        if ($_SESSION['status'] === "customer") {
            $cartQuantity = $this->shoppingCartModel->getCartQuantity($userId);
        }

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
            ],
            'items' => $items,
            'cartQuantity' => $cartQuantity->items_quantity
        ];
        return $this->render('mainPage', $params);
    }

    public function fetchItemsByType(Request $request, $type)
    {
        $selectedType = $type['value'];
        $items = $this->itemsModel->getByType($selectedType);
        $data['items'] = $items;

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function singleItem(Request $request, $itemId)
    {
        $userId = $_SESSION['user_id'];
        $item = $this->itemsModel->getOne($itemId['value']);
        $cartQuantity = $this->shoppingCartModel->getCartQuantity($userId);

        $params = [
            'name' => "Gaming World",
            'currentPage' => "singleItem",
            'userId' => $userId,
            'item' => $item,
            'cartQuantity' => $cartQuantity->items_quantity
        ];

        return $this->render('singleItem', $params);
    }

    public function notFound()
    {
        return $this->render('_404');
    }
}