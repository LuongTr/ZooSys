<?php
session_start();
include('includes/dbconnection.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (strlen($_SESSION['zmsaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
  {
    $empid=$_POST['empid'];
    $cccd=$_POST['cccd'];
    $fullname=$_POST['fullname'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $dob=$_POST['dob'];
    $gender=$_POST['gender'];
    $phone=$_POST['phone'];
    $role=$_POST['role'];
    $salary=$_POST['salary'];
    
    // Validate phone number format (basic validation)
    if(!preg_match('/^[0-9+\-\s()]{10,15}$/', $phone))
    {
        echo "<script>alert('Phone number has invalid format. Please enter a valid phone number');</script>";
    }
    // Validate CCCD format (12 digits)
    elseif(!preg_match('/^[0-9]{12}$/', $cccd))
    {
        echo "<script>alert('CCCD must be exactly 12 digits');</script>";
    }
    else
    {
        // Check if employee ID, phone number or CCCD already exists
        $ret=mysqli_query($con,"select ID from tbladmin where ID='$empid' OR MobileNumber='$phone' OR CCCD='$cccd'");
        $result=mysqli_fetch_array($ret);
        if($result>0){
            echo "<script>alert('Employee ID, Phone number, or CCCD is already registered to another employee');</script>";
        }
        else{
            $query=mysqli_query($con, "insert into tbladmin(ID,CCCD,AdminName,Email,UserName,Password,DateOfBirth,Gender,MobileNumber,Role,Salary) values('$empid','$cccd','$fullname','$email','$username','$password','$dob','$gender','$phone','$role','$salary')");
            if ($query) {
                echo '<script>alert("Employee detail has been added.")</script>';
            }
            else
            {
                echo '<script>alert("Something Went Wrong. Please try again.")</script>';
            }
        }
    }
}
  ?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Employee Detail - Zoo Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
</head>

<body>
    
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
     <?php include_once('includes/sidebar.php');?>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
          <?php include_once('includes/header.php');?>
            <!-- header area end -->
            <!-- page title area start -->
           <?php include_once('includes/pagetitle.php');?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
          
                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <!-- basic form start -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Add Employee Detail</h4>
                                        <form method="post">
                                            <div class="form-group">
                                                <label for="empid">Employee ID</label>
                                                <input type="text" class="form-control" id="empid" name="empid" placeholder="Enter employee ID (e.g., NV001)" value="" required="true" maxlength="10">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="cccd">CCCD Number</label>
                                                <input type="text" class="form-control" id="cccd" name="cccd" placeholder="Enter 12-digit CCCD number" value="" required="true" maxlength="12" pattern="[0-9]{12}">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="fullname">Full Name</label>
                                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter employee full name" value="" required="true">
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter employee email" value="" required="true">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">User Name</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter employee user name" value="" required="true">
                                            </div>

                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" class="form-control" id="password" name="password" placeholder="Enter employee password" value="" required="true">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob" value="" required="true">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select class="form-control" id="gender" name="gender" required="true">
                                                    <option value="">Select Gender</option>
                                                    <option value="Nam">Nam</option>
                                                    <option value="Nu">Nữ</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="" required="true" maxlength="15" pattern="[0-9+\-\s()]*">
                                            </div>
                                            
                                            <!-- <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter employee address" value="" required="true"></input>
                                            </div> -->
                                            
                                            <div class="form-group">
                                                <label for="role">Role/Position</label>
                                                <select class="form-control" id="role" name="role" required="true">
                                                    <option value="">Select Role</option>
                                                    <option value="animal_staff">Nhân viên chăm sóc</option>
                                                    <option value="veterinary_staff">Bác sĩ thú y</option>
                                                    <option value="tour_guide">Hướng dẫn viên</option>
                                                    <option value="maintenance_staff">Nhân viên bảo trì</option>
                                                    <option value="ticket_staff">Nhân viên vé</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="salary">Salary (VND)</label>
                                                <input type="number" class="form-control" id="salary" name="salary" placeholder="Enter salary amount" value="" required="true" min="0" step="1000">
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" name="submit">Add Employee</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- basic form end -->
                         
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <?php include_once('includes/footer.php');?>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
    
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
<?php }  ?>