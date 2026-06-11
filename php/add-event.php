<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $tags = $_POST['tags']; // comma-separated tags
    $description = $_POST['description'];
    $event_date = $_POST['date'];
    $link = $_POST['link'] ?? '#';

    $imageName = "";
    if(isset($_FILES['image']) && $_FILES['image']['name'] !== "") {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/images/" . $imageName);
    }

    $stmt = $conn->prepare("INSERT INTO events (title, tags, description, event_date, image, link) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $tags, $description, $event_date, $imageName, $link);

    if($stmt->execute()){
        header("Location: ../events.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>