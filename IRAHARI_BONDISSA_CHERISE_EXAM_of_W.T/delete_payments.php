<?php
include('db_connection.php');

// Check if Payment ID is set
if(isset($_REQUEST['payment_id'])) {
    $payment_id = $_REQUEST['payment_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM payments WHERE paymentID=?");
    $stmt->bind_param("i", $payment_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Payment</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this payment?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Payment deleted successfully.";
        } else {
            echo "Error deleting payment: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Payment ID is not set.";
}

$connection->close();
?>
