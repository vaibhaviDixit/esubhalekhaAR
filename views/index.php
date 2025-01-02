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
            <div class="col-12 d-flex justify-content-center mt-2 center-container">
              <!--   <button class="custom-btn rounded-pill px-4 py-2" style="border: none; background-color: #FFFFFF78; font-size: 14px;">
                    for the moments of life
                </button> -->
                <div class="h-4"></div>

                <!-- <a href="<?php echo route('themes-invite'); ?>" class="btn order-now-btn">Getting Start</a> -->

            </div>

            <!-- Title Section -->
            <div class="col-12 text-center mt-5" style="">
            <span class="fw-bold for-moment section-title badge rounded-pill mt-5 mt-md-0 mb-4 px-4" style="font-size: 1.2rem; border: 1px solid #86363B; ">For the moments of life</span>
                <h2 class="fw-bold section-title" style="font-size: 1.8rem;">Wow your guests with eye-catching Wedding Websites</h2>
            </div>
    
          
        </div>
         <div class="container-fluid px-5">
                    <div class="d-flex align-items-center timelineDiv">
                        
                        
                        <div class="owl-carousel owl-theme w-100 themeOwl timelineDiv">

                               <?php
                             foreach ($websiteThemes as $theme) {
                        ?>

                           
                            <div class="card custom-products item mb-3 mx-2 overflow-hidden">
                                <img class="card-img-top product-image" src="<?= themeAssets($theme['folder'], $theme['img']) ?>" alt="<?= $theme['title'] ?>">
                                <div class="card-body" style="margin-top: 10px;">
                                     <h5>₹<?= $theme['price'] ?></h5>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="margin-top: 5px;"><del>₹3500</del></div>
                                        <div class="rounded-pill d-flex align-items-center justify-content-center" style="font-size: 12px; border: 1px solid #F2D5D7; color : #FFFFFF; background-color : #86363B; padding: 3px 9px; text-align: center;">45% off</div>
                                    </div>
                                    <div class="card-text mt-3" style="font-size: 14px;"><?= $theme['title'] ?></div>
                                    <div class="card-text" style="font-size: 12px;">by eSubhalekha.com</div>
                                    <div class="d-flex gap-2 mt-1">

                                        <a href="<?= $theme['url'] ?>" target="_blank"  class="btn btn-dark rounded-pill  d-flex  align-items-center justify-content-center" style="font-size: 14px; padding: 4px 10px;margin : 15px 0px; border: 1px solid #F2D5D7; color : #FFFFFF; background-color : #86363B;">View</a>

                                          <form  method="POST">
                                        <?php 
                                             $isItemInCart3 = isset($_SESSION['cart']['theme']) && in_array($theme['themeID'], $_SESSION['cart']['theme']);
                                              
                                        ?>
                                    <input type="hidden" name="itemType" value="theme">
                                    <input type="hidden" name="itemID" value="<?= $theme['themeID'] ?>">

                                        <button type="submit" name="addToCart" class="btn btn-outline-secondary rounded-pill  d-flex  align-items-center justify-content-center ordernow-btn" style="font-size: 14px; padding: 4px 10px;margin : 15px 0px; width: 100%;
    border: 1px solid #86363B; color : #86363B; background-color : #FFFFFF">Order Now</button>
                                    </form>
                                       
                                      </div>
                                </div>
                            </div>

                        <?php } ?>
                  
                    
                            
                        </div>
    
                    </div>
        </div>
    </section>
    <div class="flex" style="display: flex; justify-content: center; align-items: center;">
  <a href="<?php echo route('themes'); ?>" class="fw-bold view-theme badge rounded-pill bg-primary my-3 view-all px-3" style="font-size: 1.1rem; border : 1px solid #F2D5D7; cursor: pointer;">
    View all themes
  </a>
</div>
                    
