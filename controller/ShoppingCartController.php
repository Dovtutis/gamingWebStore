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

        $quantityBool = $this->itemsModel->checkQuantity($itemId, $itemQuantity);
        $itemQuantityFromDatabase = $this->itemsModel->getItemQuantity($itemId);
        $itemQuantityFromDatabase = $itemQuantityFromDatabase->item_quantity;
        $shoppingCart = $this->shoppingCartModel->getAll($userId);


        if ($quantityBool) {
            $data['user_id'] = $userId;
            $newItem = [
                'itemId' => $itemId,
                'itemQuantity' => $itemQuantity
            ];
            $itemQuantityFromDatabase = $itemQuantityFromDatabase - $itemQuantity;

            if ($shoppingCart) {
                $data['shopping_cart_id'] = $shoppingCart[0]->shopping_cart_id;

                $shoppingCartItems = $shoppingCart[0]->items;
                $shoppingCartItems = json_decode($shoppingCartItems);

                $existingItemTrigger = false;

                for ($i = 0; $i < count($shoppingCartItems); $i++) {
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
                $this->itemsModel->editItemQuantity($itemId, $itemQuantityFromDatabase);
            } else {
                $shoppingCartItems = [];
                $shoppingCartItems[] = $newItem;
                $shoppingCartItems = json_encode($shoppingCartItems);

                $data['items'] = $shoppingCartItems;
                $data['items_quantity'] = 1;

                $this->shoppingCartModel->add($data);
                $this->itemsModel->editItemQuantity($itemId, $itemQuantityFromDatabase);
            }

            $data['response'] = true;
        } else {
            $data['response'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function shoppingCart(Request $request)
    {
        $userId = $_SESSION['user_id'];
        $shoppingCart = $this->shoppingCartModel->getAll($userId);

        if ($shoppingCart) {
            $shoppingCartItems = json_decode($shoppingCart[0]->items);
            $cartQuantity = $this->shoppingCartModel->getCartQuantity($userId);

            for ($x = 0; $x < count($shoppingCartItems); $x++) {
                $shoppingCartItems[$x]->itemData = $this->itemsModel->getOne($shoppingCartItems[$x]->itemId);
            }

            $params = [
                'name' => "Gaming World",
                'currentPage' => "shoppingCart",
                'userId' => $userId,
                'shoppingCartItems' => $shoppingCartItems,
                'shoppingCartId' => $shoppingCart[0]->shopping_cart_id,
                'shoppingCartTimestamp' => $shoppingCart[0]->timestamp,
                'cartQuantity' => $cartQuantity->items_quantity
            ];
        } else {
            $params = [
                'name' => "Gaming World",
                'currentPage' => "shoppingCart",
                'userId' => $userId,
                'shoppingCartItems' => false
            ];
        }

        return $this->render('shoppingCart', $params);
    }

    public function deleteFromCart(Request $request)
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
        }

        $shoppingCartId = $decoded['info']['shoppingCartId'];
        $itemId = $decoded['info']['itemId'];
        $selectedQuantity = $decoded['info']['selectedQuantity'];
        $userId = $decoded['info']['userId'];

        $shoppingCart = $this->shoppingCartModel->getAll($userId);

        $shoppingCartItems = $shoppingCart[0]->items;
        $shoppingCartItems = json_decode($shoppingCartItems);

        $filteredShoppingCartItems = [];

        foreach ($shoppingCartItems as $item) {
            if ($item->itemId != $itemId) {
                $filteredShoppingCartItems[] = $item;
            }
        }

        $data['shopping_cart_id'] = $shoppingCartId;
        $data['items_quantity'] = count($shoppingCartItems);
        $data['items'] = json_encode($filteredShoppingCartItems);

        if ($data['items_quantity'] == 1) {
            $this->shoppingCartModel->delete($shoppingCartId);
        } else {
            $data['items_quantity'] = count($filteredShoppingCartItems);
            $this->shoppingCartModel->edit($data);
        };

        $quantity = $this->itemsModel->getItemQuantity($itemId)->item_quantity;
        $quantity = $quantity + $selectedQuantity;
        $this->itemsModel->editItemQuantity($itemId, $quantity);
        $data['response'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
    }


    public function notFound()
    {
        return $this->render('_404');
    }
}
