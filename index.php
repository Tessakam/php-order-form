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

//your products with their price.
$food = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$drinks = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

// required fields: e-mail, street, street number, city and zipcode
// define variables and set to empty values
$submit = "";
$emailErr = $streetErr = $streetNumberErr = $cityErr = $zipcodeErr = "";
$email = $street = $streetNumber = $city = $zipcode = "";

//step 2: sessions -  Make sure the input fields are saved for the address

if (!empty($_SESSION['street'])) {
    $street = $_SESSION['street'];
}
if (!empty($_SESSION['streetnumber'])) {
    $streetNumber = $_SESSION['streetnumber'];
}
if (!empty($_SESSION['city'])) {
    $city = $_SESSION['city'];
}
if (!empty($_SESSION['zipcode'])) {
    $zipcode = $_SESSION['zipcode'];
}

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
        $_SESSION['street'] = $street;
    }

    if (empty($_POST["streetnumber"])) {
        $streetNumberErr = "* Street number is required";
    } else {
        $streetNumber = test_input($_POST["streetnumber"]);
        // validate number
        if (!is_numeric($streetNumber)) {
            $streetNumberErr = "Data entered is not a number";
        } else {
            $_SESSION['streetnumber'] = $streetNumber;
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "* City is required";
    } else {
        $city = test_input($_POST["city"]);
        $_SESSION['city'] = $city;
    }

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "* Zipcode is required";
    } else {
        $zipcode = test_input($_POST["zipcode"]);
        // validate number (also possible with is_numeric
        if (!filter_var($zipcode, FILTER_VALIDATE_INT)) {
            $zipcodeErr = "Data entered is not a number";
        } else {
            $_SESSION['zipcode'] = $zipcode;
        }
    }
}

function test_input($data)
{
    $data = trim($data); // Strip whitespace (or other characters) from the beginning and end of a string
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//make food default page by using session
//isset = Check whether a variable is empty
if (!isset($_SESSION['products'])) {
    $products = $food;
} else {
    $products = $_SESSION['products'];
}
//switch between drinks and food
if (isset($_GET['food'])) {
    if ($_GET['food'] == 1) {
        $products = $food;
        $_SESSION['products'] = $food;
    } else {
        $products = $drinks;
        $_SESSION['products'] = $drinks;
    }
}

//Calculate the delivery time: normal delivery: 2H // express 45 min
$delivery = "";
$totalValue = 0;
$orderValue = 0;
$express = 5;

if (isset($_POST['express_delivery'])) { // express delivery checked?
    $delivery = "You will receive your delivery on " . date("jS F - H:i", strtotime("+45minutes")) ." - Note: extra 5 EUR for express delivery!";
} else {
    $delivery = "You will receive your delivery on " . date("jS F - H:i", strtotime("+2 hours"));
}

// counter based on checkboxes
$checkboxes = (isset($_POST['products'])) ? $_POST['products'] : array();
//var_dump($checkboxes);

// use loop for the prices // to fix: order doesn't calculate the delivery
for ($i = 0; $i < count($checkboxes); $i++) {
    $totalValue += $products[$i]['price'];
    //var_dump($_POST['products']);
}

// popup confirmation and delivery
if ($emailErr == "" && $streetErr == "" && $streetNumberErr == "" && $cityErr == "" && $zipcodeErr == "") {
    $submit = '<div class="alert alert-primary" role="alert">
    Form submitted! ' . $delivery;
} // var_dump($delivery);

//set cookie to calculate the total
setcookie("totalValue", strval($totalValue), time()+3600);  // expires in 1 hour

//installed "sendmail" but didn't receive any mail - commented out otherwise it takes to long to load
/*function sendEmail()
{
    //make global for variables, otherwise undefined
    global $email, $street, $streetNumber, $city, $zipcode, $totalValue, $delivery;

    $to = "tessa.kam@hotmail.com"; //test if email is arriving
    $subject = "Your order from the Personal Ham Processors ";

    $headers = "From: $email";
    $message = "Email: {$email}\n street: {$street}\n streetnumber: {$streetNumber}\n city: {$city}\n zipcode: {$zipcode}\n  total order: {$totalValue}";
    var_dump($message);

    //confirmation mail
    mail($to, $subject, $headers, $message, $delivery);
    //mail to restaurant - mail("order@)personalhamprocessors.be", 'New order confirmation', $message);
sendEmail();
}*/

//whatIsHappening();


require 'form-view.php';
//https://www.tutorialspoint.com/php/php_validation_example.htm
//https://www.php.net/manual/en/function.setcookie.php
//https://stackoverflow.com/questions/15728741/use-strtotime-to-format-variables-for-hour-minute-and-am-pm
//https://stackoverflow.com/questions/566182/complete-mail-header

/* Original code cookie
$totalValue = $orderValue;

if(isset($_COOKIE['order'])){
    $totalValue = $_COOKIE['order'];
}
else {
    $cookie_name ='order';
    $cookie_value = $totalValue;
    setcookie($cookie_name,strval($cookie_value), time()+3600);  // expires in 1 hour
}*/

/* //check if all fields are completed before popup message shows
if ($emailErr == "" && $streetErr == "" && $streetNumberErr == "" && $cityErr == "" && $zipcodeErr == "") {
    $submit = '<div class="alert alert-primary" role="alert">
Form submitted. We received your order!
</div>';
}*/
