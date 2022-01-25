<?php
    include('config.php');
?>
<!DOCTYPE html>
<html>
<title>Zaloguj się</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <body>
        <header class="w3-container w3-blue-gray">
        <h1>Losowanie prezentów</h1>
        </header>
        <div class="w3-container w3-half w3-margin-top">
            <form class="w3-container w3-card-4" method="POST" action="zaloguj.php">
                <p>
                <select class="w3-select" style="width:90%" name="login">
                <option value="Mariusz Sosnowski" disabled selected>Wybierz swój login</option>
                <?php
                    $sql = "SELECT imie FROM `uzytkownicy`";
                    $query = $mysqli -> query($sql);
                    if( $query -> num_rows > 0) {
                        while($row = $query->fetch_assoc()) {
                            $name = $row['imie'];
                            echo '<option value="'.$name.'">'.$name.'</option>';
                        }
                    }
                ?>
                </select></p>

                <p>
                <input class="w3-input" type="password" name="haslo" style="width:90%" required>
                <label>Hasło</label></p>

                <p>
                <input class="w3-button w3-section w3-blue-gray w3-ripple" type="submit" value="Zaloguj" name="loguj">
            </form>
        </div>
    </body>
</html> 

