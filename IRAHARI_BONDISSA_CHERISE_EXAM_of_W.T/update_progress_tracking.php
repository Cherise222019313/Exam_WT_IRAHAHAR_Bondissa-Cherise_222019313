<?php
include('db_connection.php');

// Check if Progress ID is set
if(isset($_REQUEST['progressID'])) {
    $progressID = $_REQUEST['progressID'];
    
    $stmt = $connection->prepare("SELECT * FROM progress_tracking WHERE progressID=?");
    $stmt->bind_param("i", $progressID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['userID'];
        $courseID = $row['courseID'];
        $moduleID = $row['moduleID'];
        $completion_status = $row['completion_status'];
        $completion_date = $row['completion_date'];
    } else {
        echo "Progress not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in progress_tracking Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update progress_tracking form -->
    <h2><u>Update Form for Progress Tracking</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="userID">User ID:</label>
        <input type="number" name="userID" value="<?php echo isset($userID) ? $userID : ''; ?>">
        <br><br>

        <label for="courseID">Course ID:</label>
        <input type="number" name="courseID" value="<?php echo isset($courseID) ? $courseID : ''; ?>">
        <br><br>

        <label for="moduleID">Module ID:</label>
        <input type="number" name="moduleID" value="<?php echo isset($moduleID) ? $moduleID : ''; ?>">
        <br><br>

        <label for="completion_status">Completion Status:</label>
        <input type="text" name="completion_status" value="<?php echo isset($completion_status) ? $completion_status : ''; ?>">
        <br><br>

        <label for="completion_date">Completion Date:</label>
        <input type="text" name="completion_date" value="<?php echo isset($completion_date) ? $completion_date : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $userID = $_POST['userID'];
    $courseID = $_POST['courseID'];
    $moduleID = $_POST['moduleID'];
    $completion_status = $_POST['completion_status'];
    $completion_date = $_POST['completion_date'];
    
    // Update the progress in the database
    $stmt = $connection->prepare("UPDATE progress_tracking SET userID=?, courseID=?, moduleID=?, completion_status=?, completion_date=? WHERE progressID=?");
    $stmt->bind_param("iiiiss", $userID, $courseID, $moduleID, $completion_status, $completion_date, $progressID);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: progress_tracking.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
