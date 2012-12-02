<?php
class db {
	
  	function __construct()
  	{
 		global $dbh;
  		if (!is_null($dbh))
  		{
  			$data['error'] = true;
  			$data['msg'] = 'System Error';
  			echo json_encode($data);
  			exit;
  		}
  		$dbh = mysql_pconnect('localhost', 'PaulWallacc', '1111');
  		//THis is the server info
  		//Only use when updating production server
  		//$dbh = mysql_pconnect('localhost', 'p27b60k3_pwall', 'Th30ff1c3');
  		if( !$dbh)
  		{
  			$data['error'] = true;
  			$data['msg'] = 'System Error';
  			echo json_encode($data);
  			exit;
  				
  		}
  		mysql_select_db('bookspace');
  		mysql_query('SET NAMES utf8');
  		
  		//THis is the server info
  		//Only use when updating production server
  		//mysql_select_db('p27b60k3_BookSpace');
  	}
  	
  	 
	// use this if there will be results.
    function select_list($query)
    {
        $getList = mysql_query($query);
        if (!$getList){
        	$error = mysql_error();
        	$data['error'] = true;
        	$data['msg'] = 'System Error -' . $error;
        	echo json_encode($data);
        	exit;
        }
       //$row = mysql_fetch_Array($getList);
        //$row = mysql_fetch_array($getList, MYSQL_BOTH);
        $ret = array();
        //Make sure there is data in the $row variable
        while($row = mysql_fetch_array($getList))
        {
        	array_push($ret, $row);
        }
	    mysql_free_result($getList);
        return $ret;   
    }
    
    //Use this if you are simply inserting something.
    function run_query($query)
    {
    	$runQuery = mysql_query($query);
    	
    	if (!$runQuery){
    		$error = mysql_error();
    		$data['error'] = true;
    		$data['msg'] = 'System Error -' . $error;
    		echo json_encode($data);
    		exit;
    	}
    }
  }
?>
