<?php 
    include('configuration.php');
?>
<!DOCTYPE html>
<html lang="en">
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title>Grocery Shopper Price Chopper</title>
        
        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        
        <!-- Custom styles for this template -->
        <link href="jumbotron-narrow.css" rel="stylesheet">
        
        <style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
            .en-markup-crop-options {
            top: 18px !important;
            left: 50% !important;
            margin-left: -100px !important;
            width: 200px !important;
            border: 2px rgba(255,255,255,.38) solid !important;
            border-radius: 4px !important;
            }

            .en-markup-crop-options div div:first-of-type {
                margin-left: 0px !important;
            }
            
        </style> <!-- end style-1-cropbar -->
        
    </head>

    
    <body>
        <div class="container">
            <?php
            include("header.php");
            printHeader("index.php");
            ?>
            
            <div class="jumbotron center-block">
                <h1 class="text-center">Find cheap groceries!</h1>
                <p class="lead text-center">
                    Enter your grocery list and we will show you the price of your items at 2 local grocery store chains, 
                    including where the best place to buy your groceries is! 
                </p>
                <p>
                    <!-- FIX THE LINK FOR THE SIGN UP BUTTON!!!!!!!!!!! -->
                    <a class="btn btn-lg btn-success text-center" href="<?php echo $root_url ?>users/new.php" role="button">Sign up today!</a>
                </p>
                
                <p>
                    <!-- FIX THE LINK FOR THE SIGN UP BUTTON!!!!!!!!!!! -->
                    <a class="btn btn-lg btn-warning text-center" href="<?php echo $root_url ?>session/new.php" role="button">Returning users login</a>
                </p>
            </div> <!-- jumbotron -->
            
            <div class="further-information">
                <div class="col-lg-6 text-center">
                    <h4>What this system does:</h4>
                    <p>
                        This system takes your grocery shopping list and compares prices at two different grocery stores.
                    </p>
                    
                    <br>
                    
                    <p>
                        We then highlight the lowest price so you know where to do your shopping!
                    </p>
                </div> <!-- col lg 6 -->
                
                <div class="col-lg-6 text-center">
                    <h4>How we do this:</h4>
                    <p>
                        We do this by allowing you, the customer, to enter prices of common items as you see them!
                    </p>
                </div> <!-- col lg 6 -->
            </div> <!-- further-information -->
            
            <footer class="footer">
                <p>&copy;2015 Oregon State University</p>
            </footer>
        </div> <!-- container -->
    </body>
</html>
