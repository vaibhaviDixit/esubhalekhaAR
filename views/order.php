<!DOCTYPE html>
<html lang="en">
<?php 

include("views/partials/head.php");

// errors(1);
// print_r($_SESSION);
if(count($_SESSION['cart']['smartCard']) == 0 && count($_SESSION['cart']['ARInvite']) == 0 && count($_SESSION['cart']['theme']) == 0  ){

    redirect("smart-cards");
}

DB::connect();
$customers = DB::select('users', '*', "status <> 'deleted'")->fetchAll();
DB::close();

$userID = App::getUser()['userID'];
$userPhone = "";
$userName = "";

if(App::getUser()['userID']){
    $userPhone = App::getUser()['phone'];
    $userName = App::getUser()['name'];
}

// locked(['user', 'host', 'manager', 'admin']);
controller("Gallery");
$gallery = new Gallery();

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
   

// Array to store fetched items
$fetchedItems = [];
$totalPrice = 0;

// Check if 'smartCard' is in cart and fetch details if it exists
if (isset($_SESSION['cart']['smartCard'][0])) {

    $smartCardID = $_SESSION['cart']['smartCard'][0];
    
    DB::connect();
    $productData = DB::select('smartCard ', " * ", " cardID = '$smartCardID' ")->fetch();
    DB::close();

    $productData['img'] = $gallery->getProductGallery($smartCardID)[0]['imageURL'];

    $productData['count'] = $_SESSION['cart']['smartCard']['count'] ?? 100;
    $fetchedItems['smartCard'] = $productData;
}

// Check if 'ARInvite' is in cart and fetch details if it exists
if (isset($_SESSION['cart']['ARInvite'][0])) {

    $ARInviteID = $_SESSION['cart']['ARInvite'][0];

    DB::connect();
    $productData = DB::select('ARInvites ', " * ", " ARID = '$ARInviteID' ")->fetch();
    DB::close();

    $productData['img'] = $gallery->getProductGallery($ARInviteID)[0]['imageURL'];

    $fetchedItems['ARInvite'] = $productData;
}

// Check if 'theme' is in cart and fetch details if it exists
if (isset($_SESSION['cart']['theme'][0])) {
    $themeID = $_SESSION['cart']['theme'][0];

                     $websiteThemes = [];

                          foreach ($themeFolders as $index => $folder) {
                              $themeDetails = [];
                              $themeName = ucwords(explode("_", basename($folder))[2]);
                              $themeDetails = json_decode(file_get_contents('themes/'.basename($folder).'/manifest.json'), true);

                              if ($themeDetails['active'] && $themeDetails['themeID'] == $themeID) {
                                  // Store theme URL and ID in an array for easy navigation
                                  $websiteThemes = [
                                      'themeID' => $themeDetails['themeID'],
                                      'name' => $themeDetails['themeName'],
                                      'url' => route("KaaviaWedsRohan/en?theme=" . $themeDetails['themeID']),
                                      'img' => $themeDetails['displayImages'][0],
                                      'folder' => basename($folder),
                                      'price' => $themeDetails['themePrice'],
                                  ];
                              }
                        }


    $fetchedItems['theme'] = $websiteThemes;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cardCount'])) {

    $cardCount = intval($_POST['cardCount']);
    
    $_SESSION['cart']['smartCard']['count'] = $cardCount;

    redirect("order"); 
}

// Build the JSON structure for the cart
$cart = [
    "smartCards" => [
            "id" => $fetchedItems['smartCard']['cardID'],
            "price" => $fetchedItems['smartCard']['price'],
            "count" => $fetchedItems['smartCard']['count'],
            "totalPrice" => $fetchedItems['smartCard']['price'] * $fetchedItems['smartCard']['count']
    ],
    "arInvites" => [
            "id" => $fetchedItems['ARInvite']['ARID'],
            "price" => $fetchedItems['ARInvite']['price']
    ],
    "theme" => [
        "id" => $fetchedItems['theme']['themeID'],
        "price" => $fetchedItems['theme']['price'],
        "validity" => "lifetime" // Assuming "lifetime" as default
    ]
];

// Convert to JSON for storage
$cartJson = json_encode($cart, JSON_PRETTY_PRINT);

$totalPrice = $cart['smartCards']['totalPrice'] + $cart['arInvites']['price'] + $cart['theme']['price'];

// echo $cartJson;

?>


