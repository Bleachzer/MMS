<?php
	// Enable errors

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	

	include("credentials.php");

	// get the variable in js
	$username = filter_var($_POST["name"],FILTER_SANITIZE_STRING);

	try
	{
		$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
		$pdo = new PDO($dsn,$db_username,$db_password);
		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		
		$stmt = $pdo->prepare("SELECT * FROM `Player` where `Username` = :username");
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		if ($stmt->rowCount()) 
		{
			echo true;
		}
		else
		{
			echo false;
		}
		
	}
	catch(Exception $e)
	{
		header('Location: /~zy18745/MMS/template/production/errorpage.html');
	}



?>