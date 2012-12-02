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
                    <li onclick="location.href='./html_member_info.php';"><a>Member Info</a></li>
                    <li onclick="location.href='./html_book_info.php';"><a>Book Info</a></li>
                    <li id="selected" onclick="location.href='./html_account_info.php';"><a>Account Info</a></li>
                    <li onclick="location.href='./html_about.php';"><a">About the Book Space</a></li>
                    <li onclick="location.href='./html_meet_staff.php';"><a>Meet the staff</a></li>
                </ul>
            </div>
		</div>
		<div id="content-space">
			<div id="under_construction">
            	<a>Site under construction...</a>
                <a>Check back soon!</a>
            </div>
		</div>
    </div>
</body>
</html>