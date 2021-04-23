<?php

include('./include/header-banner.php');

if (isset($_GET['is'])) {
    if ($_GET['is'] == "DE") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "DE-DE";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } elseif ($_GET['is'] == "CH") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "DE-CH";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    }  elseif ($_GET['is'] == "NL") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "NL";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } elseif ($_GET['is'] == "GB") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "US";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } elseif ($_GET['is'] == "PL") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "PL";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } elseif ($_GET['is'] == "US") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "US";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } elseif ($_GET['is'] == "CN") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "ZH-CN";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } elseif ($_GET['is'] == "HK") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "ZH-HK";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } elseif ($_GET['is'] == "TW") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "ZH-TW";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } elseif ($_GET['is'] == "NO") {
        $_SESSION['selfselect'] = "1";
        $_SESSION['selfselectlang'] = "NO";
        header('location: ./');
        $_SESSION['langupdate'] = '<div class="alert alert-success mb-5" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully updated! </strong> Your language got successfully changed to ' . $_SESSION['selfselectlang'] . '.
      </div>';
    } 
}

if (!empty($_GET['callbackURI'])) {
    header('location: '. $_GET['callbackURI']);
}

if ($_SESSION['selfselect'] == '1') {
    $cookie_name = "language_preference";
    $cookie_value = $_SESSION['selfselectlang'];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

?>
<section class="mb-0 mt-5">
    <section class="container pt-4 my-md-5 pt-md-5 text-center border-top">
        <?php echo $_SESSION['langupdate'];?>
        <div class="row">
            <div class="col-6 col-md" style="text-align: left;">
                <h5><?php echo $lang['europe']; ?></h5>
                <ul class="list-unstyled">
                    <li>
                        <a style="color:black;" href="?is=DE"><span class="flag-icon flag-icon-de"></span> <?php echo $lang['de-de']; ?></a>
                    </li>
                    <li>
                        <a style="color:black;" href="?is=CH"><span class="flag-icon flag-icon-ch"></span> <?php echo $lang['de-ch']; ?></a>
                    </li>
                    <li>
                        <!-- <s style="color:black;" href="?is=FR"><span class="flag-icon flag-icon-fr"></span> <?php echo $lang['fr-fr']; ?></s> -->
                    </li>
                    <li>
                        <!-- <s style="color:black;" href="?is=ES"><span class="flag-icon flag-icon-es"></span> <?php echo $lang['es-es']; ?></s> -->
                    </li>
                    <li>
                        <!-- <s style="color:black;" href="?is=IT"><span class="flag-icon flag-icon-it"></span> <?php echo $lang['it-it']; ?></s> -->
                    </li>
                    <li>
                        <!-- <s style="color:black;" href="?is=GR"><span class="flag-icon flag-icon-gr"></span> <?php echo $lang['gr-gr']; ?></s> -->
                    </li>
                    <li>
                        <a style="color:black;" href="?is=NL"><span class="flag-icon flag-icon-nl"></span> <?php echo $lang['nl-nl']; ?></a>
                    </li>
                    <li>
                        <a style="color:black;" href="?is=GB"><span class="flag-icon flag-icon-gb"></span> <?php echo $lang['en-gb']; ?></a>
                    </li>
                    <li>
                        <!-- <s style="color:black;" href="?is=RU"><span class="flag-icon flag-icon-ru"></span> <?php echo $lang['ru-ru']; ?></s> -->
                    </li>
                    <li>
                        <a style="color:black;" href="?is=NO"><span class="flag-icon flag-icon-no"></span> <?php echo $lang['no-no']; ?></a>
                    </li>
                    <li>
                        <a style="color:black;" href="?is=PL"><span class="flag-icon flag-icon-pl"></span> <?php echo $lang['pl-pl']; ?></a>
                    </li>
                </ul>
            </div>
            <div class="col-6 col-md" style="text-align: left;">
                <h5><?php echo $lang['america']; ?></h5>
                <ul class="list-unstyled  ">
                    <li>
                        <a style="color:black;" href="?is=US"><span class="flag-icon flag-icon-us"></span> <?php echo $lang['en-us']; ?></a>
                    </li>
                    <li>
                        <!-- <s style="color:black;" href="?is=ES"><span class="flag-icon flag-icon-mx"></span> <?php echo $lang['mx-mx']; ?></s> -->
                    </li>
                </ul>
            </div>
            <div class="col-6 col-md" style="text-align: left;">
                <h5><?php echo $lang['asia']; ?></h5>
                <ul class="list-unstyled  ">
                    <li>
                        <!-- <s style="color:black;" href="#"><span class="flag-icon flag-icon-jp"></span> <?php echo $lang['jp-jp']; ?></s> -->
                    </li>
                    <li>
                        <a style="color:black;" href="?is=CN"><span class="flag-icon flag-icon-cn"></span> <?php echo $lang['cn-cn']; ?></a>
                    </li>
                    <li>
                        <a style="color:black;" href="?is=HK"><span class="flag-icon flag-icon-hk"></span> <?php echo $lang['hk-hk']; ?></a>
                    </li>
                    <li>
                        <a style="color:black;" href="?is=TW"><span class="flag-icon flag-icon-tw"></span> <?php echo $lang['tw-tw']; ?></a>
                    </li>
                    <li>
                        <!-- <s style="color:black;" href="#"><span class="flag-icon flag-icon-sg"></span> <?php echo $lang['sp-sp']; ?></s> -->
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <p>Huge probs and a big shout-out to: <a href="/user/meko/">meko</a> for translating our asia area, <a href="/user/Huskyy/">Huskyy</a> for translating the polish version, <a href="/user/Fredney/">Fredney</a> for translating the norwegian version and to <a href="/user/awesomecore1">Awesome_core1</a> for translating the dutch version. </p>
        <small>We are happy about any help with our translations - via <a href="/ref?rdc=https://github.com/FiveMods">GitHub</a>.</small>
    </section>
</section>
<?php unset($_SESSION['langupdate']); ?>