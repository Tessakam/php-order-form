<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

// TIP: stuck? run function whatIsHappening()
//we are going to use session variables so we need to enable sessions

session_start();
//session is started if you don't write this line can't use $_Session global variable

function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

// required fields: e-mail, street, street number, city and zipcode
// define variables and set to empty values
$submit = "";
$emailErr = $streetErr = $streetNumberErr = $cityErr = $zipcodeErr = "";
$email = $street = $streetNumber = $city = $zipcode = "";

//step 2: sessions -  Make sure the input fields are saved

if (!empty($_SESSION['email'])){
    $street = $_SESSION['email'];
}
if (!empty($_SESSION['street'])){
    $streetNum = $_SESSION['street'];
}
if (!empty($_SESSION['streetnumber'])){
    $streetNum = $_SESSION['streetnumber'];
}
if (!empty($_SESSION['city'])){
    $city = $_SESSION['city'];
}
if (!empty($_SESSION['zipcode'])){
    $zipcode = $_SESSION['zipcode'];
}

//$_SESSION["email"] = $email;
//$_SESSION["street"] = $street;
//$_SESSION["streetnumber"] = $streetNumber;
//$_SESSION["zipcode"] = $zipcode;
//$_SESSION["city"] = $city;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"])) {
        $emailErr = "* Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["street"])) {
        $streetErr = "* Street is required";
    } else {
        $street = test_input($_POST["street"]);
    }


    if (empty($_POST["streetnumber"])) {
        $streetNumberErr = "* Street number is required";
    } else {
        $streetNumber = test_input($_POST["streetnumber"]);
        // validate number
        if (!is_numeric($streetNumber)) {
            $streetNumberErr = "Data entered is not a number";
        }
     else {
            $_SESSION['streetnumber'] = $streetNumber;
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "* City is required";
    } else {
        $city = test_input($_POST["city"]);
    }

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "* Zipcode is required";
    } else {
        $zipcode = test_input($_POST["zipcode"]);
        // validate number (also possible with is_numeric
        if (!filter_var($zipcode, FILTER_VALIDATE_INT)) {
            $zipcodeErr = "Data entered is not a number";
        }
    }
    //check if all fields are completed before popup message shows
    if ($emailErr == "" && $streetErr == "" && $streetNumberErr == "" && $cityErr == "" && $zipcodeErr == "") {
        $submit = '<div class="alert alert-primary" role="alert">
    Form submitted. We received your order!
    </div>';
    }
}

function test_input($data)
{
    $data = trim($data); // Strip whitespace (or other characters) from the beginning and end of a string
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;
// whatIsHappening();
require 'form-view.php';
//https://www.tutorialspoint.com/php/php_validation_example.htm

