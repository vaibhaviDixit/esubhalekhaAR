<?php

// errors(1);

locked(['admin']);
require('views/partials/dashboard/head.php');
require('views/partials/admin/sidebar.php');


controller("Offer");
$offerController = new Offer();


if(isset($_REQUEST['id'])){

    $offerID = $_REQUEST['id'];
    $thisOffer = $offerController->getOfferById($offerID);

    if($thisOffer['error']){
        redirect("offers");
    }

    $btn = "Update";
    $readonly = "readonly";

}else{
    $btn = "Save";
    $readonly = "";
}


controller("ARInvite");
$ARInvites=new ARInvite();

controller("Gallery");
$gallery = new Gallery();

controller("Theme");
$theme = new ThemeController();

controller("SmartCard");
$cardController=new SmartCard();

DB::connect();
$arInvites = DB::select('ARInvites ', '*', "")->fetchAll();
$smartCards = DB::select('smartCard ', '*', "")->fetchAll();
DB::close();

// Fetch folder names dynamically
$themeFolders = array_filter(glob('themes/*'), 'is_dir');
sort($themeFolders);

usort($themeFolders, function($a, $b) {
    // Extract the number after "theme_"
    preg_match('/theme_(\d+)/', $a, $aMatch);
    preg_match('/theme_(\d+)/', $b, $bMatch);
    
    // Compare the extracted numbers
    return (int)$aMatch[1] - (int)$bMatch[1];
});
                        $websiteThemes = [];

                          foreach ($themeFolders as $index => $folder) {
                              $themeDetails = [];
                              $themeName = ucwords(explode("_", basename($folder))[2]);
                              $themeDetails = json_decode(file_get_contents('themes/'.basename($folder).'/manifest.json'), true);

                              if ($themeDetails['active']) {
                                  // Store theme URL and ID in an array for easy navigation
                                  $websiteThemes[] = [
                                      'themeID' => $themeDetails['themeID'],
                                      'title' => $themeDetails['themeName'],
                                      'url' => route("KaaviaWedsRohan/en?theme=" . $themeDetails['themeID']),
                                      'img' => $themeDetails['displayImages'][0],
                                      'folder' => basename($folder),
                                      'price' => $themeDetails['themePrice'],
                                  ];
                              }
                        }

DB::connect();
$users = DB::select('users', '*', "")->fetchAll();
DB::close();

?>

<head>

	 <style type="text/css">
        

    </style>
<!-- Jquery -->
    <script src="<?php assets("jquery/jquery.min.js"); ?>"></script>
    
