<?php
    $putanja = dirname($_SERVER['REQUEST_URI']);
    $direktorij = dirname(getcwd());

    require "$direktorij/WebDiP2020x060/klase/baza.class.php";
    require "$direktorij/WebDiP2020x060/klase/sesija.class.php";
    require "$direktorij/WebDiP2020x060/klase/dnevnik.class.php";
    Sesija::kreirajSesiju();
    
    if (!isset($_SESSION["uloga"])) {
        header("Location: prijava.php");
        exit();
    } elseif (isset($_SESSION["uloga"]) && $_SESSION["uloga"] === '3') {
        header("Location: index.php");
        exit();
    }
    
    $log = new Dnevnik();
    if(!strpos($_SERVER['REQUEST_URI'], '?')){
        $log->spremiDnevnik(3, " ");
    }
    
    $ispis = "";
    
    if (!isset($_GET['naziv_kategorije'])) {
        $veza = new Baza();
        $veza->spojiDB();
        $ispis = "<form novalidate name='kategorijedodaj' id='kategorijedodaj' method='get' action='kategorije.php'>"
        . "<label>Naziv kategorije:<br></label>"
        . "<input name='naziv' id='naziv' type='text'/>"
        . "<label><br>Opis kategorije:<br></label>"
        . "<input name='opis' id='opis' type='text'/>"
        . "<input id='submit1' name='dodaj' type='submit' value='Dodaj kategoriju' />"
        . "</form>";
    }
    
    if (isset($_GET['naziv_kategorije']) && !isset($_GET['azuriraj'])) {
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "SELECT ID_kategorija, naziv, opis FROM kategorija_ceste WHERE naziv='{$_GET['naziv_kategorije']}'";
        $rezultat = $veza->selectDB($upit);
        $row = mysqli_fetch_array($rezultat);
        
        $upit2 = "SELECT korisnik.ID_korisnik, korisnik.korisnicko_ime FROM korisnik WHERE ID_uloga=2";
        $rezultat2 = $veza->selectDB($upit2);
        
        $upit3 = "SELECT DISTINCT korisnik.ID_korisnik, korisnik.korisnicko_ime FROM upravlja INNER JOIN korisnik ON upravlja.ID_korisnik = korisnik.ID_korisnik INNER JOIN kategorija_ceste ON upravlja.ID_kategorija = kategorija_ceste.ID_kategorija WHERE korisnik.ID_korisnik > 1 AND kategorija_ceste.naziv = '{$_GET['naziv_kategorije']}'";
        $rezultat3 = $veza->selectDB($upit3);
        
        $ispis = "<form novalidate name='kategorije' id='kategorije' method='get' action='kategorije.php'>"
        . "<input name='IDkategorije' id='IDkategorije' type='hidden' value='{$row['ID_kategorija']}'/>"
        . "<label>Naziv kategorije:<br></label>"
        . "<input name='naziv' id='naziv' type='text' value='{$row['naziv']}'/>"
        . "<label><br>Opis kategorije:<br></label>"
        . "<input name='opis' id='opis' type='text' value='{$row['opis']}'/>"
        . "<input id='submit1' name='azuriraj' type='submit' value='Spremi promjene' />"
        . "<label><br>Dodijeli moderatora:<br></label>"
        . "<select name='slobodnimod' id='slobodnimod' style='width: 100%; margin: 8px 0; height: 41px;'>"
                . "<option selected></option>";
            while ($row2 = mysqli_fetch_array($rezultat2)) {
            $ispis.= "<option value='{$row2["ID_korisnik"]}'>{$row2["korisnicko_ime"]}</option>";
            }
        $ispis.= "</select>"
        . "<label><br>Makni moderatora:<br></label>"
        . "<select name='dodijeljenimod' id='dodijeljenimod' style='width: 100%; margin: 8px 0; height: 41px;'>"
                . "<option selected></option>";
            while ($row3 = mysqli_fetch_array($rezultat3)) {
            $ispis.= "<option value='{$row3["ID_korisnik"]}'>{$row3["korisnicko_ime"]}</option>";
            }
        $ispis.= "</select>"
        . "<input id='submit1' name='moderatori' type='submit' value='Spremi moderatore' />"
        . "</form>";
    }
    
    if(isset($_GET['azuriraj'])){
        $IDkategorije = $_GET['IDkategorije'];
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "UPDATE kategorija_ceste SET "
                    . "naziv = '{$_GET["naziv"]}', "
                    . "opis = '{$_GET["opis"]}' "
                    . "WHERE ID_kategorija = '{$IDkategorije}'";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        header("Location: kategorije.php");
        exit();
    }
    
    if(isset($_GET['dodaj'])){
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "INSERT INTO kategorija_ceste (naziv, opis) VALUES"
                    . "('{$_GET['naziv']}', "
                    . "'{$_GET['opis']}');";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        header("Location: kategorije.php");
        exit();
    }
    
    if(isset($_GET['moderatori']) && $_GET['slobodnimod'] == "" && $_GET['dodijeljenimod'] != ""){
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "DELETE FROM upravlja WHERE "
                    . "ID_korisnik = {$_GET['dodijeljenimod']} AND "
                    . "ID_kategorija = {$_GET['IDkategorije']};";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        header("Location: kategorije.php");
        exit();
    }
    
    if(isset($_GET['moderatori']) && $_GET['slobodnimod'] != "" && $_GET['dodijeljenimod'] == ""){
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "INSERT INTO upravlja (ID_korisnik, ID_kategorija) VALUES ("
                    . "{$_GET['slobodnimod']}, "
                    . "{$_GET['IDkategorije']});";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        header("Location: kategorije.php");
        exit();
    }
    
    if(isset($_GET['moderatori']) && $_GET['slobodnimod'] != "" && $_GET['dodijeljenimod'] != ""){
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "INSERT INTO upravlja (ID_korisnik, ID_kategorija) VALUES ("
                    . "{$_GET['slobodnimod']}, "
                    . "{$_GET['IDkategorije']});";
        $rezultat = $veza->selectDB($upit);
        $log->spremiDnevnik(2, $upit);
        if($rezultat!=null){
            $ispis .="<p style='text-align: center;'>Uspješno dodani moderator</p>";
        }
        $upit2 = "DELETE FROM upravlja WHERE "
                    . "ID_korisnik = {$_GET['dodijeljenimod']} AND "
                    . "ID_kategorija = {$_GET['IDkategorije']};";
        $rezultat2 = $veza->selectDB($upit2);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit2);
        header("Location: kategorije.php");
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
        <title>Kategorije</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Autor">
        <meta name="autor" content="Petar Mihalić">
        <meta name="opis" content="Stranica kreirana 03.6.2021.">
        <meta name="kljucne_rijeci" content="index, pocetna, glavna">
        <link rel="stylesheet" type="text/css" href="css/pmihalic.css">
    </head>
    <body>
        <header>
            <h1 class="naslov"><a href="#sadrzaj">Kategorije cesta</a></h1>
        </header>
        <br>
    <?php
        include 'meni.php';
    ?>  
    <section id="sadrzaj">
        <br>
        <p id="uvod">Ovdje možete prgledavati, kreirati te ažurirati kategorije cesta.</p>
        <?php
            echo "<p style='text-align: center;'>";
            echo $ispis;
            echo "</p>";
        ?>  
        <table>
            <caption><h3>Pregled kategorija cesta</h3></caption>
        <thead>
            <tr>
                <th>Naziv kategorije</th>
                <th>Opis kategorije</th>
                <th>Moderatori</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $veza = new Baza();
            $veza->spojiDB();
            $upit = "SELECT naziv, opis FROM kategorija_ceste";
            $rezultat = $veza->selectDB($upit);
            while($row = mysqli_fetch_array($rezultat)){
            echo "<tr>";
                echo "<td><a href='kategorije.php?naziv_kategorije={$row['naziv']}'>".$row['naziv']."</a></td>";
                echo "<td>".$row['opis']."</td>";
                echo "<td>";
                    $upit2 = "SELECT korisnik.korisnicko_ime FROM upravlja INNER JOIN kategorija_ceste ON kategorija_ceste.ID_kategorija = upravlja.ID_kategorija INNER JOIN korisnik ON upravlja.ID_korisnik = korisnik.ID_korisnik WHERE kategorija_ceste.naziv = '{$row['naziv']}' AND korisnik.ID_korisnik > 1";
                    $rezultat2 = $veza->selectDB($upit2);
                    while($row2 = mysqli_fetch_array($rezultat2)){
                        echo "{$row2['korisnicko_ime']}<br>";
                    }
                echo "</td>";
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

