<?php
include('db_connection.php');

// Check if Resource ID is set
if(isset($_REQUEST['resource_id'])) {
    $resource_id = $_REQUEST['resource_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM agile_methodology_resources WHERE resourceID=?");
    $stmt->bind_param("i", $resource_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Resource</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this resource?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="resource_id" value="<?php echo $resource_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Resource deleted successfully.";
        } else {
            echo "Error deleting resource: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Resource ID is not set.";
}

$connection->close();
?>
