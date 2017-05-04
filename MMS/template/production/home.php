<?php

	session_start();
	if (isset($_SESSION["username"]) && isset($_SESSION["type"]))
	{
		try
		{
			include("credentials.php");
			$dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
			$pdo = new PDO($dsn,$db_username,$db_password);
			$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


			$stmt = $pdo->query("SELECT count(*) FROM Matches");
			$rows = $stmt->fetch();
			$totalmatch = $rows[0];


			$stmt = $pdo->query("SELECT count(*) FROM Player");
			$rows = $stmt->fetch();
			$totaluser = $rows[0];

			$stmt = $pdo->prepare("SELECT * FROM Player where `Username` = :name");
			$stmt->bindParam(":name", $_SESSION["username"]);
			$stmt->execute();
			$rows = $stmt->fetch();
			$name = $rows["Name"];

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

<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>MMS</title>

	<!-- Bootstrap -->
	<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
	<!-- bootstrap-progressbar -->
	<link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
	<!-- JQVMap -->
	<link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
	<!-- bootstrap-daterangepicker -->
	<link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
	<div class="container body">
	  <div class="main_container">
		<div class="col-md-3 left_col">
		  <div class="left_col scroll-view">
			<div class="navbar nav_title" style="border: 0;">
			  <a href="home.php" class="site_title"><i class="fa fa-futbol-o"></i> <span>Welcome to MMS</span></a>
			</div>

			<div class="clearfix"></div>

			<!-- menu profile quick info -->
			<div class="profile clearfix">
			  <div class="profile_pic">
				<img src="images/user.png" alt="..." class="img-circle profile_img">
			  </div>
			  <div class="profile_info">
				<span>Welcome</span>
				<h2><?php echo $name ?></h2>
			  </div>
			</div>
			<!-- /menu profile quick info -->

			<br />

			<!-- sidebar menu -->
			<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			  <div class="menu_section">
				<h3>General</h3>
				<ul class="nav side-menu">
				  <li><a href="home.php"><i class="fa fa-home"></i> Home</a>
				  </li>
				  <li><a><i class="fa fa-edit"></i> Player <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
					  <li><a href="match.php">view matches</a></li>
					  <li><a href="user.php">view users</a></li>
					</ul>
				  </li>
				  <li><a><i class="fa fa-desktop"></i> adminstrator <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
					  <li><a href="creatmatch.php">creat match</a></li>
					  <li><a href="adminmatch.php">view matches</a></li>
					  <li><a href="adminuser.php">view users</a></li>
					</ul>
				  </li>
				</ul>
			  </div>
			</div>
			<!-- /sidebar menu -->

		  </div>
		</div>

		<!-- top navigation -->
		<div class="top_nav">
		  <div class="nav_menu">
			<nav>
			  <div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			   </div>
				
			  <ul class="nav navbar-nav navbar-right">
				<li class="">
				  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<img src="images/user.png" alt="">
					<?php echo $name; ?>
					<span class=" fa fa-angle-down"></span>
				  </a>
				  <ul class="dropdown-menu dropdown-usermenu pull-right">
				  	<li><a href="modify.php"><i class="fa fa-user pull-right"></i>Edit Information</a></li>
					<li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
				  </ul>
				</li>
			  </ul>
			</nav>
		  </div>
		</div>
		<!-- /top navigation -->

		<!-- page content -->
		<div class="right_col" role="main">
		  <!-- top tiles -->
		  <div class="row-md-4 tile_count">
			<div class="col-md-6 col-sm-4 col-xs-6 tile_stats_count">
			  <span class="count_top"><i class="fa fa-users"></i> Total Users</span>
			  <div class="count"><?php echo $totaluser ?></div>
			</div>
			<div class="col-md-6 col-sm-4 col-xs-6 tile_stats_count">
			  <span class="count_top"><i class="fa fa-sitemap"></i> Total Matches</span>
			  <div class="count"><?php echo $totalmatch?></div>
			</div>
		  </div>
		  <div class="page-title">
			  <div class="title_left">
				<h3>Your Matches are shown here!</h3>
				<br>
			  </div>
		   </div>
		   
		   <!-- match chart -->
		   <div class="row">
			  <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
				  <div class="x_title">
					<h2>Match Table <small>basic table subtitle</small></h2>
					<ul class="nav navbar-right panel_toolbox">
					  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					  </li>
					</ul>
					<div class="clearfix"></div>
				  </div>
				  <div class="x_content">

					<table class="table">
					  <thead>
						<tr>
						  <th style="width: 20%">date</th>
						  <th style="width: 10%">time</th>
						  <th style="width: 10%">duration</th>
						  <th>location</th>
						  <th>capacity</th>
						  <th style="width: 20%">Info</th>
						  <th style="width: 25%">#Edit</th>
						</tr>
					  </thead>
					  <tbody>

					  <?php
						include("credentials.php");
						try 
						{
						  // Specify our connection string
						  $dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
						  // Esablish a connection to our DB
						  $pdo = new PDO($dsn,$db_username,$db_password);
						  // Enable exceptions - we want to know when our queries fail
						  $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

						  $result = $pdo->prepare("SELECT * FROM Usermatch WHERE `Username` = :name");
						  $result->bindParam(':name', $_SESSION['username']);
						  $result->execute();
						  
						  while($results = $result->fetch(PDO::FETCH_BOTH))
						  {
							$rows = $pdo->prepare("SELECT * FROM Matches WHERE `MatchId` = :matid");
							$rows->bindParam(':matid', $results['MatchId']);
							$rows->execute();
							$row = $rows->fetch();

						  
					  ?>

					  <tr>
						
						<td> <?php print(htmlspecialchars($row['Matchdate']));?></td>
						<td> <?php print(htmlspecialchars($row['Starttime']));?></td>
						<td> <?php print(htmlspecialchars($row['Duration']));?></td>
						<td> <?php print(htmlspecialchars($row['Location']));?></td>
						<td> <?php print(htmlspecialchars($row['Spaces']));?>/<?php print(htmlspecialchars($row['Capacity']));?></td>
						<td> <?php print(htmlspecialchars($row['Information']));?></td>
						<td>
						  <a href="cancel.php?id=<?php echo $row['MatchId'];?>" class="btn btn-primary btn-xs"><i class="fa fa-close"></i> cancel </a>
						</td>
					  </tr>

					  <?php 
						  } 

						} catch (Exception $e)
						  {
						   	header('Location: /~zy18745/MMS/template/production/errorpage.html');
						  }
					  ?>
					  </tbody>
					</table>

				  </div>
				</div>
			  </div>
		  <!-- /top tiles -->
		  </div>
		</div>
		<!-- footer content -->
			<footer>
				<div class="pull-right">
					<a href="https://www.nottingham.ac.uk/">The University of Nottingham</a>
				</div>
				<div class="clearfix"></div>
			</footer>
		<!-- /footer content -->
	  </div>
	 </div> 

	<!-- jQuery -->
	<script src="../vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="../vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="../vendors/nprogress/nprogress.js"></script>
	<!-- Chart.js -->
	<script src="../vendors/Chart.js/dist/Chart.min.js"></script>
	<!-- gauge.js -->
	<script src="../vendors/gauge.js/dist/gauge.min.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="../vendors/iCheck/icheck.min.js"></script>
	<!-- Skycons -->
	<script src="../vendors/skycons/skycons.js"></script>
	<!-- Flot -->
	<script src="../vendors/Flot/jquery.flot.js"></script>
	<script src="../vendors/Flot/jquery.flot.pie.js"></script>
	<script src="../vendors/Flot/jquery.flot.time.js"></script>
	<script src="../vendors/Flot/jquery.flot.stack.js"></script>
	<script src="../vendors/Flot/jquery.flot.resize.js"></script>
	<!-- Flot plugins -->
	<script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
	<script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
	<script src="../vendors/flot.curvedlines/curvedLines.js"></script>
	<!-- DateJS -->
	<script src="../vendors/DateJS/build/date.js"></script>
	<!-- JQVMap -->
	<script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
	<script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
	<script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="../vendors/moment/min/moment.min.js"></script>
	<script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

	<!-- Custom Theme Scripts -->
	<script src="../build/js/custom.min.js"></script>
	
  </body>
</html>
