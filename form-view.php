<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>

    <div <span class="submit"> <?php echo $submit; ?></span>
    </div>
    <!--Submit form = the form data is sent with method="post". -->
    <!-- HTML use method Get and link with name - NOT with id!! -->

    <form method="post"
          action="<?php echo htmlspecialchars ($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <span style="color:darkred" class="error"> <?php echo $emailErr; ?></span>
                <input type="text" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>"
                       id="email" name="email" class="form-control" input/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <span style="color:darkred" class="error"> <?php echo $streetErr; ?></span>
                    <input type="text" name="street"
                           value="<?php echo htmlspecialchars($_POST['street'] ?? '', ENT_QUOTES); ?>" id="street"
                           class="form-control">
                    <!-- remember value https://webstoked.com/keep-form-data-submit-refresh-php/ -->
                    <!-- htmlspecialchars() is used here to convert specific HTML characters to their HTML entity names, e.g. > will be converted to &gt;. This prevents the form from breaking if the user submits HTML markup and also is a means of protecting against XSS (Cross Site Scripting) attacks, which attackers will use to try to exploit vulnerabilities in web applications -->
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number (only numbers):</label>
                    <span style="color:darkred" class="error"> <?php echo $streetNumberErr; ?></span>
                    <input type="text" value="<?php echo htmlspecialchars($_POST['streetnumber'] ?? '', ENT_QUOTES); ?>"
                           id="streetnumber" name="streetnumber" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <span style="color:darkred" class="error"> <?php echo $cityErr; ?></span>
                    <input type="text" value="<?php echo htmlspecialchars($_POST['city'] ?? '', ENT_QUOTES); ?>"
                           id="city" name="city" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <span style="color:darkred" class="error"> <?php echo $zipcodeErr; ?></span>
                    <input type="text" value="<?php echo htmlspecialchars($_POST['zipcode'] ?? '', ENT_QUOTES); ?>"
                           id="zipcode" name="zipcode" class="form-control">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?>
                    -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br/>
            <?php endforeach; ?>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5"/>
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" name="submit" class="btn btn-primary">Order!</button>

    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
<?php whatIsHappening(); ?>
</body>
</html>
