<?php
session_start();
if(!isset($_SESSION['id'])){
    //redirect them back to login page
    header("Location: ../session/new.php"); /* Redirect browser */
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 'ON');
$input = "valid";

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
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title>Grocery Shopper Price Chopper</title>
          
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"/>
 
	<!-- Latest compiled and minified JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        
        <!-- Custom styles for this template 
        <link href="jumbotron-narrow.css" rel="stylesheet">-->
        
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

        <style>
            .minimum-price {
              background-color: green;
              color: white;
            }
	</style>

    </head>

    
    <body>
        <div class="container">
            <?php
            include("../header.php");
            printHeader();
            ?>

        <div>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
          
main();


function main() {
  
	$ItemIDs= parseItemIDs(); // Get items passed from HTTP GET as an array
	$priceByStoreByItem = getItems($ItemIDs); // Query database to get prices at different stores for each item
	printItems($priceByStoreByItem); // Print out returned info as a demo how to use the data returned by function getItems
}

/* This function will parse item ids in URL and return values of ids in an array
*/
function parseItemIDs() {
    if (isset($_GET['itemID'])) {
        $ItemIDs = $_GET['itemID'];
    } else {
        $ItemIDs = array();
    }
	return $ItemIDs;
}


/* This function query database for each id in the array
   param Items: array that contains item ids 
   return: a dictionary where the key is each item's itemID, value is an array of 
   item objects. Each object contains info item's price, etc in a store. ie,
   itemID 1: 
      name: apple, store: QFC, ...
	  name: apple, store: safeway, ...
   itemID 2:
      name: bread, store: QFC, ....
*/
function getItems($ItemIDs) {
  if(!isset($_POST['sorted']) || $_POST['sorted'] == "All Movies") {
    global $mysqli;
    $priceByStoreByItem = new PriceByStoreByItem();

    foreach($ItemIDs as $itemID) {
      $priceByStore = new PriceByStore();
      // For each item query db to get its price, etc in different stores
      $tableList = "SELECT cs361_store.id as store_id, cs361_store.city as store_city, cs361_store.name as store_name, cs361_item.name as name, cs361_item.brand, cs361_item.size, cs361_item.unit, cs361_item.id as id, cs361_has.price "
        . "FROM cs361_store "
        . "INNER JOIN cs361_item INNER JOIN cs361_has ON cs361_item.id = cs361_has.itemid AND cs361_store.id = cs361_has.storeid "
        . "WHERE cs361_has.itemid = \"{$itemID}\" ";
      if (!($stmt = $mysqli->prepare($tableList))) {
        echo "Error: Prepare failed: " . $stmt->errno . " " . $stmt->error;
      }
      if (!$stmt->execute()) {
        echo "Error: Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
      }

      // Create item object with values from db and add it to the array
      $result = $stmt->get_result();

      $lastItem = null;


      while($row = $result->fetch_assoc()) //get it one by one
      {
        $Item = new Item();

        $Store = new Store();

        $Item->brand = $row["brand"];
        $Item->size = $row["size"];
        $Item->unit = $row["unit"];
        $Item->name = $row["name"];
        $Item->id = $row["id"];

        $Store->id = $row["store_id"];
        $Store->name = $row["store_name"];
        $Store->city = $row["store_city"];

        $price = $row["price"];

        $lastItem = $Item;

              $priceByStore[$Store] = $price;			
      }

      if ($lastItem !== null) {
        $priceByStoreByItem[$lastItem] = $priceByStore;
      }
    }
    return $priceByStoreByItem;
    } else {
          global $mysqli;
    $priceByStoreByItem = new PriceByStoreByItem();

    foreach($ItemIDs as $itemID) {
      $priceByStore = new PriceByStore();
      // For each item query db to get its price, etc in different stores
      $tableList = "SELECT cs361_store.id as store_id, cs361_store.city as store_city, cs361_store.name as store_name, cs361_item.name as name, cs361_item.brand, cs361_item.size, cs361_item.unit, cs361_item.id as id, cs361_has.price "
        . "FROM cs361_store "
        . "INNER JOIN cs361_item INNER JOIN cs361_has ON cs361_item.id = cs361_has.itemid AND cs361_store.id = cs361_has.storeid "
        . "WHERE cs361_has.itemid = \"{$itemID}\" AND cs361_store.city = \"{$_POST['sorted']}\" ";
      if (!($stmt = $mysqli->prepare($tableList))) {
        echo "Error: Prepare failed: " . $stmt->errno . " " . $stmt->error;
      }
      if (!$stmt->execute()) {
        echo "Error: Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
      }

      // Create item object with values from db and add it to the array
      $result = $stmt->get_result();

      $lastItem = null;


      while($row = $result->fetch_assoc()) //get it one by one
      {
        //if(strcmp ($row["store_city"], $_POST['sorted'])) { //Figure out why this isnt working
          $Item = new Item();

          $Store = new Store();

          $Item->brand = $row["brand"];
          $Item->size = $row["size"];
          $Item->unit = $row["unit"];
          $Item->name = $row["name"];
          $Item->id = $row["id"];

          $Store->id = $row["store_id"];
          $Store->name = $row["store_name"];
          $Store->city = $row["store_city"];

          $price = $row["price"];

          $lastItem = $Item;

                $priceByStore[$Store] = $price;			
        //}
      }

      if ($lastItem !== null) {
        $priceByStoreByItem[$lastItem] = $priceByStore;
      }
    }
    return $priceByStoreByItem;
    
    }
}

