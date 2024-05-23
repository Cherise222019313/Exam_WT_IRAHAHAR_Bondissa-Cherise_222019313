<?php
include('db_connection.php');

// Check if Resource ID is set
if(isset($_REQUEST['resourceID'])) {
    $resource_id = $_REQUEST['resourceID'];
    
    $stmt = $connection->prepare("SELECT * FROM agile_methodology_resources WHERE resourceID=?");
    $stmt->bind_param("i", $resource_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resource_name = $row['resource_name'];
        $resource_url = $row['resource_url'];
    } else {
        echo "Resource not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in agile_methodology_resources Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update agile_methodology_resources form -->
    <h2><u>Update Form for Agile Methodology Resources</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="resource_name">Resource Name:</label>
        <input type="text" name="resource_name" value="<?php echo isset($resource_name) ? $resource_name : ''; ?>">
        <br><br>

        <label for="resource_url">Resource URL:</label>
        <input type="text" name="resource_url" value="<?php echo isset($resource_url) ? $resource_url : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $resource_name = $_POST['resource_name'];
    $resource_url = $_POST['resource_url'];
    
    // Update the resource in the database
    $stmt = $connection->prepare("UPDATE agile_methodology_resources SET resource_name=?, resource_url=? WHERE resourceID=?");
    $stmt->bind_param("ssi", $resource_name, $resource_url, $resource_id);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: agile_methodology_resources.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
