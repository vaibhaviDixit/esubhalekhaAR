<header>
        <div class="h-4">. </div>
        <nav class="navbar navbar-expand-lg navbar-light main-navbar">
            
            <a href="<?= route("/"); ?>">
                <img  src="<?php assets('img/logo-esubhalekha.com.svg') ?>" alt="logo" style="width: 160px; height: 40px; margin-top: -4px;" />
            </a>
            
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse  me-auto navbar-collapse nav-tabs" id="navbarSupportedContent">

                  <?php if (url() != route('login')) { ?>

                   <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link font-heading" aria-current="page" href="<?= route("/"); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-heading" aria-current="page" href="#">Demo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-heading" aria-current="page" href="#">Price</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-heading" aria-current="page" href="#">Themes</a>
                    </li>

                    <?php if (App::getSession()) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link font-heading dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <?php echo App::getUser()['name']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?php echo route('dashboard'); ?>">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" aria-current="page"
                                        href="<?php echo route('logout'); ?>">Logout</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <?php if (!App::getSession()) { ?>
                            <a class="nav-link font-heading btn btn-secondary rounded-pill" aria-current="page"
                                href="<?php echo route('register') . "?back=" . url(); ?>">Login/Signup</a>
                        <?php } ?>
                    </li>
                </ul>

            <?php } ?>

                <a href="<?php echo route('themes-invite'); ?>" class="btn order-now-btn">Order Now</a>
            </div>
        </nav>
    </header>