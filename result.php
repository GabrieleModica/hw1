<?php


$latitude = $_GET['lat'] ?? '';
$longitude = $_GET['lng'] ?? '';
$address = $_GET['address'] ?? '';

// Categoria iniziale per la ricerca (default: tutte)
$initialCategory = $_GET['category'] ?? '13003-13025,13044-13046,13064,13065-13390';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ristoranti vicino a <?=$address ?></title>
    <link rel="stylesheet" href="css/result.css">
    <script>
        const LATITUDE = <?= json_encode($latitude) ?>;
        const LONGITUDE = <?= json_encode($longitude) ?>;
        const ADDRESS = <?= json_encode($address) ?>;
        const INITIAL_CATEGORY = <?= json_encode($initialCategory) ?>;
    </script>
    <script src="js/result.js" defer></script>
</head>
<body>
    <nav>
        <a href="index.php">
            <img id="logo" class="logo" src="img/back_button.png" alt="Torna indietro">
        </a>
    </nav>

    <div class="container">
        <aside class="sidebar">
            <h2>Filtra Risultati</h2>

            <div class="filter-section">
                <label><strong>Seleziona categoria:</strong></label>
                <div class="filter-options">
                    <!-- Categorie principali per il filtro -->
                    <button data-category="13003-13025,13044-13046,13064,13065-13390">Tutti</button>
                    <button data-category="13065-13390">Ristoranti</button>
                    <button data-category="13064">Pizzerie</button>
                    <button data-category="13003-13025">Bar</button>
                    <button data-category="13044-13046">Gelaterie</button>
                </div>
            </div>

            <div class="filter-section">
                <label><strong>Preferiti:</strong></label>
                <div class="filter-options">
                    <!-- Filtro per mostrare solo i preferiti -->
                    <button id="filter-favorites">Mostra solo preferiti</button>
                </div>
            </div>
        </aside>

        <main class="results">
            <h1>Ristoranti vicino a <?= $address ?></h1>
            <div id="places-container"></div> <!-- Qui vengono mostrati i risultati --> 
        </main>
    </div>
</body>
</html>