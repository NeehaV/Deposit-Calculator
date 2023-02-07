<?php
session_start();

if (!isset($_SESSION['month'])) {
    $_SESSION['month'] = "";
}


if (!isset($_SESSION['agreement'])) {
    header("Location: Disclaimer.php");
    exit();
}



if (empty($_SESSION['correction'])) {
    header("Location: CustomerInfo.php");
    exit();
}


$error = false;
$alarm_checker = "";
$amount =  $rate = $amount_error  = $new_error = "";
$amount_error = $rate_error =  $month_error   = "";



function ValidatePrincipal($amount)
{
    $_SESSION["amount"] = "";
    if (empty($amount)) {
        $GLOBALS['error'] = true;
        return $GLOBALS['amount_error'] = "Please enter a amount";
    } else {
        if ($amount <= 0 || !is_numeric($amount)) {
            $GLOBALS['error'] = true;
            $_SESSION['amount'] = $amount;
            return $GLOBALS['amount_error'] =  "Must be numeric or greater than zero";
        } else {
            $_SESSION['amount'] = $amount;
        }
    }
}

function ValidateRate($rate)
{
    $_SESSION["rate"] = "";
    if (empty($rate)) {
        $GLOBALS['error'] = true;
        return $GLOBALS['rate_error'] = "Please enter a interest rate";
    } else {
        if ($rate < 0 || !is_numeric($rate)) {
            $GLOBALS['error'] = true;
            $_SESSION['rate'] = $rate;
            return $GLOBALS['rate_error'] = "Must be numeric and not negative";
        } else {
            $_SESSION['rate'] = $rate;
        }
    }
}


if (isset($_POST['submit'])) {

    $_SESSION['month'] = $_POST['deposit'];
    $amount = ValidatePrincipal($_POST['amount']);
    $rate = ValidateRate($_POST['rate']);

    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];
    }
    if (isset($_POST['deposit'])) {
        $monthOfPayment = $_POST['deposit'];
    }
    if (isset($_POST['rate'])) {
        $rate = $_POST['rate'];
    }
    if ($error == false) {
        $_SESSION['final'] = "done";
    }
}


if (isset($_POST['previous'])) {
    header("Location: CustomerInfo.php");
    exit();
}

if (isset($_POST['last'])) {
    if (!empty($_SESSION['final'])) {
        header("Location: Complete.php"); 
        exit();
    }
}



include("./common/header.php");

?>


    <div class="container">
        <h2 class="text-center m-4">Deposite Calculator</h2>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="form-group row xx">
                <label for="amount" class="col-sm-2 col-form-label">Principal Amount</label>
                <div class="col-sm-5 yy">
                    <input type="text" name="amount" id="amount" class="form-control" value="<?= empty($_SESSION['amount']) ? $amount : $_SESSION['amount'] ?>">
                    
                </div>
                <div class="text-danger"><?php echo $amount_error;?></div>

            </div>
            <div class="form-group row xx">
                <label for="rate" class="col-sm-2 col-form-label">Interest Rate (%)</label>
                <div class="col-sm-5 yy">
                    <input type="text" name="rate" id="rate" class="form-control" value="<?= empty($_SESSION['rate']) ? $rate : $_SESSION['rate'] ?>">
                    
                </div>
                <div class="text-danger"><?php echo $rate_error;?></div>
            </div>
            <div class="form-group row xx">
                <label for="deposit" class="col-sm-2 col-form-label">Month of deposit</label>
                <div class="col-sm-5">
                    <select name="deposit" class="form-control">
                        <option value="1" <?= $_SESSION['month'] == "1" ? ' selected="selected"' : ''; ?>>1</option>
                        <option value="2" <?= $_SESSION['month'] == "2" ? ' selected="selected"' : ''; ?>>2</option>
                        <option value="3" <?= $_SESSION['month'] == "3" ? ' selected="selected"' : ''; ?>>3</option>
                        <option value="4" <?= $_SESSION['month'] == "4" ? ' selected="selected"' : ''; ?>>4</option>
                        <option value="5" <?= $_SESSION['month'] == "5" ? ' selected="selected"' : ''; ?>>5</option>
                        <option value="6" <?= $_SESSION['month'] == "6" ? ' selected="selected"' : ''; ?>>6</option>
                        <option value="7" <?= $_SESSION['month'] == "7" ? ' selected="selected"' : ''; ?>>7</option>
                        <option value="8" <?= $_SESSION['month'] == "8" ? ' selected="selected"' : ''; ?>>8</option>
                        <option value="9" <?= $_SESSION['month'] == "9" ? ' selected="selected"' : ''; ?>>9</option>
                        <option value="10" <?= $_SESSION['month'] == "10" ? ' selected="selected"' : ''; ?>>10</option>
                        <option value="11" <?= $_SESSION['month'] == "11" ? ' selected="selected"' : ''; ?>>11</option>
                        <option value="12" <?= $_SESSION['month'] == "12" ? ' selected="selected"' : ''; ?>>12</option>
                        <option value="13" <?= $_SESSION['month'] == "13" ? ' selected="selected"' : ''; ?>>13</option>
                        <option value="14" <?= $_SESSION['month'] == "14" ? ' selected="selected"' : ''; ?>>14</option>
                        <option value="15" <?= $_SESSION['month'] == "15" ? ' selected="selected"' : ''; ?>>15</option>
                        <option value="16" <?= $_SESSION['month'] == "16" ? ' selected="selected"' : ''; ?>>16</option>
                        <option value="17" <?= $_SESSION['month'] == "17" ? ' selected="selected"' : ''; ?>>17</option>
                        <option value="18" <?= $_SESSION['month'] == "18" ? ' selected="selected"' : ''; ?>>18</option>
                        <option value="19" <?= $_SESSION['month'] == "19" ? ' selected="selected"' : ''; ?>>19</option>
                        <option value="20" <?= $_SESSION['month'] == "20" ? ' selected="selected"' : ''; ?>>20</option>
                    </select>
                </div>
            </div>
            <div class="form-group row xx">
                <input type="submit" value="Previous" name="previous" class="btn btn-primary m-1" />
                <input type="submit" value="Calculate" name="submit" class="btn btn-primary m-1" />
                <input type="submit" value="Complete" name="last" class="btn btn-primary m-1" />
            </div>
        </form>
       
        <?php if ($error == false && isset($_POST['submit'])) : ?>
            <div class="row">
                <?php
                print("<p class='zz'><strong>The following is the result of your calculation</strong></p>");


                echo "<table class='pp table table-striped table-condensed table-bordered' border =\"1\" style='border-collapse: collapse'>";
                echo "<tr><th>Year</th><th>Princial at Year Start</th><th>Interest for the Year</th>
                        </tr> \n";
                for ($x = 1; $x <= $monthOfPayment; $x++) {
                    $calculation =  $rate / 10;
                    $term = 1 / $monthOfPayment;
                    $total = $amount * $term * $calculation;
                    echo "<tr> \n";
                    for ($col = 1; $col <= 3; $col++) {
                        if ($col == 1) echo "<td>$x</td> \n";
                        elseif ($col == 2) echo "<td>" . round(($amount), 2) . "</td> \n";
                        else echo "<td>" . round($total, 2) . "</td> \n";
                    }
                    $amount += $total;
                    echo "</tr>";
                }
                echo "</table>";
                ?>
            </div>
        <?php endif; ?>
    </div>
    <?php include('./common/footer.php'); ?>