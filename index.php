<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Zoo Management System | Home Page</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
</head>
<body>
		<?php include_once('includes/header.php');?>
			<div class="header-banner">
				<div class="container">
					<div class="head-banner">
						<h3>Tham Quan Sở Thú</h3>
						<p> Một chuyến tham quan sở thú mang đến cho chúng ta cơ hội được tận mắt nhìn thấy các loài động vật hoang dã. Sở thú là nơi tập hợp nhiều loài động vật và chim chóc khác nhau. Đây là điểm đến hấp dẫn, đặc biệt đối với trẻ em. Tham quan sở thú không chỉ mang lại kiến thức mà còn là trải nghiệm giải trí thú vị. Chúng ta có thể tìm hiểu về những loài quý hiếm tại đây.</p>
					</div>
					<div class="banner-grids">
						<div class="col-md-6 banner-grid">
							<h4>Khám Phá Thế Giới Hoang Dã</h4>
							<p>Trải nghiệm vẻ đẹp của thiên nhiên và tìm hiểu về những loài sinh vật quý hiếm tại nơi mà sự sống hoang dã phát triển mạnh mẽ.</p>
						</div>
						<div class="col-md-6 banner-grid">
						<h4>Cánh Cửa Dẫn Vào Vương Quốc Động Vật</h4>
							<p>Bước vào thế giới của những sinh vật kỳ thú và khám phá sự kỳ diệu của đa dạng sinh học.</p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		<!--header-->
			<!--welcome-->
			<div class="content">
				<div class="welcome">
					<div class="container">
						<h2>Hành tinh thú</h2>
							<div class="welcome-grids">
								
								<?php 
 $query=mysqli_query($con,"select * from tblanimal order by rand() limit 4");
 while ($row=mysqli_fetch_array($query)) {
 ?>
								<div class="col-md-3 welcome-grid" >
									<img src="admin/images/<?php echo $row['AnimalImage'];?>" width='220' height='200' alt=" " class="img-responsive" />
									<div class="wel-info">
										<h4><a href="animal-detail.php?anid=<?php echo $row['ID'];?>"><?php echo $row['AnimalName'];?>(<?php echo $row['Breed'];?>)</a></h4>
										<p><?php echo substr($row['Description'],0,100);?>.</p>
									</div>
								</div><?php }?>
								<br>
								<div class="clearfix"></div>
							</div>
					</div>
				</div>
			<!--welcome-->
			
				<!--animals-->
					<div class="animals">
						<div class="container">
							<h3>Các loài thú</h3>
							<div class="clients">
								<ul id="flexiselDemo3">
									<?php 
 $query=mysqli_query($con,"select * from tblanimal");
 while ($row=mysqli_fetch_array($query)) {
 ?>
									<li><img src="admin/images/<?php echo $row['AnimalImage'];?>" width='220' height='200' alt=" " class="img-responsive" /></li><?php }?>
								</ul>
									<script type="text/javascript">
								$(window).load(function() {
									
								  $("#flexiselDemo3").flexisel({
										visibleItems: 5,
										animationSpeed: 1000,
										autoPlay: true,
										autoPlaySpeed: 3000,    		
										pauseOnHover: true,
										enableResponsiveBreakpoints: true,
										responsiveBreakpoints: { 
											portrait: { 
												changePoint:480,
												visibleItems: 1
											}, 
											landscape: { 
												changePoint:640,
												visibleItems: 2
											},
											tablet: { 
												changePoint:768,
												visibleItems: 3
											}
										}
									});
									});
								</script>
								<script type="text/javascript" src="js/jquery.flexisel.js"></script>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			<!--models-->
		
				
						<!--events-->
						<!--specials-->
				 <?php include_once('includes/special.php');?>
			</div>
			<!--footer-->
			<?php include_once('includes/footer.php');?>
</body>
</html>
