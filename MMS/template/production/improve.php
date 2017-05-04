<?php

session_start();

if (isset($_SESSION["username"]) && isset($_SESSION["type"]))
{

	if ($_SESSION["type"]!='admin') 
  	{
  		echo "<script type='text/javascript'> alert('You do not have the permission to access here!') </script>";
		echo "<meta http-equiv='Refresh' content='0;URL=home.php'>";
		exit(0);
  	}

	$name = $_GET['name'];
	try
	{
		include("credentials.php");
		$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
		$pdo = new PDO($dsn,$db_username,$db_password);
		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


		$stmt = $pdo->prepare("UPDATE Player set `Type`='admin' WHERE `Username` = :name");
		$stmt->bindParam(':name', $name);
		$stmt->execute();

		header("Location: adminuser.php");
		exit(0);

	}
	catch(Exception $e)
	{
		header('Location: /~zy18745/MMS/template/production/errorpage.html');
	}


}
else
{
	header("Location: /~zy18745/MMS/index.html");
}


?>
