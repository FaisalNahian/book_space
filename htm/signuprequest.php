<?php
    // sleep for two seconds to show the loading gif.
    sleep(2);

    $return['error'] = false;
    $return['msg'] = '';
    
    
    // iclude the db.php file
    // create a new db object. This simply allows us to run queries and output the reults into a array easily.
    include('db.php');
    $db = new db();
    
    //sets the name of the table that will be queried below.
    $tbl_name = 'usernamepassword';
   
     //phone number does not need to be filled in so we initialize it here.
    $phone_number = '';
    
    //Set each new member as confirmed until I implement the confirmation email utility.
    $confirmed = 1;
    
    // Create all of the variables for future use.
    // never trust what user wrote! We must ALWAYS sanitize user input
    $first_name = stripslashes($_POST['first_name']);
    $last_name = stripslashes($_POST['last_name']);
    $email = stripslashes($_POST['email']);
    $username = stripslashes($_POST['username']);
    $password = stripslashes($_POST['password']);
    $password_confirm = stripslashes($_POST['password_confirm']);
    $city = stripslashes($_POST['city']);
    $state = stripslashes($_POST['state']);
    $phone_number = stripslashes($_POST['phone_number']);
    //
    $first_name = mysql_real_escape_string($_POST['first_name']);
    $last_name = mysql_real_escape_string($_POST['last_name']);
    $email = mysql_real_escape_string($_POST['email']);
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $password_confirm = mysql_real_escape_string($_POST['password_confirm']);
    $city = mysql_real_escape_string($_POST['city']);
    $state = mysql_real_escape_string($_POST['state']);
    $phone_number = mysql_real_escape_string($_POST['phone_number']);
    
    //These variables will need to be created when I implement the session code for each new member.
    //Right now they are just being initialized so that I can add to the database.
    $cookie = '';
    $session = '';
    $ip = '';

    // Make sure the appropriate fields are filled in. Function at bottom
    validate_input($first_name, $last_name, $email, $username, $password, $password_confirm, $city, $state, $phone_number);
 
    // Hash the password for database security
    $hashed_password = sha1($password);
    
    
    // See if the username is already in use.      
    if(validate_username($username))
    {
        $return['error'] = true;
        $return['msg'] .= 'Username Already in use';
        echo json_encode($return);
        exit;
    }
    
   
    //Get the last id from the database
    $last_id = get_last_id();
    
    insert_new_user($last_id, $username, $hashed_password, $first_name, $last_name, $email, $city, $state,
    		 $phone_number, $cookie, $session, $ip, $confirmed);
       
    if(isset($_SESSION['username'])){
        $return['error'] = false;
        $return['msg'] .= 'Success! Now add your books.';
    }
    else {            
        $return['error'] = true;
        $return['msg'] .= 'Error!! - You should not see this';

        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['id']);
        unset($_SESSION['regresult']);
    }
    
    echo json_encode($return);

    //Insert a new member
    function insert_new_user( $last_id, $username, $hashed_password, $first_name, $last_name, $email, $city, $state, $phone_number, $cookie, $session, $ip, $confirmed){
        global $db;
        global $tbl_name;
        $sql = "INSERT INTO $tbl_name VALUES ( $last_id, '$username', '$hashed_password', '$first_name', '$last_name', '$email', '$city', '$state', '$phone_number', '$cookie', '$session', '$ip', $confirmed)";
       	$db->run_query($sql);
        
        $_SESSION['username'] = $username;
       	$_SESSION['password'] = $hashed_password;
        $_SESSION['id'] = $last_id;
        $_SESSION['registered'] = true;

    }
 
    // Get the last id from the database
    function get_last_id(){
        global $db;
        global $tbl_name;
       //We need to select the last id so we can increment it by one for the new member
        $getLastID = "SELECT id FROM $tbl_name ORDER BY id DESC LIMIT 1";
        $row = $db->select_list($getLastID);

        // If there aren't any people in the database than the newest id is one
        $last_id = 1;

        // if there are people in the database than grab the last id and incremet it by one.
        if(count($row) ) {
            foreach($row as $r) {
                $last_id = $r[0] + 1;
            }
        }       
        return $last_id;
    }
    

    // Make sure that the username hasn't been taken
    function validate_username($username){
        global $db;
        global $tbl_name;
        $checkUsername = "SELECT username FROM $tbl_name WHERE username = '$username' ";
        $data = $db->select_list($checkUsername);

        //If a result is found then the username is already in use and the script will exit.
        // otherwise we will continue on.
        
        return (count($data) > 0);
    }
    
    // This function validates
    function validate_input($first, $last, $email, $username, $pword, $pword_confirm, $city, $state, $phone){
        if(strlen($first) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid first name';
            echo json_encode($return);
            exit;
        }
        if(strlen($last) <= 1){
            $return['error'] = true;
            $return['msg'] = 'please enter a valid last name';
            echo json_encode($return);
            exit;
        }
        if(strlen($email) <= 1 || validEmail($email) == false){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid email';
            echo json_encode($return);
            exit;
        }
        if(strlen($username) <= 1){
            $return['error'] = true;
            $return['msg'] = 'please enter a valid username.';
            echo json_encode($return);
            exit;
        }
        if(strlen($pword) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid password';
            echo json_encode($return);
            exit;
        }
        if( $pword != $pword_confirm){
            $return['error'] = true;
            $return['msg'] = 'Your passwords dont match!';
            echo json_encode($return);
            exit;
        }
        if(strlen($city) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid city.';
            echo json_encode($return);
            exit;
        }
        if(strlen($state) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid state.';
            echo json_encode($return);
            exit;
        }
        if(strlen($phone) <= 1 || strlen($phone) >= 14){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid phone number(No more than 13 charactors).';
            echo json_encode($return);
            exit;
        }
    }
    
    /**
     Validate an email address.
     Provide email address (raw input)
     Returns true if the email address has the email
     address format and the domain exists.
     http://www.linuxjournal.com/article/9585?page=0,3
     */
    function validEmail($email)
    {
    	$isValid = true;
    	$atIndex = strrpos($email, "@");
    	if (is_bool($atIndex) && !$atIndex)
    	{
    		$isValid = false;
    	}
    	else
    	{
    		$domain = substr($email, $atIndex+1);
    		$local = substr($email, 0, $atIndex);
    		$localLen = strlen($local);
    		$domainLen = strlen($domain);
    		if ($localLen < 1 || $localLen > 64)
    		{
    			// local part length exceeded
    			$isValid = false;
    		}
    		else if ($domainLen < 1 || $domainLen > 255)
    		{
    			// domain part length exceeded
    			$isValid = false;
    		}
    		else if ($local[0] == '.' || $local[$localLen-1] == '.')
    		{
    			// local part starts or ends with '.'
    			$isValid = false;
    		}
    		else if (preg_match('/\\.\\./', $local))
    		{
    			// local part has two consecutive dots
    			$isValid = false;
    		}
    		else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
    		{
    			// character not valid in domain part
    			$isValid = false;
    		}
    		else if (preg_match('/\\.\\./', $domain))
    		{
    			// domain part has two consecutive dots
    			$isValid = false;
    		}
    		else if
    		(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
    				str_replace("\\\\","",$local)))
    		{
    			// character not valid in local part unless
    			// local part is quoted
    			if (!preg_match('/^"(\\\\"|[^"])+"$/',
    					str_replace("\\\\","",$local)))
    			{
    				$isValid = false;
    			}
    		}
    		if ($isValid && !(checkdnsrr($domain,"MX") ||
    				checkdnsrr($domain,"A")))
    		{
    		// domain not found in DNS
    			$isValid = false;
    		}
    		}
    			return $isValid;
    }
    
?>