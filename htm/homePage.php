<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Book Space</title>
    <link rel="stylesheet" href="../common/homePage.css" />
</head>
    
    
<script type="text/javascript" src="../jquery/jquery-1.7.2.js"></script>


<script>
/*
 * 
 * This script is not completed but I will be using it for the log out feature.
 * 
 */
$(document).ready(function(){	
	$('#logout').click(function() {
                
                $('#waiting').fadeIn(500);
                $('#title').fadeOut(500);
                $('#adbar').fadeOut(500);
                $('#contentcontainer').fadeOut(500);
                
                $.post('htm/logout.php', {
                    function(data){
                        if(data.error){
                             $('#waiting').fadeOut(500);
                               $('#error_message').removeClass().addClass((data.error === true) ? 'error' : 'success')                          
                                .text(data.msg).fadeIn(500);
                                $('#login_form').fadeIn(500); 
                                 }else{
                                         location.href=data.redirect;
                                           };
                           }, 'json');
            return false;
        });
    });
</script>



<script type="text/javascript">
/*
 * This script has two totally seperate sections.
 * The first deals with the search bar
 * The second deals with the main tabs holding the data.
 *  
 */
$(function() {
    $(".search_button").click(function() {
        // getting the value that user typed
        var searchString = $("#search_box").val();
        // forming the queryString
        var data = 'search='+ searchString;

        // if searchString is not empty
        if(searchString) {
            // ajax call
            $.ajax({
                type: "POST",
                url: "searchCode.php",
                data: data,
                beforeSend: function() { // this happens before actual call
                    $("#results").html('');
                    $("#searchresults").show();
                    $(".word").html(searchString);
               },
               success: function(html){ // this happens after we get results
                    $("#results").show();
                    $("#results").append(html);
              }
            });
        }
        return false;
    });
});
//
//
//
// Below is the Jquery script for the tabs
//
//
var containerId = '#tabs-container';
var tabsId = '#tabs';

$(document).ready(function(){
	// Preload tab on page load
	if($(tabsId + ' LI.current A').length > 0){
		loadTab($(tabsId + ' LI.current A'));
	}
	
    $(tabsId + ' A').click(function(){
    	if($(this).parent().hasClass('current')){ return false; }
    	
    	$(tabsId + ' LI.current').removeClass('current');
    	$(this).parent().addClass('current');
    	
    	loadTab($(this));    	
        return false;
    });
});

function loadTab(tabObj){
    if(!tabObj || !tabObj.length){ return; }
    $(containerId).addClass('loading');
    $(containerId).hide();
    
    $(containerId).load(tabObj.attr('href'), function(){
        $(containerId).removeClass('loading');
        $(containerId).show();
    });
};
</script>

<?php 
	$woopdyDoo = 'wowy';
?>

<body>
	<img src="../images/bookspace.jpg" class="stretch" alt="" />
	
	<div id="waiting" style="display: none;">
        Please wait<br />
        <img src="../images/ajax-loader.gif" title="Loader" alt="Loader" />
    </div>


	<div id="container">
        <div id="title">
            
            <div id="titleimage"></div>
            <div id="overbanner"></div>
            
            <div id="searchbar">
                <div id="searchbarhome">
                    <a href="../index.php">Home</a>
                </div>
                <div id="searchbarabout">
                    <a href="./main_page/html_college_book_space.php">PHP Info</a>
                </div>
                <div id="searchbarcompany">
                    <a id="logout" href="./logout.php">Log Out</a>
                </div>
            </div>
        </div>
        <div id="adbar">
            <div style="margin:20px auto; text-align: center;">
                <form method="post" action="searchCode.php">
                    <input type="text" name="search" id="search_box" class='search_box'/>
                    <input type="submit" value="Search" class="search_button" /><br />
                </form>
            </div>
            
            <div>
                <div id="searchresults">Search results for: <span class="word"></span></div>
                <ul id="results" class="update"> </ul>
            </div>

        </div>
        <div id="contentcontainer">
            <!-- the tabs -->
            <div id="content">
                <ul class="mytabs" id="tabs">
                    <li class="current"><a href="../tabs/student_tab.php">Students</a></li>
                    <li><a href="../tabs/book_tab.php">Books</a></li>
                </ul>
            </div>
            <div class="mytabs-container" id="tabs-container">
                Loading. Please Wait...
            </div>
        </div>
   </div>
</body>
</html>