<?php
header('Content-Type: application/json');

require_once 'auth.php';
require_once 'dbconfig.php';

if (!$userId = checkAuth()) {
    echo json_encode([]);
    exit;
}

$latitude = $_GET['lat'] ?? '';
$longitude = $_GET['lng'] ?? '';
$rawCategory = $_GET['category'] ?? '';

$defaultCategories = '13003-13025,13044-13046,13064,13065-13390';
$categoriesToProcess = ($rawCategory === '') ? $defaultCategories : $rawCategory;
$foursquareCategories = [];

foreach (explode(',', $categoriesToProcess) as $part) {
    if (str_contains($part, '-')) {
        list($start, $end) = explode('-', $part);
        for ($i = (int)$start; $i <= (int)$end; $i++) {
            $foursquareCategories[] = $i;
        }
    } else {
        $foursquareCategories[] = (int)$part;
    }
}
$foursquareCategoryParam = "&categories=" . implode(',', $foursquareCategories);

$foursquareApiKey = 'secret';

$foursquareApiUrl = "https://api.foursquare.com/v3/places/search"
                  . "?ll={$latitude},{$longitude}"
                  . "{$foursquareCategoryParam}"
                  . "&limit=25"
                  . "&fields=fsq_id,name,location,photos,categories";

$requestHeaders = [
    "Authorization: {$foursquareApiKey}",
    "Accept: application/json"
];

$curlHandle = curl_init();
curl_setopt($curlHandle, CURLOPT_URL, $foursquareApiUrl);
curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $requestHeaders);

$apiResponse = curl_exec($curlHandle);


curl_close($curlHandle);

$foursquareData = json_decode($apiResponse, true);
$foundPlaces = $foursquareData['results'] ?? [];

$filteredPlaces = [];
foreach ($foundPlaces as $place) {

    if (!empty($place['categories']) && in_array($place['categories'][0]['id'], $foursquareCategories, true)) {
        $filteredPlaces[] = $place;
    }
}

$databaseConnection = mysqli_connect(
    $dbconfig['host'],
    $dbconfig['user'],
    $dbconfig['password'],
    $dbconfig['name']
);


$safeUserId = mysqli_real_escape_string($databaseConnection, $userId);
$favoriteQuery = "SELECT restaurant_id FROM favorite_restaurants WHERE user_id = '$safeUserId'";
$favoriteResult = mysqli_query($databaseConnection, $favoriteQuery);

$favoriteRestaurantIds = [];
if ($favoriteResult) {
    while ($row = mysqli_fetch_assoc($favoriteResult)) {
        $favoriteRestaurantIds[] = $row['restaurant_id'];
    }
    mysqli_free_result($favoriteResult);
} 

$outputRestaurants = [];
foreach ($filteredPlaces as $place) {
    $placeId = $place['fsq_id'];
    $photoUrl = null;


    if (isset($place['photos'][0]['prefix']) && isset($place['photos'][0]['suffix'])) {
        $photoUrl = $place['photos'][0]['prefix'] . 'original' . $place['photos'][0]['suffix'];
    }

    $outputRestaurants[] = [
        'id'         => $placeId,
        'name'       => $place['name'],
        'address'    => $place['location']['formatted_address'] ?? 'Indirizzo non disponibile',
        'photo_url'  => $photoUrl,
        'isFavorite' => in_array($placeId, $favoriteRestaurantIds)
    ];
}

mysqli_close($databaseConnection);

echo json_encode($outputRestaurants);
exit();