<?php
include('db_connection.php');

// Check if Course ID is set
if(isset($_REQUEST['course_id'])) {
    $course_id = $_REQUEST['course_id'];
    
    $stmt = $connection->prepare("SELECT * FROM courses WHERE courseID=?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $course_name = $row['course_name'];
        $instructor_id = $row['instructorID'];
    } else {
        echo "Course not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in Courses Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update courses form -->
    <h2><u>Update Form for Courses</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">

        <label for="course_name">Course Name:</label>
        <input type="text" name="course_name" value="<?php echo isset($course_name) ? $course_name : ''; ?>">
        <br><br>

        <label for="instructor_id">Instructor ID:</label>
        <input type="number" name="instructor_id" value="<?php echo isset($instructor_id) ? $instructor_id : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $course_name = $_POST['course_name'];
    $instructor_id = $_POST['instructor_id'];
    
    // Update the course in the database
    $stmt = $connection->prepare("UPDATE courses SET course_name=?, instructorID=? WHERE courseID=?");
    $stmt->bind_param("sii", $course_name, $instructor_id, $course_id);
    $stmt->execute();
    
    // Redirect to view page
    header('Location: courses.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
