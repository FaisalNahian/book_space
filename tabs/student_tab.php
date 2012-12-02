
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
<style type="text/css">
	#student_table
	{
		width: 665px;
		border-style: none;
		collapse-borders: true;
	}
	.master 
	{
		
	}
	#student_table tr:HOVER
	{
		background-color: #ccc;
	}

</style></head>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<script type="text/javascript" src="../jquery/jExpand.js"></script>

<script>

$(document).ready(function(){	
	$("#student_table tr:odd").addClass("master");
	$("#student_table tr:not(.master)").hide();
	$("#student_table tr:first-child").show();
	$("#student_table tr.master").click(function(){
	    $(this).next("tr").toggle();
	    $(this).find(".arrow").toggleClass("up");
	});
});

</script>

<body id="background">
    <div id="container">
		<table id="student_table" border="1">
	      <tr>
	        <th>Name</th>
	        <th>Email</th>
	        <th>City</th>
        	<th>State</th>
        	<th>Phone</th>
	        </tr>
			<?
			//the example of searching data with the sequence based on the field name
			//search.php
		    include('../htm/db.php');
		    $db = new db();
							
		    //Select all of the people/students in our database
			$order = "SELECT id, firstname, lastname, email, city, state, phonenumber FROM usernamepassword ORDER BY id";
			//order to search data
			//declare in the order variable
							
			//Get the results		
			$result = $db->select_list($order);	
			//order executes the result is saved
			//in the variable of $result
			
			// This is where I want to implement the drop down feature.
			// As you can see for each student, I get the books that are linked to them. Somehow I need to 
			// concatinate them into one table row so that I can hide that row and show just one row rather
			// thatn however many books that person has on the site.
			foreach($result as $value)
			{
				//Get the full name
				$fullName = $value[1] . ' ' . $value[2];
				//Create our table row
			  	echo("<tr><td>$fullName</td><td>$value[3]</td><td>$value[4]</td><td>$value[5]</td><td>$value[6]</td></tr>");
			  	
			  	//Now select all of the books associated with the current person.
				$books = "SELECT firstname, lastname, title, isbnnumber, askingprice, bookcondition FROM books ".
							"WHERE link = " . $value[0] ." ORDER BY id";
			  	
			  	//Get the result			  	
			  	$bookResult = $db->select_list($books);
			  				  	
			  	//Declare the return string. THis will be added to. Because we only want one row for each person
			  	// I get all of the results up them in arrays and then build the single table row later.
			  	if( $bookResult != null)
			  	{
				  	$returnString = "<tr><td>";
				  	$count = 0;	
				  	foreach($bookResult as $value)
				  	{
				  		//add the results to the arrays.
				  		$authorNames[$count] = $value[0] . " " . $value[1];
				  		$bookTitles[$count] = $value[2];
				  		$isbnNUmbers[$count] = $value[3];
				  		$askingPrices[$count] = $value[4];
				  		$bookConditions[$count] = $value[5];
	
				  		// Increment the count
				  		$count++;		  		
				  	}
				  	
				  	//Now for each array add all of the books.
				  	for($i=0; $i < count($authorNames); $i++)
				  	{
				  	$returnString .= $authorNames[$i] . "<br>";
				  	}
				  	
				  	$returnString .= "</td><td>";
				  	
				  	for($i=0; $i < count($bookTitles); $i++)
				  	{
				  	$returnString .= $bookTitles[$i] . "<br>";
				  	}
				  	
				  	$returnString .= "</td><td>";
				  	
				  	for($i=0; $i < count($isbnNUmbers); $i++)
				  	{
				  	$returnString .= $isbnNUmbers[$i] . "<br>";
				  	}
				  	
				  	$returnString .= "</td><td>";
				  	
				  	for($i=0; $i < count($askingPrices); $i++)
				  	{
				  	$returnString .= $askingPrices[$i] . "<br>";
				  	}
				  	
				  	$returnString .= "</td><td>";
				  	
				  	for($i=0; $i < count($bookConditions); $i++)
				  	{
				  	$returnString .= $bookConditions[$i] . "<br>";
				  	}
				  	
				  	$returnString .= "</td><td></tr>";
				  	
				  	//
				  	// Empty the Arrays
				  	//
				  	unset($authorNames);
				  	unset($bookTitles);
				  	unset($isbnNUmbers);
				  	unset($askingPrices);
				  	unset($bookConditions);
				  	
				  	
				  	// return our new row.
				  	echo $returnString;
			  	}

			}
							
			?>
	    </table>
    </div>
</body>
</html>
