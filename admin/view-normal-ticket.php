<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['zmsaid']==0)) {
  header('location:logout.php');
  } else{


  
  ?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>View Indian Ticket - Zoo Management System</title>
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
    <!-- ADD JQUERY HERE -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    
</head>

<body>
    
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
     <?php include_once('includes/sidebar.php');?>
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
                <div class="row">
               
                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <!-- basic form start -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body" id="exampl">
                                        <?php
 $vid=$_GET['viewid'];
$ret=mysqli_query($con,"select * from tblticindian where ID='$vid' || TicketID='$vid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                                        <h4 class="header-title" style="color: blue">Ticket ID: <?php  echo $row['TicketID'];?></h4>
                                        <h5 class="header-title" style="color: blue">Visiting Date: <?php  echo $row['PostingDate'];?></h5>
                                          <h5 class="header-title" style="color: blue">Visitor Name: <?php  echo $row['visitorName'];?></h5>


                                        <table border="1" class="table table-striped table-bordered first"  width="100%">
                                            <tr>
                                                <th>#</th>
                                                <th>No of Tickets</th>
                                                <th>Price per unit</th>
                                                <th>Total</th>
                                            </tr>
                                <tr>
                                    <th >Number of Adult </th>
                                    <td style="padding-left: 10px"><?php  echo $noadult=$row['NoAdult'];?></td>
                                     <td style="padding-left: 10px">$<?php  echo $cup=$row['AdultUnitprice'];?></td>
                                     <td style="padding-left: 10px">$<?php  echo $ta=$cup*$noadult;?></td>
                                </tr>
                                <tr>
                                    <th>Number of Chlidren </th>
                                    <td style="padding-left: 10px"><?php  echo $nochild=$row['NoChildren'];?></td>
                                    <td style="padding-left: 10px">$<?php  echo $aup=$row['ChildUnitprice'];?></td>
                                     <td style="padding-left: 10px">$<?php  echo $tc=$aup*$nochild;?></td>
                                </tr>
     
                                 <tr>
                                    <th style="text-align: center;color: red;font-size: 20px" colspan="3">Total Ticket Price</th>
                                    <td style="padding-left: 10px;">$<?php  echo ($ta+$tc);?></td>
                                </tr>
                                </table>
                                    </div>
                                    <?php } ?>
                                     <p style="margin-top:1%"  align="center">
  <!-- <i class="fa fa-print fa-2x" style="cursor: pointer;"  OnClick="CallPrint(this.value)" ></i> -->
</p>
<div class="text-center" style="margin-top: 20px;">
    <button type="button" class="btn btn-primary" onclick="CallPrint('exampl')">
        <i class="fa fa-print"></i> Print Ticket
    </button>
    &nbsp;&nbsp;
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#emailTicketModal">
        <i class="fa fa-envelope"></i> Email Ticket
    </button>
</div>

<!-- Add this modal at the bottom of your page, before the closing body tag -->
<div class="modal fade" id="emailTicketModal" tabindex="-1" role="dialog" aria-labelledby="emailTicketModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="emailTicketModalLabel">Send Ticket to Email</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="emailTicketForm">
          <div class="form-group">
            <label for="emailAddress">Email address</label>
            <input type="email" class="form-control" id="emailAddress" placeholder="Enter email" required>
          </div>
          <input type="hidden" id="ticketId" value="<?php echo $_GET['viewid']; ?>">
        </form>
        <div id="emailResult" class="alert" style="display:none;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="sendEmailBtn">Send Email</button>
      </div>
    </div>
  </div>
</div>

<!-- Add this JavaScript code before the closing body tag -->
<script>
$(document).ready(function() {
    $("#sendEmailBtn").click(function() {
        var email = $("#emailAddress").val();
        var ticketId = $("#ticketId").val();
        
        // Validate email
        if (!email) {
            $("#emailResult").removeClass("alert-success").addClass("alert-danger").text("Please enter an email address.").show();
            return;
        }
        
        // Disable button and show loading
        $("#sendEmailBtn").prop("disabled", true).text("Sending...");
        
        // Send AJAX request
        $.ajax({
            url: "../send_ticket_email.php",
            type: "POST",
            data: {
                email: email,
                ticketId: ticketId
            },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    $("#emailResult").removeClass("alert-danger").addClass("alert-success").text(response.message).show();
                } else {
                    $("#emailResult").removeClass("alert-success").addClass("alert-danger").text(response.message).show();
                }
            },
            error: function(xhr, status, error) {
                console.log("Error details:", xhr.responseText);
                $("#emailResult").removeClass("alert-success").addClass("alert-danger").text("An error occurred. Please try again.").show();
            },
            complete: function() {
                // Re-enable button
                $("#sendEmailBtn").prop("disabled", false).text("Send Email");
            }
        });
    });
});
</script>
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
        <?php include_once('includes/footer.php');?>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
    
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

     <script>
function CallPrint(strid) {
var prtContent = document.getElementById("exampl");
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
}

</script>

</body>

</html>
<?php }  ?>