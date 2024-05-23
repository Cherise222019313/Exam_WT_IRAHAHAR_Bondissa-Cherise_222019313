<?php
include('db_connection.php');

// Check if Feedback ID is set
if(isset($_REQUEST['feedbackID'])) {
    $feedbackID = $_REQUEST['feedbackID'];
    
    $stmt = $connection->prepare("SELECT * FROM feedback WHERE feedbackID=?");
    $stmt->bind_param("i", $feedbackID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['userID'];
        $courseID = $row['courseID'];
        $rating = $row['rating'];
        $comments = $row['comments'];
        $feedback_date = $row['feedback_date'];
    } else {
        echo "Feedback not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in feedback Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update feedback form -->
    <h2><u>Update Form for Feedback</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="userID">User ID:</label>
        <input type="number" name="userID" value="<?php echo isset($userID) ? $userID : ''; ?>">
        <br><br>

        <label for="courseID">Course ID:</label>
        <input type="number" name="courseID" value="<?php echo isset($courseID) ? $courseID : ''; ?>">
        <br><br>

        <label for="rating">Rating:</label>
        <input type="number" name="rating" value="<?php echo isset($rating) ? $rating : ''; ?>">
        <br><br>

        <label for="comments">Comments:</label>
        <input type="text" name="comments" value="<?php echo isset($comments) ? $comments : ''; ?>">
        <br><br>

        <label for="feedback_date">Feedback Date:</label>
        <input type="text" name="feedback_date" value="<?php echo isset($feedback_date) ? $feedback_date : ''; ?>">
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
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];
    $feedback_date = $_POST['feedback_date'];
    
    // Update the feedback in the database
    $stmt = $connection->prepare("UPDATE feedback SET userID=?, courseID=?, rating=?, comments=?, feedback_date=? WHERE feedbackID=?");
    $stmt->bind_param("iiiisi", $userID, $courseID, $rating, $comments, $feedback_date, $feedbackID);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: feedback.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
