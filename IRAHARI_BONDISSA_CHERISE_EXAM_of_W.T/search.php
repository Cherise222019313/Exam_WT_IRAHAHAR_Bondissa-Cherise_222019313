<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {

 include('db_connection.php');

    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'agile_methodology_resources' => "SELECT resource_name FROM agile_methodology_resources WHERE resource_name LIKE '%$searchTerm%'",
        'assignments' => "SELECT title FROM assignments WHERE title LIKE '%$searchTerm%'",
        'certificates' => "SELECT certificateID FROM certificates WHERE certificateID LIKE '%$searchTerm%'",
        'feedback' => "SELECT rating FROM feedback WHERE rating LIKE '%$searchTerm%'",
        'courses' => "SELECT course_name FROM courses WHERE course_name LIKE '%$searchTerm%'",
        'instructors' => "SELECT instructorID FROM instructors WHERE instructorID LIKE '%$searchTerm%'",
        'payments' => "SELECT paymentID FROM payments WHERE paymentID LIKE '%$searchTerm%'",
        'progress_tracking' => "SELECT progressID FROM progress_tracking WHERE progressID LIKE '%$searchTerm%'",
        'enrollments' => "SELECT enrollmentID FROM enrollments WHERE enrollmentID LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>




