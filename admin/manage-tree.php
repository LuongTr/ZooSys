<?php  
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['zmsaid']==0)) {
    header('location:logout.php');
} else {
    // Code Xóa dữ liệu
    if(isset($_GET['del'])) {
        $treeid = $_GET['id'];
        mysqli_query($con, "DELETE FROM tbTree WHERE TreeID='$treeid'");
        echo "<script>alert('Data Deleted');</script>";
        echo "<script>window.location.href='manage-tree.php'</script>";
    }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Manage Trees - Tree Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Các CSS tương tự như mẫu -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
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
                                <h4 class="header-title">Manage Trees</h4>
                                <div class="data-tables">
                                    <table id="dataTable" class="table text-center">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>S.NO</th>
                                                <th>Tree ID</th>
                                                <th>Tree Name</th>
                                                <th>Scientific Name</th>
                                                <th>Planting Date</th>
                                                <th>Status</th>
                                                <th>Location</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ret = mysqli_query($con, "SELECT * FROM tbTree ORDER BY TreeID DESC");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $cnt;?></td>
                                                <td><?php echo $row['TreeID'];?></td>
                                                <td><?php echo $row['TreeName'];?></td>
                                                <td><?php echo $row['ScientificName'];?></td>
                                                <td><?php echo date('d-m-Y', strtotime($row['PlantingDate']));?></td>
                                                <td><?php echo $row['Status'];?></td>
                                                <td><?php echo $row['Location'];?></td>
                                                <td><?php echo $row['Description'];?></td>
                                                <td>
                                                    <a href="edit-tree-details.php?editid=<?php echo $row['TreeID'];?>" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="manage-tree.php?id=<?php echo $row['TreeID']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-xs">Delete</a>
                                                </td>
                                            </tr>
                                        <?php 
                                            $cnt++;
                                        } ?>
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

    <!-- JS tương tự như mẫu -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
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
