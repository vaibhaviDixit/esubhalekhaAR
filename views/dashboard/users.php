<?php
// errors(1);
locked(['admin']);
require('views/partials/dashboard/head.php');
require('views/partials/admin/sidebar.php');

$suerID = App::getUser()['userID'];
if(App::getUser()['role'] == "admin"){
    DB::connect();
    $users = DB::select('users', '*', "")->fetchAll();
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
            user-select: none !important;
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
    <h1 class="h2">All Users</h1>
    
    <div class="table-responsive mb-5">
        <table id="myTable" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Action</th>
                    <th class="text-nowrap">Name</th>
                    <th class="text-nowrap">Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) {
                    ?>
                    <tr>
                        <td>
                            <a href="tel:+91<?= $user['phone'] ?>" class="btn btn-sm btn-primary  action-btn"> <i class="bi bi-telephone-forward"></i> </a>
                            <a href="https://wa.me/+91<?= $user['phone'] ?>" target="_blank" class="btn btn-sm btn-primary  action-btn"> <i class="bi bi-whatsapp"></i>  </a>
                            
                        </td>

                        <td>
                            <?= $user['name'] ?>
                        </td>
                        <td>
                            <?= $user['email'] ?>
                        </td>
                        <td>
                            <?= $user['role'] ?>
                        </td>
                         <td>
                            <?= $user['status'] ?>
                        </td>
                         <td>  <?= $user['createdAt'] ?> </td>
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