<?php
include('db_connection.php');

// Check if Feedback ID is set
if(isset($_REQUEST['feedback_id'])) {
    $feedback_id = $_REQUEST['feedback_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM feedback WHERE feedbackID=?");
    $stmt->bind_param("i", $feedback_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Feedback</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this feedback?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="feedback_id" value="<?php echo $feedback_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Feedback deleted successfully.";
        } else {
            echo "Error deleting feedback: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Feedback ID is not set.";
}

$connection->close();
?>
