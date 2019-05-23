<?php  
	$server = 'localhost';
	$username = '';
	$password = '';
	$connectionInfo = array("UID"=>$username, "PWD"=>$password);
	$con = sqlsrv_connect($server, $connectionInfo);

	if(!$con)
	{
		die('cannot connect'.sqlsrv_errors());
		die(print_r(sqlsrv_errors(), true));
	}

	//connection established
	//create database
	

	//use database
	$serverName = 'localhost';  
	$dbInfo = array("Database"=>"syukurparking");  
	$con = sqlsrv_connect($serverName, $dbInfo);  

	if($con == false)
	{
		$con = sqlsrv_connect($server, $connectionInfo);
		$query_createDB = "CREATE DATABASE syukurparking";
		$result = sqlsrv_query($con, $query_createDB);
		
		if(!$result)
		{
			die('cannot connect');
			die(print_r(sqlsrv_errors(), true));
		}
		$con = sqlsrv_connect($serverName, $dbInfo); 
		include_once "../migrations/migrate.php";
		migrate($con);

		$createManager = 
		"
		CREATE PROCEDURE makeManager
		AS
		BEGIN
			INSERT INTO TrRegistration(Nama, Alamat, HP, Email, Password, Role) VALUES('manager','Jalan manager','0000000','manager@manager.com','manager', 'manager')
		END
		";
		
		$query = "{CALL makeManager}";

		//execute SP
		$pst = sqlsrv_query($con, $query);
		if($pst == false) //SP exec fails
		{
			$createSP = sqlsrv_query($con, $createManager); //try to create SP
			$pst = sqlsrv_query($con, $query);
		}
	}
	
	
	//=============================//
	// ===  TABLE MIGRATIONS ==== //
	//============================//
	//include "../migrations/migrate.php";
	//migrate($con); //uncomment to migrate tables
?>