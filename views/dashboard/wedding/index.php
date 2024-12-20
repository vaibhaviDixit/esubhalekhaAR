<?php
// errors(1);
locked(['user', 'host', 'manager', 'admin']);

require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">

<h1><?=$_REQUEST['id']?></h1>

<?php require('views/dashboard/wedding/progress_template.php') ?>


</main>



<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>