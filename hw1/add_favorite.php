<?php
require_once 'auth.php';
require_once 'dbconfig.php';

if (!$userid = checkAuth()) exit;


$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

$restaurant_id = mysqli_real_escape_string($conn, $_POST['restaurant_id']);


$query = "SELECT * FROM favorite_restaurants WHERE user_id = '$userid' AND restaurant_id = '$restaurant_id'";
$res = mysqli_query($conn, $query);

if (mysqli_num_rows($res) > 0) {

    $delete = "DELETE FROM favorite_restaurants WHERE user_id = '$userid' AND restaurant_id = '$restaurant_id'";
    mysqli_query($conn, $delete);
    echo "REMOVED";
} else {

    $insert = "INSERT INTO favorite_restaurants(user_id, restaurant_id) VALUES('$userid', '$restaurant_id')";
    mysqli_query($conn, $insert);
    echo "ADDED";
}

mysqli_close($conn);
?>