/* This function is for demo purpose only. It will print item dictionary as a demo to retrieve its info. GroupA can modify this function to fit info into the actual UI
*/
function printItems($priceByStoreByItem) {
    echo "<table class=\"table table-striped\">";
    echo "<thead>";
    echo "<tr>";
    echo "<th rowspan='2'>Name</th>";
    echo "<th rowspan='2'>Brand</th>";
    echo "<th rowspan='2'>Size</th>";
    echo "<th rowspan='2'>Unit</th>";
    
    $StoreSet = StoreSet($priceByStoreByItem);
    
    foreach($StoreSet as $Store){
        echo "<th colspan='3'>Store</th>";
    }
    echo "</tr>";
    
    echo "<tr>";
    foreach($StoreSet as $Store){
        echo "<th>Name</th>";
        echo "<th>City</th>";
        echo "<th>Price</th>";
    }
    echo "</tr>";
    
    echo "</thead>";
    echo "<tbody>";
    
  
	foreach($priceByStoreByItem as $Item) {
	    $priceByStore = $priceByStoreByItem[$Item];
		$minimumPrice = minimumPrice($priceByStore);
		
		echo "<tr>";
		echo "<td>".$Item->name."</td>";
		echo "<td>".$Item->brand."</td>";
		echo "<td>".$Item->size."</td>";
		echo "<td>".$Item->unit."</td>";
		
		foreach($StoreSet as $Store){
		    echo "<td>".$Store->name."</td>";
		    echo "<td>".$Store->city."</td>";
		    
		    echo "<td";
		    
		    if ($priceByStore->offsetExists($Store)) {
		        $price = $priceByStore[$Store];
		    
			    if ($price == $minimumPrice) {
			        echo " class =\"minimum-price\"";
			    }
			} else {
			    $price = "N/A";
			}
			
		    echo ">".$price."</td>";
		}
		
		echo "</tr>";
	}
	
	echo "</tbody>";
	echo "</table>";
}

function minimumPrice($priceByStore) {
    $minimum = 1000000000;
    
    foreach($priceByStore as $Store) {
        $price = $priceByStore[$Store];
        $minimum = min($minimum, $price);
    }
    
    return $minimum;
}

function StoreSet($priceByStoreByItem) {
    $StoreSet = new StoreSet();
    
    foreach($priceByStoreByItem as $Item) {
        $priceByStore = $priceByStoreByItem[$Item];
        
        foreach($priceByStore as $Store) {
            $StoreSet[$Store] = true;
        }
    }
    
    return $StoreSet;
}

class Item {
	public $name = "";
	public $brand = "";
	public $size = "";
	public $unit = "";
	public $id = "";
}

class Store {
	public $name = "";
	public $city = "";
	public $id = "";
}

class PriceByStoreByItem extends SPLObjectStorage {
     public function getHash($Item){
         return strval($Item->id);
     }
}

class PriceByStore extends SPLObjectStorage {
    public function getHash($Store) {
        return strval($Store->id);
    }
}

