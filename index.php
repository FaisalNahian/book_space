
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Book Space</title>
    <link rel="stylesheet" href="./common/login.css" />
</head>
    
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31378098-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<script type="text/javascript" src="./jquery/jquery-1.7.2.js"></script>
<script>
    $(document).ready(function(){	
	$('#submit').click(function() {
                
                $('#waiting').fadeIn(500);
                $('#login_form').fadeOut(500);
                $('#error_message').fadeOut(500);
                
                $.post('htm/checkLogin.php', {
                    username: $('[name=username]').val(),
                    password: $('[name=password]').val(),
                    remember: $('[name=remember]').attr('checked')},

                    function(data){
                        if(data.error){
                            //alert("AHHHHH");
                             $('#waiting').fadeOut(500);
                               $('#error_message').removeClass().addClass((data.error === true) ? 'error' : 'success')                        
                                .text(data.msg).fadeIn(500);
                                $('#login_form').fadeIn(500); 
                                 }
                        else
                        {
                        	// similar behavior as an HTTP redirect and the location.href
                        	//window.location.replace(data.redirect);
							//return true;
                        	//The following line does the same thing
                            location.href=data.redirect;
                        }
                }, 'json');
            return false;
        });
    });
</script>

<?php 
    include('./htm/db.php');
    $db = new db();
    
    $logged_in = check_login();
    
    if( $logged_in == true){
    	header("Location: ./htm/homepage.php");
    }

    function confirm_user($username, $password){
        global $db;
        $tbl_name = 'usernamePassword';
        
        $sql="SELECT id FROM $tbl_name WHERE username = '$username' and password='$password'";
        $result = $db->select_list($sql);
        if(!$result || count($result[0]) < 1 || count($result[0]) > 2){     
            return 1; //Indicates username failure either no one was recovered or too many people whree recovered    
        } else {
        	session_start();
        	$_SESSION['username'] = $username;
        	$_SESSION['password'] = $password;
        	$_SESSION['id'] = $result[0]['id'];
        	$_SESSION['registered'] = true;
        	return 0; // One person was found -> auto log in       	     
        }
    }
    
    
    function check_login(){
        //Check if the user is remembered
        if( isset($_COOKIE['CollegeBookSpace1']) && isset($_COOKIE['CollegeBookSpace2'])) {             
            if(confirm_user($_COOKIE['CollegeBookSpace1'], $_COOKIE['CollegeBookSpace2']) != 0){              
                /* Variables are incorrect, user not logged in */                 
                return false;             
            } else {
            	// This user is in the database so log in automatically
            	return true;
            }
        }
        return false;
    }
    

?>


<body id="background">

	<img src="./images/bookspace.jpg" class="stretch" alt="" />
    <div id="container">
                
        <div id="error_message" style="display: none;"></div>
        
        <div id="waiting" style="display: none;">
            Please wait<br />
            <img src="./images/ajax-loader.gif" title="Loader" alt="Loader" />
        </div>
        
         <div id="login_form">
            <form action="htm/checkLogin.php" id="form_input" method="post">
                <fieldset>
                    <legend>Log in</legend>
                    <p>
                        <label for="username">Username:</label> <br/>
                        <input type="text" name="username" id="username" value="" />
                    </p>
                    <p>
                        <label for="password">Password:</label> <br/>
                        <input type="password" name="password" id="password" value="" />
                    </p>

                    <p>
         				<a id="facebook_logo" href="https://www.facebook.com/dialog/oauth?client_id=<?=405928632755645?>&redirect_uri=<?=urlencode('localhost/book_space /fb_oauth_return.php')?>&scope=offline_access,user_checkins,friends_checkins"><img src="./images/Facebook-32.png" ></img></a>
                   		<a id ="signupButton" href="./htm/signup.php">Sign up here!</a>
                        <a id ="contactUsButton" href="./resumes/PaulWallaceResume.pdf">Contact us!</a>
                        <a id="remember_title">Remember me</a><input id="remember" type="checkbox" name="remember"></input>
                        <input type="submit" name="submit" id="submit" style="float: right; clear: both; margin-right: 3px;" value="Log in" />
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>
