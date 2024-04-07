<?php
session_start();
function get_user_by_username(string $username): array | null {
    $users = load_data("adatok/felhasznalok.json");
    foreach ($users["users"] as $user)
        if ($user["username"] === $username)
            return $user;

    return null;
}

function load_data(string $filename): array {
    if (!file_exists($filename))
        die("Nem sikerült a fájl megnyitása!");

    $json_data = file_get_contents($filename);

    return json_decode($json_data, true);
}
$errors = [];
if (isset($_POST["bejelentike"])) {
    $username = $_POST["username"];
    $password = $_POST["passwd"];

    if (trim($username) === "")
        $errors[] = "empty_username";

    if (trim($password) === "")
        $errors[] = "empty_password";

    if (count($errors) === 0) {
        $user = get_user_by_username($username);

        if ($user == null || !password_verify($password, $user["password"]))
            $errors[] = "invalid_user";
        else {
                header("Location: ertekeles.php");
            }
        }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="stilus/stilus.css">
    <link rel = "stylesheet" href="stilus/forum.css">
    <link rel="icon" href="img/icon.png">
    <title>Fórum</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Bemutatkozás</a>
                </li>
                <li>
                    <a href="filmek.php">Filmek</a>
                </li>
                <li>
                    <a href="karakterek.php">Karakterek</a>
                </li>
                <li>
                    <a href="statisztikak.php">Statisztikák</a>
                </li>
                <li>
                    <a aria-current="page" href="forum.php">Fórum</a>
                </li>
            </ul>
        </nav>
        <div id="alap">
            <div id="baloszlop">
                <p class="animate-charcter">Mekkora fan vagy?</p>
            </div>
            <div id="focimkep"> 
                <p><img src="img/shrek-banner.png" alt="jobb kint mint bent" width="1020"></p>
            </div>
        </div>
    </header>
    <hr>
    <main>
        <div class="cim">
            <p>Csatlakozz rajongótáborunkhoz!</p>
        </div>

        <div id="bejelentkezes">
            <h1>Bejelentkezés</h1>
            <form method="POST">
                <input type="text" size="40" name="username" placeholder="Felhasználónév..." required/> <br/><br/>
                <div>
                    <?php
                    if (in_array("empty_username", $errors)) echo "A mező kitöltése kötelező!";
                    if (in_array("exist_username", $errors)) echo "A megadott felhasználónév foglalt!";
                    ?>
                </div>
                <input type="password" size="40" name="passwd" placeholder="Jelszó..." required/> <br/><br/>
                <div>
                    <?php
                    if (in_array("empty_password", $errors)) echo "A mező kitöltése kötelező!";
                    if (in_array("invalid_user", $errors)) echo "Hibás jelszó, vagy nem létező felhasználó!";
                    ?>
                </div>
                <input type="submit" value="Bejelentkezés" name="bejelentike"/>
                <br><br>Nincs még fiókod? <a href="regisztracio.php">Regisztráció</a>
            </form>
        </div>
    </main>
    
</body>
</html>