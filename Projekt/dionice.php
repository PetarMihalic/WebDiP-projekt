<?php
    $putanja = dirname($_SERVER['REQUEST_URI']);
    $direktorij = dirname(getcwd());

    require "$direktorij/WebDiP2020x060/klase/baza.class.php";
    require "$direktorij/WebDiP2020x060/klase/sesija.class.php";
    require "$direktorij/WebDiP2020x060/klase/dnevnik.class.php";
    Sesija::kreirajSesiju();
    
    $log = new Dnevnik();
    if(!strpos($_SERVER['REQUEST_URI'], '?')){
        $log->spremiDnevnik(3, " ");
    }
    
    
    $ispis = null;
    if (isset($_GET['oznaka']) && !isset($_GET['submitdodaj'])) {
        $oznaka = $_GET['oznaka'];
        
        $veza = new Baza();
        $veza->spojiDB();
        
        $korisnik = $_SESSION[Sesija::KORISNIK];
        $upit1 = "SELECT ID_korisnik"
                . " FROM korisnik"
                . " WHERE korisnicko_ime = '{$korisnik}'";
        $rezultat1 = $veza->selectDB($upit1);
        $row1 = mysqli_fetch_array($rezultat1);
        $IDkorisnika = $row1["ID_korisnik"];
        
        $upit = "SELECT cesta.stanje, kategorija_ceste.naziv "
                . "FROM cesta "
                . "INNER JOIN kategorija_ceste ON cesta.ID_kategorija = kategorija_ceste.ID_kategorija "
                . "WHERE cesta.oznaka = '{$oznaka}'";
        $rezultat = $veza->selectDB($upit);
        $row = mysqli_fetch_array($rezultat);
        $upit2 ="SELECT DISTINCT kategorija_ceste.naziv "
                    . "FROM kategorija_ceste "
                    . "INNER JOIN upravlja ON upravlja.ID_kategorija = kategorija_ceste.ID_kategorija "
                    . "WHERE upravlja.ID_korisnik = {$IDkorisnika}";
        $rezultat2 = $veza->selectDB($upit2);
        $veza->zatvoriDB();
        while ($row2 = mysqli_fetch_array($rezultat2)) {
            $kategorije[] = $row2['naziv'];
        }
        $ispis = "<form novalidate name='odabir' id='odabir' method='get' action='dionice.php'>"
        . "<label>Odabrali ste dionicu {$oznaka}</label>"
        . "<input name='oznaka' id='oznaka' type='hidden' value='{$oznaka}'/>";
        if(isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 3 && !in_array($row['naziv'], $kategorije)){
            $ispis .= "<label>, nemate pravo za ažuriranje dionice pod kategorijom '{$row['naziv']}'</label>";
        }
        if(isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 3 && $row['stanje'] === 'zatvorena'){
            $ispis .= "<label>, zatvorena je</label>";
        }
        if(isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 4 && $row['stanje'] === 'otvorena'){
            $ispis.= "<input id='submit1' name='dodajobilazak' type='submit' value='Dodaj obilazak' />";
            $ispis.= "<input id='submit1' name='prijaviproblemforma' type='submit' value='Prijavi problem' />";
        }
        if(isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 3 && in_array($row['naziv'], $kategorije)){
        $ispis .= "<input id='submit1' name='azurirajdionicuforma' type='submit' value='Ažuriraj dionicu' />";
        }
        $ispis .= "</form>";
    }
    if(!isset($_GET['oznaka']) && isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 3){
        $ispis = "<form novalidate name='odabir' id='odabir' method='get' action='dionice.php'>"
               . "<input id='submit1' name='dodajdionicuforma' type='submit' value='Dodaj dionicu' /></form>";
    }
    
    if(isset($_GET['prijaviproblemforma'])){
        $oznaka = $_GET['oznaka'];
        $ispis = "<form novalidate name='odabir' id='odabir' method='get' action='dionice.php'>"
        . "<label>Odabrali ste dionicu {$oznaka}</label>"
        . "<input name='oznaka' id='oznaka' type='hidden' value='{$oznaka}'/>"
        . "<label><br><br>Naziv problema</label>"
        . "<input name='naziv' id='naziv' type='text'/><br>"
        . "<label>Opis problema</label>"
        . "<input name='opis' id='opis' type='text'/><br>"
        . "<label>Datum i vrijeme</label>"
        . "<br><input name='datumivrijeme' id='datumivrijeme' type='datetime-local'/><br>"
        . "<input id='submit1' name='prijaviproblem' type='submit' value='Prijavi problem' /></form>";
    }
    
    if(isset($_GET['prijaviproblem'])){
        $veza = new Baza();
            $veza->spojiDB();
            $oznaka = $_GET['oznaka'];
            $upit = "SELECT ID_cesta"
                    . " FROM cesta"
                    . " WHERE oznaka = '{$oznaka}'";
            $rezultat = $veza->selectDB($upit);
            $row = mysqli_fetch_array($rezultat);
            $IDceste = $row["ID_cesta"];
            
            $korisnik = $_SESSION[Sesija::KORISNIK];
            $upit2 = "SELECT ID_korisnik"
                    . " FROM korisnik"
                    . " WHERE korisnicko_ime = '{$korisnik}'";
            $rezultat2 = $veza->selectDB($upit2);
            $row2 = mysqli_fetch_array($rezultat2);
            $IDkorisnika = $row2["ID_korisnik"];
            $upit3 = "INSERT INTO problem (naziv, opis, datum_vrijeme, ID_korisnik, ID_cesta) VALUES"
                    . "('{$_GET["naziv"]}', "
                    . "'{$_GET["opis"]}', "
                    . "'{$_GET["datumivrijeme"]}', "
                    . "{$IDkorisnika}, "
                    . "{$IDceste});";
            $rezultat3 = $veza->selectDB($upit3);
            $veza->zatvoriDB();
            $log->spremiDnevnik(2, $upit3);
            
            if($rezultat3 != null){
                $ispis = "Prijava problema je uspješno poslana";
            }
            header("Location: dionice.php?poruka={$ispis}");
            exit();
    }
    
    if(isset($_GET['azurirajdionicuforma'])){
            $ispis ="";
            $veza = new Baza();
            $veza->spojiDB();
            $oznaka = $_GET['oznaka'];
            
            $upit = "SELECT * FROM cesta"
                    . " WHERE oznaka = '{$oznaka}'";
            $rezultat = $veza->selectDB($upit);
            $row = mysqli_fetch_array($rezultat);
            
            $korisnik = $_SESSION[Sesija::KORISNIK];
            $upit1 = "SELECT ID_korisnik"
                    . " FROM korisnik"
                    . " WHERE korisnicko_ime = '{$korisnik}'";
            $rezultat1 = $veza->selectDB($upit1);
            $row1 = mysqli_fetch_array($rezultat1);
            $IDkorisnika = $row1["ID_korisnik"];
            
            $upit2 ="SELECT DISTINCT kategorija_ceste.naziv, kategorija_ceste.ID_kategorija "
                    . "FROM kategorija_ceste "
                    . "INNER JOIN upravlja ON upravlja.ID_kategorija = kategorija_ceste.ID_kategorija "
                    . "WHERE upravlja.ID_korisnik = {$IDkorisnika}";
            $rezultat2 = $veza->selectDB($upit2);
            
        $ispis = "<form novalidate name='odabir' id='odabir' method='get' action='dionice.php'>"
        . "<label>Odabrali ste dionicu {$oznaka}<br><br></label>"
        . "<input name='oznaka' id='oznaka' type='hidden' value='{$oznaka}'/>"
        . "<label>Kategorija<br></label>"
        . "<select name='kategorija' id='kategorija' style='width: 100%; margin: 8px 0; height: 41px; padding: 12px 16px;'>";
            while ($row2 = mysqli_fetch_array($rezultat2)) {
            $ispis.= "<option value='{$row2["naziv"]}' ".(($row['ID_kategorija'] === $row2['ID_kategorija']) ? "selected" : '').">{$row2["naziv"]}</option>";
            }
        $ispis.= "</select>"
        . "<label>Naziv početka dionice</label>"
        . "<input name='poc' id='poc' type='text' value='{$row['pocetak_dionice']}'/><br>"
        . "<label>Naziv završetka dionice</label>"
        . "<input name='zav' id='zav' type='text' value='{$row['zavrsetak_dionice']}'/><br>"
        . "<label>Broj kilometara</label>"
        . "<input name='brkm' id='brkm' type='number' step='0.01' min='0.01' value='{$row['broj_kilometara']}'/><br>"
        . "<label>Stanje odabrane dionice:<br></label>"
        . "<select name='stanje' id='stanje' style='width: 100%; margin: 8px 0; height: 41px; padding: 12px 16px;'>"
            . "<option value='otvorena' ".(($row['stanje'] === 'otvorena') ? "selected" : '').">Otvorena</option>"
            . "<option value='zatvorena' ".(($row['stanje'] === 'zatvorena') ? 'selected' : '').">Zatvorena</option>"
        . "</select>"
        . "<input id='submit1' name='azurirajdionicu' type='submit' value='Ažuriraj dionicu' /></form>";
        $veza->zatvoriDB();
    }
    
    if (isset($_GET['azurirajdionicu'])) {
        $oznaka = $_GET['oznaka'];
        $veza = new Baza();
        $veza->spojiDB();
        $spoj = "SELECT ID_kategorija FROM kategorija_ceste "
                . "WHERE naziv = '{$_GET["kategorija"]}'";
        $rezultat = $veza->selectDB($spoj);
        $row = mysqli_fetch_array($rezultat);
        $upit = "UPDATE cesta SET "
                    . "pocetak_dionice = '{$_GET["poc"]}', "
                    . "zavrsetak_dionice = '{$_GET["zav"]}', "
                    . "broj_kilometara = '{$_GET["brkm"]}', "
                    . "stanje = '{$_GET["stanje"]}', "
                    . "ID_kategorija = {$row['ID_kategorija']} "
                    . "WHERE oznaka = '{$oznaka}'";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        if($rezultat!=null){
            $ispis="Uspješno ažurirano!";
        }
        header("Location: dionice.php?poruka={$ispis}");
        exit();
    }
    
    if(isset($_GET['dodajdionicuforma'])){
        $veza = new Baza();
        $veza->spojiDB();
        $korisnik = $_SESSION[Sesija::KORISNIK];
        $upit1 = "SELECT ID_korisnik"
                . " FROM korisnik"
                . " WHERE korisnicko_ime = '{$korisnik}'";
        $rezultat1 = $veza->selectDB($upit1);
        $row1 = mysqli_fetch_array($rezultat1);
        $IDkorisnika = $row1["ID_korisnik"];
        $upit2 ="SELECT DISTINCT kategorija_ceste.naziv "
                    . "FROM kategorija_ceste "
                    . "INNER JOIN upravlja ON upravlja.ID_kategorija = kategorija_ceste.ID_kategorija "
                    . "WHERE upravlja.ID_korisnik = {$IDkorisnika}";
        $rezultat2 = $veza->selectDB($upit2);
        $ispis = "<form novalidate name='odabir' id='odabir' method='get' action='dionice.php'>"
        . "<label>Kategorija<br></label>"
        . "<select name='kategorija' id='kategorija' style='width: 100%; margin: 8px 0; height: 41px;'>";
            while ($row2 = mysqli_fetch_array($rezultat2)) {
            $ispis.= "<option value='{$row2["naziv"]}'>{$row2["naziv"]}</option>";
            }
        $ispis.= "</select>"
        . "<label><br>Oznaka dionice</label>"
        . "<input name='oznaka' id='oznaka' type='text'/><br>"
        . "<label>Naziv početka dionice</label>"
        . "<input name='poc' id='poc' type='text'/><br>"
        . "<label>Naziv završetka dionice</label>"
        . "<input name='zav' id='zav' type='text'/><br>"
        . "<label>Broj kilometara</label>"
        . "<input name='brkm' id='brkm' type='number' step='0.01' min='0.01'/><br>"
        . "<input id='submit1' name='dodajdionicu' type='submit' value='Dodaj dionicu' /></form>";
    }
    
    if (isset($_GET['dodajdionicu'])) {
        $oznaka = $_GET['oznaka'];
        $veza = new Baza();
        $veza->spojiDB();
        $spoj = "SELECT ID_kategorija FROM kategorija_ceste "
                . "WHERE naziv = '{$_GET["kategorija"]}'";
        var_dump($spoj);
        $rezultat = $veza->selectDB($spoj);
        $row = mysqli_fetch_array($rezultat);
        $upit = "INSERT INTO cesta (oznaka, pocetak_dionice, zavrsetak_dionice, broj_kilometara, stanje, ID_kategorija) VALUES "
                    . "('{$_GET["oznaka"]}', "
                    . "'{$_GET["poc"]}', "
                    . "'{$_GET["zav"]}', "
                    . "{$_GET["brkm"]}, "
                    . "'otvorena', "
                    . "{$row['ID_kategorija']});";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        if($rezultat!=null){
            $por="Uspješno dodano!";
        }
        header("Location: dionice.php?poruka={$por}");
        exit();
    }
    
    if(isset($_GET['poruka'])){
        $ispis = $_GET['poruka'];
    }
    
    if (isset($_GET['dodajobilazak'])) {
            $veza = new Baza();
            $veza->spojiDB();
            $oznaka = $_GET['oznaka'];
            $upit = "SELECT ID_cesta"
                    . " FROM cesta"
                    . " WHERE oznaka = '{$oznaka}'";
            $rezultat = $veza->selectDB($upit);
            $row = mysqli_fetch_array($rezultat);
            $IDceste = $row["ID_cesta"];
            
            $korisnik = $_SESSION[Sesija::KORISNIK];
            $upit2 = "SELECT ID_korisnik"
                    . " FROM korisnik"
                    . " WHERE korisnicko_ime = '{$korisnik}'";
            $rezultat2 = $veza->selectDB($upit2);
            $row2 = mysqli_fetch_array($rezultat2);
            $IDkorisnika = $row2["ID_korisnik"];
            
            
            $upit3 = "INSERT INTO obilazak (ID_korisnik, ID_cesta) VALUES"
                    . "({$IDkorisnika}, "
                    . "{$IDceste});";
            $rezultat = $veza->selectDB($upit3);
            $veza->zatvoriDB();
            $log->spremiDnevnik(2, $upit3);
            header("Location: obilasci.php");
            exit(); 
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
        <title>Početna stranica</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Autor">
        <meta name="autor" content="Petar Mihalić">
        <meta name="opis" content="Stranica kreirana 03.6.2021.">
        <meta name="kljucne_rijeci" content="dionice, ceste, popis">
        <link rel="stylesheet" type="text/css" href="css/pmihalic.css">
    </head>
    <body>
        <header>
            <h1 class="naslov"><a href="#sadrzaj">Dionice</a></h1>
        </header>
        <br>
    <?php
        include 'meni.php';
    ?>  
    <section id="sadrzaj">
        <br>
        <p id="uvod">Ovdje možete vidjeti popis svih dionica, njihove oznake, početnu i završnu dionicu grupnirano po kateogrijama.</p>
        <?php
            echo "<p style='text-align: center;'>";
            echo $ispis;
            echo "</p>";
        ?>  
        <table>
            <caption><h3>Popis dionica</h3></caption>
        <thead>
            <tr>
                <th>Oznaka</th>
                <th>Početna dionica</th>
                <th>Završna dionica</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $veza = new Baza();
            $veza->spojiDB();
            for($i=1;$i<10;$i++){
            $grupa = true;
            $upit = "SELECT cesta.oznaka, cesta.pocetak_dionice, cesta.zavrsetak_dionice,kategorija_ceste.naziv, cesta.stanje"
                    . " FROM cesta"
                    . " INNER JOIN kategorija_ceste ON kategorija_ceste.ID_kategorija = cesta.ID_kategorija"
                    . " WHERE kategorija_ceste.ID_kategorija = {$i}"
                    . " ORDER BY cesta.oznaka";
            $rezultat = $veza->selectDB($upit);
            while($row = mysqli_fetch_array($rezultat)){
            if($grupa){
            echo "<tr>";
                echo "<td colspan='3'>".$row['naziv']."</td>";
            echo"</tr>";
            $grupa = false;
            }
            echo "<tr>";
                if((isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 3) ||  (isset($_SESSION["uloga"]) && $row['stanje'] === 'otvorena')){
                    echo "<td><a href='dionice.php?oznaka={$row['oznaka']}'>".$row['oznaka']."</a></td>";
                }
                else {
                    echo "<td>".$row['oznaka']."</td>";
                }
                echo "<td>".$row['pocetak_dionice']."</td>";
                echo "<td>".$row['zavrsetak_dionice']."</td>";
            echo"</tr>";
            }
            }
            ?>
        </tbody>
        <tfoot>
            <tr id="footerTablice">
                <!--<td colspan="9">Za prijavu problema potrebno je .</td>-->
            </tr>
        </tfoot>
    </table>
        <br>
        <form novalidate name="dionice" id="dionice" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="box-sizing: border-box; float: left; width: 25%; margin-left: 5%; margin-right: 1%;" >
            <label for="pocetak">Pocetak dionice: </label>
            <input name="pocetak" id="pocetak" type="text" placeholder="Unesite mjesto"/><br>
            <label for="zavrsetak">Završetak dionice: </label>
            <input name="zavrsetak" id="zavrsetak" type="text" placeholder="Unesite mjesto"/><br>
            <input id="submit1" name="submit" type="submit" value="Pretraži" />
        </form>
        <?php
        if (isset($_GET['submit'])) {
            $veza = new Baza();
            $veza->spojiDB();
            $pocetak = $_GET['pocetak'];
            $zavrsetak = $_GET['zavrsetak'];
            $upit = "SELECT oznaka, broj_kilometara FROM cesta WHERE "
                    . "`pocetak_dionice`='{$pocetak}' AND "
                    . "`zavrsetak_dionice`='{$zavrsetak}' AND"
                    . "`stanje`='otvorena'";
            $rezultat = $veza->selectDB($upit);
            $log->spremiDnevnik(2, $upit);
            echo "<table style='box-sizing: border-box; float: left; width: 64%;'><thead><tr>";
            echo "<th>Oznaka</th>";
            echo "<th>Broj kilometara</th></tr></thead><tbody>";
            while($row = mysqli_fetch_array($rezultat)){
            echo "<tr>";
                if(isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 4){
                    echo "<td><a href='dionice.php?oznaka={$row['oznaka']}'>".$row['oznaka']."</a></td>";
                }
                else {
                    echo "<td>".$row['oznaka']."</td>";
                }
                echo "<td>".$row['broj_kilometara']."</td>";
            echo"</tr>";
            }
            echo "</tbody></table>";
            }
        ?>
    </section>
    <footer>
    </footer>
    </body>
</html>
