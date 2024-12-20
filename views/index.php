<!DOCTYPE html>
<html lang="en">

<?php include("views/partials/head.php") ?>

<?php
    
    controller("Gallery");
    $gallery = new Gallery();

    DB::connect();
    $smartCards = DB::select('smartCard ', '*', "")->fetchAll();
    $arInvites = DB::select('ARInvites ', '*', "")->fetchAll();
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




?>


<body>
    
    <!-- nav -->
    <?php require('views/partials/nav.php'); ?>

   
    
    <section class="mt-5 container">
        <div class="row">
            <!-- Button Section -->
            <div class="col-12 d-flex justify-content-center">
                <button class="custom-btn rounded-pill px-4 py-2" style="border: none; background-color: #FFFFFF78; font-size: 14px;">
                    for the moments of life
                </button>
            </div>
    
            <!-- Title Section -->
            <div class="col-12 mt-4 text-center">
                <h2 class="fw-bold section-title" style="font-size: 1.8rem;">Wow your guests with eye-catching AR invites</h2>
            </div>
    
            <!-- Swipeable Cards Section -->
            <div class="col-12 mt-4">
                <div class="cards-container d-flex align-items-center justify-content-center">
                    <!-- Card 1 -->
                    <div class="custom-card d-flex row">
                        <h4 class="text-center mt-5">Smart Wedding Card</h4>
                        <p class="text-center">Personalised for you</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="custom-card d-flex row">
                        <h4 class="text-center mt-5">AR-Invites</h4>
                        <p class="text-center">Cool-aesthetic AR-card.</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="custom-card d-flex row">
                        <h4 class="text-center mt-5">Wedding Website</h4>
                        <p class="text-center">Premium crafted websites.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



   <section class="mt-4">
        <h3 class="fw-bold text-center">The Products We Offer</h3>
        <div class="container-fluid px-5">
            <div class="row align-items-center g-4">
                
                <div class="col-md-4 col-sm-12">
                    <div class="p-4 custom-products mobile-custom-product" style="background-color: #F9F9F9; border-radius: 30px;">
                        <h2>Beautiful <span style="color: black;">AR-invites</span> for your wedding.</h2>
                        <div class="explore-btn" style="margin-top: 20px;">Explore</div>
                    </div>
                </div>
    
                
                <div class="col-md-8 col-sm-12">
                    <div class="d-flex align-items-center">
                       
                        <button id="prevBtn1" class="btn d-none">&lt;</button>
    
                        
                        <div class="container mt-4 owl-carousel arOwl owl-theme">

                        <?php 
                             foreach ($arInvites as $invite) {

                                    $arGallery = array();
                                    $arGallery = $gallery->getProductGallery($invite['ARID']);

                        ?>
                         
                           
                            <div class="card custom-products item mb-3 mx-2">
                                <img class="card-img-top product-image" src="<?= $arGallery[0]['imageURL'] ?>" alt="<?= $invite['name'] ?>">
                                <div class="card-body" style="margin-top: 10px;">
                                    <div class="d-flex align-items-center gap-3">
                                        <h3>₹<?= intval($invite['price']) ?></h3>
                                        <p style="margin-top: 5px;"><del>₹35</del></p>
                                        <div class="rounded-pill px-4 py-1" style="font-size: 14px; background-color: #494949; color: white;">45% off</div>
                                    </div>
                                    <p class="card-text mt-3" style="font-size: 14px;"><?= $invite['name'] ?></p>
                                    <p class="card-text" style="font-size: 12px;">by eSubhalekha.com</p>
                                    <div class="d-lg-flex gap-3 mt-3">
                                         <form  method="POST">
                                            <?php   $isItemInCart = isset($_SESSION['cart']['ARInvite']) && in_array($invite['ARID'], $_SESSION['cart']['ARInvite']); 
                                                if($isItemInCart){$btn1="Added to cart";}else{$btn1="Add to cart";}
                                             ?>
                                        <input type="hidden" name="itemType" value="ARInvite">
                                        <input type="hidden" name="itemID" value="<?= $invite['ARID'] ?>">
                                            <button type="submit" name="addToCart" class="btn btn-outline-dark rounded-pill px-4" style="font-size: 11px;"><?= $btn1 ?></button>
                                    </form>

                                        <a href="<?= route("ar-invites"); ?>" class="btn btn-dark rounded-pill px-4" style="font-size: 11px;">Order now</a>
                                    </div>
                                </div>
                            </div>

                              <?php } ?>
                            
                        </div>
                        
                        <button id="nextBtn1" class="btn d-none">&gt;</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

      <section class="mt-4">
        <div class="container-fluid px-5">
            <div class="row align-items-center g-4">
               
                <div class="col-md-5 col-sm-12">
                    <div class="p-4 custom-products websites-custom-product" style="background-color: #1A1A1A; border-radius: 30px;">
                        <h2 style="color: white; margin-top: 20px;">Beautiful Websites<span style="color: gray;"> for your wedding.</span></h2>
                        <div class="d-flex">
                            <div class="py-1 px-2 explore-btn" style="background-color: #D9D9D9; text-align: center; color: #303030; font-size: 20px; width: 100px; height: 40px; border-radius: 60px;  top: 250px;">Explore</div>
                            <img src="<?php assets("img/center.png");?>" alt="middle" style="width: 65%; height: 180px; position: relative; top: 90px; left: 0px;" />
                        </div>
                    </div>
                </div>
    
                
                <div class="col-md-7 col-sm-12">
                    <div class="d-flex align-items-center">
                        
                        <div class="container mt-4 owl-carousel themeOwl owl-theme">

                               <?php
                             foreach ($websiteThemes as $theme) {
                        ?>

                           
                            <div class="card custom-products item mb-3 mx-2">
                                <img class="card-img-top product-image" src="<?= themeAssets($theme['folder'], $theme['img']) ?>" alt="<?= $theme['title'] ?>">
                                <div class="card-body" style="margin-top: 10px;">
                                    <div class="d-flex align-items-center gap-3">
                                        <h3>₹<?= $theme['price'] ?></h3>
                                        <p style="margin-top: 5px;"><del>₹35</del></p>
                                        <div class="rounded-pill px-4 py-1" style="font-size: 14px; background-color: #494949; color: white;">45% off</div>
                                    </div>
                                    <p class="card-text mt-3" style="font-size: 14px;"><?= $theme['title'] ?></p>
                                    <p class="card-text" style="font-size: 12px;">by eSubhalekha.com</p>
                                    <div class="d-lg-flex gap-3 mt-3">

                                          <form  method="POST">
                                        <?php 
                                             $isItemInCart3 = isset($_SESSION['cart']['theme']) && in_array($theme['themeID'], $_SESSION['cart']['theme']);
                                              if($isItemInCart3){$btn3="Added to cart";}else{$btn3="Add to cart";}
                                        ?>
                                    <input type="hidden" name="itemType" value="theme">
                                    <input type="hidden" name="itemID" value="<?= $theme['themeID'] ?>">

                                        <button type="submit" name="addToCart" class="btn btn-outline-secondary rounded-pill px-3" style="font-size: 12px;"><?= $btn3; ?></button>
                                    </form>
                                       

                                        <a href="<?= route("themes"); ?>" class="btn btn-dark rounded-pill px-4" style="font-size: 11px;">Order now</a>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                  
                            
                        </div>
    
                        
                        <button id="nextBtn2 d-none" class="btn">&gt;</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <section class="mt-4">
        <div class="container-fluid px-5">
            <div class="row align-items-center">
               
                <div class="col-lg-4 col-md-5 mb-4 mb-lg-0">
                    <div class="p-4 custom-products mobile-custom-product" style="background-color: #FFFFFF; border-radius: 30px;">
                        <h2 style="color: gray;">Beautiful <span style="color: black;">Smart Wedding Cards</span> for your wedding.</h2>
                        <div class="d-flex align-items-center" style="gap: 16px; margin-top: 40px;">
                            <div class="py-1 px-3" style="background-color: #303030; color: #D9D9D9; font-size: 20px; border-radius: 60px; text-align: center;">Explore</div>
                            <img src="<?php assets("img/card.png");?>" alt="Smart Wedding Cards" style="width: 100%; height: auto; max-width: 150px;">
                        </div>
                    </div>
                </div>
    
               
                <div class="col-lg-8 col-md-7">
                    <div class="d-flex align-items-center">
                       
                        <button id="prevBtn3" class="btn d-none btn-light me-2">&lt;</button>
                        
                        
                        <div class="owl-carousel cardOwl owl-theme w-100">

                                   <?php 


                    foreach ($smartCards as $card) {
                             
                        $productGallery = array();
                        $productGallery=$gallery->getProductGallery($card['cardID']);
                                    
                    ?>
                            
                            <div class="card custom-products item p-3" style="background-color: #FFFFFF; border-radius: 10px;">
                                <img class="card-img-top product-image" src="<?= $productGallery[0]['imageURL'] ?>" alt="<?= $card['name'] ?>">
                                <div class="card-body">
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <h3>₹<?= intval($card['price']) ?></h3>
                                        <p style="margin-top: 4px;"><del>₹35</del></p>
                                        <div class="rounded-pill px-3 py-1" style="background-color: #494949; color: white; font-size: 14px;">45% off</div>
                                    </div>
                                    <p class="card-text" style="font-size: 14px;"><?= $card['name'] ?></p>
                                    <p class="card-text" style="font-size: 12px; color: gray;">by eSubhalekha.com</p>
                                    <div class="d-flex align-items-center" style="gap: 10px;">


                                          <form  method="POST">
                                            <?php 

                                                $isItemInCart2 = isset($_SESSION['cart']['smartCard']) && in_array($card['cardID'], $_SESSION['cart']['smartCard']);

                                                if($isItemInCart2){$btn2="Added to cart";}else{$btn2="Add to cart";}

                                            ?>
                                    <input type="hidden" name="itemType" value="smartCard">
                                    <input type="hidden" name="itemID" value="<?= $card['cardID'] ?>">

                                        <button type="submit" name="addToCart" class="btn btn-outline-dark rounded-pill px-4" style="font-size: 11px;"> <?= $btn2; ?></button>
                                    </form>
                                        
                                  


                                        <a  href="<?= route("ar-invites"); ?>" class="btn btn-dark rounded-pill px-3" style="font-size: 12px;">Order now</a>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                            
                        </div>
                        
                        
                        <button id="nextBtn3" class="btn d-none btn-light ms-2">&gt;</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

  <section class="comments-section">
       <div class="comments-content">
        <div class="comments-floating">
            <div class="comment-bubble">Great service!</div>
            <div class="comment-bubble">I love this product!</div>
            <div class="comment-bubble">Amazing experience!</div>
            <div class="comment-bubble">Highly recommend!</div>
        </div>
           <h2 class="comments-title">They fell in love💗 with our products</h2>
           <p class="comments-subtitle">Our customers fell in love with personalised products shipped with quality</p>
           <div class="comments-floating">
               <div class="comment-bubble">Will definitely come back!</div>
               <div class="comment-bubble">Fantastic support!</div>
               <div class="comment-bubble">Very satisfied!</div>
               <div class="comment-bubble">Best purchase ever!</div>
           </div>
       </div>
    </section>
  
    <!-- footer -->
    <?php include('views/partials/footer.php'); ?> 

<!-- Owl Carousel CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

</body>
</html>
