<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];

    $stmt = $conn->prepare("INSERT INTO events (title, description, date, venue) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $date, $venue);

    if($stmt->execute()){
        echo "Event added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>