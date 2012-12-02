<?php   
	sleep(1);
	
    // include the db file and create a new instance which will connect us to the db.
    include('./db.php');
    $db = new db();

    // specify the table name for future queries
    $tbl_name="usernamepassword";

    $data['error'] = false;
    $data['msg'] = '';
    
    //Make sure there is a username entered
    if(empty($_POST['username']) || strlen($_POST['username']) <= 1 ){
        $data['error'] = true;
        $data['msg'] = 'Your username is too short!'; 
        echo json_encode($data);
        exit;
    }
    //Make sure there is a password entered
    if(empty($_POST['password']) || strlen($_POST['password']) <= 1 ){
        $data['error'] = true;
        $data['msg'] = 'Your pasword is too short!';
        echo json_encode($data);
        exit;
    }   

    // username and password sent from form 
    $username = $_POST['username']; 
    $password = $_POST['password'];
    $remember = $_POST['remember'];
    
    
    // To protect MySQL injection
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);

    //Hashing for more security
    $hashed_password = sha1($password);
    
    // IF confirm user returns false there was an issue
    if( confirm_user($username, $hashed_password) == false )
    { 	    	
        $data['error'] = true;
        $data['msg'] = "Incorrect Username or Password!";
        echo json_encode($data);
          
    } 
    else { // confirm user returned true so we can log the user in.
 	 
        // If the 'rememberme' checkbox is set then set the cookies for the remember me checkbox.           
        if( $remember == 'checked' ){
      		setcookie("CollegeBookSpace1", $username, time()+3600*24*60);
      		setcookie("CollegeBookSpace2", $hashed_password, time()+3600*24*60);
        }
   		
    	
   		// Redirect to the home page.
   		$data['error'] = false;
    	$data['msg'] = '';
        $data['redirect'] = 'htm/main_page/html_college_book_space.php';
        echo json_encode($data);                  
    }    
   
    function confirm_user($username, $password){
        global $db;
        global $tbl_name;
        $sql="SELECT id FROM $tbl_name WHERE password='$password'AND username='$username'";
        $result=$db->select_list($sql);
        
        return (count($result[0]) == 2);

    }    
?>
