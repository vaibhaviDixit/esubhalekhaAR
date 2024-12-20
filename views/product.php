<!DOCTYPE html>
<html lang="en">
<?php 

include("views/partials/head.php");

// errors(1);
locked(['user', 'host', 'manager', 'admin']);

controller("Gallery");
$gallery = new Gallery();

$id = $_REQUEST['id'];
$item = "";
$productData = array();
$productGallery = array();

	if (substr($id, 0, 3) === 'AR_') {

        DB::connect();
        $item = "AR Invite";
        $productData = DB::select('ARInvites ', " * ", " ARID = '$id' ")->fetch();
        DB::close();

        $productGallery = $gallery->getProductGallery($id);
        
    } elseif (substr($id, 0, 5) === 'card_') {

        DB::connect();
        $item = "Smart Card";
        $productData = DB::select('smartCard ', " * ", " cardID = '$id' ")->fetch();
        DB::close();

        $productGallery = $gallery->getProductGallery($id);
        

    } else {
        return;
    }

// print_r($productData);
// echo "<br><br>";
// print_r($productGallery);


?>


<style>
    #app {
        margin-top: 12vh;
        max-height: 100vh !important;
    }

    .thumbnail-container {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .thumbnailImg {
            cursor: pointer !important;
            width: 80px !important;
            height: 80px !important;
            object-fit: cover;
            border: 2px solid transparent;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .thumbnailImg:hover,.active-thumbnail {
            border: 2px solid var(--color-primary-1);
        }

        .main-image {
            width: 100%;
            object-fit: cover;
        }

        .card img{
        	height: inherit !important;
        }
        img {
 		    user-select: all !important;
    		pointer-events: all !important;
		}
</style>

<body>

    <?php require('views/partials/nav.php'); ?>

    <div id="app" class="">
        
        <!-- main content here -->

    <main class="col-md-9 mx-auto col-lg-10 px-md-4 pt-5">
    
        <h1 class="h2"> <?= $item; ?> </h1>

<div class="container mt-3">
    <!-- Product Card -->
    <div class="card p-3">
        <div class="row g-0">
            <!-- Product Images Carousel -->
        <div class="col-md-6">
            <!-- Large Main Image -->
            <img id="mainImage" src="<?= $productGallery[0]['imageURL'] ?>" class="main-image" alt="Main Product Image">

            <!-- Thumbnails -->
            <div class="d-flex justify-content-center align-items-center mt-3 gap-3">
                <?php foreach ($productGallery as $index => $image): ?>
                    <img src="<?= $image['imageURL'] ?>" class="thumbnailImg <?= $index === 0 ? 'active-thumbnail' : '' ?>" alt="Thumbnail <?= $index + 1 ?>" onclick="changeMainImage(this,'<?= $image['imageURL'] ?>')">
                <?php endforeach; ?>
            </div>

        </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <div class="card-body">
                    <h3 class="card-title"><?= $productData['name'] ?></h3>
                    <p class="card-text">Price: <strong>&#8377; <?= $productData['price'] ?></strong></p>
                    <button class="btn btn-primary">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>


    </main>
 
        <?php //include('views/partials/footer.php'); ?> 
    </div>

<script type="text/javascript">
	
	// JavaScript function to change the main image when a thumbnail is clicked
    function changeMainImage(thumbnailElement,imageURL) {
        document.getElementById('mainImage').src = imageURL;

        // Remove the active class from any other thumbnails
        const thumbnails = document.querySelectorAll('.thumbnailImg');
        thumbnails.forEach(thumbnail => thumbnail.classList.remove('active-thumbnail'));

        // Add the active class to the clicked thumbnail
        thumbnailElement.classList.add('active-thumbnail');
    }

</script>

<!-- Owl Carousel CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</body>

</html>




