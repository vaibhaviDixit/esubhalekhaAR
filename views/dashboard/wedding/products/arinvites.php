<?php
// errors(1);
locked(['admin']);
require('views/partials/dashboard/head.php');
require('views/partials/admin/sidebar.php');

$suerID = App::getUser()['userID'];

controller("Gallery");
$gallery = new Gallery();

if(App::getUser()['role'] == "admin"){
    DB::connect();
    $ARInvites = DB::select('ARInvites ', '*', "")->fetchAll();
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
            card-select: none !important;
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
    </style>
</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">AR Invites</h1>
    
    <div class="text-end"><a class="btn btn-primary btn-sm" href="<?php echo route('addARInvite'); ?>?back=dashboard">
            Add AR Invite <i class="bi bi-plus-circle"></i></a></div>

    <div class="table-responsive mb-5">
        <table id="myTable" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Action</th>
                    <th class="text-nowrap">Name</th>
                    <th class="text-nowrap">Price</th>
                    <th>Images</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ARInvites as $card) {
                    ?>
                    <tr>
                        <td>
                             <a class="btn btn-sm btn-primary  action-btn"
                                href="<?php echo route('addARInvite/'.$card['ARID']); ?>?back=dashboard"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                data-bs-title="Edit Card"> <i class="bi bi-pencil-square"></i></a>
                            
                        </td>
                        <td>
                            <?= $card['name'] ?>
                        </td>
                        <td>
                            <?= $card['price'] ?>
                        </td>
                        <td>
                            <?php 
                                $productGallery = array();
                                $productGallery=$gallery->getProductGallery($card['ARID']);
                            ?>

                                   <div class="d-flex align-items-center gap-4 mt-3 flex-wrap">
        
                                 <div class="d-flex gap-2 align-items-center">
                            <?php 
                                if (!$productGallery['error']) {
                                     for ($i = 0; $i < count($productGallery); $i++) {
                            ?>
                                 <!-- Image Thumbnail -->
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a href="<?= $productGallery[$i]['imageURL'] ?>" target="_blank">
                                            <img src="<?= $productGallery[$i]['imageURL'] ?>" class="img-fluid" alt="image" style="width: 80px; height: 80px;">
                                        </a>
                                    </div>



                                    <?php } } ?>

                                    </div>
                                </div>

                                <?php 
                                    if($productGallery['error']){
                                        echo "No images found!";
                                    } 
                                ?>

                        
                        </td>
                         <td>  <?= $card['createdAt'] ?> </td>
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