class StoreSet extends SPLObjectStorage {
    public function getHash($Store) {
        return strval($Store->id);
    }
}
?>
<!--/////////////////////////////////////////////////////////////////////////-->
</div> <!-- jumbotron -->
            
                <footer class="footer">
                <p>&copy;2015 Oregon State University</p>
            </footer>
        </div> <!-- container -->
    </body>
</html> 
<!--/////////////////////////////////////////////////////////////////////////-->
<!--
// Below is original code from Emmalee, comment it out for now

//$City = $_GET['City'];
//$Item = $_GET['ItemName'];
//$Brand = $_GET['ItemBrand'];
//$Size = $_GET['ItemSize'];
//$ItemUOM = $_GET['ItemUOM'];



#Prepare statement that selects from Store the attributes city, name and address 
#and from Item the item name, brand, size and unit of measure
#and from Has the Price and calculates Price/UOM

//$tableList = "SELECT cs361_store.city, cs361_store.storename, cs361_store.zipcode, cs361_item.itemname,  "
//        . "cs361_item.brand, cs361_item.size, cs361_item.unit, cs361_has.price "
//        . "FROM cs361_store INNER JOIN cs361_item INNER JOIN cs361_has ON cs361_item.id = cs361_has.itemid "
//        . "AND cs361_store.id = cs361_has.storeid WHERE cs361_store.city = \"{$City}\" "
////        . "AND cs361_store.storename = \"{$Store}\" "
//        . "AND cs361_store.zipcode = \"{$Zipcode}\" "
//        . "AND cs361_item.itemname = \"{$Item}\" AND cs361_item.brand = \"{$Brand}\" AND cs361_item.size = \"{$Size}\" AND cs361_item.unit = \"{$ItemUOM}\" ";
/*
$tableList = "SELECT cs361_store.city, cs361_store.name, cs361_store.address, cs361_item.name,  "
        . "cs361_item.brand, cs361_item.size, cs361_item.unit, cs361_has.price "
        . "FROM cs361_store INNER JOIN cs361_item INNER JOIN cs361_has ON cs361_item.id = cs361_has.itemid "
        . "AND cs361_store.id = cs361_has.storeid WHERE cs361_store.city = \"{$City}\" "
//        . "AND cs361_store.name = \"{$Store}\" "
//        . "AND cs361_store.zipcode = \"{$Zipcode}\" "
        . "AND cs361_item.name = \"{$Item}\" AND cs361_item.brand = \"{$Brand}\" AND cs361_item.size = \"{$Size}\" AND cs361_item.unit = \"{$ItemUOM}\" ";

###echo $tableList;

if (!($stmt = $mysqli->prepare($tableList))) {
    echo "Error: Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if (!$stmt->execute()) {
    echo "Error: Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt->bind_result($tabCity, $tabStore, $tabAddress, $tabItem, $tabBrand, $tabSize, $tabItemUOM, $tabPrice)) {
    echo "Error: Binding failed: (" . $stmt->errno . ") "
    . $stmt->error;
}
?>

<!DOCTYPE html>
<html>
    <body>
        <div>
            </div>
            <!-- HTML to create a table with 7 columns
            <table border="1">
                <tbody> 
                <tr>
                    <td><font size="4">Price Comparison</font></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td>Store</td>
                    <td>Address</td>
                    <td>Item</td>
                    <td>Brand</td>
                    <td>Size</td>
                    <td>Unit of Measure (UOM)</td>
                    <td>Price</td>
                </tr>

                php
                error_reporting(E_ALL);
                ini_set('display_errors', 'ON');

                # Populate the table rows with movie data.
                while ($stmt->fetch()) {
                    printf("<tr>\n" . "\t<td>%s</td>\n" . "\t<td>%s</td>\n" . "\t<td>%s</td>\n"
                            . "\t<td>%s</td>\n" . "\t<td>%s</td>\n" . "\t<td>%s</td>\n" . "\t<td>%s</td>\n" . "\t<td>%s</td>\n"
                            . "</tr>\n", $tabCity, $tabStore, $tabAddress, $tabItem, $tabBrand, $tabSize, $tabItemUOM, $tabPrice);
                }
                #Close fetch of $stmt
                $stmt->close();
                ?>
                </tbody>
            </table>
</body>
</html>

-->
