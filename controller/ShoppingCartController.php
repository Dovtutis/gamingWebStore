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
        $itemQuantity = $decoded['info']['itemQuantity'];

        $quantityBool = $this->shoppingCartModel->checkQuantity($itemId, $itemQuantity);
        $shoppingCart = $this->shoppingCartModel->getAll($userId);


        if ($quantityBool) {
            $data['user_id'] = $userId;
            $newItem = [
                'itemId' => $itemId,
                'itemQuantity' => $itemQuantity
            ];

            if ($shoppingCart) {
                $data['shopping_cart_id'] = $shoppingCart[0]->shopping_cart_id;

                $shoppingCartItems = $shoppingCart[0]->items;
                $shoppingCartItems = json_decode($shoppingCartItems);

                $existingItemTrigger = false;

                for ($i=0; $i < count($shoppingCartItems); $i++) { 
                    if ($shoppingCartItems[$i]->itemId === $itemId) {
                        $shoppingCartItems[$i]->itemQuantity += $itemQuantity;
                        $existingItemTrigger = true;
                        break;
                    }
                }

                if (!$existingItemTrigger) {
                    $shoppingCartItems[] = $newItem;
                }

                $data['items_quantity'] = count($shoppingCartItems);
                $shoppingCartItems = json_encode($shoppingCartItems);
                $data['items'] = $shoppingCartItems;

                $this->shoppingCartModel->edit($data);
            } else {
                $shoppingCartItems = [];
                $shoppingCartItems[] = $newItem;
                $shoppingCartItems = json_encode($shoppingCartItems);

                $data['items'] = $shoppingCartItems;
                $data['items_quantity'] = 1;
                
                $this->shoppingCartModel->add($data);
            }

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