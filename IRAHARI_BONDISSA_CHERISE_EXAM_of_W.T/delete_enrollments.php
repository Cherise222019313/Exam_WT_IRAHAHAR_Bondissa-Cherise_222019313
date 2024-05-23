<?php
include('db_connection.php');

// Check if Enrollment ID is set
if(isset($_REQUEST['enrollment_id'])) {
    $enrollment_id = $_REQUEST['enrollment_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM enrollments WHERE enrollmentID=?");
    $stmt->bind_param("i", $enrollment_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Enrollment</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this enrollment?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="enrollment_id" value="<?php echo $enrollment_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Enrollment deleted successfully.";
        } else {
            echo "Error deleting enrollment: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Enrollment ID is not set.";
}

$connection->close();
?>
