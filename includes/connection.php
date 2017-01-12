<?php

    session_start();

    //Localhost connection
	if($_SERVER['HTTP_HOST'] == "localhost"){
        $ip="localhost";
        $username="root";
        $password="";
        $dbname="elantro";
	
	}else{
	//Production connection
        $ip="localhost";
        $username="username";
        $password="password";
        $dbname="elantro";
	}

	$cn=mysql_connect($ip,$username,$password) OR die("Cannot connect ".mysql_error());
	$link=mysql_select_db($dbname,$cn) OR die("Cannot select ".mysql_error()); 


?>