<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['zmsaid']==0)) {
  header('location:logout.php');
} else {
    if(isset($_POST['submit']))
    {
        $healid = $_GET['editid'];
        $idanimal = $_POST['idanimal'];
        $checkdate = $_POST['checkdate'];
        $status = $_POST['status'];
        $note = $_POST['note'];

        $query = mysqli_query($con, "UPDATE tbhealth SET id_animal='$idanimal', check_date='$checkdate', status='$status', note='$note' WHERE id_heal='$healid'");
        if ($query) {
            echo '<script>alert("Health record has been Updated.")</script>';
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
    <title>Edit Health Record - Zoo Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS links, same as your animal edit -->
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
        <?php include_once('includes/sidebar.php');?>
        <div class="main-content">
            <?php include_once('includes/header.php');?>
            <?php include_once('includes/pagetitle.php');?>
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Update Health Record</h4>
                                        <form method="post" enctype="multipart/form-data">
                                            <?php
                                            $healid = $_GET['editid'];
                                            $ret = mysqli_query($con, "SELECT * FROM tbhealth WHERE id_heal='$healid'");
                                            while ($row = mysqli_fetch_array($ret)) {
                                            ?>
                                            <div class="form-group">
                                                <label for="idanimal">Animal ID</label>
                                                <input type="number" class="form-control" id="idanimal" name="idanimal" value="<?php echo $row['id_animal'];?>" required="true" readonly>
                                                <!-- Nếu muốn có dropdown chọn Animal, có thể thay bằng select -->
                                            </div>

                                            <div class="form-group">
                                                <label for="checkdate">Check Date</label>
                                                <input type="date" class="form-control" id="checkdate" name="checkdate" value="<?php echo $row['check_date'];?>" required="true">
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <input type="text" class="form-control" id="status" name="status" placeholder="Enter status" value="<?php echo $row['status'];?>" required="true">
                                            </div>

                                            <div class="form-group">
                                                <label for="note">Note</label>
                                                <input type="text" class="form-control" id="note" name="note" placeholder="Additional notes" value="<?php echo $row['note'];?>">
                                            </div>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" name="submit">Update</button>
                                            <a href="manage-health.php" class="btn btn-secondary mt-4 pr-4 pl-4 ml-2">Cancel</a>
                                        </form>
                                    </div>
                                </div>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php');?>
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
