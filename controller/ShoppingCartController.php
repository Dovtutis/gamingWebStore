<?php


namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\model\ItemsModel;
use app\model\ShoppingCartModel;

class ShoppingCartController extends Controller
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

    public function addToCart(Request $request)
    {   

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
        } 

        $itemId = $decoded['info']['itemId'];
        $userId = $decoded['info']['userId'];

        $quantityBool = $this->shoppingCartModel->checkQuantity($itemId, 1);

        if ($quantityBool) {
            $data = [
                'user_id' => $userId,
                'item_id' => $itemId,
                'item_quantity' => 1
            ];
            $this->shoppingCartModel->add($data);
            $data['response'] = true;
        } else {
            $data['response'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }


    public function notFound()
    {
        return $this->render('_404');
    }
}