<?php

// errors(1);

locked(['admin']);
require('views/partials/dashboard/head.php');
require('views/partials/admin/sidebar.php');


controller("Order");
$orderController = new Order();


if(isset($_REQUEST['id'])){

    $orderID = base64_decode($_REQUEST['id']);
    $thisOrder = $orderController->getOrderById($orderID);
    $cart = json_decode($thisOrder['cart'], true);

    if($thisOrder['error']){
        redirect("orders");
    }

}else{
    redirect("orders");
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


?>

<head>

	 <style type="text/css">
        

    </style>
<!-- Jquery -->
    <script src="<?php assets("jquery/jquery.min.js"); ?>"></script>
    
</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    

	<h1 class="h2">Edit Order</h1>

	<form method="post" id="form" class="form-wedding" enctype="multipart/form-data">
			<?php
				if (isset($_REQUEST['btn-submit'])) {

                    $_REQUEST['id'] = base64_decode($_REQUEST['id']);

                    $_REQUEST['cart'] = [
                        "smartCards" => [
                                "id" => $_REQUEST['smartCards'],
                                "price" => $_REQUEST['cardPerPrice'],
                                "count" => $_REQUEST['cardCount'],
                                "totalPrice" => $_REQUEST['cardPrice']
                        ],
                        "arInvites" => [
                                "id" => $_REQUEST['arInvites'],
                                "price" => $_REQUEST['arPrice']
                        ],
                        "theme" => [
                            "id" => $_REQUEST['theme'],
                            "price" => $_REQUEST['themePrice'],
                            "validity" => "lifetime" // Assuming "lifetime" as default
                        ]
                    ];

                    $editOrder = $orderController->updateOrder($_REQUEST['id'],$_REQUEST);
                    // print_r($editOrder);

					if ($editOrder['error']) {
						?>
						<div class="alert alert-danger">
							<?php
							foreach ($editOrder['errorMsgs'] as $msg) {
								if (count($msg))
									echo $msg[0] . "<br>";
							}
							?>
						</div>
						<?php
					}else
					redirect("orders/");

				}

	?>
			<div class="row">

  		     <!-- <?php //print_r($thisOrder); ?> -->

                 <!-- User Name Input -->
                <div class="mb-3 col-sm-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?= Auth::getUser($thisOrder['userID'])['name']; ?>" readonly>
                    <small id="nameError" class="text-danger"></small>
                </div>

                <!-- Phone Input -->
                <div class="mb-3 col-sm-4">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?= Auth::getUser($thisOrder['userID'])['phone']; ?>" readonly >
                </div>

                <div class="mb-3 col-sm-4">
                    <label for="totalAmount" class="form-label">Total</label>
                    <input type="number" class="form-control" id="totalAmount" name="totalAmount" value="<?= $thisOrder['totalAmount']; ?>" readonly >
                </div>
			</div>

            <div class="row">
                
                <div class="mb-3 col-sm-4">
                <label for="smartCardSelect" class="form-label">Select Smart Card</label>
                <select id="smartCardSelect" name="smartCards" class="form-select" onchange="cardChange();">
                    <option value="" data-price="0" selected>Skip</option>
                    <?php foreach ($smartCards as $card): ?>
                        <option 
                            value="<?= htmlspecialchars($card['cardID']) ?>" 
                            data-price="<?= htmlspecialchars($card['price']) ?>" 
                            <?php if ($cart['smartCards']['id'] == $card['cardID']) { echo "selected"; } ?>>
                            <?= htmlspecialchars($card['name']) ?>
                        </option>
                    <?php endforeach; ?>

                    </select>
                </div>
                <input type="number" name="cardPerPrice" value="<?= $cart['smartCards']['price'] ?>" id="cardPerPrice" hidden>
                <div class="mb-3 col-sm-4">
                          <label for="cardCount" class="form-label">No. of cards:</label>
                                    <select id="cardCount" name="cardCount" class="form-select" >
                                        <option value="100" <?php echo (isset($cart['smartCards']['count']) && $cart['smartCards']['count'] == 100) ? 'selected' : ''; ?>>100</option>
                                        <option value="200" <?php echo (isset($cart['smartCards']['count']) && $cart['smartCards']['count'] == 200) ? 'selected' : ''; ?>>200</option>
                                        <option value="500" <?php echo (isset($cart['smartCards']['count']) && $cart['smartCards']['count'] == 500) ? 'selected' : ''; ?>>500</option>
                                        <option value="1000" <?php echo (isset($cart['smartCards']['count']) && $cart['smartCards']['count'] == 1000) ? 'selected' : ''; ?>>1000</option>
                                    </select>            
                </div>

                 <div class="mb-3 col-sm-4">
                        <label for="cardPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="cardPrice" name="cardPrice" value="<?= $cart['smartCards']['totalPrice']; ?>" readonly >
                </div>


            </div>


            <div class="row">
                
                <div class="mb-3 col-sm-4">
                <label for="arInvitesSelect" class="form-label">Select AR Invite</label>
                <select id="arInvitesSelect" name="arInvites" class="form-select" onchange="arChange();">
                     <option value="" data-price="0" selected>Skip</option>

                    <?php foreach ($arInvites as $card): ?>
                        <option 
                            value="<?= htmlspecialchars($card['ARID']) ?>" 
                            data-price="<?= htmlspecialchars($card['price']) ?>" 
                           <?php if($cart['arInvites']['id'] == $card['ARID'] ){echo "selected";} ?>  >
                            <?= htmlspecialchars($card['name']) ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>


                 <div class="mb-3 col-sm-4">
                        <label for="arPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="arPrice" name="arPrice" value="<?= $cart['arInvites']['price']; ?>" readonly >
                </div>


            </div>

               <div class="row">
                
                <div class="mb-3 col-sm-4">
                <label for="themeSelect" class="form-label">Select Theme</label>
                <select id="themeSelect" name="theme" class="form-select" onchange="themeChange();">
                    <option value="" data-price="0" selected>Skip</option>
                    <?php foreach ($websiteThemes as $card): ?>
                        <option data-price="<?= htmlspecialchars($card['price']) ?>"
                            value="<?= htmlspecialchars($card['themeID']) ?>" <?php if($cart['theme']['id'] == $card['themeID'] ){echo "selected";} ?>  >
                            <?= $theme->getName($card['themeID']) ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>


                 <div class="mb-3 col-sm-4">
                        <label for="themePrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="themePrice" name="themePrice" value="<?= $cart['theme']['price']; ?>" readonly >
                </div>

                     <div class="mb-3 col-sm-4">
                        <label for="eventDate" class="form-label">Event Date and Time</label>
                        <input type="datetime-local" class="form-control" id="eventDate">
                        <small id="dateError" class="text-danger"></small>
                    </div>


            </div>




		<!-- Submit Button -->
		<button type="submit" name="btn-submit" class="btn btn-primary">Edit</button>
	</form>


</main>

<script>


    // Function to handle smart card selection change
    function cardChange() {
        // Get the selected option element
        const selectedOption = document.getElementById('smartCardSelect').options[document.getElementById('smartCardSelect').selectedIndex];
        
        // Get cardID and price from the selected option
        const selectedCardID = selectedOption.value;
        const cardPrice = selectedOption.getAttribute('data-price');

        document.getElementById('cardPerPrice').value = cardPrice;

        // Get the selected card count
        const cardCount = document.getElementById('cardCount').value;

        // Calculate the total price for the selected card
        const totalPrice = cardPrice * cardCount;

        // Update the card price field
        document.getElementById('cardPrice').value = totalPrice;

        updateTotal();
    }

    function arChange() {
        // Get the selected option element
        const selectedOption = document.getElementById('arInvitesSelect').options[document.getElementById('arInvitesSelect').selectedIndex];
        
        // Get cardID and price from the selected option
        const selectedCardID = selectedOption.value;
        const cardPrice = selectedOption.getAttribute('data-price');

        // Update the card price field
        document.getElementById('arPrice').value = cardPrice;

        updateTotal();
    }

     function themeChange() {
        // Get the selected option element
        const selectedOption = document.getElementById('themeSelect').options[document.getElementById('themeSelect').selectedIndex];
        
        // Get cardID and price from the selected option
        const selectedCardID = selectedOption.value;
        const cardPrice = selectedOption.getAttribute('data-price');

        // Update the card price field
        document.getElementById('themePrice').value = cardPrice;

        updateTotal();
    }

    function updateTotal(){
        let total = 0;
        let cardPrice = parseInt(document.getElementById('cardPrice').value);
        let arPrice = document.getElementById('arPrice').value;
        let themePrice = document.getElementById('themePrice').value;
        total = parseInt(cardPrice) + parseInt(arPrice) + parseInt(themePrice);
        document.getElementById('totalAmount').value = total;
    }

    document.getElementById('cardCount').addEventListener('change', function () {

        cardChange();
    });


</script>


<!-- Owl Carousel CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script type="text/javascript">



</script>

<!--Main End-->