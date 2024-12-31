<!DOCTYPE html>
<html lang="en">
<?php 
include("views/partials/head.php");

// errors(1);

locked(['user', 'host', 'manager', 'admin']);

$userID = App::getUser()['userID'];

controller("Gallery");
$gallery = new Gallery();

controller("Order");
$order = new Order();

controller("Theme");
$theme = new ThemeController();

controller("SmartCard");
$cardController=new SmartCard();

controller("ARInvite");
$arController=new ARInvite();

$userOrders = $order->getOrdersByUser($userID);

?>

<style>
    #app {
        margin-top: 12vh;
        max-height: 100vh !important;
    }
    #app img{
        object-fit: cover;
        width: 100%;
        height: 150px !important;
    }
    .line{
        width: 100%;
        height: 2px;
        margin-bottom: 10px;
        color: var(--color-secondary-2);
    }

</style>

<body>
    <?php require('views/partials/nav.php'); ?>

    <div id="app" class="">
        <!-- main content here -->
        <main class="col-md-9 mx-auto col-lg-10 px-md-4 col-9 pt-2">

             <h1 class="h2">Order History</h1>
            
             <div class="mt-4" style="padding-bottom: 20px;">

              <?php
                foreach ($userOrders as $orderKey => $orderValue) {
                    $cart = json_decode($orderValue['cart'], true);
                ?>
                
                <div class="d-flex align-items-center pt-2 flex-wrap justify-content-center" style="background-color: #fff; padding: 10px; margin: 10px 0; border-radius: 9px;">
                    <div class="">
                        <dir>
                            Order Date: <strong><?php $dt = new DateTime($orderValue['createdAt']); echo $dt->format('d/m/y'); ?></strong>
                        </dir>
                        <dir>
                            Event Date: <strong><?php $dt = new DateTime($orderValue['eventDate']); echo $dt->format('d/m/y h:m'); ?></strong>
                        </dir>

                    </div>

            <?php
                    foreach ($cart as $cartKey => $cartValue) {
                        if(isset( $cartValue['id']) && $cartValue['id']!=''){

            ?>

<div class="d-flex align-items-center flex-wrap justify-content-center mx-3">
<div class="text-center d-flex">   
    <div class="">
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

    <div class="">
        <div class="card-body">
            <!-- Remove `//` from inline PHP echo -->
            <h6 class="card-title">  

                <?php if($cartKey == "theme"){ echo $theme->getName($cartValue['id']); }else if($cartKey == "smartCards"){ echo $cardController->getSmartCardByID($cartValue['id'])['name']; }else if($cartKey == "arInvites"){ echo $arController->getARInviteByID($cartValue['id'])['name']; } ?> 

            <?php if ($cartKey === 'theme'){ ?>
                <!-- Uncomment if necessary -->
                <a href="<?= $cartValue['url'] ?>" target="_blank">(Preview)</a><br> 
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
            <?php
                }
            ?>
   

            </div>

        </main>
    </div>
</body>
</html>
