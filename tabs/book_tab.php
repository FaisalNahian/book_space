<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
<style type="text/css">
	#book_table
	{
		width: 665px;
	
	}
	#book_table td, #book_table th 
	{
		border-style: none;
		text-align: left;
	}
	#book_table th
	{
		font-size: 1.2em;
		background-color: #ffffff;
		border-collapse: collapse;
	}
</style>
</head>


<body id="background">
    <div id="container">
		<table id="book_table" border="1";>
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
							
			$order = "SELECT firstname, lastname, title, isbnnumber, askingprice, bookcondition FROM books ORDER BY id";
			//order to search data
			//declare in the order variable
							
			$result = $db->select_list($order);	
			//order executes the result is saved
			//in the variable of $result
			
			foreach($result as $value)
			{
				$fullName = $value[0] . ' ' . $value[1];
			  	echo("<tr><td>$fullName</td><td>$value[2]</td><td>$value[3]</td><td>$value[4]</td><td>$value[5]</td></tr>");
			}
							
			?>
	    </table>
    </div>
</body>
</html>
