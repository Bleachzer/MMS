<?php

session_start();

if (isset($_SESSION["username"]) && isset($_SESSION["type"]))
{

	$id = $_GET['id'];
	try
	{
		include("credentials.php");
		$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
		$pdo = new PDO($dsn,$db_username,$db_password);
		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		date_default_timezone_set('Asia/Shanghai');
		$showdate = date("Y-m-d H:i:s");

		$stmt = $pdo->query("SELECT * FROM Matches where `MatchId` = '$id' ");
		$result = $stmt->fetch();
		if ($result['Matchdate'].' '.$result['Starttime'] < $showdate) 
		{
			echo "<script type='text/javascript'> alert('This game is out of date!') </script>";
			echo "<meta http-equiv='Refresh' content='0;URL=match.php'>";
			exit(0);
		}
		if ($stmt->rowCount()) 
		{
			if ($result["Spaces"]==0) 
			{
				echo "<script type='text/javascript'> alert('This game has enough players!') </script>";
				echo "<meta http-equiv='Refresh' content='0;URL=match.php'>";
				exit(0);
			}
		}

		$stmt = $pdo->prepare("SELECT * FROM Usermatch where `Username` = :user AND `MatchId` = :ID");
		$stmt->bindParam(':user',$_SESSION["username"]);
		$stmt->bindParam(':ID',$id);
		$stmt->execute();
		if ($stmt->rowCount()) 
		{
			echo "<script type='text/javascript'> alert('You have already joined this game!') </script>";
			echo "<meta http-equiv='Refresh' content='0;URL=match.php'>";
			exit(0);
		}


		$stmt = $pdo->prepare("INSERT INTO Usermatch (Username, MatchId)VALUES(:username, :matchid)");
		$stmt->bindParam(':username', $_SESSION["username"]);
		$stmt->bindParam(':matchid', $id);
		$stmt->execute();

		$stmt = $pdo->prepare("UPDATE Matches set `Spaces` = Spaces-1 where `MatchID` = :id");
		$stmt->bindParam(':id', $id);
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
	header("Location: /~zy18745/MMS/index.html");
}


?>
