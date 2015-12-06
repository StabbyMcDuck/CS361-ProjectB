<html>
<style>
	table, th, td {border: 1px red;}
	body {background-color:white;}
	h1 {color: green; text-align: center; font-size: 60px; font-family: Arial}
	p {color: black; text-align: left; font-size: 20px; font-family: Arial}
</style>

<!--<p>
	<a href="http://web.engr.oregonstate.edu/~imhoffr/CS361-ProjectB-master/">Home</a>
</p>
<p>
	<a href="http://web.engr.oregonstate.edu/~collikyl/Test">Item Entry</a>
</p>-->

<head>
redirecting....

</head>


<?php


$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'zengx-db';
$dbpass = 'qWXPWG1wbhOLVCAG';
$dbuser = 'zengx-db';

//$dbhost = 'oniddb.cws.oregonstate.edu';
//$dbname = 'collikyl-db';
//$dbuser = 'collikyl-db';
//$dbpass = 'SWL4zK1AsWAicYvZ';

$mysql_handle = mysqli_connect($dbhost, $dbuser, $dbpass,'zengx-db') or die("Error connecting to database server");



$STORE = $_POST['Store'];
$CITY = $_POST['City'];
$STATE = $_POST['State'];
$NAME = $_POST['Name'];
$SIZE = $_POST['Size'];
$BRAND = $_POST['Brand'];
$UNIT = $_POST['Unit'];
$PRICE = $_POST['Price'];


//PRECONDITION: Database connection is established. User correctly entered store, city, and state.
//POSTCONDITION: Returns 0 if store doesn't exist, else returns 1.
function verify_store($mysql_handle, $STORE, $CITY, $STATE)
{
	$query_verify = "SELECT * FROM cs361_store WHERE cs361_store.name='$STORE' AND cs361_store.city='$CITY' AND cs361_store.state='$STATE'";
	$result_verify = mysqli_query($mysql_handle,$query_verify);
	$row = mysqli_fetch_assoc($result_verify);
	if($row == NULL)
	{
		return 0;
	}
	return 1;
}


//PRECONDITION: Database connection is established. User correctly entered all values with the exception of price.
//POSTCONDITION: Returns - if a given store does not sell the item the user entered, else reutrns 0.
function check_item_has($mysql_handle, $NAME, $BRAND, $SIZE,$UNIT,$CITY,$STORE,$STATE)
{
	$query_item_has = "SELECT * FROM cs361_has,cs361_item,cs361_store WHERE cs361_item.name='$NAME' AND cs361_item.size='$SIZE' AND cs361_item.brand='$BRAND' AND cs361_item.unit='$UNIT' AND cs361_item.id=cs361_has.itemID AND cs361_has.storeID=cs361_store.id  AND cs361_store.name ='$STORE' AND cs361_store.state='$STATE'";
	$result_item_has = mysqli_query($mysql_handle,$query_item_has) or die ('Error searching for item_has');
	$row = mysqli_fetch_assoc($result_item_has);
	if ($row == NULL)
	{

		return 0;
	}
	
	return 1;
}

//PRECONDITION: Database connection established. User correctly entered values for store.
//POSTCONDITION: Inserts a new store into the database.
function create_store($mysql_handle,$STORE,$CITY,$STATE)
{
	$create_store = "INSERT INTO cs361_store VALUES (NULL, '$STORE', 'TempHold', '$CITY', '$STATE')";
	$result_create = mysqli_query($mysql_handle,$create_store) or die ('Error creating store');
}

//PRECONDITION: Database connection established. User correctly entered values for item.
//POSTCONDITION: Inserts new item into database.
function insert_item($mysql_handle,$NAME,$SIZE,$BRAND,$UNIT) //Create new item if store exists, but item does not. Updates item, and has table.
{
	$query_insert = "INSERT INTO cs361_item VALUES(NULL, '$NAME', '$SIZE', '$BRAND', '$UNIT')";
	$result_insert = mysqli_query($mysql_handle,$query_insert) or die ('Error inserting new item');
}


