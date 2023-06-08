<?php
    $putanja = dirname($_SERVER['REQUEST_URI'], 2);
    $direktorij = dirname(getcwd());

    require "$direktorij/klase/baza.class.php";
    require "$direktorij/klase/sesija.class.php";
    require "$direktorij/klase/dnevnik.class.php";
    
    Sesija::kreirajSesiju();
    $log = new Dnevnik();
    if(!strpos($_SERVER['REQUEST_URI'], '?')){
        $log->spremiDnevnik(3, " ");
    }
    
    $ispis ="";
    
    if (isset($_GET['korime']) && !isset($_GET['spremi'])) {
        $veza = new Baza();
        $veza->spojiDB();
        
        
        $upit2 = "SELECT status, korisnicko_ime FROM korisnik WHERE korisnicko_ime='{$_GET['korime']}'";
        $rezultat2 = $veza->selectDB($upit2);
        $row = mysqli_fetch_array($rezultat2);
        $ispis = "<form novalidate name='upravljanje' id='upravljanje' method='get' action='korisnici.php'>"
        . "<label>Odabrali ste korisnika {$row['korisnicko_ime']}</label>"
        . "<input name='korime' id='korime' type='hidden' value='{$row['korisnicko_ime']}'/>"
        . "<label><br><br>Status računa odabranog korisnika:<br></label>"
        . "<select name='status' id='status' style='width: 100%; margin: 8px 0; height: 41px; padding: 12px 16px;'>"
            . "<option value='0' ".(($row['status'] === '0') ? "selected" : '').">Otključan</option>"
            . "<option value='1' ".(($row['status'] === '1') ? 'selected' : '').">Blokiran</option>"
        . "</select>"
        . "<input id='submit1' name='spremi' type='submit' value='Spremi promjene' />"
        . "</form>";
        $veza->zatvoriDB();
    }
    
    if(isset($_GET['spremi'])){
        $veza = new Baza();
        $veza->spojiDB();
        $row = mysqli_fetch_array($rezultat);
        $upit = "UPDATE korisnik SET "
                    . "status = '{$_GET["status"]}' "
                    . "WHERE korisnicko_ime = '{$_GET["korime"]}'";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        if($rezultat!=null){
            $ispis="Uspješno ažurirano!";
        }
        header("Location: korisnici.php?poruka={$ispis}");
        exit();
    }
    
    if(isset($_GET['poruka'])){
        $ispis = $_GET['poruka'];
    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="hr">
    <head>
        <title>Popis korisnika</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Autor">
        <meta name="autor" content="Petar Mihalić">
        <meta name="opis" content="Stranica kreirana 03.6.2021.">
        <meta name="kljucne_rijeci" content="index, pocetna, glavna">
        <link rel="stylesheet" type="text/css" href="../css/pmihalic.css">
    </head>
    <body>
        <header>
            <h1 class="naslov"><a href="#sadrzaj">Popis korisnika</a></h1>
        </header>
        <br>
    <?php
        include '../meni.php';
    ?>  
    <section id="sadrzaj">
        <?php
            echo "<p style='text-align: center;'>";
            echo $ispis;
            echo "</p>";
        ?>  
        <br>
        <table>
            <caption><h3>Popis korisnika</h3></caption>
        <thead>
            <tr>
                <th>Korisničko ime</th>
                <th>Prezime</th>
                <th>Ime</th>
                <th>Email</th>
                <th>Lozinka</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $veza = new Baza();
            $veza->spojiDB();
            $upit = "SELECT * FROM korisnik";
            $rezultat = $veza->selectDB($upit);
            while($row = mysqli_fetch_array($rezultat)){
            echo "<tr>";
                if(isset($_SESSION["uloga"]) && $_SESSION["uloga"] === '1'){
                    echo "<td><a href='korisnici.php?korime={$row['korisnicko_ime']}'>".$row['korisnicko_ime']."</a></td>";
                }else{
                    echo "<td>".$row['korisnicko_ime']."</td>";
                }
                echo "<td>".$row['prezime']."</td>";
                echo "<td>".$row['ime']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['lozinka']."</td>";
            echo"</tr>";
            }
            ?>
        </tbody>
    </table>
    </section>
    <footer>
    </footer>
    </body>
</html>