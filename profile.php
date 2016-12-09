<?php
	session_start();
	ob_start();
	if($_SESSION['usertype'] != 1) {
		header('Location: ' . $_SERVER["REQUEST_URI"] . '?notFound=1');
		exit;
	}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="public/stylesheets/index.css">
        <link rel="stylesheet" type="text/css" href="public/stylesheets/profile.css">
        <link rel="stylesheet" type="text/css" href="public/stylesheets/font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Quicksand:700" rel="stylesheet" type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <header>
            <div class="nav">
                <ul>
                    <li><a href="./userPage.php">Home</a></li>
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['user']['name']; ?> <i class="fa fa-caret-down fa-lg" aria-hidden="true"></i></a>
                        <ul>
                            <li><a href="./profile.php"><i class="fa fa-pencil fa-fw"></i> Profile</a></li>
                            <li><a href="./logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>

        <div class="container" style="margin-top:80px;text-align: center; font-size: 35px; cursor:pointer">
            <h1 class="bigwelcome">ME</h1>
            <a data-toggle="modal" data-target="#myModalone">Edit profile</a><br>
            <a data-toggle="modal" data-target="#myModaltwo">My Application</a>
        </div>

        <div class="modal fade" id="myModalone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong>Edit Profile</strong>
                        </h2>
                    </div>
                    <div class="modal-body">
						<form action="#" method="POST">
							<div class="form-group">
	                            <strong style="font-size:16px; margin:0 65px 0 0;">Major</strong>
								<?php
									include "db.php";
									if(isset($_SESSION['user'])) {
										$name = $_SESSION['user'];
										$res = getMajorFromUser($name["name"]);
										$major = $res[0]["major"];
										$res1 = getYearFromUser($name["name"]);
										$year = $res1[0]["year"];
										$department = getDepartmentByMajor($major);
										$majors = selectMajor();
										echo '<select name="role" class="form-control" style="display: inline; width: 300px;">';
										if($major != NULL){
											echo "<option> " . $major . " </option>";
										}
										for($i = 0; $i < count($majors); $i++) {
											if($majors[$i]['name'] != $major)
												echo "<option>" . $majors[$i]['name'] . "</option>";
										}
										echo "</select>";
									}
								?>
	                        </div>
	                        <div class="form-group">
	                            <strong style="font-size:16px; margin:0 73px 0 0;">Year</strong>
								<?php
									echo '<select name="role" class="form-control" style="display: inline; width: 100px;">>';
									echo "<option>" . $year . "</option>";
									$year_Array = array("freshman", "sophomore", "junior", "senior");
									foreach($year_Array as $val)
									{
										if($val != $year)
											echo "<option>" . $val . "</option>";
									}
									echo "</select>"
								?>
	                        </div>
	                        <div class="form-group">
	                            <strong style="font-size:16px; margin-right:13px;">Department</strong>
								<?php echo $department[0]['dept_name']; ?>
	                        </div>
						</form>
                    </div>
                  <div class="modal-footer">
                      <button type="submit" data-dismiss="modal" name="button" class="btn btn-danger btn-lg">
                          Cancel
                      </button>
                  </div>
              </div>
          </div>
      </div>

        <!--My Application Modal-->
        <div class="modal fade" id="myModaltwo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                          </button>
                          <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong>My Application</strong>
                          </h2>
                      </div>
                      <div class="modal-body">
                          <table class="table table-condensed table-hover table-responsive">
                              <thead>
                                  <tr>
                                      <th class="col-md-2">Date</th>
                                      <th class="col-md-8">Project Name</th>
                                      <th>Status</th>
                                  </tr>
                              </thead>
                              <tbody>
								  <?php
									  if(isset($_SESSION['user'])) {
										  $re = $_SESSION['user'];
										  $name = $re['name'];
										  $res = selectApplication($name);
										  for($i = 0; $i < count($res); $i++) {
											  echo "<tr>";
											  echo "<td class=col-md-2>" . $res[$i]["date"] . "</td>";
											  echo "<td class=col-md-8>" . $res[$i]["project_name"] . "</td>";
											  echo "<td>" . $res[$i]["status"] . "</td>";
											  echo "</tr>";
										  }
									  }
								  ?>
                              </tbody>
                          </table>
                          <div class="modal-footer">
                              <button type="submit" name="button" class="btn btn-danger btn-lg" data-dismiss="modal">
                                Cancel</button>
                          </div>
                      </div>
                   </div>
               </div>
           </div>
		   <?php
			   $name = $_SESSION['user'];
			   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				   if(isset($_POST['change'])) {
					   $major = $_POST['major'];
					   $year = $_POST['year'];
					   print_r($year);
					   updateTableUserMajor($name["name"], $major);
					   updateTableUserYear($name["name"], $year);
					   header("Refresh:0");
				   }
			   }
		   ?>
    </body>
</html>
