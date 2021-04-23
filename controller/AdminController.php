<?php


namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Validation;
use app\model\OrdersModel;
use app\model\ItemsModel;
use app\model\UserModel;

class AdminController extends Controller
{

    public Validation $validation;
    private OrdersModel $ordersModel;
    private ItemsModel $itemsModel;
    private UserModel $userModel;

    public function __construct()
    {
        if (!\app\core\Session::isUserLoggedIn()) {
            return $this->render('_404');
        }
        $this->validation = new Validation();
        $this->ordersModel = new OrdersModel();
        $this->itemsModel = new ItemsModel();
        $this->userModel = new UserModel();
    }

    /**
     * This handles Admin Page requests
     * @return string|string[]
     */
    public function adminInferface(Request $request)
    {   
        $orders = $this->ordersModel->getAllOrders();
        for ($i=0; $i < count($orders); $i++) { 
            $orderItems = [];
            $orders[$i]->user = $this->userModel->getUserById($orders[$i]->user_id);
            $orderList = json_decode($orders[$i]->order_list);

            foreach ($orderList as $order) {
                $itemObj = new \stdClass();
                $item = $this->itemsModel->getOne($order->item_id);
                $itemObj->itemName = $item->item_name;
                $itemObj->quantity = $order->item_quantity;
                $itemObj->itemId = $item->item_id;
                $orderItems[] = $itemObj;
            }
            $orders[$i]->order_list = $orderItems;
        }

        if ($request->isGet()){
            $data = [
                'currentPage' => 'adminPage',
                'item' => [
                    'itemName' => '',
                    'itemType' => '',
                    'itemImage' => '',
                    'itemVideo' => '',
                    'itemPrice' => '',
                    'itemQuantity' => '',
                    'itemDescription' => '',
                    'errors' => [
                        'itemNameError' => '',
                        'itemTypeError' => '',
                        'itemImageError' => '',
                        'itemVideoError' => '',
                        'itemPriceError' => '',
                        'itemQuantityError' => '',
                        'itemDescriptionError' => '',
                    ]
                ],
                'orders' => $orders
            ];
            return $this->render('adminPage', $data);
        }

        if ($request->isPost()){
            $data = $request->getBody();

            $data['item']['errors']['itemNameError'] = $this->validation->validateEmpty($data['itemName'], "Enter item name, input field can not bet empty");
            $data['item']['errors']['itemTypeError'] = $this->validation->validateItemType($data['itemType']);
            $data['item']['errors']['itemImageError'] = $this->validation->validateURL($data['itemImage']);
            $data['item']['errors']['itemVideoError'] = $this->validation->validateURL($data['itemVideo']);
            $data['item']['errors']['itemPriceError'] = $this->validation->validateEmpty($data['itemPrice'], "Enter item price, input field can not bet empty");
            $data['item']['errors']['itemQuantityError'] = $this->validation->validateEmpty($data['itemQuantity'], "Enter item quantity, input field can not bet empty");
            $data['item']['errors']['itemDescriptionError'] = $this->validation->validateEmpty($data['itemDescription'], "Enter item description, input field can not bet empty");


            if ($this->validation->ifEmptyArray($data['item']['errors'])){
                if ($this->itemsModel->add($data)){
                    $data['response'] = true;
                }else{
                    $data['response'] = false;
                }
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    public function updateOrder (Request $request) {

        $data = $request->getBody();

            if ($this->ordersModel->updateOrder($data)){
                $data['response'] = 'success';
            }

            header('Content-Type: application/json');
            echo json_encode($data);
    }

    public function notFound()
    {
        return $this->render('_404');
    }
}
