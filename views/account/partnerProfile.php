<?php

// errors(1);

locked(['manager', 'admin', 'partner']);
require('views/partials/dashboard/head.php');
require('views/partials/partner/sidebar.php');

controller("partners");
$user = new Auth();

$currentUser = App::getUser();
$partner = new Partners();

$currentPartner = $partner->getPartner($currentUser['userID']);

?>

<!-- Main Start -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">

    <h1 class="h2 mb-4">Partner Profile</h1>




         <?php

                if (isset($_SESSION['alert_message'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['alert_message'] . "</div>";
                    // Unset the message so it's not shown again after another refresh
                    unset($_SESSION['alert_message']);
                }

                if (isset($_POST['submit-business'])) {
                    $updateBusiness = $partner->editPartner($currentUser['userID'], $_REQUEST);
                    if ($updateBusiness['error']) {
                        echo "<div class='alert alert-danger'>";
                        foreach ($updateBusiness['errorMsgs'] as $msg) {
                            echo $msg[0] . "<br>";
                        }
                        echo "</div>";
                    } else {
                        $_SESSION['alert_message'] = "Business details updated successfully";
                        echo "<script> window.location.href = window.location.href; </script>";
                    }
                }
                ?>

         <?php
                if (isset($_POST['submit-personal'])) {

                    $updateUser = $user->edit($currentUser['userID'], $_REQUEST);

                    if ($updateUser['error']) {
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach ($updateUser['errorMsgs'] as $msg) {
                                if (count($msg))
                                    echo $msg[0] . "<br>";
                            }
                            ?>
                        </div>
                        <?php
                    }else {
                        $_SESSION['alert_message'] = "Personal details updated successfully";
                        echo "<script> window.location.href = window.location.href; </script>";
                    }
                }
         ?>


         <?php
                if (isset($_POST['submit-bank'])) {
                    $updateBank = $partner->editPartner($currentUser['userID'], $_REQUEST); // Adjust logic as needed
                    if ($updateBank['error']) {
                        echo "<div class='alert alert-danger'>";
                        foreach ($updateBank['errorMsgs'] as $msg) {
                            echo $msg[0] . "<br>";
                        }
                        echo "</div>";
                    } else {
                        $_SESSION['alert_message'] = "Bank details updated successfully";
                        echo "<script> window.location.href = window.location.href; </script>";
                    }
                }
        ?>

    <ul class="nav nav-tabs " id="myTab" role="tablist">

         <li class="nav-item" role="presentation">
            <button class="nav-link text-primary fw-bold" id="personal-details-tab" data-bs-toggle="tab" data-bs-target="#personal-details" type="button" role="tab" aria-controls="personal-details" aria-selected="false">Personal Details</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link active text-primary fw-bold" id="business-details-tab" data-bs-toggle="tab" data-bs-target="#business-details" type="button" role="tab" aria-controls="business-details" aria-selected="true">Business Details</button>
        </li>
       
        <li class="nav-item" role="presentation">
            <button class="nav-link text-primary fw-bold" id="bank-details-tab" data-bs-toggle="tab" data-bs-target="#bank-details" type="button" role="tab" aria-controls="bank-details" aria-selected="false">Bank Details</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        
        <!-- Business Details Form -->
        <div class="tab-pane fade show active" id="business-details" role="tabpanel" aria-labelledby="business-details-tab">
            <form method="post" id="businessDetailsForm" enctype="multipart/form-data">
                <div class="row">
                    <!-- Business Name -->
                    <div class="mb-3 col-sm-6">
                        <label for="businessName" class="form-label">Business Name</label>
                        <input type="text" class="form-control" id="businessName" name="businessName" value="<?= $currentPartner['businessName'] ?>" placeholder="Enter Business Name">
                    </div>
                    <!-- City -->
                    <div class="mb-3 col-sm-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?= $currentPartner['city'] ?>" placeholder="Enter City">
                    </div>
                    <!-- Address -->
                    <div class="mb-3 col-sm-6">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address"><?= $currentPartner['address'] ?></textarea>
                    </div>
                    <!-- Pincode -->
                    <div class="mb-3 col-sm-6">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" value="<?= $currentPartner['pinCode'] ?>" placeholder="Enter Pincode">
                    </div>
                </div>
                <button type="submit" name="submit-business" class="btn btn-primary">Update Business Details</button>
            </form>
        </div>

        <!-- Personal Details Form -->
        <div class="tab-pane fade" id="personal-details" role="tabpanel" aria-labelledby="personal-details-tab">
            <form method="post" id="personalDetailsForm">
               
                <div class="row">
                    <!-- Name -->
                    <div class="mb-3 col-sm-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $currentUser['name'] ?>" placeholder="Enter Name">
                    </div>
                    <!-- Phone -->
                    <div class="mb-3 col-sm-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $currentUser['phone'] ?>" readonly>
                    </div>
                    <!-- Email -->
                    <div class="mb-3 col-sm-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $currentUser['email'] ?>" placeholder="Enter Email">
                    </div>
                    <!-- Gender -->
                    <div class="mb-3 col-sm-4">
                        <label class="form-label">Gender</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= $currentUser['gender'] === 'male' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= $currentUser['gender'] === 'female' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit-personal" class="btn btn-primary">Update Personal Details</button>
            </form>
        </div>

        <!-- Bank Details Form -->
        <div class="tab-pane fade" id="bank-details" role="tabpanel" aria-labelledby="bank-details-tab">
            <form method="post" id="bankDetailsForm">
               
                <div class="row">
                    <!-- Bank Name -->
                    <div class="mb-3 col-sm-6">
                        <label for="bankName" class="form-label">Bank Name</label>
                        <input type="text" class="form-control" id="bankName" name="bankName" value="<?= $currentPartner['bankName'] ?>" placeholder="Enter Bank Name">
                    </div>
                    <!-- Bank Account Number -->
                    <div class="mb-3 col-sm-6">
                        <label for="bankAccountNumber" class="form-label">Bank Account Number</label>
                        <input type="text" class="form-control" id="bankAccountNumber" name="bankAccountNumber" value="<?= $currentPartner['bankAccountNumber'] ?>" placeholder="Enter Bank Account Number">
                    </div>
                    <!-- IFSC Code -->
                    <div class="mb-3 col-sm-6">
                        <label for="ifscCode" class="form-label">IFSC Code</label>
                        <input type="text" class="form-control" id="ifscCode" name="ifscCode" value="<?= $currentPartner['ifscCode'] ?>" placeholder="Enter IFSC Code">
                    </div>
                </div>
                <button type="submit" name="submit-bank" class="btn btn-primary">Update Bank Details</button>
            </form>
        </div>

    </div>
</main>

<?php require('views/partials/dashboard/scripts.php') ?>
