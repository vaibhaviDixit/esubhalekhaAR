<?php
// errors(1);

// locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');


?>

<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">

<h1 class="h2">View Themes</h1>

<?php


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


?>
  
<div class="container mt-5">
 
<!-- Theme Preview -->
<div class="theme-container">

<!-- Theme Cards -->
<div class="row">

  <?php 
      // track of theme URLs for preview
      $themePreviews = [];

      foreach ($themeFolders as $index => $folder) {
          $themeDetails = [];
          $themeName = ucwords(explode("_", basename($folder))[2]);
          $themeDetails = json_decode(file_get_contents('themes/'.basename($folder).'/manifest.json'), true);

          if ($themeDetails['active']) {
              // Store theme URL and ID in an array for easy navigation
              $themePreviews[] = [
                  'id' => $themeDetails['themeID'],
                  'name' => $themeDetails['themeName'],
                  'url' => route("KaaviaWedsRohan/en?theme=" . $themeDetails['themeID'])
              ];
  ?>
  <!-- Card  -->
  <div class="col-lg-4 col-md-6 col-sm-3 mb-4">
    <div class="card theme-card text-center position-relative" style="overflow: hidden;">
      <!-- Badge for Discount or Trending -->
      <?php if ($themeDetails['isPremium']) { ?>
        <span class="badge bg-danger position-absolute top-0 end-0 m-2">Premium</span>
      <?php } ?>

      <a type="button" href="javascript:void(0);" onclick="showPreviewModal(<?php echo $index; ?>);" class="btn btn-sm btn-primary d-inline position-absolute top-3 start-0 m-2"> <i class="bi bi-arrows-fullscreen"></i> </a>
      
      
  
      <img src="<?php themeAssets(basename($folder), $themeDetails['displayImages'][0]); ?>" class="card-img-top theme-image" alt="Theme Preview">

      <!-- Card Body -->
      <div class="card-body">
      
        <h5 class="card-title"><?php echo $themeDetails['themeName']; ?></h5>
        
        <dt class="card-text text-muted">Price: <?php echo strtoinr($themeDetails['themePrice'], 2); ?></dt>
      
        <!-- Preview and Select Buttons -->
        <div class="d-flex justify-content-center">
          <!-- Live Preview Button -->
          <a href="javascript:void(0);" onclick="showPreviewModal(<?php echo $index; ?>);" class="btn btn-sm btn-primary preview-btn text-light">Preview</a>

        </div>
      </div>
    </div>
  </div>
  <?php
          }
      }
  ?>
</div>

<!-- Preview Modal -->
<div class="modal fade" data-bs-backdrop="static" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        
        <!-- Title -->
        <h5 class="modal-title me-auto" id="previewModalLabel">Theme Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <iframe id="previewIframe" src="" frameborder="0" width="100%" height="500px"></iframe>
      </div>
      
      <!-- Footer with Prev and Next buttons -->
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="navigatePreview(-1)">Prev</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="navigatePreview(1)">Next</button>
      </div>
      
    </div>
  </div>
</div>



<script>
  // Store theme previews in JavaScript
  const themePreviews = <?php echo json_encode($themePreviews); ?>;
  let currentThemeIndex = 0;

  function showPreviewModal(index) {
      currentThemeIndex = index;
      updatePreview();
      $('#previewModal').modal('show');
  }

  function updatePreview() {
      const theme = themePreviews[currentThemeIndex];
      document.getElementById('previewIframe').src = theme.url;
      document.getElementById('previewModalLabel').innerText = theme.name + " Theme";
  }

  function navigatePreview(direction) {
      currentThemeIndex += direction;

      // Wrap around when reaching the ends of the array
      if (currentThemeIndex < 0) {
          currentThemeIndex = themePreviews.length - 1;
      } else if (currentThemeIndex >= themePreviews.length) {
          currentThemeIndex = 0;
      }

      updatePreview();
  }

  function openFullScreen() {
      const url = document.getElementById('previewIframe').src;
      window.open(url, '_blank');
  }
</script>


</div>

<style>
  .theme-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
  }

  /* Ensure the card is responsive */
  @media (max-width: 768px) {
    .theme-image {
      height: 200px; 
    }
  }
</style>



</main>

<!--Main End-->


<?php require('views/partials/dashboard/scripts.php') ?>