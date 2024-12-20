<!DOCTYPE html>
<html lang="en">
<?php 

include("views/partials/head.php");

// errors(1);
// locked(['user', 'host', 'manager', 'admin']);

controller("Gallery");
$gallery = new Gallery();


?>

<style>
    #app {
        margin-top: 12vh;
        max-height: 100vh !important;
    }
</style>

<body>

    <?php require('views/partials/nav.php'); ?>

    <div id="app" class="">
        <!-- main content here -->

<main class="col-md-9 mx-auto col-lg-10 px-md-4 timelineDiv">
<div class="d-flex align-items-center justify-content-center mb-4">
  <a href="<?= route('smart-cards') ?>" class="btn timelineBtn btn-primary rounded-circle text-secondary active">1</a>
  <span class="line"></span>
  <a href="<?= route('ar-invites') ?>" class="btn timelineBtn btn-primary rounded-circle text-secondary">2</a>
  <span class="line"></span>
  <a href="<?= route('themes-invite') ?>" class="btn timelineBtn btn-primary rounded-circle text-secondary">3</a>
</div>


    <!-- Section 1: Smart Wedding Card -->
    <div id="section1" class="timeline-item mb-5" >
        <h3>1. Smart Wedding Card</h3>
        <div class="owl-carousel owl-theme timelineProducts">
            <?php

            // Dynamic data for Smart Wedding Card
            DB::connect();
            $smartCards = DB::select('smartCard ', '*', "")->fetchAll();
            DB::close();

            foreach ($smartCards as $card) {
                     
                $productGallery = array();
                $productGallery=$gallery->getProductGallery($card['cardID']);
                            
            ?>
                <div class="item">
                    <div class="card text-center">
                        <img src="<?= $productGallery[0]['imageURL'] ?>" alt="<?= $card['name'] ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $card['name'] ?></h5>
                            <p class="card-text">Price: &#8377; <?= $card['price'] ?><br>by eSubhalekha</p>

                            <div class="d-flex align-items-center justify-content-between">

                                <a href="<?= route("smart-cards/".$card['cardID']) ?>" target="_blank" class="btn btn-primary">View</a>
                                
                                <!-- Add to Cart Button -->
                                <form  method="POST">
                                    <input type="hidden" name="itemType" value="smartCard">
                                    <input type="hidden" name="itemID" value="<?= $card['cardID'] ?>">

                                    <?php
                                    // Check if the item is already in the cart
                                    
                                    // Initialize the cart if not already set
                                    if (!isset($_SESSION['cart'])) {
                                        $_SESSION['cart'] = [];
                                    }

                                    // Check if the item is already in the cart
                                    $isItemInCart = isset($_SESSION['cart']['smartCard']) && in_array($card['cardID'], $_SESSION['cart']['smartCard']);
                                    
                                    if ($isItemInCart) {
                                        // If the item is in the cart, show "Added" button
                                        echo '<button type="submit" class="btn btn-success" disabled>Selected</button>';
                                    } else {
                                        // If the item is not in the cart, show "Add" button
                                        echo '<button type="submit" name="addToCart" class="btn btn-secondary">Select</button>';
                                    }
                                    ?>

                            
                                </form>
                                

                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
          <div class="card-body d-flex justify-content-between">
            <form>
                <button type="submit" name="removeFromCart" value="smartCard" class="btn btn-secondary mt-3">Skip</button>
            </form>
            <a href="<?= route('ar-invites') ?>" class="btn btn-primary mt-3">Continue</a>
          </div>
    </div>
 
 </main>
 
        <?php //include('views/partials/footer.php'); ?> 
    </div>

<!-- Owl Carousel CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</body>

</html>


