<?php
  
    include 'auth.php';
    if (!checkAuth()) {
        header('Location: home.php');
        exit;
    }




if (isset($_SESSION['user_id'])) {
  
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
$userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);

  
    $query = "SELECT username FROM users WHERE id = $userid";
    $res = mysqli_query($conn, $query);

    if ($res && mysqli_num_rows($res) > 0) {
        $userinfo = mysqli_fetch_assoc($res);
        $username = $userinfo['username'];
    } else {
        $username = "Utente";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Just Eat</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="js/index.js" defer></script>
</head>
<body>


<img id="feed" src="img/just-eat-button-e8ed320f050ac0c26a9470a9d1250c89.png">

<nav>
    <img id="logo" class="logo" src="img/just-eat-brand.30f1ebe5.svg">
     <span class="welcome-message">Benvenuto, <?php echo $username ?>!</span>
    <div class="links">
        <a><img src="img/icona-ordine.svg"> Ordine Aziendale</a>
        <a><img src="img/icona-rider.svg"> Diventa Rider</a>
        <a><img src="img/icona-partner.svg"> Diventa Partner</a>

        <div><img class="language-flag" src="img/italy-flag.svg"></div>
        <img id="menù" src="img/menù.svg">

           
       
    </div>
</nav>

<header>
    <div class="left">
        <h1>Ordina cibo e tanto altro</h1>
        <h2>Ristoranti e spesa, a domicilio</h2>
        <form id="address-form">
            <input type="text" id="address-input" placeholder="Inserisci indirizzo">
            <input type="submit" id="submit" value="Cerca">
        </form>
        <div id="suggestions"></div>
    </div>
    <div class="right">
        <img id="foodImage" src="img/cheeseburger_home_dss_desktop_it.5bf7d9e2.png">
    </div>
</header>
<div id="results"></div>   
 <section class="how-to-order">
      <h2>Come ordinare</h2>
      <h1>È semplicissimo!</h1>
      <div class="indicazioni">
          <div class="block" data-index="1">
              <img class="icon" src="img/posizione.svg">
              <h3>Indicaci la tua posizione</h3>
              <p>Ti mostreremo i negozi e i ristoranti della tua zona da cui puoi ordinare.</p>
          </div>
          <div class="block" data-index="2">
              <img class="icon" src="img/panino.svg">
              <h3>Trova ciò che desideri</h3>
              <p>Cerca articoli o piatti, locali o cucine.</p>
          </div>
          <div class="block" data-index="3">
              <img class="icon" src="img/ordina.svg">
              <h3>Ordina con consegna o ritiro al locale</h3>
              <p>Ti terremo aggiornato sullo stato del tuo ordine.</p>
          </div>
      </div>
  </section>
    
    <section class="app">
        <div class="app-left">
            <h2><strong>Scarica l'app</strong></h2>
            <p>Il tuo piatto preferito è a portata di click!</p>
            <div class="app-buttons">
                <a href="#"><img class="app-store" src="img/download-google-play.a220a276.png"></a>
                <a href="#"><img class="app-store" src="img/download-ios.00848a3e.png"></a>
            </div>
        </div>
        <div class="app-right">
            <img src="img/smartphone.png">
        </div>
    </section>
    <section class="util">
      <h2>Just eat</h2>
      <h1>Di cosa hai voglia?</h1>
      <div class="indicazioni">
          <div class="block" data-index="1">
              <img class="icon" src="img/icona-fedeltà.svg">
              <h3>Programmi fedeltà</h3>
              <p><strong>✓ </strong>Ricevi i timbri, promozioni, sconti, novità e molto altro tramite newsletter e pagine social</p>
          </div>
          <div class="block" data-index="2">
              <img class="icon" src="img/icona-promessa.svg">
              <h3>La nostra promessa</h3>
              <p><strong>✓ </strong>Servizio eccellente</p>
              <p><strong>✓ </strong>Recensioni autentiche</p>
          </div>
          <div class="block" data-index="3">
              <img class="icon" src="img/icona-vantaggi.svg">
              <h3>I tuoi vantaggi</h3>
              <p><strong>✓ </strong>Oltre 28.000 locali tra cui scegliere</p>
              <p><strong>✓ </strong>Paga online o in contanti</p>
              <p><strong>✓ </strong>Ordina ovunque, in qualsiasi momento e con qualsiasi dispositivo</p>
          </div>
      </div>
  </section>
    <footer>
      <div class="footer-container">
          <div class="footer-top">
              <div class="footer-logo">
                  <img src="img/just-eat-brand.30f1ebe5-black.svg">
              </div>
              <div id="seguici">Seguici</div>
              <div class="footer-social">
                  <a ><img src="img/facebook.svg"></a>
                  <a ><img src="img/instagram.svg"></a>
                  <a ><img src="img/X.svg"></a>
                  <a ><img src="img/youtube.svg"></a>
              </div>
          </div>
  
            <div class="footer-links">
            <div class="footer-left">
              <div class="footer-section">
                <h3 class="footer-toggle">Just Eat <span class="toggle-icon">+</span></h3>
                <div class="footer-dropdown">
                <p>Informazioni su Just Eat</p>
                <p>Domande Frequenti</p>
                <p>Diventa partner Just Eat</p>
                <p>Diventa rider Just Eat</p>
                <p>Lavora con noi</p>
                <p>Just Eat for business</p>
                <p>Informativa sulla privacy</p>
                <p>Miglior prezzo garantito</p>
                <p>Informazioni legali</p>
                <p>Informativa sui cookie</p>
                <p>Media e stampa</p>
                <p>Partner Hub</p>
                <p>Segnala un problema sul contenuto</p>
                </div>
              </div>
            </div>
            <div class="footer-right">
              <div class="footer-section">
                <h3 class="footer-toggle">International <span class="toggle-icon">+</span></h3>
                <div class="footer-dropdown">
                <p>Investor Relations</p>
                <p>Bistro.sk</p>
                <p>Just Eat - Switzerland</p>
                <p>Just Eat - Denmark</p>
                <p>Just Eat - Spain</p>
                <p>Just Eat - United Kingdom</p>
                <p>Just Eat - Ireland</p>
                <p>Just Eat - Italy</p>
                <p>Lieferando.at</p>
                <p>Lieferando.de</p>
                <p>Menulog - Australia</p>
                <p>Pyszne.pl</p>
                <p>SkipTheDishes</p>
                <p>Takeaway.com - Belgium</p>
                <p>Takeaway.com - Luxembourg</p>
                <p>Takeaway.com - Bulgaria</p>
                <p>Thuisbezorgd.nl</p>
                <p>10bis</p>
                </div>
              </div>
              
              <div class="footer-section">
                <h3 class="footer-toggle">Cucine <span class="toggle-icon">+</span></h3>
                <div class="footer-dropdown">
                <p>Pizza</p>
                <p>Sushi</p>
                <p>Kebab</p>
                <p>Poke</p>
                <p>Gelato</p>
                <p>Dolci</p>
                <p>Cibo cinese</p>
                <p>Hamburger</p>
                <p>Supermercato - Spesa online</p>
                <p>Cibo italiano</p>
                <p>Panini</p>
                <p>Colazione</p>
                <p>Pollo</p>
                <p>Cibo messicano</p>
                <p>Tutti i tipi di cucina</p>
                </div>
              </div>
              
              <div class="footer-section">
                <h3 class="footer-toggle">Esplora <span class="toggle-icon">+</span></h3>
                <div class="footer-dropdown">
                <p>Blog</p>
                <p>Sostenibilità</p>
                <p>L'Osservatorio Just Eat 2024</p>
                <p>Just Eat Awards 2024</p>
                <p>Cosa mangiare oggi</p>
                <p>Partners</p>
                <p>Tiro, gol, rimborso</p>
                </div>
              </div>
              
              <div class="footer-section">
                <h3 class="footer-toggle">Città <span class="toggle-icon">+</span></h3>
                <div class="footer-dropdown">
                <p>Roma</p>
                <p>Milano</p>
                <p>Torino</p>
                <p>Bologna</p>
                <p>Napoli</p>
                <p>Genova</p>
                <p>Trieste</p>
                <p>Bari</p>
                <p>Firenze</p>
                <p>Palermo</p>
                <p>Pisa</p>
                <p>Ferrara</p>
                <p>Parma</p>
                <p>Tutte le città</p>
                </div>
              </div>
              
              <div class="footer-section">
                <h3 class="footer-toggle">Catene <span class="toggle-icon">+</span></h3>
                <div class="footer-dropdown">
                <p>McDonald's</p>
                <p>Burger King</p>
                <p>Old Wild West</p>
                <p>La Piadineria</p>
                <p>Alice Pizza</p>
                <p>Poke House</p>
                <p>Carrefour</p>
                <p>Fratelli La Bufala</p>
                <p>Hamerica's</p>
                <p>Starbucks</p>
                <p>Sushiko</p>
                <p>Zushi</p>
                <p>Tutte le catene</p>
                </div>
              </div>
            </div>
            </div>
  
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
<div id="account-menu" class="account-menu">
    <div class="menu-content">
      <button class="close-btn" > <strong>×</strong></button>
      <h1>Il mio account</h1>
      
      <div class="menu-section">
      <div class="menu-item"> <a  href= "logout.php">Logout</a></div>

      </div>
  
      <div class="menu-section">
        <div class="menu-item ">Premi</div>
        <div class="menu-item ">Carte Fedeltà</div>
        <div class="menu-item">Ti serve aiuto?</div>
      </div>
  
      <div class="menu-section">
        <div class="menu-item">Diventa rider</div>
        <div class="menu-item">Just Eat for business</div>
        <div class="menu-item ">Diventa Partner</div>
      </div>
    </div>
  </div>
  <div id="menu-overlay" class="menu-overlay"></div>

<div id="language-menu" class="account-menu">
  <div class="menu-content">
      <button class="close-btn"><strong>×</strong></button>
      <h1>Seleziona lingua</h1>
      
      <div class="menu-section">
          <div class="menu-item">
              <img src="img/italy-flag.svg" class="language-flag">
              <span>Italiano</span>
          </div>
          <div class="menu-item">
              <img src="img/uk-flag.svg" class="language-flag">
              <span>English</span>
          </div>
          <div class="menu-item">
              <img src="img/france-flag.svg" class="language-flag">
              <span>Français</span>
          </div>
          <div class="menu-item">
              <img src="img/germany-flag.svg" class="language-flag">
              <span>Deutsch</span>
          </div>
          <div class="menu-item">
              <img src="img/spain-flag.svg" class="language-flag">
              <span>Español</span>
          </div>
      </div>
  </div>
</div>
</body>
</html>