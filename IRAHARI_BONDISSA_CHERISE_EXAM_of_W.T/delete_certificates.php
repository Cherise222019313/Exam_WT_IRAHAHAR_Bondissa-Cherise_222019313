<?php
include('db_connection.php');

// Check if Certificate ID is set
if(isset($_REQUEST['certificate_id'])) {
    $certificate_id = $_REQUEST['certificate_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM certificates WHERE certificateID=?");
    $stmt->bind_param("i", $certificate_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Certificate</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this certificate?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="certificate_id" value="<?php echo $certificate_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Certificate deleted successfully.";
        } else {
            echo "Error deleting certificate: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Certificate ID is not set.";
}

$connection->close();
?>
