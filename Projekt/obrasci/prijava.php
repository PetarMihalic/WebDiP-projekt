<?php
    $putanja = dirname($_SERVER['REQUEST_URI'], 2);
    $direktorij = dirname(getcwd());
    
    if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    exit;
    }

    require "$direktorij/klase/baza.class.php";
    require "$direktorij/klase/sesija.class.php";
    require "$direktorij/klase/dnevnik.class.php";
    Sesija::kreirajSesiju();
    
    $log = new Dnevnik();
    if(!strpos($_SERVER['REQUEST_URI'], '?')){
        $log->spremiDnevnik(1, " ");
    }

    if (isset($_SESSION["uloga"])) {
        $log->spremiDnevnik(1, " ");
        Sesija::obrisiSesiju();
    }

    if (isset($_GET['submit'])) {
        //var_dump($_GET);
        $greska = "";
        $poruka = "";
        foreach ($_GET as $k => $v) {
            if (empty($v)) {
                $greska .= "Nije popunjeno: " . $k . "<br>";
            }
        }
        if (empty($greska)) {
            //$poruka = 'Nema greške!';
            $veza = new Baza();
            $veza->spojiDB();

            $korime = $_GET['korime'];
            $lozinka = $_GET['lozinka'];
            //$upit = "SELECT *FROM korisnik";
            $upit = "SELECT * FROM `korisnik` WHERE "
                    . "`korisnicko_ime`='{$korime}' AND "
                    . "`lozinka`='{$lozinka}'";

            $rezultat = $veza->selectDB($upit);
            $autenticiran = false;
            while ($red = mysqli_fetch_array($rezultat)) {
                //var_dump($red);
                if ($red) {
                    $autenticiran = true;
                    $uloga = $red["ID_uloga"];
                    $status = $red["status"];
                }
            }

            if ($autenticiran && $status === '0') {
                $poruka = 'Uspješna prijava!';
                Sesija::kreirajKorisnika($korime, $uloga);
                header("Location: ../index.php");
            } elseif ($autenticiran && $status === '1') {
                $poruka = 'Račun blokiran!';
            } else{
                $poruka = 'Neuspješna prijava!';
            }

            $veza->zatvoriDB();
        }
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
        <title>Prijava</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Autor">
        <meta name="autor" content="Petar Mihalić">
        <meta name="opis" content="Stranica kreirana 03.6.2021.">
        <meta name="kljucne_rijeci" content="prijava, login, podaci">
        <link rel="stylesheet" type="text/css" href="../css/pmihalic.css">
    </head>
    <body>
        <header>
            <h1 class="naslov"><a href="#sadrzaj">Prijava</a></h1>
        </header>
        <?php
            include '../meni.php';
        ?>
        <section id="sadrzaj">
            <h2>Unesite Vaše podatke za prijavu</h2>
            <div id="greske" style="color:red; width: 30%; min-width: 350px; margin-left: auto; margin-right: auto;">
        <?php
            if (isset($greska)) {
                echo "<p>$greska</p>";
            }
        ?>
            </div>
            <form novalidate name="prijava" id="prijava" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="korime">Korsiničko ime: </label>
                <input name="korime" id="korime" type="text" placeholder="Unesite korisničko ime" autofocus maxlength="15" size="15" /><br>
                <label for="lozinka">Lozinka: </label>
                <input name="lozinka" id="lozinka" type="password" placeholder="Unesite lozinku"/><br>
                <label for="zapamtiMe">Zapamti me: </label>
                <input name="zapamtiMe" id="zapamtiMe" type="checkbox" value="1" /><br><br>
                <input id="submit1" name="submit" type="submit" value="Prijavi se" />
            </form>
            <div id="poruka" style="color:green; width: 30%; min-width: 350px; margin-left: auto; margin-right: auto;">
            <?php
                if (isset($poruka)) {
                    echo "<p>$poruka</p>";
                }
            ?>

        </section>
    </body>
</html>
