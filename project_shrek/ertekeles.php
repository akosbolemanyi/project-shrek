<?php
    session_start();
    function load_data(string $filename): array {
        if (!file_exists($filename))
            die("Nem sikerült a fájl megnyitása!");

        $json_data = file_get_contents($filename);

        return json_decode($json_data, true);
    }
    function update_user(string $username, array $updated_user): void {
        $users = load_data("adatok/felhasznalok.json");

        foreach ($users["users"] as &$user) {
            if ($user["username"] === $username) {
                if($updated_user["email"] != "")
                    $user["email"] = $updated_user["email"];
                if($updated_user["password"] != "")
                    $user["password"] = $updated_user["password"];
                break;
            }
        }
        save_data("adatok/felhasznalok.json", $users);
    }
    function save_data(string $filename, array $data): void {
        $json_data = json_encode($data, JSON_PRETTY_PRINT);

        file_put_contents($filename, $json_data);
    }

    if (isset($_POST["kijelentike"])) {
        header("Location: forum.php");
        session_unset();
        session_destroy();
        exit();
    }
    
    if (!isset($_COOKIE['ertekelt'])) {
        $ertekelesek = [0 => 1, 1 => 1, 2 => 1, 3 => 1];
    }
    else {
        $ertekelesek = [
            0 => isset($_COOKIE["ertekeles"]) ? $_COOKIE["ertekeles"] : 1,
            1 => isset($_COOKIE["ertekeles1"]) ? $_COOKIE["ertekeles1"] : 1,
            2 => isset($_COOKIE["ertekeles2"]) ? $_COOKIE["ertekeles2"] : 1,
            3 => isset($_COOKIE["ertekeles3"]) ? $_COOKIE["ertekeles3"] : 1
        ];
    }
    
    if(isset($_GET["ertekeles"])){
        setcookie("ertekelt", true, time() + (60*60*24*30), "/");
        setcookie("ertekeles", $_GET["shrek1"], time() + (60*60*24*30), "/");
        $ertekelesek[0] = $_COOKIE["ertekeles"];
        setcookie("ertekeles1", $_GET["shrek2"], time() + (60*60*24*30), "/");
        $ertekelesek[1] = $_COOKIE["ertekeles1"];
        setcookie("ertekeles2", $_GET["shrek3"], time() + (60*60*24*30), "/");
        $ertekelesek[2] = $_COOKIE["ertekeles2"];
        setcookie("ertekeles3", $_GET["shrek4"], time() + (60*60*24*30), "/");
        $ertekelesek[3] = $_COOKIE["ertekeles3"];
        $ertekelesek = load_data("adatok/ertekelesek.json");
        $ujertekeles = [
            "username" => $_SESSION["user"]["username"],
            "shrek1" => $_GET["shrek1"],
            "shrek2" => $_GET["shrek2"],
            "shrek3" => $_GET["shrek3"],
            "shrek4" => $_GET["shrek4"],
        ];
        $ertekelesek["ertekelesek"][] = $ujertekeles;
        save_data("adatok/ertekelesek.json", $ertekelesek);
        header("Location: ertekeles.php");
        exit;
    }

    $errors = [];
    if(isset($_POST["modosit"])){
        $password = $_POST["passwd"];
        $password_check = $_POST["passwd_check"];
        $email = $_POST["email"];

        if ($password !== "" && strlen($password) < 5)
            $errors[] = "short_password";
        if ($password !== "" && strlen($password) >= 5 && (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)))
            $errors[] = "password_characters";
        if ($password_check !== "" && $password !== $password_check)
            $errors[] = "match_password";
        if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = "invalid_email";

        if (count($errors) === 0) {
            $email = trim($email) !== "" ? $email : null;
            $password = password_hash($password, PASSWORD_DEFAULT);
            $user = ["email" => $email, "password" => $password];
            update_user($_SESSION["user"]["username"], $user);
            $_SESSION["user"]["email"] = $email;
        }
    }
    if(isset($_POST["torles"])){
        $users = load_data("adatok/felhasznalok.json");
        foreach ($users["users"] as $key => $user) {
            if ($user["username"] === $_SESSION["user"]["username"]) {
                unset($users["users"][$key]);
                break;
            }
        }
        save_data("adatok/felhasznalok.json", $users);

        $ertekelesek = load_data("adatok/ertekelesek.json");
        foreach ($ertekelesek["ertekelesek"] as $key => $ertekeles) {
            if ($ertekeles["username"] === $_SESSION["user"]["username"]) {
                unset($ertekelesek["ertekelesek"][$key]);
                break;
            }
        }
        save_data("adatok/ertekelesek.json", $ertekelesek);

        session_unset();
        session_destroy();
        header("Location: forum.php");
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="stilus/stilus.css">
    <link rel = "stylesheet" href="stilus/bejelentkezes.css">

    <link rel="icon" href="img/icon.png">
    <title>Értékelés</title>
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
  <div id="alap2">
    <div id="bal">
        <form method="GET" id="adatok2" >
            <p class="cim">Hány csillagos szerinted?</p>
            
            <label for="shrek1">Shrek 1</label>
            <select name="shrek1" id="shrek1">
              <option value="1" <?php if ($ertekelesek[0] == 1) echo "selected"; ?>>1</option>
              <option value="2" <?php if ($ertekelesek[0] == 2) echo "selected"; ?>>2</option>
              <option value="3" <?php if ($ertekelesek[0] == 3) echo "selected"; ?>>3</option>
              <option value="4" <?php if ($ertekelesek[0] == 4) echo "selected"; ?>>4</option>
              <option value="5" <?php if ($ertekelesek[0] == 5) echo "selected"; ?>>5</option>
            </select>
            <br>
            <br>
            <label for="shrek2">Shrek 2</label>
            <select name="shrek2" id="shrek2">
                <option value="1" <?php if ($ertekelesek[1] == 1) echo "selected"; ?>>1</option>
                <option value="2" <?php if ($ertekelesek[1] == 2) echo "selected"; ?>>2</option>
                <option value="3" <?php if ($ertekelesek[1] == 3) echo "selected"; ?>>3</option>
                <option value="4" <?php if ($ertekelesek[1] == 4) echo "selected"; ?>>4</option>
                <option value="5" <?php if ($ertekelesek[1] == 5) echo "selected"; ?>>5</option>
            </select>
            <br>
            <br>
            
            <label for="shrek3">Harmadik Shrek</label>
            <select name="shrek3" id="shrek3">
                <option value="1" <?php if ($ertekelesek[2] == 1) echo "selected"; ?>>1</option>
                <option value="2" <?php if ($ertekelesek[2] == 2) echo "selected"; ?>>2</option>
                <option value="3" <?php if ($ertekelesek[2] == 3) echo "selected"; ?>>3</option>
                <option value="4" <?php if ($ertekelesek[2] == 4) echo "selected"; ?>>4</option>
                <option value="5" <?php if ($ertekelesek[2] == 5) echo "selected"; ?>>5</option>
            </select>
            <br>
            <br>

            <label for="shrek4">Shrek a vége, fuss el véle</label>
            <select name="shrek4" id="shrek4">
                <option value="1" <?php if ($ertekelesek[3] == 1) echo "selected"; ?>>1</option>
                <option value="2" <?php if ($ertekelesek[3] == 2) echo "selected"; ?>>2</option>
                <option value="3" <?php if ($ertekelesek[3] == 3) echo "selected"; ?>>3</option>
                <option value="4" <?php if ($ertekelesek[3] == 4) echo "selected"; ?>>4</option>
                <option value="5" <?php if ($ertekelesek[3] == 5) echo "selected"; ?>>5</option>
            </select>
            <br>
            <br>

            <input type="submit" value="Értékelés" name="ertekeles">
        </form>
    </div>
    <div id="jobb">
      <form method="POST" id="adatok">
          <p class="cim">Adataim</p>
        <input type="text" size="40" name="username" disabled value="<?php echo $_SESSION["user"]["username"]?>"/> <br/><br/>
        <div>
            <?php
                if (in_array("long_username", $errors)) echo "A felhasználónév nem lehet hosszabb 50 karakternél!";
                if (in_array("exist_username", $errors)) echo "A megadott felhasználónév foglalt!";
            ?>
        </div>
        <input type="email" size="40" name="email" value="<?php echo $_SESSION["user"]["email"]?>"/> <br/><br/>
        <div>
            <?php
                if (in_array("invalid_email", $errors)) echo "Az e-mail cím formátuma nem megfelelő!";
            ?>
        </div>
        <input type="password" size="40" name="passwd" placeholder="Jelszó..." /> <br/><br/>
        <div >
            <?php
                if (in_array("short_password", $errors)) echo "A jelszónak legalább 5 karakter hosszúnak kell lennie!";
                if (in_array("password_characters", $errors)) echo "A jelszónak tartalmaznia kell betűt és számjegyet is!";
            ?>
        </div>
        <input type="password" size="40" name="passwd_check" placeholder="Jelszó újra..." /> 
        <div>
            <?php
                 if (in_array("match_password", $errors)) echo "A jelszavak nem egyeznek meg!";
            ?>
        </div>
        <p>Születési dátum:</p>
        <p><?php echo $_SESSION["user"]["DOB"]?></p>
        <input type="submit" value="Mósosítás" name="modosit"/>
        <input type="submit" value="Fiók törlése" name="torles"/>
        <input type="submit" value="Kijelentkezés" name="kijelentike"/>
        </form>
    </div>
  </div>
  
</main>
</body>
</html>