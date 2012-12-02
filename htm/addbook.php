<?php
	session_start();
    // sleep for two seconds to show the loading gif.
    sleep(1);

    // This is the json return vairable. 
    $return['error'] = false;
    $return['msg'] = '';
    
    
    // iclude the db.php file
    // create a new db object. This simply allows us to run queries and output the reults into a array easily.
    include('db.php');
    $db = new db();
    
    
    //sets the names of the tables that will be queried below.
    $tbl_name = 'usernamepassword';
    $book_tbl_name = 'books';
    
    //phone number does not need to be filled in so we initialize it here.
    $phone_number = '';
    
    // Create all of the variables for future use.
    // never trust what user wrote! We must ALWAYS sanitize user input
    $title = stripslashes($_POST['book_title']);
    $author_last_name = stripslashes($_POST['book_author_last']);
    $author_first_name = stripslashes($_POST['book_author_first']);
    $isbn_number = stripslashes($_POST['isbn_num']);
    $class_used_for = stripslashes($_POST['class_used_for']);
    $asking_price = stripslashes($_POST['price']);
    $condition = stripslashes($_POST['condition']);
    
    $title = mysql_real_escape_string($_POST['book_title']);
    $author_last_name = mysql_real_escape_string($_POST['book_author_last']);
    $author_first_name = mysql_real_escape_string($_POST['book_author_first']);
    $isbn_number = mysql_real_escape_string($_POST['isbn_num']);
    $class_used_for = mysql_real_escape_string($_POST['class_used_for']);
    $asking_price = mysql_real_escape_string($_POST['price']);
    $condition = mysql_real_escape_string($_POST['condition']);
    
    $author_full_name = $author_first_name . ' ' . $author_last_name;
    
    // Make sure the appropriate fields are filled in. Function at bottom
    validate_input($title, $author_last_name, $author_first_name, $isbn_number, $class_used_for, $asking_price, $condition);    

    // See if the username is already in use.
    
    $book_already_there = duplicate_book($title, $author_full_name, $isbn_number);
    
    if($book_already_there){
        $return['error'] = true;
        $return['msg'] .= 'This book is already on your shelf';
        echo json_encode($return);
        exit;
    }    

    
    insert_book($title, $author_last_name, $author_first_name, $author_full_name, $isbn_number, $class_used_for, $asking_price, $condition); 
       
  
    $return['error'] = false;
    $return['msg'] .= 'Success! Add another or log in!';
    
    echo json_encode($return);
    
    /*
     *  Functions from here down
     */

    //Insert a new member
    function insert_book($title, $author_last_name, $author_first_name, $author_full_name, $isbn_number, $class_used_for, $asking_price, $condition){ 
        global $db;
        global $book_tbl_name;
        
        // Get the current session id( the distict column in the sql table)
        // THis will be used to link this book to the user.
        $link = $_SESSION['id'];
        
	    //Get the last id from the book table
	    $last_book_id = get_last_id();    
       
        $sql = "INSERT INTO $book_tbl_name VALUES ( $last_book_id, $link, '$title', '$author_last_name', '$author_first_name', '$author_full_name', '$isbn_number', '$class_used_for', '$asking_price', '$condition')";
        $db->run_query($sql);
    }
 
    // Get the last id from the database
    function get_last_id(){
        global $db;
        global $book_tbl_name;
       //We need to select the last id so we can increment it by one for the new member
        $getLastID = "SELECT id FROM $book_tbl_name ORDER BY id DESC LIMIT 1";
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
    function duplicate_book($title, $author_full_name, $isbn_number){
        global $db;
        global $book_tbl_name;
        
        // THis is the eunique identifier.
   		$link = $_SESSION['id'];
   		
        $check_book = "SELECT id FROM $book_tbl_name WHERE  link = $link AND title = '$title' AND fullname = '$author_full_name'";
        $data = $db->select_list($check_book);

        if(count($data) > 0){
        	return true;
        }
        
        $check_isbn = "SELECT id FROM $book_tbl_name WHERE link = $link AND isbnnumber = '$isbn_number'";
        $data = $db->select_list($check_isbn);
        
        if(count($data) > 0){
        	return true;
        } else {
        	return false;
        }
        
        
    }
    
    // This function validates
    function validate_input($title, $author_last_name, $author_first_name, $isbn_number, $class_used_for, $asking_price, $condition){    
            if(strlen($title) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid book title';
            echo json_encode($return);
            exit;
        }
        if(strlen($author_last_name) <= 1){
            $return['error'] = true;
            $return['msg'] = 'please enter a valid last name';
            echo json_encode($return);
            exit;
        }
        if(strlen($author_first_name) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid first name';
            echo json_encode($return);
            exit;
        }
        if(strlen($isbn_number) <= 1){
            $return['error'] = true;
            $return['msg'] = 'please enter a valid isbn number.';
            echo json_encode($return);
            exit;
        }
        if(strlen($class_used_for) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid class or enter none';
            echo json_encode($return);
            exit;
        }
        if(strlen($asking_price) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid asking price.';
            echo json_encode($return);
            exit;
        }
        if(strlen($condition) <= 1){
            $return['error'] = true;
            $return['msg'] = 'Please enter a valid condition of your book.';
            echo json_encode($return);
            exit;
        }
    }
    
?>