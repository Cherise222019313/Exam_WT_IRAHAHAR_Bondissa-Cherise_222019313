<?php
include('db_connection.php');

// Check if Payment ID is set
if(isset($_REQUEST['paymentID'])) {
    $payment_id = $_REQUEST['paymentID'];
    
    $stmt = $connection->prepare("SELECT * FROM payments WHERE paymentID=?");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['userID'];
        $course_id = $row['courseID'];
        $amount = $row['amount'];
        $payment_date = $row['payment_date'];
    } else {
        echo "Payment not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in Payments Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update payments form -->
    <h2><u>Update Form for Payments</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="userID">User ID:</label>
        <input type="number" name="userID" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br>

        <label for="courseID">Course ID:</label>
        <input type="number" name="courseID" value="<?php echo isset($course_id) ? $course_id : ''; ?>">
        <br><br>

        <label for="amount">Amount:</label>
        <input type="text" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>">
        <br><br>

        <label for="payment_date">Payment Date:</label>
        <input type="text" name="payment_date" value="<?php echo isset($payment_date) ? $payment_date : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $user_id = $_POST['userID'];
    $course_id = $_POST['courseID'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    
    // Update the payment in the database
    $stmt = $connection->prepare("UPDATE payments SET userID=?, courseID=?, amount=?, payment_date=? WHERE paymentID=?");
    $stmt->bind_param("iiisi", $user_id, $course_id, $amount, $payment_date, $payment_id);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: payments.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?> 
