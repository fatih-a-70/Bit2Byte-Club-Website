<?php
session_start();
include "php/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    header("Location: member-dashboard.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$item_id = (int) $_GET['id'];
$type = $_GET['type'];

$tables = [
    "project" => ["table" => "member_projects", "column" => "project_id"] 
];

if (!array_key_exists($type, $tables) || $item_id <= 0) {
    header("Location: member-dashboard.php");
    exit;
}

$table = $tables[$type]["table"];
$column = $tables[$type]["column"];

$stmt = $conn->prepare("INSERT IGNORE INTO $table (user_id, $column) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();

header("Location: member-dashboard.php");
exit;
?>