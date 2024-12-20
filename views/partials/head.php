<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo $config['APP_DESC']; ?>" />
    <meta name="keywords" content="<?php echo $config['APP_KEYWORDS']; ?>" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="author" content="<?php echo $config['APP_AUTHOR']; ?>" />
    <meta name="robots" content="follow" />
    <link rel="canonical" href="<?php echo url(); ?>" />
    <link rel="icon" href="<?php echo route($config['APP_ICON']); ?>" />
    <meta name="theme-color" content="<?php echo $config['APP_THEME_COLOR']; ?>" />

    <!-- OPEN GRAPH -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $config['APP_TITLE'] ?>" />
    <meta property="og:url" content="<?php echo url(); ?>" />
    <meta property="og:description" content="<?php echo $config['APP_DESC']; ?>" />
    <meta property="og:image" itemprop="image" content="<?php echo route($config['APP_OG_ICON_MOBILE']); ?>" />
    <meta property="og:image:secure_url" itemprop="image"
        content="<?php echo route($config['APP_OG_ICON_MOBILE']); ?>" />
    <meta property="og:site_name" content="<?php echo $config['APP_NAME']; ?>" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo $config['APP_TITLE']; ?>" />
    <meta name="twitter:description" content="<?php echo $config['APP_DESC']; ?>" />
    <meta name="twitter:image" content="<?php echo route($config['APP_OG_ICON_MOBILE']); ?>" />
    <meta name="twitter:creator" content="<?php echo $config['APP_TWITTER_CREATOR']; ?>">

    <!-- Bootstrap core CSS -->
    <link href="<?php assets("bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <script src="<?php assets("bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>

    <!-- Jquery -->
    <script src="<?php assets("jquery/jquery.min.js"); ?>"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />


    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?php assets("css/common.css");?>">
    <link rel="stylesheet" href="<?php assets("css/app.css"); ?>">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" 
          integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" 
          integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://unpkg.co/gsap@3/dist/gsap.min.js"></script>
    <script src="https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/gsap@3/dist/ScrollToPlugin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <title>
        <?php echo $config['APP_TITLE']; ?>
    </title>


     <script>
$(document).ready(function() {


     $(".timelineProducts").owlCarousel({
        items: 3,
        margin: 10,
        nav: true,
        dots: false,
         navText: ["<span class='carousel-control-prev-icon'></span>", "<span class='carousel-control-next-icon'></span>"], 
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 3 }
        },
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true
        
    });
     
    // Owl Carousel Configurations
    var owl1 = $('.arOwl');
    var owl2 = $('.themeOwl');
    var owl3 = $('.cardOwl');

    // Shared Owl Carousel settings
    var owlSettings = {
        responsive: {
            0: { items: 1 },
            770: { items: 2 },
            1310: { items: 3 }
        },
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true
    };

    // Initialize Owl Carousels
    owl1.owlCarousel(owlSettings);
    owl2.owlCarousel(owlSettings);
    owl3.owlCarousel(owlSettings);

    // Navigation buttons for Owl Carousels
    $('#prevBtn1').click(function() { owl1.trigger('prev.owl.carousel'); });
    $('#nextBtn1').click(function() { owl1.trigger('next.owl.carousel'); });
    $('#prevBtn2').click(function() { owl2.trigger('prev.owl.carousel'); });
    $('#nextBtn2').click(function() { owl2.trigger('next.owl.carousel'); });
    $('#prevBtn3').click(function() { owl3.trigger('prev.owl.carousel'); });
    $('#nextBtn3').click(function() { owl3.trigger('next.owl.carousel'); });

    // Navbar toggle
    function toggleNavbar() {
        var navbar = document.querySelector('.navbar-nav');
        navbar.classList.toggle('show');
    }

    // Card Swipe Cycle Animation
    class CardSwipeCycle {
        constructor(cardStack) {
            this.cardStack = cardStack;
            this.cards = Array.from(cardStack.children);
            this.currentIndex = 0;
            this.startAnimation();
        }

        startAnimation() {
            console.log('Start animation');
            this.animateNextCard();
        }

        animateNextCard() {
            // Remove active and swipe classes
            this.cards.forEach(card => card.classList.remove('active', 'swipe-left'));

            const currentCard = this.cards[this.currentIndex];
            currentCard.classList.add('active');

            setTimeout(() => {
                currentCard.classList.add('swipe-left');
                setTimeout(() => {
                    this.cardStack.appendChild(currentCard);
                    this.currentIndex = (this.currentIndex + 1) % this.cards.length;
                    setTimeout(() => this.animateNextCard(), 500);
                }, 700);
            }, 2000);
        }
    }

    // Initialize Card Swipe Cycle
    const cardStack = document.querySelector('.cards-container');
    if (cardStack) {
        console.log('Initializing CardSwipeCycle...');
        new CardSwipeCycle(cardStack);
    } else {
        console.error('Card stack not found in the DOM.');
    }
});


    </script>


