<?php
session_start();
$error = "";


if (isset($_POST['submit'])) {
    if (isset($_POST['agree'])) {
        $_SESSION['agreement'] = "agreed";
        $_SESSION['agree'] = 'agree';
        header("Location: CustomerInfo.php");
        exit();
    } else {
        $error = "You must agree the terms and consitions";
        $_SESSION['agree'] = '';
        session_destroy();
    }
}

include("./common/header.php");

?>

<div class="container">
    <h1>Terms and Conditions</h1>

<br/>
<table border='1' style='border-collapse:collapse'>
    <tr>
        <td>
            I agree to abide by the Bank's Terms and Conditions and rules in force and the changes thereto in Terms and Conditions from time to time relating to my account as communicated and made available on the Bank's website
            <br />
        </td>
        
        
    </tr>
    <tr>
        <td>
            I agree the bank before opening any deposit account, will carry out a due diligence as required under know your customer guidelines of the bank. I would be required to submit necessary documents or proofs, such as identity, address, photograph and any such information, I agree to submit the above documents again at periodic intervals, as may be required by the bank. 
            <br />
        
        </td>
        
        
    </tr>
    <tr>
        <td>
            I agree that the Bank can at its sole discretion, amend any of the services/facilities given in my account either wholly or partially at any time by giving me at least 30 days notice and/or provide an option to me to switch to other services/facilities.
            <br />
        </td>
        
        
    </tr>
    
    
</table>
<form action="Disclaimer.php" method="POST">
        <div>
            <br />
            
            <input type="checkbox" name="agree" value="agree"
                <?php if (!empty($_SESSION['agree'])) echo ("checked = checked") ?> />
            <span>I have read and agree with the term of conditions</span>
            <div class="text-danger"><?php echo $error;?></div>
        </div>
    
    <br />
        <button class="btn btn-primary " type="submit" name="submit">Start</button>
    </form>

<br />
    
</div>

<?php include('./common/footer.php'); ?>


</html>