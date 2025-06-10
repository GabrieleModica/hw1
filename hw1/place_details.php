<?php
header('Content-Type: application/json');

require_once 'auth.php';
require_once 'dbconfig.php';

if (!$userId = checkAuth()) {
    echo json_encode([]);
    exit;
}

$fsqId = $_GET['fsq_id'] ?? '';
if ($fsqId === '') {
    echo json_encode([]);
    exit;
}

$foursquareApiKey = 'secret';


$curlHandle = curl_init("https://api.foursquare.com/v3/places/$fsqId?fields=fsq_id,name,location,tel,website,rating,photos,categories");
curl_setopt_array($curlHandle, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: $foursquareApiKey",
        "Accept: application/json"
    ]
]);
$apiResponse = curl_exec($curlHandle);
if (!$apiResponse) {
    error_log("Errore cURL: " . curl_error($curlHandle));
    echo json_encode([]);
    exit;
}
curl_close($curlHandle);

$foursquareData = json_decode($apiResponse, true);
if (!isset($foursquareData['fsq_id'])) {
    echo json_encode([]);
    exit;
}

$outputDetails = [
    'id'      => $foursquareData['fsq_id'],
    'name'    => $foursquareData['name'] ?? '',
    'address' => $foursquareData['location']['formatted_address'] ?? '',
    'tel'     => $foursquareData['tel'] ?? '',
    'rating'  => $foursquareData['rating'] ?? null,
    'photo'   => isset($foursquareData['photos'][0]['prefix']) && isset($foursquareData['photos'][0]['suffix'])
                 ? $foursquareData['photos'][0]['prefix'] . 'original' . $foursquareData['photos'][0]['suffix']
                 : null
];

$foursquareCategoryIds = array_column($foursquareData['categories'] ?? [], 'id');

$databaseConnection = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$databaseConnection) {
    error_log("Errore DB: " . mysqli_connect_error());
    echo json_encode([]);
    exit;
}


$genericMenuConditions = [];
foreach ($foursquareCategoryIds as $categoryId) {
    $safeCategoryId = mysqli_real_escape_string($databaseConnection, $categoryId);
    $genericMenuConditions[] = "$safeCategoryId BETWEEN m.category_code_start AND m.category_code_end";
}
$finalWhereClause = '';
if (!empty($genericMenuConditions)) {
    $finalWhereClause = "(" . implode(' OR ', $genericMenuConditions) . ")";
} else {
    
    $finalWhereClause = "0";
}

// Query menù
$menuQuery = "
    SELECT m.id AS menu_id, m.title, mi.name, mi.description, mi.price
    FROM menus m
    JOIN menu_items mi ON mi.menu_id = m.id
    WHERE $finalWhereClause
    ORDER BY m.id, mi.id
";
$menuResult = mysqli_query($databaseConnection, $menuQuery);

$outputMenus = [];
while ($row = mysqli_fetch_assoc($menuResult)) {
    $title = $row['title'];
    if (!isset($outputMenus[$title])) {
        $outputMenus[$title] = ['title' => $title, 'items' => []];
    }
    $outputMenus[$title]['items'][] = [
        'name'        => $row['name'],
        'description' => $row['description'],
        'price'       => floatval($row['price'])
    ];
}
mysqli_free_result($menuResult);
mysqli_close($databaseConnection);

$outputDetails['menus'] = array_values($outputMenus);

echo json_encode($outputDetails, JSON_UNESCAPED_UNICODE);
exit;
?>