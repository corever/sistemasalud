<?php
    //database configuration
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'calidadgestion';
    
    //connect with the database
    $db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $db->query("SELECT id,email FROM tbl_usuario WHERE email LIKE '%".$searchTerm."%' ORDER BY email ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['email'];
		//$data[] = $row['id'];
    }
    
    //return json data
    echo json_encode($data);
?>