<style type="text/css">
    
    /* General Styles */
body {
    background-image: url(<?php assets('img/Group71.svg') ?>);
    font-family: "Roboto", serif;
    margin: 0;
    padding: 0;
}

/* Container Styles */
.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

/* Navbar Styles */
.main-navbar {
    background-color: white;
    border-radius: 90px;
    padding: 10px 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.main-navbar .navbar-brand {
    font-size: 1rem;
    font-weight: bold;
    color: #86363b;
}

.main-navbar .navbar-nav .nav-link {
    color: #5f6368;
    font-weight: 500;
    margin: 0 15px;
    transition: color 0.3s ease;
}

.main-navbar .navbar-nav .nav-link:hover {
    color: #ff5e63;
}

/* Product Card Styles */
.custom-card {
    background-image: url(<?php assets('img/image1.png') ?>);
    width: 325px; 
    height: 300px; 
    background-repeat: no-repeat;
}

.card.custom-products {
    background-color: #FFFFFF;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin: 15px;
    padding: 20px;
    transition: transform 0.2s;
}

.card.custom-products:hover {
    transform: scale(1.05);
}

.product-image {
    height: 250px;
    width: 100%;
}

/* Button Styles */
.order-now-btn {
    color: var(--color-white) !important;
    background-color: var(--color-primary-1);
    border: 2px solid var(--color-primary-1);
    padding: 10px 20px;
    border-radius: 30px;
    transition: background-color 0.3s ease;
}

.order-now-btn:hover {
    color: var(--color-white) !important;
    background-color: var(--color-primary-1);
    border-color: var(--color-primary-1);
}

/* Comments Section Styles */
.comments-section {
    width: 100%;
    background-color: #404040;
    padding: 40px 20px;
    position: relative;
    overflow: hidden; /* Prevents overflow of floating comments */
}

.comments-content {
    text-align: center;
    position: relative;
}

.comments-title {
    color: #FFFFFF;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.comments-subtitle {
    color: #FFFFFF;
    font-size: 1.2rem;
    margin-bottom: 20px;
}

.comments-floating {
    position: relative;
    height: 300px; /* Set a height for the floating area */
}

.comment-bubble {
    background-color: #FFFFFF;
    color: #000;
    padding: 10px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    position: absolute; /* Positioning for random placement */
    animation: float 5s ease-in-out infinite;
    opacity: 0.9; /* Slight transparency */
}

/* Random positions for each comment bubble */
.comment-bubble:nth-child(1) { top: 45%; left: 5%; }
.comment-bubble:nth-child(2) { top: 20%; left: 30%; }
.comment-bubble:nth-child(3) { top: 40%; left: 70%; }
.comment-bubble:nth-child(4) { top: 50%; left: 50%; }
.comment-bubble:nth-child(5) { top: 30%; left: 100%; }
.comment-bubble:nth-child(6) { top: 60%; left: 20%; }
.comment-bubble:nth-child(7) { top: 70%; left: 40%; }
.comment-bubble:nth-child(8) { top: 80%; left: 60%; }

/* Floating Animation */
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Footer Styles */
.footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-top: 1px solid #C5C5C5;
}

.footer p {
    margin: 0;
}

