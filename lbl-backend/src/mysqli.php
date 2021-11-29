<?php
$servername = "localhost";
$username = "backend";
$password = "mdp123";
$db = "librarybooklocator";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function my_q($query, $co) {
    $result = $co->query($query);
    $the_rows = array();
    while ($row = $result->fetch_array()) {
        $the_rows[] = $row;
    }
    return $the_rows;
}


//$conn->close();
