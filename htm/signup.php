<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Book Space</title>
    <link rel="stylesheet" href="../common/signup.css" />
</head>

<script type="text/javascript" src="../jquery/jquery-1.7.2.js"></script>
<script type="text/javascript" src="../jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../jquery/fancybox/jquery.fancybox-1.3.4.css" />
    
<script type="text/javascript">
        $(document).ready(function() {
                $(".fancy_box").fancybox().trigger('click');
                $("a.fancy_box").fancybox({
                        'speedIn'               : 300,
                        'speedOut'              : 200,
                        'overlayColor'		: '#000',
                        'overlayOpacity'	: 0.3
                });
        });
</script>

<script>
$(document).ready(function(){	
	$('#signup_button').click(function() {
            
            $('#signup_form').fadeOut(700);
            $('#book_signup').fadeOut(700);
            $('#error_message').fadeOut(700);               
            $('#waiting').fadeIn(800);
            window.scroll(0,0);

            // ajax call
            $.ajax({
                type: "POST",
                url: "signuprequest.php",
                dataType: 'json',
                data: {
                    first_name : $('#first_name').val(),
                    last_name : $('#last_name').val(),
                    email : $('#email').val(),
                    username : $('#username').val(),
                    password : $('#password').val(),
                    password_confirm : $('#password_confirm').val(),
                    city : $('#city').val(),
                    state : $('#state').val(),
                    phone_number : $('#phone_number').val()
                },
		success : function(data){
                    if(data.error){
                        window.scroll(0,0);
 						$('#waiting').fadeOut(700);
                        $('#error_message').removeClass().addClass((data.error === true) ? 'error' : 'success')
                                .text(data.msg).fadeIn(700);
                        $('#signup_form').fadeIn(700);
                        $('#book_signup').fadeIn(700);
                   }else{
                        window.scroll(0,0);
						$('#waiting').fadeOut(700);
						$('#error_message').removeClass().addClass((data.error === true) ? 'error' : 'success')
                                .text(data.msg).fadeIn(700);
						$('#signup_form').fadeIn(700); 
                        $('#signup_form').css("z-index", "0");
                        $('#book_signup').fadeIn(700);
                        $('#signup_input').clearForm();
}
		}
            });
        return false;
    });  
    

});

$(document).ready(function(){	
	$('#add_book_button').click(function() {
            
            $('#signup_form').fadeOut(700);
            $('#book_signup').fadeOut(700);
            $('#error_message').fadeOut(700);               
            $('#waiting').fadeIn(800);
            window.scroll(0,0);

            // ajax call
            $.ajax({
                type: "POST",
                url: "addbook.php",
                dataType: 'json',
                data: {
                    book_title : $('#book_title').val(),
                    book_author_last : $('#book_author_last').val(),
                    book_author_first : $('#book_author_first').val(),
                    isbn_num : $('#isbn_num').val(),
                    class_used_for : $('#class_used_for').val(),
                    price : $('#price').val(),
                    condition : $('#condition').val()
                },
		success : function(data){
                    if(data.error){
                        window.scroll(0,0);
 						$('#waiting').fadeOut(700);
                        $('#error_message').removeClass().addClass((data.error === true) ? 'error' : 'success')
                                .text(data.msg).fadeIn(700);
                        $('#signup_form').fadeIn(700);
                        $('#book_signup').fadeIn(700);
                   }else{
                        window.scroll(0,0);
						$('#waiting').fadeOut(700);
						$('#error_message').removeClass().addClass((data.error === true) ? 'error' : 'success')
                                .text(data.msg).fadeIn(700);
						$('#signup_form').fadeIn(700); 
                        $('#signup_form').css("z-index", "0");
                        $('#book_signup').fadeIn(700);
                        $('#book_input').clearForm();
                  }
		}
            });
        return false;
    });
    
    $('#back_button_second_page').click(function() {
         $('#signup_form').css("z-index", "2");
    });
});


$.fn.clearForm = function() {
	  return this.each(function() {
	    var type = this.type, tag = this.tagName.toLowerCase();
	    if (tag == 'form')
	      return $(':input',this).clearForm();
	    if (type == 'text' || type == 'password' || tag == 'textarea')
	      this.value = '';
	    else if (type == 'checkbox' || type == 'radio')
	      this.checked = false;
	    else if (tag == 'select')
	      this.selectedIndex = -1;
	  });
	};
	
</script>


<?php 
	$session = 1;
?>

