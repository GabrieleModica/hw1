<?php
   
    include 'auth.php';
    if (checkAuth()) {
        header('Location: index.php');
        exit;
    }?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Just Eat - Home</title>
    <link rel="stylesheet" href="css/home.css">
    <script src="js/home.js" defer></script>
</head>
<body>

    
    <nav>
        <img id="logo" class="logo" src="img/just-eat-brand.30f1ebe5.svg">
        <div class="links">
            <div><img class="language-flag" src="img/italy-flag.svg" id="language-button"></div>
            <a href="login.php" class="auth-btn">Login</a>
            <a href="signup.php" class="auth-btn">Registrati</a>
        </div>
    </nav>

    <header>
        <div class="left">
            <h1>Ordina cibo e tanto altro</h1>
          
<h2>Inizia subito a ordinare: <strong>accedi o registrati in pochi click!</strong></h2>

        </div>
        <div class="right">
            <img id="foodImage" src="img/cheeseburger_home_dss_desktop_it.5bf7d9e2.png">
        </div>
    </header>

    <footer>
        <div class="footer-container">
            <div class="footer-bottom">
                <p>
                    <a href="#">Diventa Partner Just Eat</a> | 
                    <a href="#">Lavora con noi</a> | 
                    <a href="#">Termini di servizio</a> | 
                    <a href="#">Informativa sulla privacy</a>
                </p>
                <p>&copy; 2025 Just Eat</p>
                <a href="#">Vedi preferenze sui cookie</a>
            </div>
        </div>
    </footer>


    <div id="language-menu" class="account-menu">
        <div class="menu-content">
            <button class="close-btn"><strong>×</strong></button>
            <h1>Seleziona lingua</h1>
            <div class="menu-section">
                <div class="menu-item">
                    <img src="img/italy-flag.svg" class="language-flag"><span>Italiano</span>
                </div>
                <div class="menu-item">
                    <img src="img/uk-flag.svg" class="language-flag"><span>English</span>
                </div>
                <div class="menu-item">
                    <img src="img/france-flag.svg" class="language-flag"><span>Français</span>
                </div>
                <div class="menu-item">
                    <img src="img/germany-flag.svg" class="language-flag"><span>Deutsch</span>
                </div>
                <div class="menu-item">
                    <img src="img/spain-flag.svg" class="language-flag"><span>Español</span>
                </div>
            </div>
        </div>
    </div>

    <div id="menu-overlay" class="menu-overlay"></div>
</body>
</html>
