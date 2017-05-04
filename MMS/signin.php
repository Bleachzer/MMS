<?php
	// Enable errors
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);



	include("credentials.php");

	if (isset($_POST["username"]) and isset($_POST["name"]) and isset($_POST["Email"]) and isset($_POST["Phone"]) and isset($_POST["password1"]) and isset($_POST["password2"]))
	{
		$username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
		if (strlen($username) < 5 or strlen($username) > 40) 
		{
			header("Location: signin.html");
			exit(0);
		}

		$name = filter_var($_POST["name"],FILTER_SANITIZE_STRING);
		if (strlen($name) <= 0 or strlen($name) > 60) 
		{
			header("Location: signin.html");
			exit(0);
		}

		$email = filter_var($_POST["Email"],FILTER_VALIDATE_EMAIL);
		if (strlen($email) <= 0 or strlen($email) > 100)
		{
			header("Location: signin.html");
			exit(0);
		}

		$phone = filter_var($_POST["Phone"],FILTER_SANITIZE_STRING);
		if (strlen($phone) < 6 or strlen($phone) > 50) 
		{
			header("Location: signin.html");
			exit(0);
		}

		$password1 = filter_var($_POST["password1"],FILTER_SANITIZE_STRING);
		$password2 = filter_var($_POST["password2"],FILTER_SANITIZE_STRING);
		if ($password1 != $password2 or strlen($password1) < 5 or strlen($password1) > 100)
		{
			header("Location: signin.html");
			exit(0);	
		}
		$password1=md5($password1);

		try
		{
			$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
			$pdo = new PDO($dsn,$db_username,$db_password);
			$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
			$stmt = $pdo->query("SELECT * FROM Player");
			$result = $stmt->fetch();
			if($result["Username"]==$username)
			{
				echo "<script type='text/javascript'> alert('Username has already exist!') </script>";
				echo "<meta http-equiv='Refresh' content='0;URL=signin.html'>";
				exit(0);			
			}		
			
			$stmt = $pdo->prepare("INSERT INTO Player (Username, Name, Email, Phone, Password)VALUES(:username, :name, :email, :phone, :password)");
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':password', $password1);
			$stmt->execute();

			header("Location: index.html");
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
		echo "<meta http-equiv='Refresh' content='0;URL=signin.html'>";
		exit(0);
	}
?>
