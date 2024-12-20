<?php

// errors(1);

locked(['admin']);
require('views/partials/dashboard/head.php');
require('views/partials/admin/sidebar.php');

$productGallery=array();

controller("ARInvite");
$ARInvites=new ARInvite();

controller("Gallery");
$gallery = new Gallery();

if(isset($_REQUEST['ARID'])){

	DB::connect();
	$ARID = $_REQUEST['ARID'];
    $ARData = DB::select('ARInvites', " * ", " ARID = '$ARID' ")->fetch();
    DB::close();

    $btn = "Update";

	$productGallery=$gallery->getProductGallery($_REQUEST['ARID']);

}else{

	$btn = "Save";
}

  // delete img by url
    if(isset($_REQUEST['imgurl'])){

        controller("AWSBucket");
        $awsObj = new AWSBucket();

        $imgurl=$_REQUEST['imgurl'];
        $gallery=new Gallery();
        $getrow=$gallery->deleteProductByURL($_REQUEST['ARID'],$imgurl);
        
        if(!$getrow['error']){
            $awsObj=new AWSBucket();
            $awsObj->deleteFromAWS($imgurl);

            $_SESSION['alert_message'] = "Deleted Successfully";

            echo "<script> window.history.back(); window.location.reload(true); </script>";
        }
        else{

            $_SESSION['alert_message'] = "Failed to delete";

            echo "<script> window.history.back(); window.location.reload(true); </script>";

        }

    }

?>

<head>

	 <style type="text/css">
        
    /* Full-screen overlay */
    #UpLoader {
        display: none; /* Initially hidden */
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.8); /* Black background with 80% opacity */
        z-index: 9999; /* Make sure the loader is above other elements */
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;

    }

    /* Ring Loader */
    .myLoader {
        border: 8px solid var(--color-secondary-1); /* Light border for the outer part */
        border-top: 8px solid var(--color-primary-1); /* White color for the spinning part */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite; /* Infinite rotation animation */
    }

    /* Loader Animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }


    </style>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    
    <!-- Loader Element -->
    <div id="UpLoader" style="display: none;">
         <div class="myLoader"></div>
        <h2 style="color: #fff;">Uploading..</h2>
    </div>

            <!-- Placeholder for Bootstrap alerts -->
    <div id="alertPlaceholder"></div>


		<h1 class="h2">AR Invites</h1>

	<form method="post" id="form" class="form-wedding" enctype="multipart/form-data">
			<?php
				if (isset($_REQUEST['btn-submit'])) {

                    // print_r($_REQUEST);
					
					if(isset($_REQUEST['ARID'])){
						$createProduct = $ARInvites->update($_REQUEST['ARID'], $_REQUEST);	
					}else{
						$createProduct = $ARInvites->create($_REQUEST['name'], $_REQUEST['price']);
					}

					if ($createProduct['error']) {
						?>
						<div class="alert alert-danger">
							<?php
							foreach ($createProduct['errorMsgs'] as $msg) {
								if (count($msg))
									echo $msg[0] . "<br>";
							}
							?>
						</div>
						<?php
					}else
					redirect("arinvites/");

				}

	?>
			<div class="row">

  		

				<!-- Name -->
				<div class="mb-3 col-sm-6">
					<label for="name" class="form-label">Name</label>
					<input type="text" class="form-control" id="name" name="name"
						placeholder="Enter AR Name" value="<?= $ARData['name'] ?? '' ?>">
				</div>

				<!-- Price -->
				<div class="mb-3 col-sm-6">
					<label for="price" class="form-label">AR Price</label>
					<input type="number" class="form-control" id="price" name="price"
						placeholder="Enter AR Price" value="<?= $ARData['price'] ?? '' ?>">
				</div>

			</div>

		<!-- Submit Button -->
		<button type="submit" name="btn-submit" class="btn btn-primary"><?= $btn; ?></button>
	</form>



<?php if(isset($_REQUEST['ARID'])){ ?>
		<!--  product gallery  -->
        <div class="d-flex align-items-center">
            <h5>Product Gallery</h5>
        </div>
                        
        <div class="productGallery">
            
            <form  method="post" enctype="multipart/form-data" class="uploadForm">

                <div class="row">

                    <div class="col-sm-5">
                        <input type="file" class="form-control" accept="image/*" name="ARPic" required>
                    </div>

                    <div class="col-sm-3">
                        <!-- Submit Button -->
                        <button type="submit" name="Submit" class="btn btn-primary btn-sm">Add</button>
                    </div>

                </div>

            </form>

        </div>

	     <!--  display product images -->
        <div>

            <div class="d-flex align-items-center gap-4 mt-3 flex-wrap">
        
             <div class="d-flex gap-2 align-items-center">
        <?php 
            if (!$productGallery['error']) {
       			 for ($i = 0; $i < count($productGallery); $i++) {
        ?>
        	 <!-- Image Thumbnail -->
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <a href="<?= $productGallery[$i]['imageURL'] ?>" target="_blank">
                        <img src="<?= $productGallery[$i]['imageURL'] ?>" class="img-fluid" alt="image" style="width: 150px; height: 150px;">
                    </a>
                    <a href="?imgurl=<?= $productGallery[$i]['imageURL'] ?>">
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                    </a>
                </div>


		    	<?php } } ?>

		    	</div>
			</div>
		</div>
<?php } ?>

    </div>

</main>

<script type="text/javascript">
	
const ARID = "<?php echo $_REQUEST['ARID']; ?>";

// Get all forms with the class 'uploadForm'
const forms = document.querySelectorAll('.uploadForm');

// Loop through each form and attach the submit event listener
forms.forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault(); // Prevent normal form submission

        // Show the loader
        document.getElementById('UpLoader').style.display = 'flex';

        const formData = new FormData(this); // Collect the form data from the current form

        try {
            const response = await fetch(`${ARID}/upload`, {
                method: 'POST',
                body: formData
            });

            // Log the raw response text to see what uploader.php is returning
            const responseText = await response.text();
            console.log('Raw response:', responseText);  // Log the entire raw response
            
            // Try parsing the response as JSON
            const result = JSON.parse(responseText);  // Use JSON.parse() manually for better error handling

            if (result.error) {
                displayAlert('danger', 'Error: ' + result.errorMsg); // Show red alert for errors
            } else {
                displayAlert('success', 'File uploaded successfully'); // Show green alert for success

                // Refresh the page after a delay to allow the alert to be visible
                setTimeout(() => {
                    location.reload(); // Refresh the page
                }, 2000); // Adjust the delay time as needed
            }

        } catch (error) {
            console.error('Upload failed:', error);
            displayAlert('danger', 'Upload failed: ' + error.message); 
        } finally {
            // Hide the loader
            document.getElementById('UpLoader').style.display = 'none';
        }

    });
});


// Function to display Bootstrap alerts
function displayAlert(type, message) {
    const alertPlaceholder = document.getElementById('alertPlaceholder');
    const alertElement = document.createElement('div');
    
    alertElement.className = `alert alert-${type} alert-dismissible fade show`; // Bootstrap alert classes
    alertElement.role = 'alert';
    alertElement.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertPlaceholder.append(alertElement); // Append the alert to the placeholder

    // Automatically remove the alert after 5 seconds
    setTimeout(() => {
        alertElement.classList.remove('show');
        alertElement.classList.add('hide');
        alertElement.remove();
    }, 20000);
}


</script>

<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>