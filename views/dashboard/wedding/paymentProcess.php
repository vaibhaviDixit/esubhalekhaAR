<?php

session_start();

// errors(1);

if (isset($_POST['paymentId']) && isset($_POST['cart']) && isset($_POST['totalAmount'])) {
    
      // Create an instance of the Payment class
    controller("Order");
    $order = new Order();

    controller("Auth");
    $user = new Auth();

    $userID = "";

    if($_POST['userID'] != "" ){
        $userID = $_POST['userID'];
        // echo json_encode($userID);

    }else{

        $name = $_POST['userName'];
        $phone = $_POST['phone'];

        $registerUser = $user->registerWithoutVerify($name,$phone);
        // print_r($registerUser);
        $userID = $registerUser['userID'];

    }

    // echo json_encode($userID);

    if($userID != ""){
        $data = [
            'id' => $_POST['paymentId'],
            'cart' => $_POST['cart'],
            'eventDate' => $_POST['eventDate'],
            'totalAmount' => $_POST['totalAmount'],
            'userID'    => $userID
        ];

        // Call the create method of Payment class
        $response = $order->create($data);


        unset($_SESSION['cart']);

        // Return the response as JSON
        echo json_encode($response);
    }else{
        echo json_encode(['error' => true, 'errorMsgs' => 'Payment Failed!!!']);
    }

}
else if (isset($_POST['paymentID']) && isset($_POST['weddingID']) && isset($_POST['lang']) && isset($_POST['userID'])) {
    
    // Create an instance of the Payment class
    controller("Payment");
    $payment = new Payment();

    // Prepare the data array
    $data = [
        'paymentID' => $_POST['paymentID'],
        'weddingID' => $_POST['weddingID'],
        'lang' => $_POST['lang'],
        'userID'    => $_POST['userID']
    ];

    // Call the create method of Payment class
    $response = $payment->create($data);

    // Return the response as JSON
    echo json_encode($response);

} else {
    // If required data is missing
    echo json_encode(['error' => true, 'errorMsgs' => 'Payment Failed!']);
}

?>
