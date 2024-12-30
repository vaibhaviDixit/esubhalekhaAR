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
            <div class="col-12 d-flex justify-content-center mt-2">
              <!--   <button class="custom-btn rounded-pill px-4 py-2" style="border: none; background-color: #FFFFFF78; font-size: 14px;">
                    for the moments of life
                </button> -->
                <div class="h-4"></div>

                <!-- <a href="<?php echo route('themes-invite'); ?>" class="btn order-now-btn">Getting Start</a> -->

            </div>

            <!-- Title Section -->
            <div class="col-12 mt-5 text-center">
                <h2 class="fw-bold section-title" style="font-size: 1.8rem;">Wow your guests with eye-catching Invitation Websites</h2>
            </div>
    
          
        </div>
         <div class="container-fluid px-5">
                    <div class="d-flex align-items-center timelineDiv">
                        
                        
                        <div class="owl-carousel owl-theme w-100 themeOwl timelineDiv">

                               <?php
                             foreach ($websiteThemes as $theme) {
                        ?>

                           
                            <div class="card custom-products item mb-3 mx-2">
                                <img class="card-img-top product-image" src="<?= themeAssets($theme['folder'], $theme['img']) ?>" alt="<?= $theme['title'] ?>">
                                <div class="card-body" style="margin-top: 10px;">
                                     <h5>₹<?= $theme['price'] ?></h5>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="margin-top: 5px;"><del>₹35</del></div>
                                        <div class="rounded-pill d-flex align-items-center justify-content-center" style="font-size: 14px; background-color: #494949; color: white; padding: 5px 9px; text-align: center;">45% off</div>
                                    </div>
                                    <div class="card-text mt-3" style="font-size: 14px;"><?= $theme['title'] ?></div>
                                    <div class="card-text" style="font-size: 12px;">by eSubhalekha.com</div>
                                    <div class="d-lg-flex gap-3 mt-1">

                                          <form  method="POST">
                                        <?php 
                                             $isItemInCart3 = isset($_SESSION['cart']['theme']) && in_array($theme['themeID'], $_SESSION['cart']['theme']);
                                              if($isItemInCart3){$btn3="Preview";}else{$btn3="Preview";}
                                        ?>
                                    <input type="hidden" name="itemType" value="theme">
                                    <input type="hidden" name="itemID" value="<?= $theme['themeID'] ?>">

                                        <button type="submit" name="addToCart" class="btn btn-outline-secondary rounded-pill  d-flex  align-items-center justify-content-center" style="font-size: 12px; padding: 5px 9px; width: 100%;
    border: 1px solid var(--color-secondary-1);"><?= $btn3; ?></button>
                                    </form>
                                       

                                        <a href="<?= route("themes-invite"); ?>" class="btn btn-dark rounded-pill  d-flex  align-items-center justify-content-center" style="font-size: 12px; padding: 5px 9px;">Order now</a>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                  
                    
                            
                        </div>
    
                      
                    </div>
        </div>
    </section>
    
    
    <section>
        <div class="E-Shublekha-container mb-4">
            <h2 class="E-Shublekha-title">OUR PLANS</h2>
            <div class="E-Shublekha-carousel">
                                
                <!-- Plan 1: Short-Term -->
                <div class="E-Shublekha-card">
                    <div>
                        <h3>Basic</h3>
                        <p>-> Short-term boost for your wedding's online presence</p>
                        <p>-> Includes a wedding website designed for PR purposes</p>
                        <p>-> Active for 1 month before and 1 month after your big day   </p>
                    </div>
                    <div>
                        <p class="fs-4">Rs:999/-</p>
                        
                    </div>
                </div>
                                
                <!-- Plan 2: Yearly -->
                <div class="E-Shublekha-card">
                    <div>
                        <h3>Luxury</h3>
                        <p>-> Ideal choice for extended wedding celebrations</p>
                        <p>-> A wedding website with PR support</p>
                        <p>-> Active for the first year of your marriage.</p>
                    </div>
                    <div>
                        <p class="fs-4">Rs:5999/-</p>
                        
                    </div>
                </div>
                                
                <!-- Plan 3: Lifetime -->
                <div class="E-Shublekha-card">
                    <div>
                        <h3>Premium</h3>
                        <p>-> Everlasting memories with a lifetime wedding website</p>
                        <p>-> Includes PR support throughout</p>
                        <p>-> A digital archive of your beautiful journey together.</p>
                    </div>
                    <div>
                        <p class="fs-4">Rs:11999/-</p>
                        
                    </div>
                </div>
                                
            </div>
        </div>
    </section>


  <section class="comments-section">
  <div class="comments-content ">
          <div class="comments-floating top-comments">
            <div class="comment-bubble">Great service!</div>
            <div class="comment-bubble">I love this product!</div>
            <div class="comment-bubble">Amazing experience!</div>
            <div class="comment-bubble">Highly recommend!</div>
          </div>
          <h2 class="comments-title">They fell in love💗 with our products</h2>
          <p class="comments-subtitle">Our customers fell in love with personalised products shipped with quality</p>
          <div class="comments-floating bottom-comments">
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
