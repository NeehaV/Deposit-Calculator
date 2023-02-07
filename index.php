<?php 
session_start();



include("./common/header.php"); 
 ?>

<div class="container">
    <h1>Welcome to Algonquin Bank </h1>
    <h4>Welcome to Algonquin Bank. To start, please click on the link below</h4>

    <br />
    <ul>
        <li><?php empty($_SESSION['agreement']) ? print('<a class="link" href="DepositeCalculator.php">Deposit Calculator</a>') : print('<a class="link" href="Disclaimer.php">No</a>') ?>
        </li>
    </ul>
</div>

<?php include('./common/footer.php'); ?>

</html>