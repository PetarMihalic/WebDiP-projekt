<?php
    $putanja = dirname($_SERVER['REQUEST_URI']);
    $direktorij = dirname(getcwd());
    
    if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
    header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    exit;
    }

    require "$direktorij/WebDiP2020x060/klase/baza.class.php";
    require "$direktorij/WebDiP2020x060/klase/sesija.class.php";
    require "$direktorij/WebDiP2020x060/klase/dnevnik.class.php";
    
    Sesija::kreirajSesiju();
    
    $log = new Dnevnik();
    if(!strpos($_SERVER['REQUEST_URI'], '?')){
        $log->spremiDnevnik(3, " ");
    }
    
    if (isset($_GET["korisnici"])) {
        header("Location: privatno/korisnici.php");
    }
    
    if (isset($_GET["kopija"])) {
        header("Location: backup.php");
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
        <meta name="kljucne_rijeci" content="index, pocetna, glavna">
        <link rel="stylesheet" type="text/css" href="css/pmihalic.css">
    </head>
    <body>
        <header>
            <h1 class="naslov"><a href="#sadrzaj">Početna stranica</a></h1>
        </header><br>
        
     <?php
    include 'meni.php';
    ?> 
     <form style="float: left; width: 150px; min-width: 160px; background-color: #242424; border: 0px;">
     <fieldset>
      <legend>Dokumentacija:</legend>
      <label><li><a href="dokumenti/dokumentacija.html">Dokumentacija</a></li></label>
      <label><li><a href="dokumenti/autor.html">O autoru</a></li></label>
     </fieldset>
    </form>
    <section id="sadrzaj">
        <br>
        <p id="uvod">Dobrodošli na stranicu za prijavljivanje problema te pračenje stanja na cestama.</p>
        <table>
            <caption><h3>Statistika broja problema</h3></caption>
        <thead>
            <tr>
                <th>Kategoija ceste</th>
                <th>Broj problema</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $veza = new Baza();
            $veza->spojiDB();
            for($i=1;$i<5;$i++){
            $upit = "SELECT COUNT(problem.ID_problem) AS 'Broj problema', kategorija_ceste.naziv FROM problem INNER JOIN cesta ON problem.ID_cesta = cesta.ID_cesta INNER JOIN kategorija_ceste ON cesta.ID_kategorija = kategorija_ceste.ID_kategorija WHERE kategorija_ceste.ID_kategorija = {$i}";
            $rezultat = $veza->selectDB($upit);
            $row = mysqli_fetch_array($rezultat);
            echo "<tr>";
                echo "<td>".$row['naziv']."</td>";
                echo "<td>".$row['Broj problema']."</td>";
            echo"</tr>";
            }
            ?>
        </tbody>
    </table>
        <br>
        <form novalidate name='sigkopija' id='sigkopija' method='get' action='index.php'>
        <?php
            if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] === '1') {
                echo "<input id='submit1' name='kopija' type='submit' value='Generiraj i preuzmi sigurnosnu kopiju'/>";
        }
        ?>  
            <input id='submit1' name='korisnici' type='submit' value='Popis korisnika'/>
        </form>
    </section>
    <footer>
    </footer>
    </body>
</html>
