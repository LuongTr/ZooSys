<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['zmsaid']==0)) {
  header('location:logout.php');
  } else {
if(isset($_POST['submit']))
  {
    $id_heal = $_POST['id_heal'];
    $id_animal = $_POST['id_animal'];
    $check_date = $_POST['check_date'];
    $status = $_POST['status'];
    $note = $_POST['note'];

    // Kiểm tra id_heal đã tồn tại chưa (optional)
    $ret = mysqli_query($con, "SELECT id_heal FROM tbhealth WHERE id_heal='$id_heal'");
    if(mysqli_num_rows($ret) > 0){
      echo "<script>alert('Health ID already exists. Please use a different one.');</script>";
    } else {
      // Thêm bản ghi mới
      $query = mysqli_query($con, "INSERT INTO tbhealth(id_heal, id_animal, check_date, status, note) VALUES('$id_heal','$id_animal','$check_date','$status','$note')");
      if ($query) {
        echo '<script>alert("Health record has been added.")</script>';
      } else {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
      }
    }
  }
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Health Record - Zoo Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS & JS giống như mẫu add-animal -->
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
                                        <h4 class="header-title">Add Health Record</h4>
                                        <form method="post">
                                            <div class="form-group">
                                                <label for="id_heal">Health ID</label>
                                                <input type="text" class="form-control" id="id_heal" name="id_heal" placeholder="Enter health record ID" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_animal">Animal ID</label>
                                                <input type="number" class="form-control" id="id_animal" name="id_animal" placeholder="Enter animal ID" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="check_date">Check Date</label>
                                                <input type="date" class="form-control" id="check_date" name="check_date" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <input type="text" class="form-control" id="status" name="status" placeholder="Enter health status" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="note">Note</label>
                                                <input type="text" class="form-control" id="note" name="note" placeholder="Additional notes">
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
