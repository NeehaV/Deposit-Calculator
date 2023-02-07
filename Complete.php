<?php
session_start();

if (!isset($_SESSION['agreement'])) {
    header("Location: Disclaimer.php");
    exit();
}

if (empty($_SESSION['correction'])) {
    header("Location: CustomerInfo.php");
    exit();
}

if (empty($_SESSION['final'])){
    header("Location: DepositeCalculator.php");
    exit();
}
session_destroy();

include("./common/header.php");
?>

<div class="container">
    
    <h1 class="text-secondary text-left">Thank you <strong class="text-primary"><?php print($_SESSION['name']) ?></strong>, for using our deposit calculator!</h1>
    <div>
        <?php

        if ($_SESSION['contact'] == "phone") {
            if (count($_SESSION['days']) == 2) {
                print(" <p class=' text-left text-secondary'><strong>Our Customer service will call you tomorrow " . $_SESSION['days'][0] . " or " . $_SESSION['days'][1] . " at " . $_SESSION['phone'] . "</strong></p>");
            } else {
                if (count($_SESSION['days']) == 3) {
                    print("<p class=' text-left text-secondary'><strong>Our Customer service will call you tomorrow " . $_SESSION['days'][0] . " , " . $_SESSION['days'][1] . " or " . $_SESSION['days'][2] . " at " . $_SESSION['phone'] . "</strong></p>");
                } else {
                    print("<p class=' text-left text-secondary'><strong>Our Customer service will call you tomorrow " . $_SESSION['days'][0] . "  at " . $_SESSION['phone'] . "</strong></p>");
                }
            }
        }
        if ($_SESSION['contact'] == "email") {
            print("<p class='gg text-left text-secondary'><strong>Our Customer service will email you soon at " . $_SESSION['email'] . "</strong></p>");
        }
        ?>
    </div>
</div>

<?php include('./common/footer.php'); ?>