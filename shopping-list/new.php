<?php

session_start();
    if(!isset($_SESSION['id'])){
        //redirect them back to login page
        header("Location: ../session/new.php"); /* Redirect browser */
        exit();
    }
    error_reporting(E_ALL);
    ini_set('display_errors', 'ON');
    include('../configuration.php');
    
    #Connect To Database
$mysqli = new mysqli(
                $database_configuration['servername'],
                $database_configuration['username'],
                $database_configuration['password'],
                $database_configuration['database']
            );


if ($mysqli->connect_errno) {
    echo "Error: Database connection error: " . $mysqli->connect_errno . " - "
    . $mysqli->connect_error;
    exit;
}

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
            include("../header.php");
            printHeader();
            ?>

            <div class="item-entry">
                
                <h2>Enter Your Shopping List:</h2>
                <p>You can select more than one item.  When you are done adding, hit the "Price Compare" button!</p>
              <form action="http://web.engr.oregonstate.edu/~imhoffr/CS361-ProjectB-master/item/compare.php">
               <!--<form action="http://web.engr.oregonstate.edu/~vidalj/CS361-ProjectB/item/compare.php">-->
                    <div class="form-group">
                        <div class="col-lg-12">
                          <h3>Where do you live?:</h3>
                          <?php

                            $location;
                            echo "<span class=\"sort\"><strong>City: </strong></span><select name=\"sorted\">";
                            $stmt = $mysqli->stmt_init();
                            $cty = "SELECT city FROM cs361_store WHERE id > -1 ORDER BY city";
                            $stmt->prepare($cty);
                            $stmt->execute();
                            $stmt->bind_result($location);

                            $array = array(100);
                            $cityCount = 0;
                            $include;
                            echo "<option value=\"All Cities\">All Cities</option>";
                            while($stmt->fetch()) {
                              $include = TRUE;
                              for($i = 0; $i < count($array); $i++) {
                                if($location == $array[$i]) {
                                  $include = FALSE;
                                }
                              }
                              if($include == TRUE && $location != "") {
                                $array[$cityCount] = $location;
                                $cityCount++;
                                echo "<option value=\"" . $location . "\">" . $location . "</option>";
                                }
                              }
                            echo "</select>";
                            //$stmt->close();
                          
                            $itemQuery = "SELECT id, brand, name, size, unit " .
                                         "FROM cs361_item " .
                                         "ORDER BY brand, name, size, unit";
                                         
                            if (!($statement = $mysqli->prepare($itemQuery))) {
                                echo "Error: Prepare failed: (" . $statement->errno . ") " . $statement->error;
                                exit;
                            }
                            
                            if (!$statement->execute()) {
                                echo "Error: Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
                            }
                            
                            $result = $statement->get_result();
                            
                            while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="checkbox">
                                <label>
                                    <input name="itemID[]" type="checkbox" value="<?php echo $row["id"] ?>">
                                    <?php echo $row["brand"]." ".$row["name"]." ".$row["size"]." ".$row["unit"] ?>
                                </label>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                     </div> <!-- form-group -->
                    <button type="submit" class="btn btn-success">Price Compare</button>
            </form>
            <footer class="footer">
                <p>&copy;2015 Oregon State University</p>
            </footer>
        </div> <!-- container -->
    </body>
</html>