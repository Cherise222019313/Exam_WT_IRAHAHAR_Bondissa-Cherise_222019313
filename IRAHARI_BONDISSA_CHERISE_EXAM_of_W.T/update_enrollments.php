<?php
include('db_connection.php');

// Check if Enrollment ID is set
if(isset($_REQUEST['enrollmentID'])) {
    $enrollmentID = $_REQUEST['enrollmentID'];
    
    $stmt = $connection->prepare("SELECT * FROM enrollments WHERE enrollmentID=?");
    $stmt->bind_param("i", $enrollmentID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['userID'];
        $courseID = $row['courseID'];
        $enrollment_date = $row['enrollment_date'];
    } else {
        echo "Enrollment not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in enrollments Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update enrollments form -->
    <h2><u>Update Form for Enrollments</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="userID">User ID:</label>
        <input type="number" name="userID" value="<?php echo isset($userID) ? $userID : ''; ?>">
        <br><br>

        <label for="courseID">Course ID:</label>
        <input type="number" name="courseID" value="<?php echo isset($courseID) ? $courseID : ''; ?>">
        <br><br>

        <label for="enrollment_date">Enrollment Date:</label>
        <input type="text" name="enrollment_date" value="<?php echo isset($enrollment_date) ? $enrollment_date : ''; ?>">
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
    $enrollment_date = $_POST['enrollment_date'];
    
    // Update the enrollment in the database
    $stmt = $connection->prepare("UPDATE enrollments SET userID=?, courseID=?, enrollment_date=? WHERE enrollmentID=?");
    $stmt->bind_param("iisi", $userID, $courseID, $enrollment_date, $enrollmentID);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: enrollments.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