<section id="pricings">
        <div class="E-Shublekha-container container-sm mb-4">
            <h2 class="E-Shublekha-title">Pricing</h2>
            <div class="E-Shublekha-carousel-wrapper">
            <div class="d-flex align-items-center justify-content-between">
            <i class='bi bi-arrow-right-circle-fill carousel-nav next hidden e-subhalekha-next' ></i>
                <div class="E-Shublekha-carousel">
                    <!-- Plan Cards -->
                    <div class="E-Shublekha-card">
                        <!-- <h3>Basic</h3>
                        <p>★ Boost your wedding’s online presence with ease...</p>
                        <p>★ Includes a custom wedding website...</p>
                        <p>★ Active for <strong>1 month</strong>...</p>
                        <p class="fs-4">Rs: <span>999/-</span></p> -->
                        <h3>Basic</h3>
                        <p style="font-size : 35px;">₹999</p>
                        <div>
                            <p style="display: flex; align-items: start; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px; padding-top : 5px;"></i>
                                <span style="color: rgb(56, 56, 56);" class="text-start" >Boost your wedding’s online presence with ease...</span>
                            </p>
                            <p style="display: flex; align-items: center; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px;"></i>
                                <span class="text-start">Includes a custom wedding website...</span>
                            </p>
                            <p style="display: flex; align-items: center; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px;"></i>
                                <span class="text-start">Active for <strong>1 month</strong>...</span>
                            </p>
                            <button style="width:100% ; height : 50px; background-color : #86363B; color : #FFFFFF ; margin-top :20px; border-radius : 10px ; border : 1px solid #F2D5D7" >
                                    1 Month plan
                            </button>
                        </div>  

                        
                    </div>
                    <div class="E-Shublekha-card">
                        <h3>Premium</h3>
                        <p style="font-size : 35px;">₹5,999</p>
                        <div>
                            <p style="display: flex; align-items: start; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px; padding-top : 5px;"></i>
                                <span style="color: rgb(56, 56, 56);" class="text-start">Ideal for couples planning extended celebrations...</span>
                            </p>
                            <p style="display: flex; align-items: center; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px;"></i>
                                <span class="text-start">A beautifully crafted wedding website...</span>
                            </p>
                            <p style="display: flex; align-items: center; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px;"></i>
                                <span>Active for <strong>1 year</strong>...</span>
                            </p>
                            <button style="width:100% ; height : 50px; background-color : #86363B; color : #FFFFFF ; margin-top :20px; border-radius : 10px ; border : 1px solid #F2D5D7" >
                                    1 Year plan
                            </button>
                        </div>   
                    </div>
                    <div class="E-Shublekha-card">
                        <h3>Elite</h3>
                        <p style="font-size : 35px;">₹11,999</p>
                        <div>
                            <p style="display: flex; align-items: start; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px; padding-top : 5px;"></i>
                                <span style="color: rgb(56, 56, 56);" class="text-start">Cherish everlasting memories...</span>
                            </p>
                            <p style="display: flex; align-items: center; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px;"></i>
                                <span class="text-start">Includes ongoing PR support...</span>
                            </p>
                            <p style="display: flex; align-items: center; margin: 5px 0;">
                                <i class='bx bx-check' style="font-size: 1rem; margin-right: 5px;"></i>
                                <span class="text-start">Active for a <strong>lifetime</strong>...</span>
                            </p>
                            <button style="width:100% ; height : 50px; background-color : #86363B; color : #FFFFFF ; margin-top :20px; border-radius : 10px ; border : 1px solid #F2D5D7" >
                                    Lifetime plan
                            </button>
                        </div>   
                    </div>
                </div>
                <i class='bi bi-arrow-left-circle-fill carousel-nav prev hidden e-subhalekha-next'></i>
                </div>
            </div>
        </div>
    </section>




    <section class="e-Subhalekha-comments-section">
      <div class="e-Subhalekha-comments-content">
        <div class="e-Subhalekha-comments-floating e-Subhalekha-top-comments">
          <div class="e-Subhalekha-comment-bubble">Great service!</div>
          <div class="e-Subhalekha-comment-bubble">I love this product!</div>
          <div class="e-Subhalekha-comment-bubble d-none d-sm-block">Amazing experience!</div>
          <div class="e-Subhalekha-comment-bubble d-none d-sm-block">Highly recommend!</div>
        </div>
        <h2 class="e-Subhalekha-comments-title" style="color :#FFFFFF">They fell in love💗 with our products</h2>
        <p class="e-Subhalekha-comments-subtitle" style="color :#D1D1D1">Our customers fell in love with personalised products shipped with quality</p>
        <div class="e-Subhalekha-comments-floating e-Subhalekha-bottom-comments">
          <div class="e-Subhalekha-comment-bubble d-none d-sm-block">Will definitely come back!</div>
          <div class="e-Subhalekha-comment-bubble">Fantastic support!</div>
          <div class="e-Subhalekha-comment-bubble">Very satisfied!</div>
          <div class="e-Subhalekha-comment-bubble d-none d-sm-block">Best purchase ever!</div>
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