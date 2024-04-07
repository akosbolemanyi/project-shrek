<?php
function create_user(array $user_data): void {
    $users = load_data("adatok/felhasznalok.json");

    $users["users"][] = $user_data;

    save_data("adatok/felhasznalok.json", $users);
}
function load_data(string $filename): array {
    if (!file_exists($filename))
        die("Nem sikerült a fájl megnyitása!");

    $json_data = file_get_contents($filename);

    return json_decode($json_data, true);
}
function get_user_by_username(string $username): array | null {
    $users = load_data("adatok/felhasznalok.json");
    foreach ($users["users"] as $user)
        if ($user["username"] === $username)
            return $user;

    return null;
}
function save_data(string $filename, array $data): void {
    $json_data = json_encode($data, JSON_PRETTY_PRINT);

    file_put_contents($filename, $json_data);
}


$errors = [];

if (isset($_POST["elkuld"])) {
    $username = $_POST["username"];
    $password = $_POST["passwd"];
    $password_check = $_POST["passwd_check"];
    $birth_date = $_POST["date"];
    $email = $_POST["email"];


    if (trim($username) === "")
        $errors[] = "empty_username";

    if (trim($password) === "")
        $errors[] = "empty_password";

    if (trim($password_check) === "")
        $errors[] = "empty_check_password";

    if (strlen($username) > 50)
        $errors[] = "long_username";

    if (get_user_by_username($username) != null)
        $errors[] = "exist_username";

    if ($password !== "" && strlen($password) < 5)
        $errors[] = "short_password";

    if ($password !== "" && strlen($password) >= 5 && (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)))
        $errors[] = "password_characters";

    if ($password_check !== "" && $password !== $password_check)
        $errors[] = "match_password";

    if ($birth_date > 2023 || $birth_date < 1900)
        $errors[] = "year_out_of_range";

    if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "invalid_email";

    if (count($errors) === 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $user = [
            "username" => $username,
            "password" => $password,
            "birth_date" => $birth_date,
            "email" => trim($email) !== "" ? $email : null,

        ];
        create_user($user);
        header("Location: forum.php");
        exit();
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
    <title>Regisztráció</title>
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
                    <a aria-current="page" href="regisztracio.php">Fórum</a>
                </li>
            </ul>
        </nav>
        <div id="alap">
            <div id="baloszlop">
                <p class="animate-charcter">Mekkora fan vagy?</p>
            </div>
            <div id="focimkep"> 
                <img src="img/shrek-banner.png" alt="jobb kint mint bent" width="1020">
            </div>
        </div>
    </header>
    <hr>
    <main>
        <div id="bejelentkezes">
            <h1>Regisztráció</h1>
            <form  method="POST">
                <input type="text" size="40" name="username" placeholder="Felhasználónév..." value="<?php if (isset($_POST["username"])) echo $_POST["username"]; ?>" required/> <br/><br/>
                <div>
                    <?php
                    if (in_array("empty_username", $errors)) echo "A mező kitöltése kötelező!";
                    if (in_array("long_username", $errors)) echo "A felhasználónév nem lehet hosszabb 50 karakternél!";
                    if (in_array("exist_username", $errors)) echo "A megadott felhasználónév foglalt!";
                    ?>
                </div>
                <input type="email" size="40" name="email" placeholder="Email cím..." required/> <br/><br/>
                <div>
                    <?php
                    if (in_array("invalid_email", $errors)) echo "Az e-mail cím formátuma nem megfelelő!";
                    ?>
                </div>
                <input type="password" size="40" name="passwd" placeholder="Jelszó..." required/> <br/><br/>
                <div >
                    <?php
                    if (in_array("empty_password", $errors)) echo "A mező kitöltése kötelező!";
                    if (in_array("short_password", $errors)) echo "A jelszónak legalább 5 karakter hosszúnak kell lennie!";
                    if (in_array("password_characters", $errors)) echo "A jelszónak tartalmaznia kell betűt és számjegyet is!";
                    ?>
                </div>
                <input type="password" size="40" name="passwd_check" placeholder="Jelszó újra..." required/>
                <div>
                    <?php
                    if (in_array("empty_check_password", $errors)) echo "A mező kitöltése kötelező!";
                    if (in_array("match_password", $errors)) echo "A jelszavak nem egyeznek meg!";
                    ?>
                </div>
                <p>Mikor születtél?</p>
                <input type="date" size="40" name="date" required/> <br/><br/>
                <div>
                    <?php
                    if (in_array("year_out_of_range", $errors)) echo "Az évszámnak 1900 és 2023 között kell lennie!";
                    ?>
                </div>
                <input type="reset" value="Alaphelyzet"/>
                <input type="submit" value="Regisztráció" name="elkuld"/>
                <br><br>Van már fiókod? <a href="forum.php">Bejelentkezés</a>
            </form>
        </div>
    </main>
</body>
</html>