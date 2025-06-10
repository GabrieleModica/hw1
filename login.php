<?php
require_once 'auth.php';

if (checkAuth()) {
    header('Location: index.php'); 
    exit;
}

if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($res) > 0) {
        $entry = mysqli_fetch_assoc($res);
        if (password_verify($_POST['password'], $entry['password'])) {
            $_SESSION["username"] = $entry['username'];
            $_SESSION["user_id"] = $entry['id'];
            mysqli_free_result($res);
            mysqli_close($conn);
            header("Location: index.php"); 
            exit;
        }
    }

    $error = "Username e/o password errati.";
} else if (isset($_POST["username"]) || isset($_POST["password"])) {
    $error = "Inserisci username e password.";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accedi - JustEat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link rel="stylesheet" href="css/login.css">

</head>
<body>
   <nav>
        <img id="logo" class="logo" src="img/just-eat-brand.30f1ebe5.svg">
        <div class="links">
       
        </div>
    </nav>
    </div>
    <main class="login">
        <section class="main">
            <h5>Accedi per ordinare i tuoi piatti preferiti</h5>

            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

            <form name="login" method="post">
                <div class="username">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" 
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                <div class="password">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password"
                        value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
                </div>
                <div class="submit-container">
                    <div class="login-btn">
                        <input type="submit" value="ACCEDI">
                    </div>
                </div>
            </form>

            <div class="signup">
                <h4>Non hai un account?</h4>
            </div>
            <div class="signup-btn-container">
                <a class="signup-btn" href="signup.php">ISCRIVITI A JUST EAT</a>
            </div>
        </section>
    </main>
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
</body>
</html>
