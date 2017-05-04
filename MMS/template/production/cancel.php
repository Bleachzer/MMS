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


		$stmt = $pdo->prepare("DELETE FROM Usermatch WHERE `MatchId` = :ID AND `Username` = :name");
		$stmt->bindParam(':ID',$id);
		$stmt->bindParam(':name',$_SESSION["username"]);
		$stmt->execute();


		$stmt = $pdo->prepare("UPDATE Matches set `Spaces` = Spaces+1 where `MatchID` = :id");
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
