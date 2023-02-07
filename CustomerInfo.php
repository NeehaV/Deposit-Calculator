<?php
session_start();

$_SESSION['correction'] = "";


if (!isset($_SESSION['agreement'])) {
    header("Location: Disclaimer.php");
    exit();
}


$_SESSION['days']=array();
$dayTime = array();
$error = false;
$email_checker = "";
$email = $phone = $postal = $new_error = $name = "";
$name_error = $contact_error = $postal_error = $phone_error = $email_error = "";

function ValidateName($name)
{
    $_SESSION['name'] = "";
    $name = trim($name);
    if (empty($name)) {
        $GLOBALS['error'] = true;
        $GLOBALS['name_error'] = "Name is Required";
        return;
    } else {
        $_SESSION['name'] = $name;
    }
}
function ValidatePostal($postal)
{
    $_SESSION['postal'] = "";
    if (empty($postal)) {
        $GLOBALS['error'] = true;
        return $GLOBALS['postal_error'] = "Enter your postal code";
    } else {
        $reg = "/[a-zA-Z][0-9][a-zA-Z]\s*[0-9][a-zA-Z][0-9]/";
        if (!preg_match($reg, $postal)) {
            $GLOBALS['error'] = true;
            return $GLOBALS['postal_error'] = "Incorrect postal code";
        } else {
            $_SESSION['postal'] = $postal;
        }
    }
}


function ValidatePhone($phone)
{
    $_SESSION['phone'] = "";
    if (empty($phone)) {
        $GLOBALS['error'] = true;
        return $GLOBALS['phone_error'] = "Enter your phone number";
    } else {
        $reg = "/^[2-9][0-9][0-9][\s-]?[2-9][0-9][0-9][\s-]?([0-9]{4,4})$/";
        if (!preg_match($reg, $phone)) {
            $GLOBALS['error'] = true;
            return $GLOBALS['phone_error'] = "Incorrect phone number";
        } else {
            $_SESSION['phone'] = $phone;
        }
    }

    // $phone_checker = str_split($phone);
    // $firstNumber = implode("", array_slice($phone_checker, 0, 1));
    // $secondNumber = implode("", array_slice($phone_checker, 4, 1));
    // $firstCharacter = implode("", array_slice($phone_checker, 3, 1));
    // $secondCharacter = implode("", array_slice($phone_checker, 7, 1));
    // $numbers = array();
    // $charachters = array();
    // array_push($numbers, $firstNumber);
    // array_push($numbers, $secondNumber);
    // array_push($charachters, $firstCharacter);
    // array_push($charachters, $secondCharacter);
    // foreach ($charachters as $key) {
    //     if ($key != "-") {
    //         $GLOBALS['error'] = true;
    //         return $GLOBALS['phone_error'] = "Incorrect format | (000-000-0000)";
    //     }
    // }
    // foreach ($numbers as $key) {
    //     if ($key == 0 || $key == 1) {
    //         $GLOBALS['error'] = true;
    //         return $GLOBALS['phone_error'] = "First/Second 3 digits cannot 0 or 1";
    //     }
    // }

}


function ValidateEmail($email)
{
    if (empty($email)) {
        $GLOBALS['error'] = true;
        return $GLOBALS['email_error'] = "Enter your email";
    } else {
        $reg = "/^([a-z]+)@([a-z]+)\.([a-z]{2,4})$/";
        if (!preg_match($reg, $email)) {
            $GLOBALS['error'] = true;
            return $GLOBALS['email_error'] = "Incorrect email";
        } else {
            $_SESSION['email'] = $email;
        }
    }

    // $email_checker = str_split($email);
    // $email_checker =  array_reverse(array_slice(array_reverse($email_checker), 0, 6));

    // $stringOfEmail = implode("", $email_checker);
    // if (stripos($stringOfEmail, ".") >= 4) {
    //     $GLOBALS['error'] = true;
    //     return $GLOBALS['email_error'] = "Domain must between 2 to 4 letters";
    // }

    // $x = array_search(".", $email_checker);
    // if (!$x) {
    //     $GLOBALS['error'] = true;
    //     return $GLOBALS['email_error'] = "Domain must between 2 to 4 letters";
    // }
}