<style>
    #app {
        margin-top: 12vh;
        max-height: 100vh !important;
    }
    img{
        object-fit: cover;
        width: 100px;
        height: 100px !important;
    }
</style>


<!-- Add Razorpay script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<body>

    <?php require('views/partials/nav.php'); ?>

    <div id="app" class="">
        <!-- main content here -->

    <main class="col-md-9 mx-auto col-lg-10 col-9 px-md-4 pt-5">

    <h1 class="h2">Order Summary</h1>

    <div class="mt-4 row">
        <!-- User Name Input -->
        <div class="mb-3 col-sm-4">
            <label for="userName" class="form-label">Name</label>
            <input type="text" class="form-control" id="userName" placeholder="Enter your name" value="<?= $userName; ?>">
            <small id="nameError" class="text-danger"></small>
        </div>

        <!-- Phone Input -->
        <div class="mb-3 col-sm-4">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" placeholder="Enter your phone number" value="<?= $userPhone; ?>"  <?php if($userPhone!=''){ echo "disabled";} ?> >
            <small id="phoneError" class="text-danger"></small>
        </div>

        <!-- Event Date and Time Input -->
        <div class="mb-3 col-sm-4">
            <label for="eventDate" class="form-label">Event Date and Time</label>
            <input type="datetime-local" class="form-control" id="eventDate">
            <small id="dateError" class="text-danger"></small>
        </div>

    </div>

    <div class="">
             <!-- Product Items -->
    <?php foreach ($fetchedItems as  $type => $item ): ?>
        <div class="mb-2 mt-2">
            <div class="d-flex align-items-center">
                <div class="">
                    <?php 
                        if ($type === 'theme'){
                    ?>
                        <img src="<?= themeAssets($item['folder'], $item['img']) ?>" class="img-fluid" alt="<?= $item['name'] ?>">
                     <?php
                        }else{
                    ?>
                    <img src="<?= $item['img'] ?>" class="img-fluid" alt="<?= $item['name'] ?>">
                    <?php
                        }
                    ?>
                </div>
                <div class="">
                    <div class="card-body">
                        <h6 class="card-title"> <?= $item['name'] ?> <?php if ($type === 'theme'): ?>
                                <a href="<?= $item['url'] ?>" target="_blank">(Preview)</a><br>
                            <?php endif; ?></h6>

                        <p class="card-text">
                            
                            <strong>₹<?= $item['price'] ?> </strong> <br>
                            <?php if ($type === 'smartCard'): ?>
                            Sub Total: <strong>₹<?= $cart['smartCards']['totalPrice'] ?> </strong> 
                            <?php endif; ?>

                        </p>
                            <?php if ($type === 'smartCard'){ ?>

                            <form method="post">
                                <label for="cardCount">No. of cards:</label>
                                <select id="cardCount" name="cardCount" onchange="this.form.submit()">
                                    <option value="100" <?php echo (isset($fetchedItems['smartCard']['count']) && $fetchedItems['smartCard']['count'] == 100) ? 'selected' : ''; ?>>100</option>
                                    <option value="200" <?php echo (isset($fetchedItems['smartCard']['count']) && $fetchedItems['smartCard']['count'] == 200) ? 'selected' : ''; ?>>200</option>
                                    <option value="500" <?php echo (isset($fetchedItems['smartCard']['count']) && $fetchedItems['smartCard']['count'] == 500) ? 'selected' : ''; ?>>500</option>
                                    <option value="1000" <?php echo (isset($fetchedItems['smartCard']['count']) && $fetchedItems['smartCard']['count'] == 1000) ? 'selected' : ''; ?>>1000</option>
                                </select>
                                
                            </form>

                            <?php  } ?>

                        
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

    <!-- Total Price -->
    <div class="mt-4">
        <div class="">
            <h4>Total: ₹<?= $totalPrice ?></h4>
            <button class="btn btn-success mt-3 disabled" id="checkoutBtn">Proceed to Checkout</button>
        </div>
    </div>

</main>
 
        <?php //include('views/partials/footer.php'); ?> 
    </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/core.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>

