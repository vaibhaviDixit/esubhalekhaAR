<?php


class Order
{
    protected $orderID;
    protected $userID;
    protected $cart;
    protected $offer;
    protected $totalAmount;
    protected $eventDate;

    // Create operation
    public function create($data)
    {
        DB::connect();
        $this->orderID = trim(DB::sanitize($data['id']));
        $this->userID = trim(DB::sanitize($data['userID']));
        $this->eventDate = trim(DB::sanitize($data['eventDate']));
        $this->cart = json_encode($data['cart']); // Encode array to JSON
        // $this->offer = floatval(trim(DB::sanitize($data['offer'])));
        $this->totalAmount = floatval(trim(DB::sanitize($data['totalAmount'])));
        DB::close();

    

        // Data to insert into DB
        $orderData = array(
            'id' => $this->orderID,
            'userID' => $this->userID,
            'cart' => $this->cart,
            'eventDate' =>  $this->eventDate,
            // 'offer' => $this->offer,
            'totalAmount' => $this->totalAmount,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
        );

        // Insert order into DB
        DB::connect();
        $createOrder = DB::insert('orders', $orderData);
        DB::close();

        if ($createOrder) {
            return ['error' => false, 'message' => 'Order created successfully'];
        } else {
            return ['error' => true, 'errorMsgs' => ['createOrder' => 'Failed to create order']];
        }
    }

    // Check if an order exists for a specific user
    public function checkOrderExists($orderID, $userID)
    {
        DB::connect();
        $getOrder = DB::select('orders', '*', "id = '$orderID' AND userID = '$userID'")->fetch();
        DB::close();

        return $getOrder ? true : false;
    }

    // Retrieve order details by order ID
    public function getOrderById($orderID)
    {
        DB::connect();
        $order = DB::select('orders', '*', "id = '$orderID'")->fetch();
        DB::close();

        if ($order) {
            return $order;
        } else {
            return ['error' => true, 'errorMsgs' => ['getOrder' => 'Order not found']];
        }
    }

    // Retrieve all orders for a specific user
    public function getOrdersByUser($userID)
    {
        DB::connect();
        $orders = DB::select('orders', '*', "userID = '$userID'")->fetchAll();
        DB::close();

        if ($orders) {
            return $orders;
        } else {
            return ['error' => true, 'errorMsgs' => ['getOrders' => 'No orders found for this user']];
        }
    }

    // Update order offer and total amount
    public function updateOrder($orderID, $data)
    {
        DB::connect();
        // $offer = floatval(trim(DB::sanitize($data['offer'])));
        $totalAmount = floatval(trim(DB::sanitize($data['totalAmount'])));
        DB::close();

        DB::connect();
        $updateOrder = DB::update('orders', [
            'eventDate' => $data['eventDate'],
            'cart' => json_encode($data['cart']),
            'totalAmount' => floatval(trim(DB::sanitize($data['totalAmount']))),
            'updatedAt' => date('Y-m-d H:i:s')
        ], "id = '$orderID'");
        DB::close();

        if ($updateOrder) {
            return ['error' => false, 'message' => 'Order updated successfully'];
        } else {
            return ['error' => true, 'errorMsgs' => ['updateOrder' => 'Failed to update order']];
        }
    }
}

