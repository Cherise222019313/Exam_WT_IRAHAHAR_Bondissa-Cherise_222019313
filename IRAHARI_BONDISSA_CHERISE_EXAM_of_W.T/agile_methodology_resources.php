<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>agile_methodology_resources Page</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: yellow;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
     
    }
  </style>

  <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
        
  </head>

  <header>

<body bgcolor="dimgray">
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./image/logoimage.jpeg" width="90" height="60" alt="Logo">
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./assignments.php">Assignments</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./certificates.php">Certificates</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./agile_methodology_resources.php">Agile_methodology_resources</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./courses.php">Courses</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./enrollments.php">enrollments</a>
  </li>  <li style="display: inline; margin-right: 10px;"><a href="./feedback.php">Feedback</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./instructors.php">Instructors</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./payments.php">Payments</a>
  </li>
<li style="display: inline; margin-right: 10px;"><a href="./progress_tracking.php">Progress_tracking</a>
  </li>
  
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>

</header>
<section>
   <h1><u>Agile_methodology_resources Form</u></h1>

<form method="post" onsubmit="return confirmInsert();">

    <label for="certificateID">certificateID:</label>
    <input type="number" id="Event_ID" name="Event_ID" required><br><br>

    <label for="resourceID">resourceID:</label>
    <input type="text" id="Event_Name" name="Event_Name" required><br><br>

    <label for="resource_name">resource_name:</label>
    <input type="text" id="Description" name="Description" required><br><br>

    <label for="resource_url">resource_url:</label>
    <input type="text" id="Start_Date" name="Start_Date" required><br><br>

    <input type="submit" name="add" value="Insert">
</form>


<?php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO agile_methodology_resources(resourceID, resource_name, resource_url) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $resourceID, $resource_name, $resource_url);

    // Set parameters and execute
    $resourceID = $_POST['Event_ID'];
    $resource_name = $_POST['Event_Name'];
    $resource_url = $_POST['Description'];
    
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>






<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>agile_methodology_resources</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Agile_methodology_resources Table</h2></center>
    <table border="3">
        <tr>
            <th>resourceID</th>
            <th>resource_name</th>
            <th>resource_url</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
<?php
include('db_connection.php');

// Prepare SQL query to retrieve all agile_methodology_resources
$sql = "SELECT * FROM agile_methodology_resources";
$result = $connection->query($sql);

// Check if there are any agile_methodology_resources
if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $resourceID = $row['resourceID']; // Fetch the resourceID
        echo "<tr>
            <td>" . $row['resourceID'] . "</td>
            <td>" . $row['resource_name'] . "</td>
            <td>" . $row['resource_url'] . "</td>
            <td><a style='padding:4px' href='delete_agile_methodology_resources.php?resourceID=$resourceID'>Delete</a></td> 
            <td><a style='padding:4px' href='update_agile_methodology_resources.php?resourceID=$resourceID'>Update</a></td> 
        </tr>";
    }

} else {
    echo "<tr><td colspan='7'>No data found</td></tr>";
}
// Close the database connection
$connection->close();
?>
    </table>
</body>

</section>
 
<footer>
  <center> 
   <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by:IRAHARI BONDISSA CHERISE</h2></b>
  </center>
</footer>
  
</body>
</html>

