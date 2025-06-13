<?php
include('includes/dbconnection.php');
include('includes/email_helper.php');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticketId = isset($_POST['ticketId']) ? intval($_POST['ticketId']) : 0;
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
        exit;
    }
    
    // Validate ticketId
    if ($ticketId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ticket ID']);
        exit;
    }
    
    // Get ticket information from database
    $query = mysqli_query($con, "SELECT * FROM tblticindian WHERE ID='$ticketId'");
    
    if (mysqli_num_rows($query) == 0) {
        // Try normal tickets
        $query = mysqli_query($con, "SELECT * FROM tblticforeigner WHERE ID='$ticketId'");
        
        if (mysqli_num_rows($query) == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Ticket not found']);
            exit;
        }
    }
    
    $row = mysqli_fetch_array($query);
    
    // Format ticket information as HTML
    $ticketHTML = "
    <html>
    <head>
        <title>Zoo Entry Ticket</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .ticket { border: 1px solid #ccc; padding: 20px; max-width: 600px; margin: 0 auto; }
            .header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
            .label { font-weight: bold; }
            .row { margin-bottom: 10px; }
        </style>
    </head>
    <body>
        <div class='ticket'>
            <div class='header'>
                <h2>Zoo Entry Ticket</h2>
                <p>Ticket #: {$row['TicketID']}</p>
            </div>
            
            <div class='row'>
                <span class='label'>Visitor Name:</span> {$row['VisitorName']}
            </div>
            <div class='row'>
                <span class='label'>No of Persons:</span> {$row['NoAdult']} Adults, {$row['NoChildren']} Children
            </div>
            <div class='row'>
                <span class='label'>Visit Date:</span> {$row['PostingDate']}
            </div>
            <div class='row'>
                <span class='label'>Price:</span> {$row['PricingDate']}
            </div>
            
            <p style='text-align: center; margin-top: 30px;'>Thank you for visiting our zoo!</p>
        </div>
    </body>
    </html>
    ";
    
    $subject = "Zoo Entry Ticket #{$row['TicketID']}";
    
    // Send the email
    $result = sendTicketEmail($email, $subject, $ticketHTML);
    
    if ($result === true) {
        echo json_encode(['status' => 'success', 'message' => 'Ticket sent to your email successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $result]);
    }
    
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>