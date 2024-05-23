<?php
include('db_connection.php');

// Check if Instructor ID is set
if(isset($_REQUEST['instructor_id'])) {
    $instructor_id = $_REQUEST['instructor_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM instructors WHERE instructorID=?");
    $stmt->bind_param("i", $instructor_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Instructor</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this instructor?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="instructor_id" value="<?php echo $instructor_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Instructor deleted successfully.";
        } else {
            echo "Error deleting instructor: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Instructor ID is not set.";
}

$connection->close();
?>
