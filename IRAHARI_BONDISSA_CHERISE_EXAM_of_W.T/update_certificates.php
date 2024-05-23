<?php
include('db_connection.php');

// Check if Certificate ID is set
if(isset($_REQUEST['certificateID'])) {
    $certificateID = $_REQUEST['certificateID'];
    
    $stmt = $connection->prepare("SELECT * FROM certificates WHERE certificateID=?");
    $stmt->bind_param("i", $certificateID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['userID'];
        $courseID = $row['courseID'];
        $issue_date = $row['issue_date'];
        $expiration_date = $row['expiration_date'];
    } else {
        echo "Certificate not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in certificates Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update certificates form -->
    <h2><u>Update Form for Certificates</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="userID">User ID:</label>
        <input type="number" name="userID" value="<?php echo isset($userID) ? $userID : ''; ?>">
        <br><br>

        <label for="courseID">Course ID:</label>
        <input type="number" name="courseID" value="<?php echo isset($courseID) ? $courseID : ''; ?>">
        <br><br>

        <label for="issue_date">Issue Date:</label>
        <input type="text" name="issue_date" value="<?php echo isset($issue_date) ? $issue_date : ''; ?>">
        <br><br>

        <label for="expiration_date">Expiration Date:</label>
        <input type="text" name="expiration_date" value="<?php echo isset($expiration_date) ? $expiration_date : ''; ?>">
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
    $issue_date = $_POST['issue_date'];
    $expiration_date = $_POST['expiration_date'];
    
    // Update the certificate in the database
    $stmt = $connection->prepare("UPDATE certificates SET userID=?, courseID=?, issue_date=?, expiration_date=? WHERE certificateID=?");
    $stmt->bind_param("iissi", $userID, $courseID, $issue_date, $expiration_date, $certificateID);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: certificates.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