section:nth-child(3){
    position: relative;
    top: 4vh;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .custom-card {
        margin: 10px;
    }

    .footer {
        flex-direction: column; 
        align-items: center; 
        text-align: center; 
        padding: 20px 10px;
    }

    .footer p {
        margin: 5px 0; 
    }

    .navbar-toggler {
        border: none;
        padding: 10px;
        border-radius: 5px;
    }

    .navbar-toggler:focus {
        outline: none;
    }

    /* Navbar Collapse Adjustments */
    .navbar-collapse {
        text-align: center; /* Center the nav links */
    }

    .navbar-nav {
        flex-direction: column; /* Stack the nav links vertically */
    }

    .navbar-nav .nav-item {
        margin: 10px 0; /* Space between items */
    }

    .navbar-nav .nav-link {
        color: #5f6368;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        color: #ff5e63;
    }

    .order-now-btn {
        margin-top: 10px; /* Add margin for spacing */
    }

    .custom-card.active {
        transform: translateY(-60px) scale(1.05) rotate(0deg) !important;
        z-index: 10;
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .custom-card.swipe-left {
        transform: translateX(-150%) rotate(-20deg) !important;
        opacity: 0;
    }

    .cards-container{
        position: relative;
        height: 40vh;
        transition: transform 0.7s ease, opacity 0.7s ease;
    }

    .text-center{
        position: relative;
        bottom: 5vh;
    }

    .custom-card {
        position: absolute;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        transition: 
            transform 0.7s cubic-bezier(0.4, 0, 0.2, 1), 
            opacity 0.7s;
    }

    .custom-card:nth-child(1) { 
        transform: rotate(-4deg) translateY(0px);
        z-index: 1; 
    }
    ..custom-card:nth-child(2) { 
        transform: rotate(3deg) translateY(15px);
        z-index: 2; 
    }
    ..custom-card:nth-child(3) { 
        transform: rotate(-2deg) translateY(30px);
        z-index: 3; 
    }

    .comments-floating {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    .comments-section {
        padding: 20px 10px;
    }

    .comments-title {
        font-size: 1.5rem;
    }

    .comments-subtitle {
        font-size: 1rem;
    }

    .comment-bubble {
        font-size: 0.8rem;
        padding: 8px 15px;
    }

    /* Adjust random positions for mobile */
    .comment-bubble:nth-child(1) { top: 30%; left: 5%; }
    .comment-bubble:nth-child(2) { top: 15%; left: 20%; }
    .comment-bubble:nth-child(3) { top: 20%; left: 60%; }
    .comment-bubble:nth-child(4) { top: 35%; left: 40%; }
    .comment-bubble:nth-child(5) { top: 45%; left: 75%; }
    .comment-bubble:nth-child(6) { top: 50%; left: 10%; }
    .comment-bubble:nth-child(7) { top: 90%; left: 30%; }
    .comment-bubble:nth-child(8) { top: 75%; left: 50%; }
}

/* for arinvites, smartcards and themes*/

.timelineDiv .card img{
    height: 300px;
    object-fit: cover;
}
.timelineDiv .line {
  width: 70px; 
  height: 2px;
  background-color: var(--color-primary-1);
  margin: 0 -10px;
}
.timelineDiv .timelineBtn{
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.timelineDiv .timelineBtn.active {
  background-color: var(--color-secondary-1) !important; 
  color: var(--color-primary-1) !important;
  border-color: var(--color-primary-1) !important;
}
.timelineDiv .owl-carousel .owl-nav {
    position: absolute;
    top: 50%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    transform: translateY(-50%);
    border-radius: 50%;
}
.timelineDiv .owl-carousel{
    margin-top:20px;
}
.timelineDiv owl-theme .owl-nav [class*=owl-]:hover {
    background: transparent !important;
}

.timelineDiv .owl-carousel .owl-nav .owl-prev,
.timelineDiv .owl-carousel .owl-nav .owl-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.timelineDiv .owl-carousel .owl-nav button.owl-next, .owl-carousel .owl-nav button.owl-prev, .owl-carousel button.owl-dot {
    background: none !important;
}
.timelineDiv .owl-carousel .owl-nav .owl-prev {
    left: -25px; 
}

.timelineDiv .owl-carousel .owl-nav .owl-next {
    right: -25px; 
}


.timelineDiv .owl-carousel .owl-nav .owl-prev span,
.timelineDiv .owl-carousel .owl-nav .owl-next span {
    font-size: 2rem;
    color: var(--color-secondary-1); 
    background-color: var(--color-primary-1); 
    padding: 0.5rem;
    border-radius: 50%;
    transition: background-color 0.3s, color 0.3s;
}


.timelineDiv .owl-carousel .owl-nav .owl-prev:hover span,
.timelineDiv .owl-carousel .owl-nav .owl-next:hover span {
    background-color: var(--color-primary-1); 
    color: var(--color-secondary-1); 
}


</style>

</head>



<?php

    
// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    $_SESSION['cart']['smartCard'] = array();
    $_SESSION['cart']['ARInvite'] = array();
    $_SESSION['cart']['theme'] = array();
}

// Check if the form is submitted for "Add to Cart"
if (isset($_POST['addToCart'])) {
    $itemType = $_POST['itemType'];
    $itemID = $_POST['itemID'];

    // Add the item to the cart if it's not already there
    if (!$_SESSION['cart'][$itemType]) {
        $_SESSION['cart'][$itemType][] = $itemID;
    } else {
        unset($_SESSION['cart'][$itemType]);
        $_SESSION['cart'][$itemType][] = $itemID;

    }
    echo "<script>window.location.href=window.location.href; </script>";
}

// "Remove from Cart"
if (isset($_REQUEST['removeFromCart'])) {
    $itemType = $_REQUEST['removeFromCart'];
    // Check if the cart session is set and remove the item if it exists
    if (isset($_SESSION['cart'][$itemType])) {
        $_SESSION['cart'][$itemType] = []; 
    }

    if ($itemType == "smartCard") {
        redirect("ar-invites/");
    }elseif ($itemType == "ARInvite") {
        redirect("themes-invite");
    }elseif ($itemType == "theme") {
        redirect("order");
    }
 
    
}


?>

