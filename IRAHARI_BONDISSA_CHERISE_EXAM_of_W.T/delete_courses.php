<?php
include('db_connection.php');

// Check if Course ID is set
if(isset($_REQUEST['course_id'])) {
    $course_id = $_REQUEST['course_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM courses WHERE courseID=?");
    $stmt->bind_param("i", $course_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Course</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this course?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Course deleted successfully.";
        } else {
            echo "Error deleting course: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Course ID is not set.";
}

$connection->close();
?>
