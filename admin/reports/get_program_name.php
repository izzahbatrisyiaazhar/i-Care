<?php
// Connect to your database
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'i-care_db';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the 'program_id' parameter is set in the URL
if (isset($_GET['program_id'])) {
    // Get the value of 'program_id'
    $programId = $_GET['program_id'];

    // Use the program ID to fetch the program name from the database
    $sql = "SELECT name FROM program WHERE id = '$programId' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $programName = $row['name'];

        // Return the program name as the response
        echo $programName;
    } else {
        // Handle case when no program name is found
        echo 'No program name found';
    }
} else {
    // Handle case when 'program_id' parameter is not set in the URL
    echo 'Program ID not provided';
}

// Close the database connection
$conn->close();

?>