if (isset($_POST['next'])) {
    unset($_SESSION['morning']);
    unset($_SESSION['afternoon']);
    unset($_SESSION['evening']);
    $time = isset($_POST['time']);
    $dayTime = array();
    $name = ValidateName($_POST['name']);
    $postal = ValidatePostal($_POST['code']);
    $phone = ValidatePhone($_POST['number']);
    $email = ValidateEmail($_POST['mail']);
    if (empty($_POST['contact'])) {
        $GLOBALS['error'] = true;
        $contact_error = "Choose your method of contact";
    }

    if (empty($_POST['contact'])) {
        $GLOBALS['error'] = true;
        $contact_error = "Choose your method of contact";
    }

    if (isset($_POST['contact']) && $_POST['contact'] == "phone") {
        $_SESSION["contact"] = "phone";
        if (!$time) {
            $GLOBALS['error'] = true;
            $new_error = "If you use phone, you have to use at least one preferred range of day time";
        } else {
            foreach ($_POST['time'] as $x) {
                array_push($dayTime, $x);
                $_SESSION[$x] = $x;
                array_push($_SESSION['days'],$x); 
            }
        }
    } else {
        unset($_SESSION['morning']);
        unset($_SESSION['afternoon']);
        unset($_SESSION['evening']);
    }

    if (isset($_POST['contact']) && $_POST['contact'] == "email") {
        $_SESSION["contact"] = "email";
    }

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    }
    if (isset($_POST['code'])) {
        $postal = $_POST['code'];
    }
    if (isset($_POST['number'])) {
        $phone = $_POST['number'];
    }

    if (isset($_POST['mail'])) {
        $email = $_POST['mail'];
    }

    if ($error == null) {
        $_SESSION['correction'] = "correct";
        header("Location: DepositeCalculator.php");
        exit();
    }
}


include("./common/header.php");
?>

<div class="container">
    <h2 class="text-center m-4">Customer Information</h2>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

        <div class="form-group row xx">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-5 yy">
                <input type="text" name="name" id="name" class="form-control"
                    value="<?= empty($_SESSION['name']) ? $name : $_SESSION['name'] ?>">
                
            </div>
            <div class="text-danger"><?php echo $name_error;?></div>
        </div>
        <div class="form-group row xx">
            <label for="code" class="col-sm-2 col-form-label">Postal Code</label>
            <div class="col-sm-5 yy">
                <input type="text" name="code" id="code" class="form-control"
                    value="<?= empty($_SESSION['postal']) ? $postal : $_SESSION['postal'] ?>">
               
            </div>
            <div class="text-danger"><?php echo $postal_error;?></div>
        </div>
        <div class="form-group row xx">
            <label for="number" class="col-sm-2 col-form-label">Phone Number</label>
            <div class="col-sm-5 yy">
                <input type="text" name="number" id="number" class="form-control"
                    value="<?= empty($_SESSION['phone']) ? $phone : $_SESSION['phone'] ?>">
                
            </div>
            <div class="text-danger"><?php echo $phone_error;?></div>
        </div>
        <div class="form-group row xx">
            <label for="mail" class="col-sm-2 col-form-label">Email Address</label>
            <div class="col-sm-5 yy">
                <input type="text" name="mail" id="mail" class="form-control"
                    value="<?= empty($_SESSION['email']) ? $email : $_SESSION['email'] ?>">
                
            </div>
            <div class="text-danger"><?php echo $email_error;?></div>
        </div>
        <div class="form-group row xx">
            <p class="col-md-2"><strong>Prefered Contact Method: </strong> </p>
            <div class="col-md-5 form-check">
                <label class="form-check-label col-3"> <input class="m-1" type="radio" name="contact" value="phone"
                        <?php if (isset($_SESSION['contact']) && $_SESSION['contact'] == "phone") echo ("checked = checked") ?>>Phone</label>
                <label class="form-check-label col-3"><input class="m-1" type="radio" name="contact" value="email"
                        <?php if (isset($_SESSION['contact']) && $_SESSION['contact'] == "email") echo ("checked = checked") ?>>Email</label>

            </div>
            
            
            <div class="text-danger"><?php echo $contact_error;?></div>
        </div>
        <hr />
        <div class="form-group row xx">
            <p class="col-md-4"><strong>If Phone is selected when we can contact you? (use all the
                    possibilities)</strong></p>
            <div class="col-3">
                <label class="checkbox-inline"> <input type="checkbox" class="checkbox-inline m-1" name="time[]"
                        value="morning"
                        <?php if (isset($_SESSION['morning'])) echo ("checked = checked") ?> />Morning</label>
                <label class="checkbox-inline"><input type="checkbox" class="checkbox-inline m-1" name="time[]"
                        value="afternoon"
                        <?php if (isset($_SESSION['afternoon'])) echo ("checked = checked") ?> />Afternoon</label>
                <label class="checkbox-inline"><input type="checkbox" class="checkbox-inline m-1" name="time[]"
                        value="evening"
                        <?php if (isset($_SESSION['evening'])) echo ("checked = checked") ?> />Evening</label>
            </div>
                    <div class="text-danger"><?php echo $new_error;?></div>
        </div>
        <div class="form-group row xx nn">
            <input type="submit" value="Next" name="next" class="click btn btn-primary m-1" />
        </div>
    </form>
    <!-- <span>Designed by: hrkdesigner.github.io</span> -->
</div>


<?php include('./common/footer.php'); ?>