<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log received data
file_put_contents('email_debug.log', date('Y-m-d H:i:s') . " - Request received: " . print_r($_POST, true) . "\n", FILE_APPEND);

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
    $query = mysqli_query($con, "SELECT * FROM tblticindian WHERE ID='$ticketId' OR TicketID='$ticketId'");
    $isIndian = true;
    
    if (mysqli_num_rows($query) == 0) {
        // Try foreign tickets
        $query = mysqli_query($con, "SELECT * FROM tblticforeigner WHERE ID='$ticketId' OR TicketID='$ticketId'");
        $isIndian = false;
        
        if (mysqli_num_rows($query) == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Ticket not found']);
            exit;
        }
    }
    
    $row = mysqli_fetch_array($query);
    
    // Let's debug what fields we actually have
    // file_put_contents('ticket_fields.log', print_r($row, true), FILE_APPEND);
    
    // Format ticket information based on available fields
    $visitorName = isset($row['VisitorName']) ? $row['VisitorName'] : 
                  (isset($row['visitorname']) ? $row['visitorname'] : 'N/A');
                  
    $noAdult = isset($row['NoAdult']) ? $row['NoAdult'] : 
              (isset($row['noadult']) ? $row['noadult'] : '0');
              
    $noChildren = isset($row['NoChildren']) ? $row['NoChildren'] : 
                 (isset($row['nochildren']) ? $row['nochildren'] : '0');
                 
    $postingDate = isset($row['PostingDate']) ? $row['PostingDate'] : 
                  (isset($row['postingdate']) ? $row['postingdate'] : date('Y-m-d'));
                  
    $ticketID = isset($row['TicketID']) ? $row['TicketID'] : 
               (isset($row['ticketid']) ? $row['ticketid'] : $ticketId);

    // Format ticket information as HTML
    $ticketHTML = "
    <html>
    <head>
        <title>Zoo Entry Ticket</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
            .ticket { border: 1px solid #ccc; padding: 20px; max-width: 800px; margin: 0 auto; }
            .header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
            .row { margin-bottom: 15px; }
            .label { font-weight: bold; color: #0066cc; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            table, th, td { border: 1px solid #ddd; }
            th, td { padding: 10px; text-align: left; }
            th { background-color: #f5f5f5; }
            .total-row { background-color: #f5f5f5; font-weight: bold; }
            .center { text-align: center; margin-top: 30px; }
        </style>
    </head>
    <body>
        <div class='ticket'>
            <div class='header'>
                <h2>Zoo Entry Ticket</h2>
            </div>
            
            <div class='row'>
                <span class='label'>Ticket ID:</span> {$ticketID}
            </div>
            <div class='row'>
                <span class='label'>Visiting Date:</span> {$postingDate}
            </div>
            <div class='row'>
                <span class='label'>Visitor Name:</span> {$visitorName}
            </div>
            
            <table>
                <tr>
                    <th>#</th>
                    <th>No of Tickets</th>
                    <th>Price per unit</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Number of Adult</td>
                    <td>{$noAdult}</td>
                    <td>$" . ($isIndian ? "300" : "600") . "</td>
                    <td>$" . ($noAdult * ($isIndian ? 300 : 600)) . "</td>
                </tr>
                <tr>
                    <td>Number of Children</td>
                    <td>{$noChildren}</td>
                    <td>$" . ($isIndian ? "80" : "160") . "</td>
                    <td>$" . ($noChildren * ($isIndian ? 80 : 160)) . "</td>
                </tr>
                <tr class='total-row'>
                    <td colspan='3'>Total Ticket Price</td>
                    <td>$" . (($noAdult * ($isIndian ? 300 : 600)) + ($noChildren * ($isIndian ? 80 : 160))) . "</td>
                </tr>
            </table>
            
            <div class='center'>
                <p>Thank you for visiting our zoo!</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $subject = "Zoo Entry Ticket #{$ticketID}";
    
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