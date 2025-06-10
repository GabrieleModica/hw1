<?php
require_once 'auth.php';
require_once 'dbconfig.php';

if (!$userid = checkAuth()) {
    header('Content-Type: application/json');
    echo json_encode([]);
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

$userid = mysqli_real_escape_string($conn, $userid);
$favorites = [];

$query = "SELECT restaurant_id FROM favorite_restaurants WHERE user_id = '$userid'";
$res = mysqli_query($conn, $query);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $favorites[] = $row['restaurant_id'];
    }
}

header('Content-Type: application/json');
echo json_encode($favorites);
?>
