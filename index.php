<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

// TIP: stuck? run function whatIsHappening()

//we are going to use session variables so we need to enable sessions
session_start();

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

//validate email
$email = test_input($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid format and please re-enter valid email";
}

// required fields: e-mail, street, street number, city and zipcode
// define variables and set to empty values
$emailErr = $streetErr = $streetNumberErr = $cityErr = $zipcodeErr = "";
$email = $street = $streetNumber = $city = $zipcode = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $email = test_input($_POST["email"]);
    } else {
        $emailErr = "Email is required";
    }

    if (empty($_POST["street"])) {
        $street = test_input($_POST["street"]);
    } else {
        $streetErr = "Street is required";
    }

    if (empty($_POST["streetnumber"])) {
        $streetNumber = test_input($_POST["streetnumber"]);
    } else {
        $streetNumberErr = "Street number is required";
    }

    if (empty($_POST["city"])) {
        $city = test_input($_POST["city"]);
    } else {
        $cityErr = "City is required";
    }

    if (empty($_POST["zipcode"])) {
        $zipcode = test_input($_POST["zipcode"]);
    } else {
        $zipcodeErr = "Zipcode is required";
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

require 'form-view.php';

