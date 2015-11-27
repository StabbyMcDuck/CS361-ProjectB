<?php 
    include('../configuration.php');
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
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <a href="<?php $root_url>index.php">Home</a>
                        <a href="<?php $root_url>session/destroy.php">Log Out</a>
                    </ul>
                </nav>
                
                <h2 class="text-muted">Grocery Shopper Price Chopper</h2>
            </div> <!-- header clearfix -->
            
            <div class="list-name-entry">
                <h1>Name list:</h1>
                <p>Name the list as you would like to have it saved.</p>
                
                <form>
                    <div class="form-group">
                        <label for="list-name">List Name</label>
                        <input type="list-name" class="form-control" id="list-name" placeholder="List Name">
                    </div> <!-- form-group -->
            
            <footer class="footer">
                <p>&copy;2015 Oregon State University</p>
            </footer>
        </div> <!-- container -->
    </body>
</html>