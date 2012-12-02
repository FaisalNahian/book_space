<?php
//if we got something through $_POST
if (isset($_POST['search'])) {
    include('db.php');
    $db = new db();
    // never trust what user wrote! We must ALWAYS sanitize user input
    $searchTerm = mysql_real_escape_string($_POST['search']);
    // build your search query to the database
    $tbl_name = 'usernamepassword';
    $sql = "SELECT * FROM $tbl_name WHERE firstName LIKE'%$searchTerm%'OR lastName LIKE '%$searchTerm%' "; 
    // get results
//    $fieldarray = array("id");
    
//    $db->maketable($sql, $fieldarray);
    $row = $db->select_list($sql);
    if(count($row)) {
        $end_result = '';
        foreach($row as $r) {
            $result         = $r['email'];
            // we will use this to bold the search word in result
            $bold           = '<span class="found">' . $searchTerm . '</span>';
            $end_result     .= '<li>' . str_ireplace($searchTerm, $bold, $result) . '</li>';
        }
        echo $end_result;
    } else {
        echo '<li>No results found</li>';
    }
}
?>