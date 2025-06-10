<?php
    require_once 'auth.php';

    if (checkAuth()) {
        header("Location: home.php");
        exit;
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) &&
        !empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["confirm_password"]) &&
        isset($_POST["allow"])) {

        $error = array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) 
                or die(mysqli_error($conn));

       
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $res = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }


        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        }

     
        if ($_POST["password"] !== $_POST["confirm_password"]) {
            $error[] = "Le password non coincidono";
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

     
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);
            $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT);

            $query = "INSERT INTO users(username, password, name, surname, email) 
                      VALUES('$username', '$password', '$name', '$surname', '$email')";

            if (mysqli_query($conn, $query)) {
                $_SESSION["_agora_username"] = $_POST["username"];
                $_SESSION["_agora_user_id"] = mysqli_insert_id($conn);
                mysqli_close($conn);
                header("Location: home.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registrati - Just Eat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/signup.css">
    <script src="JS/signup.js" defer></script>
</head>
<body>
    <nav>
        <img id="logo" class="logo" src="img/just-eat-brand.30f1ebe5.svg">
        <div class="links"></div>
    </nav>
    <main>
        <section class="signup-container">
            <h1>Crea un account Just Eat</h1>
            <form name="signup" method="post" autocomplete="off">
                <div class="name">
                    <label>Nome</label>
                    <input type="text" name="name" value="<?php if (isset($_POST["name"])) print $_POST["name"]; ?>">
                    <div><span>Inserisci il tuo nome</span></div>
                </div>
                <div class="surname">
                    <label>Cognome</label>
                    <input type="text" name="surname" value="<?php if (isset($_POST["surname"])) print $_POST["surname"]; ?>">
                    <div><span>Inserisci il tuo cognome</span></div>
                </div>
                <div class="username">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php if (isset($_POST["username"])) print $_POST["username"]; ?>">
                    <div><span class="username-error">Username non disponibile</span></div>
                </div>
                <div class="email">
                    <label>Email</label>
                    <input type="text" name="email" value="<?php if (isset($_POST["email"])) print $_POST["email"]; ?>">
                    <div><span class="email-error">Email non valida</span></div>
                </div>
                <div class="password">
                    <label>Password</label>
                    <input type="password" name="password">
                    <div><span>Minimo 8 caratteri</span></div>
                </div>
                <div class="confirm_password">
                    <label>Conferma Password</label>
                    <input type="password" name="confirm_password">
                    <div><span>Le password non coincidono</span></div>
                </div>
                <div class="allow">
                    <input type="checkbox" name="allow" value="1" <?php if (isset($_POST["allow"])) echo "checked"; ?>>
                    <label>Accetto i termini e le condizioni</label>
                </div>
                <?php
                if (isset($error)) {
                    foreach($error as $err) {
                        echo "<div class='errorj'><span>$err</span></div>";
                    }
                }
                ?>
                <div class="submit">
                    <input type="submit" value="Registrati">
                </div>
            </form>
            <p>Hai già un account? <a href="login.php">Accedi</a></p>
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
