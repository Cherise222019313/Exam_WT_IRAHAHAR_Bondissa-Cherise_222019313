<?php
include('db_connection.php');

// Check if Assignment ID is set
if(isset($_REQUEST['assignmentID'])) {
    $assignment_id = $_REQUEST['assignmentID'];
    
    $stmt = $connection->prepare("SELECT * FROM assignments WHERE assignmentID=?");
    $stmt->bind_param("i", $assignment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $course_id = $row['courseID'];
        $title = $row['title'];
        $description = $row['description'];
        $due_date = $row['due_date'];
    } else {
        echo "Assignment not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in assignments Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update assignments form -->
    <h2><u>Update Form for Assignments</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="course_id">Course ID:</label>
        <input type="number" name="course_id" value="<?php echo isset($course_id) ? $course_id : ''; ?>">
        <br><br>

        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
        <br><br>

        <label for="description">Description:</label>
        <textarea name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
        <br><br>

        <label for="due_date">Due Date:</label>
        <input type="text" name="due_date" value="<?php echo isset($due_date) ? $due_date : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    
    // Update the assignment in the database
    $stmt = $connection->prepare("UPDATE assignments SET courseID=?, title=?, description=?, due_date=? WHERE assignmentID=?");
    $stmt->bind_param("issii", $course_id, $title, $description, $due_date, $assignment_id);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: assignments.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?> 
