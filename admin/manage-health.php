<?php  
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['zmsaid']==0)) {
  header('location:logout.php');
} else {
  // Xử lý xóa bản ghi
  if (isset($_GET['del'])) {
    $hid = $_GET['id'];
    mysqli_query($con,"DELETE FROM tbhealth WHERE id_heal ='$hid'");
    echo "<script>alert('Health record Deleted');</script>";
    echo "<script>window.location.href='manage-health.php'</script>";
  }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Manage Health Records - Zoo Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <!-- CSS tương tự như manage-animals.php -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
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
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Manage Health Records</h4>
                                <div class="data-tables">
                                    <table class="table text-center" id="dataTable">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>S.NO</th>
                                                <th>Animal Name</th>
                                                <th>Check Date</th>
                                                <th>Status</th>
                                                <th>Note</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
// Lấy thông tin health records join với animal để hiển thị tên động vật
$query = "SELECT h.id_heal, h.check_date, h.status, h.note, a.AnimalName 
          FROM tbhealth h 
          JOIN tblanimal a ON h.id_animal = a.ID 
          ORDER BY h.check_date DESC";
$ret = mysqli_query($con, $query);
$cnt = 1;
while ($row = mysqli_fetch_array($ret)) {
?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo htmlentities($row['AnimalName']); ?></td>
                                                <td><?php echo htmlentities($row['check_date']); ?></td>
                                                <td><?php echo htmlentities($row['status']); ?></td>
                                                <td><?php echo htmlentities($row['note']); ?></td>
                                                <td>
                                                    <a href="edit-health.php?editid=<?php echo $row['id_heal']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="manage-health.php?id=<?php echo $row['id_heal']; ?>&del=delete" 
                                                       onClick="return confirm('Are you sure you want to delete this health record?')" 
                                                       class="btn btn-danger btn-xs">Delete</a>
                                                </td>
                                            </tr>
<?php 
    $cnt++;
} 
?>
                                        </tbody>
                                    </table>
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

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

</body>
</html>

<?php } ?>
