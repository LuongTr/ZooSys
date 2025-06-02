<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['zmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $cageNumber = $_GET['editid'];  // Mã khóa chính
        $cageName = $_POST['cageName'];
        $location = $_POST['location'];
        $container = $_POST['container'];

        $query = mysqli_query($con, "UPDATE tblcageanimal SET CageName='$cageName', Location='$location', Container='$container' WHERE CageNumber='$cageNumber'");
        if ($query) {
            echo '<script>alert("Cage details have been updated.")</script>';
        } else {
            echo '<script>alert("Something went wrong. Please try again.")</script>';
        }
    }
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edit Cage Details - Zoo Management System</title>
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
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-content">
            <?php include_once('includes/header.php'); ?>
            <?php include_once('includes/pagetitle.php'); ?>
            <div class="main-content-inner">
                <div class="row">

                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Update Cage Details</h4>
                                        <form method="post" enctype="multipart/form-data">
                                            <?php
                                            $cageNumber = $_GET['editid'];
                                            $ret = mysqli_query($con, "SELECT * FROM tblcageanimal WHERE CageNumber='$cageNumber'");
                                            while ($row = mysqli_fetch_array($ret)) {
                                            ?>
                                                <div class="form-group">
                                                    <label for="cageNumber">Cage Number</label>
                                                    <input type="text" class="form-control" id="cageNumber" name="cageNumber" value="<?php echo $row['CageNumber']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="cageName">Cage Name</label>
                                                    <input type="text" class="form-control" id="cageName" name="cageName" placeholder="Enter cage name" value="<?php echo $row['CageName']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="location">Location</label>
                                                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" value="<?php echo $row['Location']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="container">Container</label>
                                                    <input type="text" class="form-control" id="container" name="container" placeholder="Enter container" value="<?php echo $row['Container']; ?>" required>
                                                </div>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" name="submit">Update</button>
                                            <a href="manage-cage.php" class="btn btn-secondary mt-4 pr-4 pl-4 ml-2">Cancel</a>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php'); ?>
    </div>

    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
<?php } ?>
