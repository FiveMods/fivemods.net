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
                    <a class="nav-link" href="/"><?php echo $lang['home']; ?></a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link" href="/legal-notice/"><?php echo $lang['legal-notice']; ?></a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link" href="/privacy-policy/"><?php echo $lang['privacy-policy']; ?></a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link" href="/terms-of-service/"><?php echo $lang['terms-of-service']; ?></a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link" href="/cookie-consent/"><?php echo $lang['cookie-consent']; ?></a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link" href="/upload-policy/"><?php echo $lang['upload-policy']; ?></a>
                </li>
                <li class="nav-item mr-1">
                    <a class="nav-link" href="/account-policy/">Account Policy</a>
                </li>
                <?php

                if ($_SESSION['language'] == "DE") {
                    echo '<li class="nav-item mr-1">
                      <a class="nav-link" href="/impressum/">Impressum</a>
                   </li>';
                }

                ?>

            </ul>
        </div>
    </div>
    </div>
</nav>