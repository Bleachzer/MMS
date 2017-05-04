<?php
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	session_start();
	if ($_SESSION["type"]!='admin') 
  	{
  		echo "<script type='text/javascript'> alert('You do not have the permission to access here!') </script>";
		echo "<meta http-equiv='Refresh' content='0;URL=home.php'>";
		exit(0);
  	}

	include("credentials.php");

	if (isset($_POST["Date"]) and isset($_POST["Time"]) and isset($_POST["duration"]) and isset($_POST["location"]) and isset($_POST["capacity"]))
	{
		$date = filter_var($_POST["Date"],FILTER_SANITIZE_STRING);
		$reg = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
		preg_match($reg,$date,$result);
		if (strlen($date) <= 0 or !$result)
		{
			header("Location: creatmatch.php");
			exit(0);
		}


		$time = filter_var($_POST["Time"],FILTER_SANITIZE_STRING);
		$reg = '^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$';
		preg_match($reg,$time,$result);
		if (strlen($time) <= 0 or !$result) 
		{
			header("Location: creatmatch.php");
			exit(0);
		}


		$duration = filter_var($_POST["duration"],FILTER_SANITIZE_STRING);
		$reg = '/^(\d|[1-9]\d|[1-2]\d{2}|300)$/';
		preg_match($reg,$duration,$result);
		if (strlen($duration) <= 0 or !$result)
		{
			header("Location: creatmatch.php");
			exit(0);
		}

		$location = filter_var($_POST["location"],FILTER_SANITIZE_STRING);
		if (strlen($location) <= 0 or strlen($location) > 100) 
		{
			header("Location: creatmatch.php");
			exit(0);
		}

		$spaces = $capacity = filter_var($_POST["capacity"],FILTER_SANITIZE_STRING);
		$reg = '/^(\d|[1-9]\d|100)$/';
		preg_match($reg,$capacity,$result);
		if (strlen($capacity) <= 0 or !$result)
		{
			header("Location: creatmatch.php");
			exit(0);
		}


		$information = filter_var($_POST["information"],FILTER_SANITIZE_STRING);
		if (strlen($information) < 0 or strlen($information) > 255) 
		{
			header("Location: creatmatch.php");
			exit(0);
		}


		try
		{
			$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
			$pdo = new PDO($dsn,$db_username,$db_password);
			$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			
			$stmt = $pdo->prepare("INSERT INTO Matches (Matchdate, Starttime, Duration, Location, Capacity, Spaces, Information)VALUES(:dat, :tim, :duration, :location, :capacity, :spaces, :information)");
			$stmt->bindParam(':dat', $date);
			$stmt->bindParam(':tim', $time);
			$stmt->bindParam(':duration', $duration);
			$stmt->bindParam(':location', $location);
			$stmt->bindParam(':capacity', $capacity);
			$stmt->bindParam(':spaces', $spaces);
			$stmt->bindParam(':information', $information);
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
		echo "<meta http-equiv='Refresh' content='0;URL=creatmatch.php'>";
		exit(0);
	}
?>