<?php

    if(isset($_COOKIE['id']))
    {
        session_id($_COOKIE['id']);
    }

    session_start();

    if($_SESSION['hid'] == null){
        header("Location:hod-login.php");
    }

?>
<?php
$hdept=$_SESSION['hid'];
$count=0;
include("connection.php");
$output=0;
$sql=mysqli_query($connect,"select count(leave_id) as count from facleave where status='0' and facDept='$hdept'");
if($sql){
    while($row=mysqli_fetch_array($sql)){
        $count=$row['count'];
    }
}
?>
<?php
$input = $_GET['id'];
$arr = explode(" ",$input);
$leave_id = $arr[0];
$tableName = $arr[1];
$ndays='';
$reason='';


?>
<?php

$sql=mysqli_query($connect,"select * from $tableName where leave_id='$leave_id'");
if($sql){
    while($row=mysqli_fetch_array($sql)){
        $leave_id = $row['leave_id'];
        $facJntuId = $row['facJntuId'];
        $facName = $row['facName'];
        $fdate = $row['fdate'];
        $tdate = $row['tdate'];
        $ndays = $row['ndays'];
        $hod_status = $row['hod_status'];
        $hod_remarks = $row['hod_remarks'];

        $dean_status = $row['dean_status'];
        $dean_remarks = $row['dean_remarks'];

        $principal_status = $row['principal_status'];
        $principal_remarks = $row['principal_remarks'];

        $class_adjustment = $row['class_adjustment'];

        if($tableName == 'leavescl'){
          $reason = $row['reason'];
        }elseif ($tableName == 'leavesmtl') {
          $file_name = $row['file_path'];
        }elseif ($tableName == 'leavesal') {
          $file_name = $row['file_path'];
        }elseif ($tableName == 'leavesod') {
          $type = $row['type'];
          $file_name = $row['file_path'];
        }elseif ($tableName == 'leavesml') {
          $file_name = $row['file_path'];
        }elseif ($tableName == 'leavesccl') {
          $type = $row['type'];
          $reason = $row['reason'];
        }elseif ($tableName == 'leaveseol') {
          $reason = $row['reason'];
        }elseif ($tableName == 'leavesmrl') {
          $file_name = $row['file_path'];
        }
    }
}

$msg = '';
if($hod_status == 'REJECTED'){
  $msg = "REJECTED by HOD";
}elseif ($dean_status == 'REJECTED') {
  // code...
  $msg = "REJECTED by DEAN";
}elseif ($principal_status == 'REJECTED') {
  // code...
  $msg = "REJECTED by PRINCIPAL";
}elseif ($principal_status == 'APPROVED') {
  // code...
  $msg = "APPROVED";
}elseif ($principal_status == 'PENDING' && $dean_status == 'APPROVED') {
  // code...
  $msg = "Request at Principal - yet to be approved";
}elseif ($hod_status == 'APPROVED' && $dean_status == 'PENDING') {
  // code...
  $msg = "Request at Dean - yet to be approved";
}
if($tableName == 'leavescl'){
  $leave_type = 'CASUAL LEAVES';
}elseif ($tableName == 'leavesmtl') {
  // code...
  $leave_type = 'MATERNITY LEAVES';
}elseif ($tableName == 'leavesal') {
  // code...
  $leave_type = 'ACADEMIC LEAVES';
}elseif ($tableName == 'leavesod') {
  // code...
  $leave_type = 'ON-DUTY LEAVES';
}elseif ($tableName == 'leavesml') {
  // code...
  $leave_type = 'EMERGENCY LEAVES';
}elseif ($tableName == 'leavesccl') {
  // code...
  if($type == 'Requestccl'){
    $leave_type = 'REQUEST CCL LEAVES';
  }else{
    $leave_type = 'APPLY CCL LEAVES';
  }

}elseif ($tableName == 'leaveseol') {
  // code...
  $leave_type = 'EXTRA ORDINARY LEAVES';
}
elseif ($tableName == 'leavesmrl') {
  // code...
  $leave_type = 'MARRIAGE LEAVE';
}

