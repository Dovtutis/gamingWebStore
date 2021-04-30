<?php


namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Validation;
use app\model\OrdersModel;
use app\model\ItemsModel;
use app\model\UserModel;
use app\model\ShoppingCartModel;

class UserController extends Controller
{

    public Validation $validation;
    private OrdersModel $ordersModel;
    private ItemsModel $itemsModel;
    private UserModel $userModel;
    private ShoppingCartModel $shoppingCartModel;

    public function __construct()
    {
        if (!\app\core\Session::isUserLoggedIn()) {
            return $this->render('_404');
        }
        $this->validation = new Validation();
        $this->ordersModel = new OrdersModel();
        $this->itemsModel = new ItemsModel();
        $this->userModel = new UserModel();
        $this->shoppingCartModel = new ShoppingCartModel();
    }

    /**
     * This handles User Page requests
     * @return string|string[]
     */
    public function userAccount()
    {
        $user_id = $_SESSION['user_id'];
        $userOrders = $this->ordersModel->getAllOrdersByUser($user_id);
        $cartQuantity = $this->shoppingCartModel->getCartQuantity($user_id);

        foreach ($userOrders as $order) {
            $orderObj = new \stdClass();
            $orderObj->orderId = $order->id;
            $orderObj->message = $order->message;
            $orderObj->status = $order->status;
            $orderObj->date = $order->date;
            $orderItems = [];

            $orderList = json_decode($order->order_list);

            foreach ($orderList as $order) {
                $itemObj = new \stdClass();
                $item = $this->itemsModel->getOne($order->item_id);
                $itemObj->itemName = $item->item_name;
                $itemObj->quantity = $order->item_quantity;
                $itemObj->itemId = $item->item_id;
                $orderItems[] = $itemObj;
            }

            $orderObj->items = $orderItems;
            $allOrders[] = $orderObj;
        }

        $userData = $this->userModel->getUserById($user_id);
        $user = [
            'firstName' => $userData->firstname,
            'lastName' => $userData->lastname,
            'email' => $userData->email,
            'phone' => $userData->phone,
            'address' => $userData->address,
            'postalCode' => $userData->postal_code,
            'password' => '',
            'passwordConfirm' => '',
            'errors' => [
                'firstNameError' => '',
                'lastNameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'passwordConfirmError' => '',
                'phoneError' => '',
                'addressError' => '',
                'postalCodeError' => ''
            ],
        ];

        $params = [
            'name' => "Gaming World",
            'currentPage' => "userAccount",
            'userOrders' => $allOrders,
            'user' => $user,
            'cartQuantity' => $cartQuantity->items_quantity
        ];
        
        return $this->render('userPage', $params);
    }

    
    public function notFound()
    {
        return $this->render('_404');
    }
}
