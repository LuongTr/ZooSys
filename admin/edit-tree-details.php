<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['zmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $treeid = $_GET['editid'];
        $treename = $_POST['treename'];
        $scientificname = $_POST['scientificname'];
        $plantingdate = $_POST['plantingdate'];
        $status = $_POST['status'];
        $location = $_POST['location'];
        $description = $_POST['description'];

        $query = mysqli_query($con, "UPDATE tbTree SET TreeName='$treename', ScientificName='$scientificname', PlantingDate='$plantingdate', Status='$status', Location='$location', Description='$description' WHERE TreeID='$treeid'");
        if ($query) {
            echo '<script>alert("Tree detail has been Updated.")</script>';
        } else {
            echo '<script>alert("Something Went Wrong. Please try again.")</script>';
        }
    }
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Update Tree Detail - Tree Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>

    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <?php include_once('includes/header.php'); ?>
            <!-- header area end -->
            <!-- page title area start -->
            <?php include_once('includes/pagetitle.php'); ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">

                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <!-- basic form start -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Update Tree Detail</h4>
                                        <form method="post">
                                            <?php
                                            $treeid = $_GET['editid'];
                                            $ret = mysqli_query($con, "SELECT * FROM tbTree WHERE TreeID='$treeid'");
                                            while ($row = mysqli_fetch_array($ret)) {
                                            ?>
                                                <div class="form-group">
                                                    <label for="treename">Tree Name</label>
                                                    <input type="text" class="form-control" id="treename" name="treename" placeholder="Enter Tree Name" value="<?php echo htmlentities($row['TreeName']); ?>" required="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="scientificname">Scientific Name</label>
                                                    <input type="text" class="form-control" id="scientificname" name="scientificname" placeholder="Enter Scientific Name" value="<?php echo htmlentities($row['ScientificName']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="plantingdate">Planting Date</label>
                                                    <input type="date" class="form-control" id="plantingdate" name="plantingdate" value="<?php echo date('Y-m-d', strtotime($row['PlantingDate'])); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <input type="text" class="form-control" id="status" name="status" placeholder="Enter Status" value="<?php echo htmlentities($row['Status']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="location">Location</label>
                                                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" value="<?php echo htmlentities($row['Location']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description"><?php echo htmlentities($row['Description']); ?></textarea>
                                                </div>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" name="submit">Update</button>
                                            <a href="manage-trees.php" class="btn btn-secondary mt-4 pr-4 pl-4 ml-2">Cancel</a>
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
        <?php include_once('includes/footer.php'); ?>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->

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
<?php } ?>
