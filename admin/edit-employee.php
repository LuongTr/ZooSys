<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);

// Check for valid session (fixed the condition)
if (strlen($_SESSION['zmsaid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    // Handle form submission for employee update
    if (isset($_POST['submit'])) {
        $eid = $_GET['editid'];
        $cccd = $_POST['cccd'];
        $fullname = $_POST['fullname'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $role = $_POST['role'];
        $salary = $_POST['salary'];

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
            // Check if phone number or CCCD already exists for other employees
            $ret=mysqli_query($con,"select ID from tblemployee where (PhoneNumber='$phone' OR CCCD='$cccd') AND ID!='$eid'");
            $result=mysqli_fetch_array($ret);
            if($result>0){
                echo "<script>alert('Phone number or CCCD is already registered to another employee');</script>";
            }
            else{
                // Update employee data
                $query = mysqli_query($con, "UPDATE tblemployee SET CCCD='$cccd', FullName='$fullname', DateOfBirth='$dob', Gender='$gender', PhoneNumber='$phone', Address='$address', Role='$role', Salary='$salary' WHERE ID='$eid'");

                if ($query) {
                    echo "<script>alert('Employee updated successfully');</script>";
                } else {
                    echo "<script>alert('Something went wrong. Please try again');</script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edit Employee - Zoo Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <div class="page-container">
        <!-- Sidebar and Header -->
        <?php include_once('includes/sidebar.php'); ?>
        <?php include_once('includes/header.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <?php include_once('includes/pagetitle.php'); ?>
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <!-- Form to Edit Employee -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Edit Employee Details</h4>
                                        <form method="post">
                                            <?php
                                            // Fetch current employee data
                                            $eid = $_GET['editid'];
                                            $ret = mysqli_query($con, "SELECT * FROM tblemployee WHERE ID='$eid'");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($ret)) {
                                            ?>
                                            
                                            <div class="form-group">
                                                <label for="empid">Employee ID</label>
                                                <input type="text" class="form-control" name="empid" value="<?php echo htmlspecialchars($row['ID']); ?>" readonly style="background-color: #f8f9fa;">
                                                <small class="form-text text-muted">Employee ID cannot be changed</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="cccd">CCCD Number</label>
                                                <input type="text" class="form-control" name="cccd" value="<?php echo htmlspecialchars($row['CCCD']); ?>" required="true" maxlength="12" pattern="[0-9]{12}">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="fullname">Full Name</label>
                                                <input type="text" class="form-control" name="fullname" value="<?php echo htmlspecialchars($row['FullName']); ?>" required="true">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" class="form-control" name="dob" value="<?php echo htmlspecialchars($row['DateOfBirth']); ?>" required="true">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select class="form-control" name="gender" required="true">
                                                    <option value="">Select Gender</option>
                                                    <option value="Nam" <?php if($row['Gender'] == 'Nam') echo 'selected'; ?>>Nam</option>
                                                    <option value="Nữ" <?php if($row['Gender'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                                                
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($row['PhoneNumber']); ?>" required="true" maxlength="15" pattern="[0-9+\-\s()]*">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <textarea class="form-control" name="address" rows="3" required="true"><?php echo htmlspecialchars($row['Address']); ?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="role">Role/Position</label>
                                                <select class="form-control" name="role" required="true">
                                                    <option value="">Select Role</option>
                                                    <option value="Nhân viên chăm sóc" <?php if($row['Role'] == 'Nhân viên chăm sóc') echo 'selected'; ?>>Nhân viên chăm sóc</option>
                                                    <option value="Bác sĩ thú y" <?php if($row['Role'] == 'Bác sĩ thú y') echo 'selected'; ?>>Bác sĩ thú y</option>
                                                    <option value="Hướng dẫn viên" <?php if($row['Role'] == 'Hướng dẫn viên') echo 'selected'; ?>>Hướng dẫn viên</option>
                                                    <option value="Nhân viên bảo trì" <?php if($row['Role'] == 'Nhân viên bảo trì') echo 'selected'; ?>>Nhân viên bảo trì</option>
                                                    <option value="Nhân viên bán vé" <?php if($row['Role'] == 'Nhân viên bán vé') echo 'selected'; ?>>Nhân viên bán vé</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="salary">Salary (VND)</label>
                                                <input type="number" class="form-control" name="salary" value="<?php echo htmlspecialchars($row['Salary']); ?>" required="true" min="0" step="1000">
                                            </div>
                                            
                                            <?php } ?>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" name="submit">Update Employee</button>
                                            <a href="manage-employees.php" class="btn btn-secondary mt-4 pr-4 pl-4 ml-2">Cancel</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include_once('includes/footer.php'); ?>
    </div>

    <!-- Scripts -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
<?php } ?>