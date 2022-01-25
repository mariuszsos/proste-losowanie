<?php 
include('config.php');
    $id = $_SESSION['id'];
    $msg = "";
    $result = $mysqli -> query("SELECT id, imie, kto, logowanie, ip FROM uzytkownicy WHERE id = ".$id."");
    if( $result -> num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $imie = $row['imie'];
            $kto = $row['kto'];
            $data = $row['logowanie'];
            $ip = $row['ip'];
        }
    }
    if(isset($_POST['losuj'])) {
        $los = $mysqli -> query("SELECT imie FROM uzytkownicy WHERE `wylosowany` = 0");
        if($los->num_rows > 0) {
            $i = 0;
            while($row = $los->fetch_assoc()){
                if($row['imie'] != $imie) {
                    $dostepne[$i] = $row['imie'];
                    $i++;
                }
            }
            $length = sizeof($dostepne);

            $random = rand(0, $length-1);
            $wybrany = $dostepne[$random];
            if($mysqli -> query("UPDATE `uzytkownicy` SET `kto` = '".$wybrany."' WHERE `uzytkownicy`.`id` = ".$id."") === TRUE &&
                $mysqli -> query("UPDATE `uzytkownicy` SET `wylosowany` = '1' WHERE `uzytkownicy`.`imie` = '".$wybrany."'") === TRUE) {
                    $msg = '
                    <div class="w3-panel w3-green">
                        <h3>Losowanie pomyślne!</h3>
                        <p>Automatyczne losowanie wybrało: '.$wybrany.'!</p>
                    </div>';
                    header('Refresh:5');
                }
        }
    }
    $j = 0;
    $ileNielos = 0;
    $wylosowani = $mysqli-> query("SELECT * FROM `uzytkownicy` WHERE `kto` is NULL");
    if($wylosowani->num_rows > 0) {
        while($row = $wylosowani->fetch_assoc()) {
            $nieLos[$j] = $row['imie'];
            $j++;
        }
        $ileNielos = sizeof($nieLos);
    }


?>
<!DOCTYPE html>
<html>
<title>Sprawdz i wylosuj osobę!</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <body>
        <header class="w3-container w3-blue-gray">
        <h1>Zalogowany jako:  <?php echo $_SESSION['login']; ?> </h1>
        </header>

        <div class="w3-container">
            <?php echo $msg; ?>
            <h2>Twoje informacje</h2>
            <p>Tak naprawdę id i imię nie ma znaczenia. Tylko chodzi o to, żebyś zagłosował/-ła jeśli jeszcze tego nie zrb.</p>
            <table class="w3-table-all w3-card-4" style="width: 60%;">
            <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>Ostatnie logowanie</th>
                <th>IP</th>
                <th>Kogo wylosowałeś</th>
            </tr>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $imie; ?></td>
                <td><?php echo $data; ?></td>
                <td><?php echo $ip; ?></td>
                <td><?php if($kto == NULL) { ?>
                            <form method="POST" action="">
                                <input class="w3-input w3-blue-gray" value="Losuj!" type="submit" type="password" name="losuj" style="width:90%" required>    
                            </form>
                        <?php } else { echo $kto; }?>
                </td>
            </tr>
            </table>
            <div>
                    <?php 
                    if($ileNielos < 1) {
                        echo '<h2>Wszyscy zagłosowali!</h2>';
                    } else {
                        echo '<h2>Osoby, które nie zagłosowały: </h2><ul>';
                        for($i=0; $i < $ileNielos; $i++) {
                            echo '<li>'.$nieLos[$i].'</li>';
                        }
                        echo '</ul>';                      
                    }         
                    ?>
            </div>
            <form method="POST" action="wyloguj.php">
                <input class="w3-input w3-blue-gray" type="submit" value="Wyloguj" type="password" style="width: 10%; margin-top: 50px;" required>    
            </form>
            

        </div>
    </body>
</html> 