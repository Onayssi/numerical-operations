<?php
/*
File Name: query.php
Description: Connection to mysql database using PDO object
*/
// server name
$hostname='localhost';
// user name
$username='root';
// user password
$password='';
// database name
$database = "operations";

try {
	// connect to $database
    $dbh = new PDO("mysql:host=$hostname;dbname=$database",$username,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    }
catch(PDOException $e){
	// show error message
    print $e->getMessage()."\n";
   					  }
?>
