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
	try
	{
	  include("credentials.php");
	  $dsn = 'mysql:dbname='.$db_database.';host='.$db_host;
	  $pdo = new PDO($dsn,$db_username,$db_password);
	  $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


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



    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
	
	<!-- JQVMap -->
	<link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
	<!-- bootstrap-daterangepicker -->
	<link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

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
					<?php echo $name ?>
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
		  <div class="">
			<div class="page-title">
			  <div class="title_left">
				<h3>User <small>Lists</small></h3>
			  </div>
			</div>
			
			<div class="clearfix"></div>

			<div class="row">
			  <div class="col-md-12">
				<div class="x_panel">
				  <div class="x_title">
					<h2>Users</h2>
					<ul class="nav navbar-right panel_toolbox">
					  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					  </li>
					</ul>
					<div class="clearfix"></div>
				  </div>
				  <div class="x_content">


					<!-- start project list -->
					<table id="datatable" class="table table-striped table-bordered">
					  <thead>
						<tr>
						  <th>Username</th>
						  <th>Name</th>
						  <th>Email</th>
						  <th>Phone</th>
						  <th>Type</th>
						  <th>#Edit</th>
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
						  // We simply want all of the orders in our table
						  $rows = $pdo->query("SELECT * FROM Player;");
						  
						  $count = 0;

						  // Iterate through each row of our results
						  foreach ($rows as $row) {
					  ?>
						  
					  <tr>
						<td> <?php print(htmlspecialchars($row['Username']));?></td>
						<td> <?php print(htmlspecialchars($row['Name']));?></td>
						<td> <?php print(htmlspecialchars($row['Email']));?></td>
						<td> <?php print(htmlspecialchars($row['Phone']));?></td>
						<td> <?php print(htmlspecialchars($row['Type']));?></td>
						<?php if ($row['Type']=='Player') 
						{
						?>
						<td>
						<a class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm-<?php echo $count ?>"><i class="fglyphicon glyphicon-plus"></i>Improve</a>
							<div class="modal fade bs-example-modal-sm-<?php echo $count ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    			<div class="modal-dialog modal-sm-<?php echo $count ?>">
                      				<div class="modal-content">
										<div class="modal-header">
                          					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          					</button>
                          					<h4 class="modal-title" id="myModalLabel2">Notice</h4>
                        				</div>
                        			<div class="modal-body">
                          				<h4>Do you want to improve this user to admin?</h4>
                        			</div>
                        			<div class="modal-footer">
                          				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          				<a href="improve.php?name=<?php echo $row['Username'];?>" type="button" class="btn btn-primary">Yes</a>
                       		 		</div>

                      				</div>
                    			</div>
                  			</div>
							
						  <?php $count = $count + 1 ?>
						  <a class="btn btn-danger btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm-<?php echo $count ?>"><i class="fa fa-trash-o"></i>Delete</a>
							<div class="modal fade bs-example-modal-sm-<?php echo $count ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    			<div class="modal-dialog modal-sm-<?php echo $count ?>">
                      				<div class="modal-content">
										<div class="modal-header">
                          					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          					</button>
                          					<h4 class="modal-title" id="myModalLabel2">Notice</h4>
                        				</div>
                        			<div class="modal-body">
                          				<h4>Do you want to delete this user?</h4>
                        			</div>
                        			<div class="modal-footer">
                          				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          				<a href="deleteuser.php?name=<?php echo $row['Username'];?>" type="button" class="btn btn-primary">Yes</a>
                       		 		</div>

                      				</div>
                    			</div>
                  			</div>
                  		<?php $count = $count + 1 ?>
						</td>
						<?php 
						} 
						else
						  { ?>
							<td></td>
						  <?php } ?>
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
					<!-- end project list -->

				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<!-- /page content -->

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
	<!-- bootstrap-progressbar -->
	 <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>

	<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	
	
	<!-- Custom Theme Scripts -->
	<script src="../build/js/custom.min.js"></script>
  </body>
</html>
