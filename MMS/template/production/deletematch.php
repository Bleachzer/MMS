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

	$id = $_GET['id'];
	try
	{
		include("credentials.php");
		$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
		$pdo = new PDO($dsn,$db_username,$db_password);
		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$stmt = $pdo->prepare("DELETE FROM Usermatch WHERE `MatchId` = :ID");
		$stmt->bindParam(':ID',$id);
		$stmt->execute();

		$stmt = $pdo->prepare("DELETE FROM Matches WHERE `MatchId` = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();

		header("Location: adminmatch.php");
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
