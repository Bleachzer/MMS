<?php
	// Enable errors
	
	session_start();

	error_reporting(E_ALL);
	ini_set('display_errors', 1);


	include("credentials.php");

	if (isset($_POST["username"]) and isset($_POST["password"]))
	{
		$username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
		if (strlen($username) < 5 or strlen($username) > 40) 
		{
			header("Location: index.html");
			exit(0);
		}
		$password = $_POST["password"];
		if (strlen($password) < 5 or strlen($password) > 100) 
		{
			header("Location: index.html");
			exit(0);
		}
		$password = md5($password);


		try
		{
			$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
			$pdo = new PDO($dsn,$db_username,$db_password);
			$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			
			$stmt = $pdo->prepare("SELECT * FROM `Player` where `Username` = :username AND `Password` = :password");
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $password);
			$stmt->execute();
			$result = $stmt->fetch();
			if ($stmt->rowCount()) 
			{
				if($result["Type"] == 'Player')
				{
					$_SESSION["username"] = $username;
					$_SESSION["type"] = 'Player';
					header('Location: /~zy18745/MMS/template/production/home.php');
					exit(0);
				}
				if ($result["Type"] == 'admin') 
				{
					$_SESSION["username"] = $username;
					$_SESSION["type"] = 'admin';
					header('Location: /~zy18745/MMS/template/production/home.php');
					exit(0);
				}
			}
			echo "<script type='text/javascript'> alert('Invalid username and password! ') </script>";
			echo "<meta http-equiv='Refresh' content='0;URL=index.html'>";
			exit(0);

		}
		catch(Exception $e)
		{
			header('Location: /~zy18745/MMS/template/production/errorpage.html');
		}


	}
	else
	{
		echo "<script type='text/javascript'> alert('Invalid username and password! ') </script>";
		echo "<meta http-equiv='Refresh' content='0;URL=index.html'>";
		exit(0);
	}
?>
