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
    
    $ispis="";
    
    $veza = new Baza();
    $veza->spojiDB();
    $upit = "SELECT cesta.oznaka, problem.naziv, problem.opis, problem.datum_vrijeme, korisnik.korisnicko_ime "
            . "FROM problem "
            . "INNER JOIN cesta ON problem.ID_cesta = cesta.ID_cesta "
            . "INNER JOIN korisnik ON problem.ID_korisnik = korisnik.ID_korisnik "
            . "ORDER BY 4 DESC";
    $rezultat = $veza->selectDB($upit);
    
    if (isset($_GET['oznaka']) && !isset($_GET['spremi'])) {
        $oznaka = $_GET['oznaka'];
        
        $upit2 = "SELECT stanje FROM cesta WHERE oznaka='{$_GET['oznaka']}'";
        $rezultat2 = $veza->selectDB($upit2);
        $row = mysqli_fetch_array($rezultat2);
        $ispis = "<form novalidate name='moderiranje' id='moderiranje' method='get' action='problemi.php'>"
        . "<label>Odabrali ste dionicu {$oznaka}</label>"
        . "<input name='oznaka' id='oznaka' type='hidden' value='{$oznaka}'/>"
        . "<label><br><br>Stanje odabrane dionice:<br></label>"
        . "<select name='stanje' id='stanje' style='width: 100%; margin: 8px 0; height: 41px; padding: 12px 16px;'>"
            . "<option value='otvorena' ".(($row['stanje'] === 'otvorena') ? "selected" : '').">Otvorena</option>"
            . "<option value='zatvorena' ".(($row['stanje'] === 'zatvorena') ? 'selected' : '').">Zatvorena</option>"
        . "</select>"
        . "<input id='submit1' name='spremi' type='submit' value='Spremi promjene' />"
        . "</form>";
    }
    
    if(isset($_GET['spremi'])){
        $oznaka = $_GET['oznaka'];
        $veza = new Baza();
        $veza->spojiDB();
        $row = mysqli_fetch_array($rezultat);
        $upit = "UPDATE cesta SET "
                    . "stanje = '{$_GET["stanje"]}' "
                    . "WHERE oznaka = '{$oznaka}'";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        if($rezultat!=null){
            $ispis="Uspješno ažurirano!";
        }
        header("Location: problemi.php?poruka={$ispis}");
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
        <title>Problemi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Autor">
        <meta name="autor" content="Petar Mihalić">
        <meta name="opis" content="Stranica kreirana 03.6.2021.">
        <meta name="kljucne_rijeci" content="problem, popis, cesta">
        <link rel="stylesheet" type="text/css" href="css/pmihalic.css">
    </head>
    <body>
        <header>
            <h1 class="naslov"><a href="#sadrzaj">Popis problema</a></h1>
        </header>
        <br>
    <?php
        include 'meni.php';
    ?>  
    <section id="sadrzaj">
        <br>
        <?php
            echo "<p style='text-align: center;'>";
            echo $ispis;
            echo "</p>";
        ?>  
        <table>
            <caption><h3>Popis svih prijavljenih problema</h3></caption>
        <thead>
            <tr>
                <th>Oznaka dionice</th>
                <th>Naziv problema</th>
                <th>Opis problema</th>
                <th>Datum prijave</th>
                <th>Korisnik</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($row = mysqli_fetch_array($rezultat)){
            echo "<tr>";
                echo "<td><a href='problemi.php?oznaka={$row['oznaka']}'>".$row['oznaka']."</a></td>";
                echo "<td>".$row['naziv']."</td>";
                echo "<td>".$row['opis']."</td>";
                echo "<td>".$row['datum_vrijeme']."</td>";
                echo "<td>".$row['korisnicko_ime']."</td>";
            echo"</tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr id="footerTablice">
                <!--<td colspan="9">Za prijavu problema potrebno je .</td>-->
            </tr>
        </tfoot>
    </table>
    </section>
    <footer>
    </footer>
    </body>
</html>
