<?php
// errors(1);
locked(['admin']);

require('views/partials/dashboard/head.php');
require('views/partials/admin/sidebar.php');

$suerID = App::getUser()['userID'];

controller("Gallery");
$gallery = new Gallery();

controller("Order");
$orderController = new Order();

controller("Theme");
$theme = new ThemeController();

controller("SmartCard");
$cardController=new SmartCard();

controller("ARInvite");
$arController=new ARInvite();


if(App::getUser()['role'] == "admin"){
    DB::connect();
    $orders = DB::select('orders ', '*', "")->fetchAll();
    DB::close();
}
?>

<head>
    <style type="text/css">
        th {
            text-transform: capitalize;
        }

        .action-btn {
            margin-right: 5px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
        }

        small kbd {
            vertical-align: middle;
            padding: 2px 6px;
            order-select: none !important;
            font-size: 16px;
            font-weight: bold;
            background: white;
            color: black;
            border: 1px solid black;
        }

        .table-responsive::-webkit-scrollbar {
            height: 12px !important;
            cursor: pointer !important;
        }
        img{
            object-fit: cover;
            width: 50px;
            height: 50px !important;
        }
        .cartItems{
            font-size: 14px;
            margin-bottom: 10px;
        }

    </style>
</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Orders</h1>

    <div class="table-responsive mb-5">
        <table id="myTable" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Action</th>
                    <th class="text-nowrap">Name</th>
                    <th class="text-nowrap">Phone</th>
                    <th>Order</th>
                    <th>Event Date</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) {
                    ?>
                    <tr>
                        <td>
                             <a href="tel:+91<?= Auth::getUser($order['userID'])['phone']; ?>" class="btn btn-sm btn-success  action-btn"><i class="bi bi-telephone-forward"></i></a>

                             <a class="btn btn-sm btn-primary  action-btn"
                                href="<?php echo route('editOrder/'.base64_encode($order['id'])); ?>?back=dashboard"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                data-bs-title="Edit order"> <i class="bi bi-pencil-square"></i></a>
                            
                        </td>
                        <td>
                            <?= Auth::getUser($order['userID'])['name']; ?>
                        </td>
                        <td>
                             <?= Auth::getUser($order['userID'])['phone']; ?>
                        </td>
                        <td>
                            <?php 
                                $thisOrder = $orderController->getOrderById($order['id']);
                                $cart = json_decode($thisOrder['cart'], true);

                    foreach ($cart as $cartKey => $cartValue) {
                        if(isset( $cartValue['id']) && $cartValue['id']!=''){

            ?>  
    <div class="cartItems d-flex gap-2 align-items-center">
        <?php 
            if ($cartKey === 'theme') {
                $id = $cartValue['id'];
                // echo $id;
                $imgPath = $theme->getImg($id);
        ?>
          <a href="<?= route("KaaviaWedsRohan/en?theme=" . $id) ?>" target="_blank">  <img src="<?= themeAssets(basename($imgPath[0]), $imgPath[1]) ?>" class="img-fluid" alt="<?= $cartKey ?>"> </a>

          <span> <?= $theme->getName($cartValue['id']);  ?> </span>
          <strong> ₹ <?= $cartValue['price'] ?> </strong>

        <?php
            } else {
                $id = $cartValue['id'];
                $img = $gallery->getProductGallery($id)[0]['imageURL'];
        ?>
            <img src="<?= $img ?>" class="img-fluid" alt="<?= $cartKey ?>"> 

            <?php if($cartKey == "smartCards"){ echo $cardController->getSmartCardByID($cartValue['id'])['name']; }else if($cartKey == "arInvites"){ echo $arController->getARInviteByID($cartValue['id'])['name']; } ?>

             <?php if ($cartKey === 'smartCards'){ ?>
                    <div><strong><?= $cartValue['count'] ?></strong><sub>Cards </sub></div> <strong>₹ <?= $cartValue['totalPrice'] ?> </strong>
                <?php }else{
                ?>
                     <strong> ₹ <?= $cartValue['price'] ?> </strong>
                <?php
                } ?>

        <?php
            }
        ?>
    </div>

            <?php
                        }

                    }

                            ?>
                        
                        </td>
                        <td>  <?= $order['eventDate'] ?> </td>
                         <td>  <?= $order['createdAt'] ?> </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

</main>


<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            language: {
                search: ""
            }
        })
        let search = document.querySelector("#myTable_filter input")
        search.placeholder = "Search"
        search.classList.remove("form-control-sm")
        search.style.width = "350px"
    })


</script>

<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>