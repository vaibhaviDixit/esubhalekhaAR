<?php
// errors(1);
locked(['admin']);

require('views/partials/dashboard/head.php');
require('views/partials/admin/sidebar.php');

$suerID = App::getUser()['userID'];

controller("Offer");
$offerController = new Offer();

if(App::getUser()['role'] == "admin"){
    DB::connect();
    $offers = DB::select('offers ', '*', "")->fetchAll();
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
    <h1 class="h2">Offers</h1>

    <div class="text-end"><a class="btn btn-primary btn-sm" href="<?php echo route('addOffer'); ?>?back=dashboard">
            Add Offer <i class="bi bi-plus-circle"></i></a></div>

    <div class="table-responsive mb-5">
        <table id="myTable" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Action</th>
                    <th class="text-nowrap">Name</th>
                    <th class="text-nowrap">Code</th>
                    <th>Offer</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offers as $offer) {
                    ?>
                    <tr>
                        <td>

                             <a class="btn btn-sm btn-primary  action-btn"
                                href="<?php echo route('editOffer/'.$offer['offerID']); ?>?back=dashboard"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                data-bs-title="Edit order"> <i class="bi bi-pencil-square"></i></a>
                            
                        </td>
                        <td>
                            <?= $offer['name'] ?>
                        </td>
                        <td>
                            <?= $offer['code'] ?>
                        </td>
                        <td>
                            <?= floatval($offer['offer']); ?> %
                        </td>

                        <td>  <?= $offer['startDate'] ?> </td>

                        <td>  <?= $offer['endDate'] ?> 
                            <span class="text-danger text-sm"><?= (strtotime($offer['endDate']) < time()) ? "(Expired)":"" ?> </span>
                        </td>

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