//PRECONDITION: Database connection established. User correctly entered values for item and store.
//POSTCONDITION: Creates new relation between item and store in the database.
function insert_has($mysql_handle,$NAME,$SIZE,$BRAND,$UNIT,$PRICE,$STORE,$CITY,$STATE)
{
	$query_get_itemID = "SELECT *FROM cs361_item WHERE cs361_item.name='$NAME' AND cs361_item.size='$SIZE' AND cs361_item.brand='$BRAND' AND cs361_item.unit = '$UNIT'";
	$result_get_itemID = mysqli_query($mysql_handle,$query_get_itemID) or die ('Error getting item ID');
	$row = mysqli_fetch_assoc($result_get_itemID);
	$ID = $row['id'];
	$query_get_storeID = "SELECT * FROM cs361_store WHERE cs361_store.name='$STORE' AND cs361_store.city='$CITY' AND cs361_store.state='$STATE'";
	$result_get_storeID = mysqli_query($mysql_handle,$query_get_storeID) or die ('Error getting store ID');
	$row2 = mysqli_fetch_assoc($result_get_storeID);
	$StoreID = $row2['id'];
	$query_insert_has = "INSERT INTO cs361_has VALUES(NULL,'$StoreID', '$ID', '$PRICE')";
	$result_insert_has = mysqli_query($mysql_handle,$query_insert_has) or die ('Error entering information into has table');
}

//PRECONDITION: Database connection established. User correctly entered values for item and store.
//POSTCONDITION: Updates relation between item and store in the database.
function update_item($mysql_handle,$NAME,$SIZE,$BRAND,$UNIT,$PRICE,$STORE,$CITY,$STATE)
{
	$query_update = "UPDATE cs361_has,cs361_item,cs361_store SET cs361_has.price = '$PRICE' WHERE cs361_item.id = cs361_has.itemID AND cs361_has.storeID = cs361_store.id AND cs361_store.name='$STORE' AND cs361_store.city='$CITY' and cs361_store.state='$STATE' AND cs361_item.brand='$BRAND' AND cs361_item.name='$NAME' AND cs361_item.size='$SIZE' and cs361_item.unit='$UNIT'";
	$result_update = mysqli_query($mysql_handle,$query_update) or die ('Error updating new item');
}

//PRECONDITION: Database connection established. User correctly entered values for item.
//POSTCONDITION: Returns 1 if user entered item exists, 0 if not.
function check_allItems($mysql_handle,$NAME,$BRAND,$SIZE,$UNIT)
{
	$query_verifyItem = "SELECT * FROM cs361_item WHERE cs361_item.name='$NAME' AND cs361_item.brand='$BRAND' AND cs361_item.unit='$UNIT' AND cs361_item.size='$SIZE'";
	$result_verifyItem = mysqli_query($mysql_handle,$query_verifyItem) or die ('Error searching for item');
	$row = mysqli_fetch_assoc($result_verifyItem);
	if($row == NULL)
	{
		return 0;
	}
	return 1;		
}

//PRECONDITION: User correctly entered in values for at least one item.
//POSTCONDITION: Returns index for items where a NULL value was found. 
function check_Arrays($NAME,$BRAND,$SIZE,$UNIT,$PRICE)
{
	$myArray = array('0'=>$NAME,'1' => $BRAND, '2' => $SIZE, '3' => $UNIT, '4' => $PRICE);

	for ($col = 0; $col < 4; $col++)
	{
		for ($row = 0; $row < 5; $row++)
		{
			$myString = $myArray[$row][$col];
			if(strlen($myString) == 0)
			{
				$myIndex[] = $col;
				continue 2;
			}
		}
	}
	return $myIndex;
}


$store_exists = verify_store($mysql_handle, $STORE, $CITY, $STATE);

$myIndex = check_Arrays($NAME,$BRAND,$SIZE,$UNIT,$PRICE);

if($store_exists == 0) //Create store if doesnt exist
{
	create_store($mysql_handle,$STORE,$CITY,$STATE);
}

for ($i = 0; $i < 3; $i++)
{
	foreach ($myIndex as $val)
	{
		if($i == $val)
		{
			continue 2;
		}
	}

		$itm_exists = check_allItems($mysql_handle,$NAME[$i],$BRAND[$i],$SIZE[$i],$UNIT[$i]);
		$itm_has = check_item_has($mysql_handle, $NAME[$i], $BRAND[$i], $SIZE[$i], $UNIT[$i],$CITY,$STORE,$STATE);

		if($itm_exists == 0) //If item does not exist, create the item
		{
			insert_item($mysql_handle,$NAME[$i],$SIZE[$i],$BRAND[$i],$UNIT[$i]);
		}

		if($itm_has == 0) //item doesn't exist at store
		{
			insert_has($mysql_handle,$NAME[$i],$SIZE[$i],$BRAND[$i],$UNIT[$i],$PRICE[$i],$STORE,$CITY,$STATE);
		}

		if($itm_has == 1) //item exists at store
		{
			update_item($mysql_handle,$NAME[$i],$SIZE[$i],$BRAND[$i],$UNIT[$i],$PRICE[$i],$STORE,$CITY,$STATE);
		}
}	

mysql_close($mysql_handle);
$url='http://web.engr.oregonstate.edu/~collikyl/Test';
echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
?>

 


</html>

