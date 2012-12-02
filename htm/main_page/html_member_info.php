<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Book Space</title>
    <link rel="stylesheet" href="../../common/main_pages.css" />
</head>

<body>
	<div id="container">
		<div id="side-bar">
       		<div id="side-bar-title-div">
                <a>Welcome</a>
            </div>
       		<div id="side-bar-search-div">
                <input id="side-bar-search" type="text" value="Search" style="color: #999" onfocus="this.style.color='#000'; if(this.value==this.defaultValue) this.value='';" onblur="if(this.value==''){this.style.color='#999'; this.value=this.defaultValue; }"/>
       		</div>
            <div id="nav-bar-div">
                <ul id="nav-bar">
                    <li onclick="location.href='./html_college_book_space.php';"><a>College Book Space</a></li>
                    <li id="selected" onclick="location.href='./html_member_info.php';"><a>Member Info</a></li>
                    <li onclick="location.href='./html_book_info.php';"><a>Book Info</a></li>
                    <li onclick="location.href='./html_account_info.php';"><a>Account Info</a></li>
                    <li onclick="location.href='./html_about.php';"><a">About the Book Space</a></li>
                    <li onclick="location.href='./html_meet_staff.php';"><a>Meet the staff</a></li>
                </ul>
            </div>
		</div>
		<div id="content-space">
			<div id="member_info">
			<?php
			    //the example of searching data with the sequence based on the field name
			    //search.php
			    include('../../htm/db.php');
			    $db = new db();
			    	
			    //Select all of the people/students in our database
			    $order = "SELECT id, firstname, lastname, email, city, state, phonenumber FROM usernamepassword ORDER BY id";
			    //order to search data
			    //declare in the order variable
			    	
			    //Get the results
			    $result = $db->select_list($order);	

			    //Divide by two becuase there are duplicates of each.
			    $num = count($result);
			?>
				<table border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td>Value1</td>
					<td>Value2</td>
					<td>Value3</td>
					<td>Value4</td>
					<td>Value5</td>
				</tr>
				
			<?php
				$i=0;
				while ($i < $num) 
				{
					$f1 = $result[1][$i] . " " . $result[2][$i];
					$f2 = $result[3][$i];						
					$f3 = $result[4][$i];
					$f4 = $result[5][$i];
					$f5 = $result[6][$i];
						
					?>
					
					<tr>
						<td><?php echo $f1; ?></td>
						<td><?php echo $f2; ?></td>
						<td><?php echo $f3; ?></td>
						<td><?php echo $f4; ?></td>
						<td><?php echo $f5; ?></td>
					</tr>
					
			<?php
				$i++;
				}
			?>
            </div>		
		</div>
    </div>
</body>
</html>