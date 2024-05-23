<?php
include('db_connection.php');

// Check if Assignment ID is set
if(isset($_REQUEST['assignment_id'])) {
    $assignment_id = $_REQUEST['assignment_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM assignments WHERE assignmentID=?");
    $stmt->bind_param("i", $assignment_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Assignment</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this assignment?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Assignment deleted successfully.";
        } else {
            echo "Error deleting assignment: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Assignment ID is not set.";
}

$connection->close();
?>
