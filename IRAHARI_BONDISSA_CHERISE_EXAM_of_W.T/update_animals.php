<?php
include('db_connection.php');

// Check if AnimalID is set
if (isset($_REQUEST['AnimalID'])) {
    $animal_id = $_REQUEST['AnimalID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM animals WHERE AnimalID=?");
    $stmt->bind_param("i", $animal_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['Name'];
        $species = $row['Species'];
        $age = $row['Age'];
        $shelter_date = $row['ShelterDate'];
    } else {
        echo "Animal not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Animal Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update animal information form -->
    <h2><u>Update Animal Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
        <br><br>

        <label for="species">Species:</label>
        <input type="text" name="species" value="<?php echo isset($species) ? $species : ''; ?>">
        <br><br>

        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo isset($age) ? $age : ''; ?>">
        <br><br>

        <label for="shelter_date">Shelter Date:</label>
        <input type="text" name="shelter_date" value="<?php echo isset($shelter_date) ? $shelter_date : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $name = $_POST['name'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $shelter_date = $_POST['shelter_date'];

    // Update the animal in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE animals SET Name=?, Species=?, Age=?, ShelterDate=? WHERE AnimalID=?");
    $stmt->bind_param("ssisi", $name, $species, $age, $shelter_date, $animal_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: animals.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
