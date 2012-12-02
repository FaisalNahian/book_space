<?php 
	/*
	 * This is the logout script
	 * Paul Wallace
	 * Decemeber 30, 2011
	 */

	logout();
	
	redirect();
	
	
	function logout(){
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['id']);
		unset($_SESSION['registered']);
		
		// Set the cookie to a time in the past to delete it.
	    setcookie("cookname", $_SESSION['username'], time()-3600, "/");
	    setcookie("cookpass", $_SESSION['password'], time()-3600, "/");
	    
	    session_unset();
	    session_destroy();
	}
	
	function redirect(){
		header("Location: ../index.php");
	}
?>