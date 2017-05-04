<?php
	// Enable errors
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	session_start();
	if (!isset($_SESSION['username'])) 
	{
		header("Location: /~zy18745/MMS/index.html");
	}

	include("credentials.php");

	if (isset($_POST["Name"]) and isset($_POST["Email"]) and isset($_POST["Phone"]))
	{

		$name = filter_var($_POST["Name"],FILTER_SANITIZE_STRING);
		if (strlen($name) <= 0 or strlen($name) > 60) 
		{
			header("Location: modify.php");
			exit(0);
		}

		$email = filter_var($_POST["Email"],FILTER_VALIDATE_EMAIL);
		if (strlen($email) <= 0 or strlen($email) > 100)
		{
			header("Location: modify.php");
			exit(0);
		}

		$phone = filter_var($_POST["Phone"],FILTER_SANITIZE_STRING);
		if (strlen($phone) < 6 or strlen($phone) > 50) 
		{
			header("Location: modify.php");
			exit(0);
		}


		try
		{
			$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
			$pdo = new PDO($dsn,$db_username,$db_password);
			$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
			$stmt = $pdo->prepare("UPDATE Player SET `Name` = :name, `Email` = :email, `Phone` = :phone where `Username` = :username");
			$stmt->bindParam(':username',$_SESSION['username']);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':phone', $phone);
			$stmt->execute();

			header("Location: home.php");
			exit(0);

		}
		catch(Exception $e)
		{
			header('Location: /~zy18745/MMS/template/production/errorpage.html');
		}


	}
	else
	{
		echo "<script type='text/javascript'> alert('Invalid input!') </script>";
		echo "<meta http-equiv='Refresh' content='0;URL=home.php'>";
		exit(0);
	}
?>