$count = 0;
$sql=mysqli_query($connect,"select * from $tableName where facJntuId = '$facJntuId' and principal_status = 'APPROVED' ");
if($sql){
    while($row=mysqli_fetch_array($sql)){
        $count++;
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/vgnt.png">
    <title>Hod Portal</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript">
        window.onload = function() {
        history.replaceState("", "", "hod-view-leaves2.php");
        }
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b><img src="images/University.png" alt="homepage" class="dark-logo" /></b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <!-- <span><img src="images/logo-text.png" alt="homepage" class="dark-logo" /></span> -->
                        <!-- <span><h4 class="m-b-20">admin</h4></span> -->
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/Admin_25px.png" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                      <li><a href="hod-change_password.php"><i class="fa fa-edit"></i> Change Password</a></li>
                                    <li><a href="hod/logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="hod.php">Profile </a></li>
                            </ul>
                        </li>
                        <li class="nav-devider"></li>
                        <li class="nav-label">View Details</li>
                        <li> <a href="hod-student.php" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Student</span></a>
                        </li>
                        <li> <a href="hod-faculty.php" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Faculty</span></a>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Exam Cell</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="hod-view_results.php">View Results</a></li>
                                <li><a href="hod-result_analysis.php">Result Analysis</a></li>
                                <li><a href="hod-subject_analysis.php">Subject Analysis</a></li>
                                <li><a href="hod-backlogs.php">Backlogs</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Attendance</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="hod-view_att.php">View Attendance</a></li>
                            </ul>
                        </li>
                        <li class="nav-devider"></li>
                        <li class="nav-label">Manage</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Leaves</span></a>
                            <ul aria-expanded="false" class="collapse">
                              <li><a href="hod-view_leaves.php">View Leaves</a></li>
                              <li><a href="hod-view-leaves2.php">View Leaves(updated)</a></li>
                              <li><a href="hod-view-leaves_history.php">View Leaves History</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">WELCOME <?php echo $_SESSION['hid'];?></h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="hod-view-leaves2.php">View Leaves</a></li>
                        <li class="breadcrumb-item active">Leave Deatils</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">

                  <div class="col-lg-6">
                      <div class="card">
                          <div class="card-title">
                              <h4><?php echo $leave_type;?></h4>
                              <h4></h4>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table">
                                      <thead>
                                          <tr>
                                              <th>LEAVE ID</th>
                                              <th><?php echo $leave_id;?></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <th>Faculty ID</th>
                                              <td><?php echo $facJntuId;?></td>
                                          </tr>
                                          <tr>
                                              <th>Faculty Name</th>
                                              <td><?php echo $facName;?></td>
                                          </tr>
                                          <tr>
                                              <th>From</th>
                                              <td><?php echo $fdate;?></td>
                                          </tr>
                                          <tr>
                                              <th>To</th>
                                              <td><?php echo $tdate;?></td>
                                          </tr>
                                          <tr>
                                              <th>Total no of days</th>
                                              <td><?php echo $ndays;?></td>
                                          </tr>
                                          <tr>
                                              <th>Class Adjustment</th>
                                              <td><?php echo $class_adjustment;?></td>
                                          </tr>
                                          <tr>
                                              <th>Total no leaves available</th>
                                              <td><?php echo $ndays;?></td>
                                          </tr>
                                          <?php
                                          if($tableName == 'leavescl'){?>
                                            <tr>
                                                <th>Reason</th>
                                                <td><?php echo $reason;?></td>
                                            </tr>
                                          <?php }elseif ($tableName == 'leavesmtl') {?>
                                            <tr>
                                                <th>File for proof</th>
                                                <td><a target="_blank" href='<?php echo "uploads/".$file_name?>'>DOWNLOAD FILE</a></td>
                                            </tr>
                                          <?php }elseif ($tableName == 'leavesal') {?>
                                            <tr>
                                                <th>File for proof</th>
                                                <td><a target="_blank" href='<?php echo "uploads/".$file_name?>'>DOWNLOAD FILE</a></td>
                                            </tr>
                                          <?php }elseif ($tableName == 'leavesod') {?>
                                            <tr>
                                                <th>Type</th>
                                                <td><?php echo $type;?></td>
                                            </tr>
                                            <tr>
                                                <th>File for proof</th>
                                                <td><a target="_blank" href='<?php echo "uploads/".$file_name?>'>DOWNLOAD FILE</a></td>
                                            </tr>
                                          <?php }elseif ($tableName == 'leavesml') {?>
                                            <tr>
                                                <th>File for proof</th>
                                                <td><a target="_blank" href='<?php echo "uploads/".$file_name?>'>DOWNLOAD FILE</a></td>
                                            </tr>
                                          <?php }elseif ($tableName == 'leavesccl') {?>
                                            <tr>
                                                <th>Type</th>
                                                <td><?php echo $type;?></td>
                                            </tr>
                                            <tr>
                                                <th>Reason</th>
                                                <td><?php echo $reason;?></td>
                                            </tr>
                                          <?php }elseif ($tableName == 'leavesmrl') {?>
                                            <tr>
                                                <th>File for proof</th>
                                                <td><a target="_blank" href='<?php echo "uploads/".$file_name?>'>DOWNLOAD FILE</a></td>
                                            </tr>
                                          <?php }elseif ($tableName == 'leaveseol') {?>
                                            <tr>
                                                <th>Reason</th>
                                                <td><?php echo $reason;?></td>
                                            </tr>
                                        <?php  }
                                          ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                  <?php
                    if($hod_status != 'PENDING'){
                      ?>
                      <div class="col-lg-6">
                          <div class="card">
                              <div class="card-title">
                                  <h4><?php echo $msg;?></h4><br>
                                  <h4 class="text-primary">REMARKS:</h4><br>
                                  <?php if($hod_remarks != ''){
                                    echo "<h4>HOD : </h4>";
                                    echo "<h4>".$hod_remarks."</h4><br>";
                                  }?>
                                  <?php if($dean_remarks != ''){
                                    echo "<h4>DEAN : </h4>";
                                    echo "<h4>".$dean_remarks."</h4><br>";
                                  }?>
                                  <?php if($principal_remarks != ''){
                                    echo "<h4>PRINCIPAL : </h4>";
                                    echo "<h4>".$principal_remarks."</h4><br>";
                                  }?>
                              </div>
                          </div>
                      </div>
                      <?php
                    }else{
                  ?>
                  <div class="col-lg-6">
                      <div class="card">
                          <div class="card-title">
                              <h4>State reason for rejection</h4><br>
                          </div>
                          <div class="card-body">
                              <div class="basic-form">
                                  <form action="hod/approve2.php" method="post">
                                      <div class="form-group">
                                      <label for="comment">Remarks</label>
                                      <textarea class="form-control" rows="8" id="remark" name="remark" required></textarea>
                                      </div>
                                      <input type='hidden' name='tableName' value='<?php echo $tableName;?>' />
                                      <input type='hidden' name='leave_id' value='<?php echo $leave_id;?>' />
                                      <button type="submit" class="btn btn-info" name="forward">Forward</button>
                                      <button type="submit" class="btn btn-danger" name="reject">Reject</button>
                                  </form>
                              </div>

                          </div>
                      </div>
                  </div>
                <?php }?>
                  <!-- /# column -->


              </div>

                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 Vignan's Institute Management System Developed by CSE Dept &amp; Theme by <a href="https://colorlib.com">Colorlib</a></footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->

    <div class="modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="changePassModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
                <form action="javascript:;" novalidate="novalidate">
                    <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group">
                                <label for="oldPass">
                                    old Password
                                </label>
                                <input type="password"  data-val="true" data-val-required="this is Required Field" class="form-control" name="oldPass" id="oldPass"/>
                                <span class="field-validation-valid text-danger" data-valmsg-for="oldPass" data-valmsg-replace="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="newPass">
                                    New Password
                                </label>
                                <input type="password" data-val="true" data-val-required="this is Required Field" class="form-control" name="newPass" id="newPass"/>
                                <span class="field-validation-valid text-danger"  data-valmsg-for="newPass" data-valmsg-replace="true"></span>

                            </div>
                            <div class="form-group">
                                <label for="confirmPass">
                                    Confirm Password
                                </label>
                                <input type="password" data-val-equalto="Password not Match ", data-val-equalto-other="newPass" data-val="true" data-val-required="this is Required Field" class="form-control" name="confirmPass" id="confirmPass"/>
                                <span class="field-validation-valid text-danger" data-valmsg-for="confirmPass" data-valmsg-replace="true"></span>

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
          </div>
        </div>
      </div>

    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
    <!-- <script src="js/block/javascript.js"></script> -->

</body>

</html>
