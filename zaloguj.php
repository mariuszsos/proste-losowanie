<?php
include('config.php');
if (isset($_POST['loguj']))
{
    $login = $_POST['login'];
    $haslo =$_POST['haslo'];
    $ip = $_SERVER['REMOTE_ADDR'];

    // sprawdzamy czy login i hasło są dobre
    if ($result = $mysqli -> query("SELECT id, imie, haslo FROM uzytkownicy WHERE imie = '".$login."' AND haslo = '".md5($haslo)."'")) {
        if( $result -> num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $_SESSION['id'] = $row['id'];
            }
            $data = date('l jS \of F Y h:i:s A');
            $sqlUpdate = "UPDATE `uzytkownicy` SET `logowanie` = '".$data."', `ip` = '".$ip."' WHERE `uzytkownicy`.`imie` = '".$login."'";
            $mysqli ->query($sqlUpdate);
            //$mysqli -> query("UPDATE `uzytkownicy` SET (`logowanie` = '".time().", `ip` = '".$ip."'') WHERE imie = '".$login."';");
            $_SESSION['login'] = $login;
            header('location: witaj.php');

        } else {
            session_destroy();
            echo '
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <header class="w3-container w3-blue-gray">
            <h1>Logowanie nie powiodło się</h1>
            </header>
            <div class="w3-container w3-half w3-margin-top">
                <div class="w3-panel w3-red">
                <h3>Nieprawidłowe dane!!</h3>
                <p>Nie próbuj łamać innych haseł to ma być zabawa</p>
                <p><a href="index.php">Wróć</a></p>
                </div> 
            </div>
            ';
        }  
    }
}
?>