<script type="text/javascript">


    const userName = document.getElementById("userName");
    const phone = document.getElementById("phone");
    const eventDate = document.getElementById("eventDate");
    const checkoutBtn = document.getElementById("checkoutBtn");

    const nameError = document.getElementById("nameError");
    const phoneError = document.getElementById("phoneError");
    const dateError = document.getElementById("dateError");

    let nameE = true;
    let phoneE = true;
    let dateE = true;

    let phones = []

    <?php
    if(!App::getUser()['userID']){
        foreach ($customers as $usr) {
          echo "phones.push('" . md5($usr['phone']) . "')\n";
        }
    }
    ?>

    function validateName() {
        if (userName.value.length >= 6) {
            nameError.textContent = "";
            nameE = false;
            checkInputs();
        } else {
            nameError.textContent = "Name can't be less than 6 characters.";
            nameE = true;
            checkInputs();
        }

    }

    function validatePhone() {

        var regmm = "^([6-9][0-9]{9})$";
        var regmob = new RegExp(regmm);

        if (!regmob.test(phone.value)) {
            phoneError.textContent = "Please enter a valid 10-digit phone number.";
            phoneE = true;
            checkInputs();
        
        } else if (phones.includes(CryptoJS.MD5(phone.value.trim()).toString())) {
            phoneError.textContent = "Phone already in use";
            phoneE = true;
            checkInputs();

        } else {
            phoneError.textContent = "";
            phoneE = false;
            checkInputs();
        }
    }

    function validateDate() {
        const selectedDate = new Date(eventDate.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Set today's date to midnight

        if (selectedDate >= today) {
            dateError.textContent = "";
            dateE = false;
            checkInputs();
        } else {
            dateError.textContent = "Invalid date! Select a future date.";
            dateE = true;
            checkInputs();
        }
    }

    function checkInputs() {
        let errors = nameE + phoneE + dateE;
        console.log(errors)

        // Enable button if all validations pass
        if (errors) {
            checkoutBtn.classList.add("disabled");
        } else{
            checkoutBtn.classList.remove("disabled");
        }
    }

    checkInputs();
    validatePhone();
    validateName();
    validateDate();

    // Event listeners for input fields to validate and check inputs
    userName.addEventListener("focusout", validateName);
    userName.addEventListener("keyup", validateName);

    phone.addEventListener("focusout", validatePhone);
    phone.addEventListener("keyup", validatePhone);

    eventDate.addEventListener("focusout", validateDate);
    eventDate.addEventListener("keyup", validateDate);


    // Razorpay checkout configuration
    var options = {
        key: '<?php echo $config['RAZORPAY_API']; ?>', // should be placed in config.php
        amount: <?= $totalPrice * 100 ?>, // amount in paise
        currency: 'INR',
        name: 'Your Wedding Invitation Plan',
        description: 'Wedding Plan',
        handler: function (response) {
            // Insert data into the database on successful payment
            var paymentId = response.razorpay_payment_id;
            insertIntoDatabase(paymentId);  
        },
        prefill: {
            name: 'eSubhalekha',
            email: 'vaibhavidixit511@gmail.com',
            contact: '9284552192'
        },
        notes: {
            plan_id: 'YOUR_PLAN_ID'
        },
        theme: {
            color: '#86353b'
        }
    };

    var rzp = new Razorpay(options);

    // Event listener for checkout button
    document.getElementById('checkoutBtn').addEventListener('click', function () {
        rzp.open();
    });

    rzp.on('payment.failed', function (response) {
        alert("Payment Failed! " + response.error.description);
    });

    // Function to insert data into the database
    function insertIntoDatabase(paymentId) {
        // Prepare data for AJAX
        var cart = <?php echo json_encode($cart); ?>; // Encode the cart as JSON
        var totalAmount = <?php echo $totalPrice; ?>;
        var userId = <?php echo json_encode($userID); ?>;

        if(userId == null){ userId=''; }

        // Using AJAX
        jQuery.ajax({
            type: 'post',
            url: 'payment',
            data: {
                cart: cart,
                userName: userName.value,
                eventDate: eventDate.value,
                phone: phone.value,
                userID: userId,
                paymentId: paymentId,
                totalAmount : totalAmount
            },
            success: function(result) {
                // console.log(result)
                var response = JSON.parse(result);
                // console.log(response);

                if (!response.error) {
                    // Success case: show success message or take further action
                    // displayAlert('success', response.message); 
                    setTimeout(() => {
                        window.location.href = new URL("/order-history", window.location.origin).href;
                    }, 2000); // Adjust the delay time as needed

                } else {
                    // Error case: display the error message
                    // displayAlert('danger', response.message); 
                    setTimeout(() => {
                        location.reload(); // Refresh the page
                    }, 2000); // Adjust the delay time as needed
                }
            }
        });
    }
</script>



</body>

</html>


