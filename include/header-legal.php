<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top border-bottom border-white">
    <div class="container">
        <a class="navbar-brand mr-4" href="/">
            <img src="/static-assets/img/brand-side.png" alt="Brand Logo" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item mr-1">
                    <a class="nav-link" href="/legal/"><?php echo $lang['home']; ?></a>
                </li>
                <?php

                if ($_SESSION['language'] == "DE") {
                    echo '<li class="nav-item mr-1">
                      <a class="nav-link" href="/legal/impressum/">Impressum</a>
                   </li>';
                }

                ?>
                <div class="nav-item dropdown show">
                    <a class="nav-link dropdown-toggle" style="color:rgba(255, 255, 255, 0.5);" href="#" id="dropdownMenuLinkCommunity" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Legal pages
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkCommunity">
                        <a class="dropdown-item" href="/legal/legal-notice/"><?php echo $lang['legal-notice']; ?></a>
                        <a class="dropdown-item" href="/legal/privacy-policy/"><?php echo $lang['privacy-policy']; ?></a>
                        <a class="dropdown-item" href="/legal/cookie-consent/"><?php echo $lang['cookie-consent']; ?></a>
                        <a class="dropdown-item" href="/legal/terms-of-service/"><?php echo $lang['terms-of-service']; ?></a>
                        <a class="dropdown-item" href="/legal/upload-policy/"><?php echo $lang['upload-policy']; ?></a>
                        <a class="dropdown-item" href="/legal/account-policy/">Account Policy</a>
                        <a class="dropdown-item" href="/legal/payment-agreement/">Payment Agreement</a>
                    </div>
                </div>

            </ul>
        </div>

    </div>
    </div>
</nav>