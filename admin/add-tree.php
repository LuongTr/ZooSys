<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);

if (strlen($_SESSION['zmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $treeID = $_POST['treeID'];
        $treeName = $_POST['treeName'];
        $scientificName = $_POST['scientificName'];
        $plantingDate = $_POST['plantingDate'];
        $status = $_POST['status'];
        $location = $_POST['location'];
        $description = $_POST['description'];

        // Kiểm tra TreeID đã tồn tại chưa
        $ret = mysqli_query($con, "SELECT TreeID FROM tbTree WHERE TreeID='$treeID'");
        $result = mysqli_fetch_array($ret);
        if ($result > 0) {
            echo "<script>alert('This Tree ID is already allotted. Please choose another.');</script>";
        } else {
            // Thêm dữ liệu mới
            $query = mysqli_query($con, "INSERT INTO tbTree (TreeID, TreeName, ScientificName, PlantingDate, Status, Location, Description) 
            VALUES ('$treeID', '$treeName', '$scientificName', '$plantingDate', '$status', '$location', '$description')");
            if ($query) {
                echo '<script>alert("Tree detail has been added.")</script>';
            } else {
                echo '<script>alert("Something Went Wrong. Please try again.")</script>';
            }
        }
    }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Tree Detail - Tree Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS tương tự ví dụ -->
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
                                        <h4 class="header-title">Add Tree Detail</h4>
                                        <form method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label for="treeID">Tree ID</label>
                                                <input type="text" class="form-control" id="treeID" name="treeID" placeholder="Enter tree ID" required maxlength="5">
                                            </div>

                                            <div class="form-group">
                                                <label for="treeName">Tree Name</label>
                                                <input type="text" class="form-control" id="treeName" name="treeName" placeholder="Enter tree name" required maxlength="50">
                                            </div>

                                            <div class="form-group">
                                                <label for="scientificName">Scientific Name</label>
                                                <input type="text" class="form-control" id="scientificName" name="scientificName" placeholder="Enter scientific name" maxlength="100">
                                            </div>

                                            <div class="form-group">
                                                <label for="plantingDate">Planting Date</label>
                                                <input type="date" class="form-control" id="plantingDate" name="plantingDate" placeholder="Enter planting date">
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <input type="text" class="form-control" id="status" name="status" placeholder="Enter status" maxlength="50">
                                            </div>

                                            <div class="form-group">
                                                <label for="location">Location</label>
                                                <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" maxlength="100">
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description" placeholder="Enter description" maxlength="255" rows="3"></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" name="submit">Submit</button>
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
