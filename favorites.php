<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trojanmarketplace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming `student_id` is stored in session after login
if (!isset($_SESSION['student_id'])) {
    die("Please log in to view favorites.");
}

$student_id = $_SESSION['student_id'];

$sql = "SELECT items.item_id, items.image, items.price, items.description, items.condition, items.date_time
        FROM favorites 
        JOIN items ON favorites.item_id = items.item_id 
        WHERE favorites.student_id = $student_id";
        
$result = $conn->query($sql);
$favorites = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $favorites[] = $row;
    }
}

echo json_encode($favorites);

$conn->close();
?>
