<?php
include('db_connection.php');

// Check if Instructor ID is set
if(isset($_REQUEST['instructorID'])) {
    $instructor_id = $_REQUEST['instructorID'];
    
    $stmt = $connection->prepare("SELECT * FROM instructors WHERE instructorID=?");
    $stmt->bind_param("i", $instructor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['userID'];
    } else {
        echo "Instructor not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in Instructors Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update instructors form -->
    <h2><u>Update Form for Instructors</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="userID">User ID:</label>
        <input type="number" name="userID" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $user_id = $_POST['userID'];
    
    // Update the instructor in the database
    $stmt = $connection->prepare("UPDATE instructors SET userID=? WHERE instructorID=?");
    $stmt->bind_param("ii", $user_id, $instructor_id);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: instructors.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?> 
