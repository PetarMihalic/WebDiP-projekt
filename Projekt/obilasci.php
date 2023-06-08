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
        
    
    if (!isset($_GET['ID']) && !isset($_GET['obrisi'])) {
        $ispis = "Odaberite oznaku dionice u redu kojeg želi obrisati";
    }
    
    if (isset($_GET['ID']) && !isset($_GET['obrisi'])) {
        $ispis = "<form novalidate name='brisanje' id='brisanje' method='get' action='obilasci.php'>"
        . "<label>Jeste li sigurni da želite obrisati obilazak?</label><br>"
        . "<input name='iddolazak' id='iddolazak' type='hidden' value='{$_GET["ID"]}'/>"
        . "<input id='submit1' name='obrisi' type='submit' value='Obrisi obilazak' />"
        . "</form>";
    }
    
    if(isset($_GET['obrisi'])){
        $ID = $_GET['iddolazak'];
        $veza = new Baza();
        $veza->spojiDB();
        $row = mysqli_fetch_array($rezultat);
        $upit = "DELETE FROM obilazak "
                    . "WHERE obilazak_ID = {$ID}";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        if($rezultat!=null){
            $ispis="Uspješno obrisano!";
        }
        header("Location: obilasci.php?poruka={$ispis}");
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
        <title>Obilasci</title>
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
            <h1 class="naslov"><a href="#sadrzaj">Moji obilasci</a></h1>
        </header>
        <br>
    <?php
        include 'meni.php';
    ?>  
    <section id="sadrzaj">
        <br>
        <p id="uvod">Ovdje možete vidjeti popis svih vaših obilazaka te broj ukupno prijeđenih kilometara.</p><br>
        <?php
            echo "<p style='text-align: center;'>";
            echo $ispis;
            echo "</p>";
        ?> 
        <table>
            <caption><h3>Popis obilazaka</h3></caption>
        <thead>
            <tr>
                <th>Oznaka dionice</th>
                <th>Početna dionica</th>
                <th>Završna dionica</th>
                <th>Datum i vrijeme prijave</th>
                <th>Udaljenost (km)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $veza = new Baza();
            $veza->spojiDB();
            $upit = "SELECT obilazak.obilazak_ID, cesta.oznaka, cesta.pocetak_dionice, cesta.zavrsetak_dionice, obilazak.datum_vrijeme_pocetka, cesta.broj_kilometara "
                    . "from cesta "
                    . "INNER JOIN obilazak ON cesta.ID_cesta = obilazak.ID_cesta "
                    . "INNER JOIN korisnik ON obilazak.ID_korisnik=korisnik.ID_korisnik "
                    . "WHERE korisnik.korisnicko_ime = '{$_SESSION[Sesija::KORISNIK]}'";
            $rezultat = $veza->selectDB($upit);
            while($row = mysqli_fetch_array($rezultat)){
            echo "<tr>";
                echo "<td><a href='obilasci.php?ID={$row['obilazak_ID']}'>".$row['oznaka']."</a></td>";
                echo "<td>".$row['pocetak_dionice']."</td>";
                echo "<td>".$row['zavrsetak_dionice']."</td>";
                echo "<td>".$row['datum_vrijeme_pocetka']."</td>";
                echo "<td>".$row['broj_kilometara']."</td>";
            echo"</tr>";
            }
            $upit = "SELECT SUM(cesta.broj_kilometara) AS suma FROM cesta INNER JOIN obilazak ON cesta.ID_cesta = obilazak.ID_cesta INNER JOIN korisnik ON obilazak.ID_korisnik=korisnik.ID_korisnik WHERE korisnik.korisnicko_ime = '{$_SESSION[Sesija::KORISNIK]}'";
            $rezultat = $veza->selectDB($upit);
            $row = mysqli_fetch_array($rezultat)
            ?>
        </tbody>
        <tfoot>
            <tr id="footerTablice">
                <?php
                    echo"<td colspan='5'>Ukupni broj prijeđenih kilometara: ".$row['suma']."</td>";
                ?>
            </tr>
        </tfoot>
    </table>
    </section>
    <footer>
    </footer>
    </body>
</html>

