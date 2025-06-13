<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['zmsaid']==0)) {
  header('location:logout.php');
  } else{
?>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kết nối CSDL
try {
    $connect = new PDO("mysql:host=localhost;dbname=zmsdb", "root", "");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối CSDL thất bại: " . $e->getMessage());
}

// Dữ liệu mặc định
$data = ['labels' => [], 'counts' => []];

// Dữ liệu mặc định khi chưa POST: từ đầu năm đến hôm nay
$from = $_POST["from_date"] ?? "2024-01-01";
$to = $_POST["to_date"] ?? date("Y-m-d");

// Truy vấn khi đã có ngày
$query = "
    SELECT DATE(PostingDate) as visit_date,
           SUM(NoAdult + NoChildren) AS total_visitors
    FROM tblticindian
    WHERE DATE(PostingDate) BETWEEN :from AND :to
    GROUP BY DATE(PostingDate)
    ORDER BY visit_date ASC
";

try {
    $statement = $connect->prepare($query);
    $statement->execute([
        ':from' => $from,
        ':to' => $to
    ]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $data['labels'][] = $row['visit_date'];
        $data['counts'][] = (int)$row['total_visitors'];
    }
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>



<!doctype html>
<html class="no-js" lang="en">

<style>
  .filter-form {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 20px 0;
    font-family: Arial, sans-serif;
  }

  .filter-form label {
    font-weight: bold;
    font-size: 14px;
  }

  .filter-form input[type="date"] {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
  }

  .filter-form button {
    padding: 7px 16px;
    background-color: #a916fe;
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .filter-form button:hover {
    background-color: #6f16fe;
  }
</style>


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Zoo Management System || Dashboard</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>



<body>
    <?php include_once('includes/sidebar.php');?>
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
     
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
                <!-- sales report area start -->
                <div class="sales-report-area sales-style-two">
                    <div class="row">


            <div class="col-xl-4 col-ml-3 col-md-6 mt-5">
                            <div class="single-report" style="border:solid 1px #000">
                                <div class="s-sale-inner pt--30 mb-3">
                                    <div class="s-report-title d-flex justify-content-between">
                                        <?php
//Total Animal
 $query=mysqli_query($con,"select count(ID) as totalanimal from tblanimal ");
$result=mysqli_fetch_array($query);
$totalanimal=$result['totalanimal'];
 ?>  
                                        <h3 class="header-title mb-0">Total Animals In Zoo</h3>
                                       <p style="font-size: 20px;color: red"><?php if($totalanimal==''):
                                       echo "0";
                                    else: 
                                        echo $totalanimal;
                                    endif;

                                    ?></p>
                                    </div>
                                </div>
                               
                            </div>
                        </div>


            <div class="col-xl-4 col-ml-3 col-md-6 mt-5">
                            <div class="single-report" style="border:solid 1px #000">
                                <div class="s-sale-inner pt--30 mb-3">
                                    <div class="s-report-title d-flex justify-content-between">
                                        <?php
//total indian adult visitors
 $query=mysqli_query($con,"select sum(NoAdult) as totaladult from tblticindian ");
$result=mysqli_fetch_array($query);
$count_total_visitors=$result['totaladult'];
 ?>  
                                        <h3 class="header-title mb-0">Total Adult Visitor</h3>
                                       <p style="font-size: 20px;color: red"><?php if($count_total_visitors==''):
                                       echo "0";
                                    else: 
                                        echo $count_total_visitors;
                                    endif;

                                    ?></p>
                                    </div>
                                </div>
                               
                            </div>
                        </div>

       <div class="col-xl-4 col-ml-3 col-md-6 mt-5">
                            <div class="single-report" style="border:solid 1px #000">
                                <div class="s-sale-inner pt--30 mb-3">
                                    <div class="s-report-title d-flex justify-content-between">
                                        <?php
//total indian children visitors
 $query=mysqli_query($con,"select sum(NoChildren) as totalchild from tblticindian");
$result=mysqli_fetch_array($query);
$count_total_cvisitors=$result['totalchild'];
 ?>  
                                        <h4 class="header-title mb-0">Today Children Visitor</h4>
                                        <p style="font-size: 20px;color: red"><?php 
if($count_total_cvisitors==''):
echo "0"; else: 
echo $count_total_cvisitors;
endif;?>
    
</p>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
                            <div class="single-report" style="border:solid 1px blue">
                                <div class="s-sale-inner pt--30 mb-3">
                                    <div class="s-report-title d-flex justify-content-between">
                                        <?php
//todays indian adult visitors
 $query=mysqli_query($con,"select sum(NoAdult) as totaladult from tblticindian where date(PostingDate)=CURDATE()");
$result=mysqli_fetch_array($query);
$count_today_visitors=$result['totaladult'];
 ?>  
                                        <h3 class="header-title mb-0">Today Adult Visitor</h3>
                                       <p style="font-size: 20px;color: red"><?php if($count_today_visitors==''):
                                       echo "0";
                                    else: 
                                     echo   $count_today_visitors;
                                    endif;

                                    ?></p>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
                            <div class="single-report" style="border:solid 1px blue">
                                <div class="s-sale-inner pt--30 mb-3">
                                    <div class="s-report-title d-flex justify-content-between">
                                        <?php
//todays indian children visitors
 $query=mysqli_query($con,"select sum(NoChildren) as totalchild from tblticindian where date(PostingDate)=CURDATE()");
$result=mysqli_fetch_array($query);
$count_today_cvisitors=$result['totalchild'];
 ?>  
                                        <h4 class="header-title mb-0">Today Children Visitor</h4>
                                        <p style="font-size: 20px;color: red"><?php 
if($count_today_cvisitors==''):
echo "0"; else: 
echo $count_today_cvisitors;
endif;?>
    
</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-ml-3 col-md-6  mt-5">
                            <div class="single-report" style="border:solid 1px blue">
                                <div class="s-sale-inner pt--30 mb-3">
                                    <div class="s-report-title d-flex justify-content-between">
                                        <?php
//Yesterday indian adult visitors
 $query=mysqli_query($con,"select sum(NoAdult) as totaladulty from tblticindian where date(PostingDate)=CURDATE()-1");
$result=mysqli_fetch_array($query);
$count_Yest_visitors=$result['totaladulty'];
 ?>
                                        <h4 class="header-title mb-0">Yesterday Adult Visitor</h4>
                                        <p style="font-size: 20px;color: red">
                                            

                                            <?php 
if($count_Yest_visitors==''):
echo "0"; else: 
echo $count_Yest_visitors;
endif;?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
                            <div class="single-report" style="border:solid 1px blue">
                                <div class="s-sale-inner pt--30 mb-3">
                                    <div class="s-report-title d-flex justify-content-between">
                                        <?php
                                        //Yesterday children visitors
                                        $query=mysqli_query($con,"select sum(NoChildren) as totalchildy from tblticindian where date(PostingDate)=CURDATE()-1");
                                        $result=mysqli_fetch_array($query);
                                        $count_Yest_cvisitors=$result['totalchildy'];
                                        ?>
                                        <h4 class="header-title mb-0">Yesterday Child Visitor</h4>
                                        <p style="font-size: 20px;color: red">
                                            
                                            <?php 
                                            if($count_Yest_cvisitors==''):
                                            echo "0"; else: 
                                            echo $count_Yest_cvisitors;
                                            endif;?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Canvas tag for showing chart -->
                        <div class="col-xl-12 col-ml-12 col-md-12 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Visitor Statistics Chart</h4>
                                    <form id="dateFilterForm" method="POST" class="filter-form">
                                        <label>From date:</label>
                                        <input type="date" name="from_date" required>
                                        <label>To date:</label>
                                        <input type="date" name="to_date" required>
                                        <button type="submit">Filter</button>
                                    </form>
                                    <canvas id="visitorChart" width="600" height="300"></canvas>

                                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                    <script>
                                        const ctx = document.getElementById('visitorChart').getContext('2d');
                                        const visitorChart = new Chart(ctx, {
                                            type: 'bar', // hoặc 'bar' nếu bạn thích
                                            data: {
                                                labels: <?php echo json_encode($data['labels'] ?? []); ?>,
                                                datasets: [{
                                                    label: 'Tổng số khách mỗi ngày',
                                                    data: <?php echo json_encode($data['counts'] ?? []); ?>,
                                                    backgroundColor: 'rgba(75, 192, 192, 0.4)',
                                                    borderColor: 'rgba(75, 192, 192, 1)',
                                                    fill: true,
                                                    tension: 0.3
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        title: {
                                                            display: true,
                                                            text: 'Số khách'
                                                        }
                                                    },
                                                    x: {
                                                        title: {
                                                            display: true,
                                                            text: 'Ngày'
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    </script>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <hr />
                 <div class="sales-report-area sales-style-two">
                    <div class="row">

        
                    </div>
                </div>
                <!-- sales report area end -->
             
                
            </div>

        </div>
        <!-- main content area end -->
        <!-- footer area start-->
       <?php include_once('includes/footer.php');?>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
 
    <!-- offset area end -->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all bar chart activation -->
    <script src="assets/js/bar-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
<?php }  ?>