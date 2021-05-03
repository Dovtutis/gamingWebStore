<?php


namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Validation;
use app\model\OrdersModel;
use app\model\ShoppingCartModel;

class CheckoutController extends Controller
{
    /**
     * This handles Home Page GET request
     * @return string|string[]
     */
    private OrdersModel $ordersModel;
    public Validation $validation;

    public function __construct()
    {
        $this->ordersModel = new OrdersModel();
        $this->validation = new Validation();
        $this->shoppingCartModel = new ShoppingCartModel();
    }

    public function checkout(Request $request)
    {

        if ($request->isPost()) :
            $data = $request->getBody();

            $cardNumber = trim($data['card-number']);
            $cardNumber = str_replace(' ', '', $cardNumber);
            $user_id = $_SESSION['user_id'];

            $data = [
                'cardName' => trim($data['card-name']),
                'cardNumber' => $cardNumber,
                'cardCVC' => trim($data['card-cvc']),
                'userId' => $user_id,
                'errors' => [],
                'message' => '',
                'currentPage' => 'checkout'
            ];

            $data['errors']['cardNameError'] = $this->validation->validateCardName($data['cardName']);
            $data['errors']['cardNumberError'] = $this->validation->validateCardNumber($data['cardNumber'], 16);
            $data['errors']['cardCVCError'] = $this->validation->validateCardNumber($data['cardCVC'], 3);

            if ($this->validation->ifEmptyArray($data['errors'])) {
                $data['errors'] = [];
                $data['status'] = 'Order accepted';
                $orderList = $this->shoppingCartModel->getAll($user_id);
                $orderItems = $orderList[0]->items;
                $shoppingCartId = $orderList[0]->shopping_cart_id;
                $data['orderList'] = $orderItems;

                if ($this->ordersModel->addOrder($data)) {
                    $data['response'] = true;
                    $this->shoppingCartModel->delete($shoppingCartId);
                } else {
                    $data['response'] = false;
                }
            }

            header('Content-Type: application/json');
            echo json_encode($data);
        endif;
    }
}