</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    

	<h1 class="h2"> Offer</h1>

	<form method="post" id="form" class="form-wedding" enctype="multipart/form-data">
			<?php
				if (isset($_REQUEST['btn-submit'])) {

                

                    if (in_array('all', $_POST['smartCards'])) {
                        $_REQUEST['cards'] = 'all'; 
                    } else {
                        $_REQUEST['cards'] = $_POST['smartCards']; 
                    }

                    if (in_array('all', $_POST['users'])) {
                        $_REQUEST['users'] = 'all'; 
                    } else {
                        $_REQUEST['users'] = $_POST['users']; 
                    }


                    if (in_array('all', $_POST['arInvites'])) {
                        $_REQUEST['ar'] = 'all'; 
                    } else {
                        $_REQUEST['ar'] = $_POST['arInvites']; 
                    }


                    if (in_array('all', $_POST['themes'])) {
                        $_REQUEST['themes'] = 'all'; 
                    } else {
                        $_REQUEST['themes'] = $_POST['themes'];
                    }
                    
                    if(isset($_REQUEST['id'])){
                        $createOffer = $offerController->update($_REQUEST['id'], $_REQUEST);    
                    }else{
                        $createOffer = $offerController->create($_REQUEST);
                    }

                    if ($createOffer['error']) {
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach ($createOffer['errorMsgs'] as $msg) {
                                if (count($msg))
                                    echo $msg[0] . "<br>";
                            }
                            ?>
                        </div>
                        <?php
                    }else
                    redirect("offers/");

                }

	?>
			<div class="row">

  		     <!-- <?php //print_r($thisOffer); ?> -->

                 <!-- User Name Input -->
                <div class="mb-3 col-sm-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter offer name" value="<?= $thisOffer['name'] ?>" <?= $readonly ?>>
                    <small id="nameError" class="text-danger"></small>
                </div>

            
                <div class="mb-3 col-sm-6">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" class="form-control" id="code" name="code" value="<?= $thisOffer['code']; ?>" >
                     <small id="codeError" class="text-danger"></small>
                </div>
			</div>

            <div class="row">
                
                <div class="mb-3 col-sm-6">
                    <label for="smartCards" class="form-label">Applicable Smart Cards</label>
                    <select class="form-control" id="smartCards" name="smartCards[]" multiple="multiple">
                         <option value="all">All Smart Cards</option>
                        <?php foreach ($smartCards as $product): ?>
                                <option value="<?= $product['cardID']; ?>">
                                    <?= $product['name']; ?> (<?= $product['price']; ?>)
                                </option>
                        <?php endforeach; ?>
                    </select>
                    <small id="smartCardError" class="text-danger"></small>
                </div>

                <div class="mb-3 col-sm-6">
                    <label for="arInvites" class="form-label">Applicable AR Invites</label>
                    <select class="form-control" id="arInvites" name="arInvites[]" multiple="multiple">
                         <option value="all">All AR Invites</option>
                        <?php foreach ($arInvites as $product): ?>
                                <option value="<?= $product['ARID']; ?>">
                                    <?= $product['name']; ?> (<?= $product['price']; ?>)
                                </option>
                        <?php endforeach; ?>
                    </select>
                    <small id="arInviteError" class="text-danger"></small>
                </div>

                <div class="mb-3 col-sm-6">
                    <label for="themes" class="form-label">Applicable Themes</label>
                    <select class="form-control" id="themes" name="themes[]" multiple="multiple">
                         <option value="all">All Themes</option>
                        <?php foreach ($websiteThemes as $product): ?>
                                <option value="<?= $product['themeID']; ?>">
                                    <?= $product['title']; ?> (<?= $product['price']; ?>)
                                </option>
                        <?php endforeach; ?>
                    </select>
                    <small id="themeError" class="text-danger"></small>
                </div>

                <div class="mb-3 col-sm-6">
                    <label for="themes" class="form-label">Applicable Users</label>
                    <select class="form-control" id="users" name="users[]" multiple="multiple">
                         <option value="all">All Users</option>
                        <?php foreach ($users as $usr): ?>
                                <option value="<?= $usr['userID']; ?>">
                                    <?= $usr['name']; ?> (<?= $usr['phone']; ?>)
                                </option>
                        <?php endforeach; ?>
                    </select>
                    <small id="themeError" class="text-danger"></small>
                </div>



            </div>

            <div class="row">

                <div class="mb-3 col-sm-4">
                    <label for="offer" class="form-label">Off (%) </label>
                    <input type="number" class="form-control" id="offer" name="offer" value="<?= $thisOffer['offer']; ?>" >
                    <small id="offError" class="text-danger"></small>
                </div>

                <div class="mb-3 col-sm-4">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" value="<?= $thisOffer['startDate'] ?>" >
                    <small id="startDateError" class="text-danger"></small>
                </div>
                <div class="mb-3 col-sm-4">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" value="<?= $thisOffer['endDate'] ?>" >
                    <small id="endDateError" class="text-danger"></small>
                </div>

                

            </div>




		<!-- Submit Button -->
		<button type="submit" name="btn-submit" class="btn btn-primary" disabled><?= $btn; ?></button>
	</form>


</main>


<script>
$(document).ready(function() {
    $('#smartCards').select2();
    $('#arInvites').select2();
    $('#themes').select2();
    $('#users').select2();
});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nameInput = document.getElementById("name");
        const codeInput = document.getElementById("code");
        const offerInput = document.getElementById("offer");
        const startDateInput = document.getElementById("startDate");
        const endDateInput = document.getElementById("endDate");
        const submitButton = document.querySelector("button[name='btn-submit']");

        const nameError = document.getElementById("nameError");
        const startDateError = document.getElementById("startDateError");
        const endDateError = document.getElementById("endDateError");

        // Function to validate all inputs
        function validateForm() {
            let isValid = true;

            // Validate name (non-empty)
            if (nameInput.value.trim() === "") {
                nameError.textContent = "Name is required.";
                isValid = false;
            } else {
                nameError.textContent = "";
            }

            // Validate code (non-empty)
            if (codeInput.value.trim() === "") {
                codeInput.nextElementSibling.textContent = "Code is required.";
                isValid = false;
            } else {
                codeInput.nextElementSibling.textContent = "";
            }

            // Validate offer (positive number between 0 and 100)
            if (offerInput.value.trim() === "" || isNaN(offerInput.value) || offerInput.value <= 0 || offerInput.value > 100) {
                offerInput.nextElementSibling.textContent = "Offer must be a number between 0 and 100.";
                isValid = false;
            } else {
                offerInput.nextElementSibling.textContent = "";
            }

            // Validate startDate (non-empty and before endDate)
            if (startDateInput.value === "") {
                startDateError.textContent = "Start date is required.";
                isValid = false;
            } else if (endDateInput.value && new Date(startDateInput.value) > new Date(endDateInput.value)) {
                startDateError.textContent = "Start date must be before the end date.";
                isValid = false;
            } else {
                startDateError.textContent = "";
            }

            // Validate endDate (non-empty and after startDate)
            if (endDateInput.value === "") {
                endDateError.textContent = "End date is required.";
                isValid = false;
            } else if (startDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                endDateError.textContent = "End date must be after the start date.";
                isValid = false;
            } else {
                endDateError.textContent = "";
            }

            // Enable or disable the submit button based on validity
            submitButton.disabled = !isValid;
        }

        // Attach event listeners to inputs for real-time validation
        [nameInput, codeInput, offerInput, startDateInput, endDateInput].forEach(input => {
            input.addEventListener("input", validateForm);

        });

     
    });
</script>


<!--Main End-->