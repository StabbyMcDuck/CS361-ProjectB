<html>



<!-- Custom styles -->
<head>
  <title> Grocery Shopper Price Chopper Item Input </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://web.engr.oregonstate.edu/~collikyl/mybootstrap.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <SCRIPT language="javascript">
	function addItem(tableID)
	{
                var table = document.getElementById(tableID);
		var newdiv = document.createElement('div');
		var Rows = table.rows.length;

		var Cols = table.rows[1].cells.length;

		var newRow = table.insertRow(Rows);

		for(var i = 0; i < Cols; i++)
		{
			var col = newRow.insertCell(i);
			col.innerHTML = table.rows[1].cells[i].innerHTML;
			window.alert(col);

		}
			newdiv.innerHTML = col;
			
			document.getElementByID("myInput").appendChild(newdiv);
			
			
	}
	function help()
	{
		window.alert("Instructions: All values for Store Information and at least one row from Item Information must be filled out. The Size(Quanity) field refers to the packaged size of the item, not the total of that item bought (I.E. A single gatorade might be 16 oz, so enter 16 for Size(Quantity) and oz. for Unit of Measurement. On the other hand, a six pack of gatorade would have 6 for Size(Quantity) and pack for Unit of Measurement. Apart from the first Item Information row, all other item rows are optional. Any item row that is left blank will not be uploaded to the database.");
	}

  </script>
</head>

<style>
	table, th, td {border: 1px red;height: 40px}
	body {background-color:white;}

</style>


<body>


<div class = "navbar navbar-static-top">
    <a href = "http://web.engr.oregonstate.edu/~imhoffr/CS361-ProjectB-master/" class = "navbar-brand">Home</a>
    <a href = "http://web.engr.oregonstate.edu/~imhoffr/CS361-ProjectB-master/shopping-list/index.php" class = "navbar-brand">Shopping List</a>
</div>


<div class = "jumbotron">
	<h1 align="left" font size = "12"> Grocery Shopper Price Chopper</font></h1>	
	<p align="left" font size = "12"> Item Input Page </font></p>
</div>
	
 

<table style="width:relative">
<form method="post" id = "myPost" action ="TestInput.php">
	
	<tr>
		<th rowspan="1"> Store Information </th>
	</tr>
	<tr> 
		<td><label for= "Store"> Store Name </label> <input type ="text" id="Store" name="Store" required> </td>
		<td><label for= "City"> City </label> <input type ="text" id="City" name="City" required> </td>
<td><label for="State">State</label>
<select name = "State">
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>	
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
</select>				
</td>
</table> 

<table id = "itemTable" style="width:relative">

	<tr>
		<th rowspan="1"> Item Information <input type = "button" value = "Help" onclick="help()"></th> 
	</tr>
	<tr>
		<td><label for= "Name"> Name</label> <input type ="text" id="Name" name="Name[]" required> </td>
		<td><label for ="Size"> Size (Quantity) </label> <input type = "text" id ="Size" name="Size[]" required></td>
		<td><label for= "Brand"> Brand</label> <input type ="text" id="Brand" name="Brand[]" required> </td>
		<td><label for= "Unit"> Unit of Measure</label> <input type ="text" id="Unit" name="Unit[]" required> </td>
		<td><label for= "Price"> Price</label> <input type ="text" id="Price" name="Price[]" required></td> 
	
	</tr>
	<tr> 
		<td><label for= "Name"> Name</label> <input type ="text" id="Name" name="Name[]"> </td>
		<td><label for ="Size"> Size (Quantity)</label> <input type = "text" id ="Size" name="Size[]"></td>
		<td><label for= "Brand"> Brand</label> <input type ="text" id="Brand" name="Brand[]"> </td>
		<td><label for= "Unit"> Unit of Measure</label> <input type ="text" id="Unit" name="Unit[]"> </td>
		<td><label for= "Price"> Price</label> <input type ="text" id="Price" name="Price[]"></td> 
	
	</tr>
	<tr> 
		<td><label for= "Name"> Name</label> <input type ="text" id="Name" name="Name[]"> </td>
		<td><label for ="Size"> Size (Quantity)</label> <input type = "text" id ="Size" name="Size[]"></td>
		<td><label for= "Brand"> Brand</label> <input type ="text" id="Brand" name="Brand[]"> </td>
		<td><label for= "Unit"> Unit of Measure</label> <input type ="text" id="Unit" name="Unit[]"> </td>
		<td><label for= "Price"> Price</label> <input type ="text" id="Price" name="Price[]"></td> 
	
	</tr>
	<tr> 
		<td><label for= "Name"> Name</label> <input type ="text" id="Name" name="Name[]"> </td>
		<td><label for ="Size"> Size (Quantity)</label> <input type = "text" id ="Size" name="Size[]"></td>
		<td><label for= "Brand"> Brand</label> <input type ="text" id="Brand" name="Brand[]"> </td>
		<td><label for= "Unit"> Unit of Measure</label> <input type ="text" id="Unit" name="Unit[]"> </td>
		<td><label for= "Price"> Price</label> <input type ="text" id="Price" name="Price[]"></td> 
	
	</tr>
	

</table>
	<input type = "submit" value = "Submit" class="btn btn-success" name = "Submit" />
</form>

</body>

</html>
