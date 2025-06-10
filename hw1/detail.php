<?php
require_once 'auth.php';
if (!checkAuth()) {
    header("Location: login.php");
    exit;
}

$fsq_id = isset($_GET['fsq_id']) ? $_GET['fsq_id'] : '';
if (!$fsq_id) {
    echo "ID non valido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dettagli Locale</title>
    <link rel="stylesheet" href="css/detail.css">
    <script src="js/detail.js" defer></script>
</head>
<body>
   <nav>
        <a href="index.php">
            <img id="logo" class="logo" src="img/back_button.png" alt="Torna indietro">
        </a>
    </nav>

    <div class="detail-container" id="details-container" data-fsq-id="<?php echo $fsq_id ?>">
        </div>
</body>
</html>