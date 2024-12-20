<?php
// errors(1);

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

$currentUser=App::getUser();


controller("Order");
$orderController = new Order();

controller("Theme");
$theme = new ThemeController();

controller("SmartCard");
$cardController=new SmartCard();

controller("ARInvite");
$arController=new ARInvite();

$userOrders = $orderController->checkOrderExists($weddingData['orderID'],$currentUser['userID']);

if($userOrders){
    $order = $orderController->getOrderById($weddingData['orderID']);
    $cart = json_decode($order['cart'], true);
}

?>

<head>

    <style type="text/css">

        .invoiceBtn a:hover{
            color: var(--color-secondary-1);
        }

    </style>
    <!-- Add Razorpay script -->
</head>

<!-- Main Start -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1>Order Details</h1>
    
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body position-relative">

                    <div class="d-flex justify-content-between mb-2">
                        <dir>
                            Order Date: <strong><?php $dt = new DateTime($order['createdAt']); echo $dt->format('d/m/y'); ?></strong>
                        </dir>
                        <dir>
                            Event Date: <strong><?php $dt = new DateTime($order['eventDate']); echo $dt->format('d/m/y h:m'); ?></strong>
                        </dir>

                    </div>

                         <?php

                    foreach ($cart as $cartKey => $cartValue) {
                        if(isset( $cartValue['id']) && $cartValue['id']!=''){

            ?>

<div class="d-flex mx-3">
<div class="row align-items-center">   
    <div class="col-sm-4">
        <?php 
            if ($cartKey === 'theme') {
                $id = $cartValue['id'];
                // echo $id;
                $imgPath = $theme->getImg($id);
        ?>
          <a href="<?= route("KaaviaWedsRohan/en?theme=" . $id) ?>" target="_blank">  <img src="<?= themeAssets(basename($imgPath[0]), $imgPath[1]) ?>" class="img-fluid" alt="<?= $cartKey ?>"> </a>
        <?php
            } else {
                $id = $cartValue['id'];
                $img = $gallery->getProductGallery($id)[0]['imageURL'];
        ?>
            <img src="<?= $img ?>" class="img-fluid" alt="<?= $cartKey ?>"> 
        <?php
            }
        ?>
    </div>

    <div class="col-sm-8">
        <div class="card-body">
            <!-- Remove `//` from inline PHP echo -->
            <h6 class="card-title">  

                <?php if($cartKey == "theme"){ echo $theme->getName($cartValue['id']); }else if($cartKey == "smartCards"){ echo $cardController->getSmartCardByID($cartValue['id'])['name']; }else if($cartKey == "arInvites"){ echo $arController->getARInviteByID($cartValue['id'])['name']; } ?> 

            <?php if ($cartKey === 'theme'){ ?>
                <!-- Uncomment if necessary -->
                <!-- <a href="<?= $cartValue['url'] ?>" target="_blank">(Preview)</a><br> -->
            <?php } ?></h6>

            <p class="card-text">
                <?php if ($cartKey === 'smartCards'){ ?>
                    <strong><?= $cartValue['count'] ?></strong> <sub>Cards </sub> <strong>₹ <?= $cartValue['totalPrice'] ?> </strong>
                <?php }else{
                ?>
                     <strong> ₹ <?= $cartValue['price'] ?> </strong>
                <?php
                } ?>
            </p>
        </div>
    </div>
</div>
</div>


            <?php
                        }

                    } // cart for each ends
                    ?>

                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>


<?php require('views/partials/dashboard/scripts.php') ?>


