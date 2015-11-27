<?php
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
	$ItemIDs = $_GET['itemID'];
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
	global $mysqli;
	$priceByStoreByItem = new SplObjectStorage();
	
	foreach($ItemIDs as $itemID) {
		$priceByStore = new SplObjectStorage();
		// For each item query db to get its price, etc in different stores
		$tableList = "SELECT cs361_store.city, cs361_store.name as store, cs361_item.name as name, cs361_item.brand, cs361_item.size, cs361_item.unit, cs361_item.id as id, cs361_has.price "
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
			
			$Store->name = $row["store"];
			$Store->city = $row["city"];
			
			$price = $row["price"];

			$lastItem = $Item;

            $priceByStore[$Store] = $price;			
		}
		$priceByStoreByItem[$lastItem] = $priceByStore;
	}
	return $priceByStoreByItem;
}

/* This function is for demo purpose only. It will print item dictionary as a demo to retrieve its info. GroupA can modify this function to fit info into the actual UI
*/
function printItems($priceByStoreByItem) {
    echo "<table>";
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
		$minimum = minimumPrice($priceByStore);
		echo "<td>".$Item->name."</td>";
		echo "<td>".$Item->brand."</td>";
		echo "<td>".$Item->size."</td>";
		echo "<td>".$Item->unit."</td>";
		
		foreach($StoreSet as $Store){
		    $price = $priceByStore[$Store];
		    echo "<td>".$Store->name."</td>";
		    echo "<td>".$Store->city."</td>";
		    echo "<td";
			
			if ($Item->price == $minimum) {
			    echo " class =\"minimum-price\"";
			}
			
			echo ">";
			
			echo $price."</td>";
		}
	}
	
	echo "</tbody>";
	echo "</table>";
}

function minimumPrice($priceByStore) {
    $minimum = 0;
    
    foreach($priceByStore as $Store) {
        $price = $priceByStore[$Store];
        $minimum = min($minimum, $price);
    }
    
    return $minimum;
}

function StoreSet($priceByStoreByItem) {
    $StoreSet = new SplObjectStorage();
    
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
	
}


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
            <!-- HTML to create a table with 7 columns -->
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

                <?php
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

*/