<body id="background">
    <div id="container" class="container">

        <a class="fancy_box" href="../images/bookspace_with_Text.jpg"></a>

        <div id="error_message" style="display: none;"></div>
        
        <div id="waiting" style="display: none;">
            Please wait<br />
            <img src="../images/ajax-loader.gif" title="Loader" alt="Loader" />
        </div>
        
        
         <div id="signup_form">
            <form action="./signuprequest.php" id="signup_input" method="post">
                <fieldset>
                    <legend>Sign up</legend>
                    <span style="font-size: 0.9em;">Complete the following form to sign up!</span>
                    <p>
                        <label for="first_name" id="labels" >First Name: *</label> <br/>
                        <input type="text" name="first_name" id="first_name" value="" />
                    </p>
                    <p>
                        <label for="last_name" id="labels" >Last Name: *</label> <br/>
                        <input type="text" name="last_name" id="last_name" value="" />
                    </p>
                    <p>
                        <label for="email" id="labels" >Email: *</label> <br/>
                        <input type="text" name="email" id="email" value="" />
                    </p>
                    <p>
                        <label for="username" id="labels" >Username: *</label> <br/>
                        <input type="text" name="username" id="username" value="" />
                    </p>
                    <p>
                        <label for="password" id="labels" >Password: *</label> <br/>
                        <input type="password" name="password" id="password" value="" />
                    </p>
                    <p>
                        <label for="password_confirm" id="labels" >Confirm Password: *</label> <br/>
                        <input type="password" name="password_confirm" id="password_confirm" value="" />
                    </p>
                    <p>
                        <label for="city" id="labels" >City: *</label> <br/>
                        <input type="text" name="city" id="city" value="" />
                    </p>
                    <p>
                        <label for="state" id="labels" >State: *</label> <br/>
                        <input type="text" name="state" id="state" value="" />
                    </p>
                    <p>
                        <label for="phone_number" id="labels" >Phone Number: *</label> <br/>
                        <input type="phone" name="phone_number" id="phone_number" value="" />
                    </p>
                    <div id="signup_button">
                        <input type="submit" name="signup_button" id="signup_button" style="float: right; clear: both; margin-right: 20px;" value="Signup" />
                    </div>
                    <form> 
                        <input id="back_button" type="button" value="Back" onClick="self.location='../index.php'"/>
                    </form> 
                    <div>
                        <a id="bottom_note">Note: a '*' denotes a required field</a>
                    </div>
                </fieldset>
            </form>
            </div>
        
         
        <div id="book_signup">
            <form action="./addbook.php" id="book_input" method="post">
                <fieldset>
                    <legend>Books</legend>
                    <ul id="opening_list">
                        <li>
                            Add the books you would like to sell
                        </li>
                        <li>
                            If you don't have any books to sell, click login at the bottom of the page.
                        </li>
                    </ul>
                    <p>
                        <label for="book_title" id="labels" >Title: *</label> <br/>
                        <input type="text" name="book_title" id="book_title" value="" />
                    </p>
                    <p>
                        <label for="book_author_last" id="labels" >Author's Last Name: *</label> <br/>
                        <input type="text" name="book_author_last" id="book_author_last" value="" />
                    </p>
                    <p>
                        <label for="book_author_first" id="labels" >Author's First Name: *</label> <br/>
                        <input type="text" name="book_author_first" id="book_author_first" value="" />
                    </p>
                    <p>
                        <label for="isbn_num" id="labels" >ISBN #: *</label> <br/>
                        <input type="text" name="isbn_num" id="isbn_num" value="" />
                    </p>
                    <p>
                        <label for="class_used_for" id="labels" >Class used for: *</label> <br/>
                        <input type="text" name="class_used_for" id="class_used_for" value="" />
                    </p>
                    <p>
                        <label for="price" id="labels" >Asking Price: *</label> <br/>
                        <input type="text" name="price" id="price" value="" />
                    </p>
                    <p>
                        <label for="condition" id="labels" >Condition: *</label> <br/>
                        <input type="text" name="condition" id="condition" value="" />
                    </p>
                    <div>
                        <input type="submit" name="add_book_button" id="add_book_button" style="float: right; clear: both; margin-right: 20px;" value="Add Book" />
                    </div>
                     <form> 
                        <input id="back_button_second_page" type="button" value="Back"/>
                    </form> 
                    <p>
                        <a id="bottom_note">Note: a '*' denotes a required field</a>
                    </p>
                </fieldset>
            </form>
        </div>
        
        
    </div>
</body>
</html>
