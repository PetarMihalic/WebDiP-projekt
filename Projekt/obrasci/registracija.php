<?php
    $putanja = dirname($_SERVER['REQUEST_URI'], 2);
    $direktorij = dirname(getcwd());
    
    if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
    header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    exit;
    }

    require "$direktorij/klase/baza.class.php";
    require "$direktorij/klase/sesija.class.php";
    require "$direktorij/klase/dnevnik.class.php";
    Sesija::kreirajSesiju();
    
    $log = new Dnevnik();
    if(!strpos($_SERVER['REQUEST_URI'], '?')){
        $log->spremiDnevnik(3, " ");
    }
    if (isset($_GET['submit'])) {
    //var_dump($_GET);
    $greska = "";
    foreach ($_GET as $k => $v) {
        if (empty($v)) {
            $greska .= "Nije popunjeno: " . $k . "<br>";
        }elseif ($k === "ime") {
            $uzorak = '/^[A-Z][a-z0-9_-]{2,}$/';
                if (!preg_match($uzorak, $v)) {
                    $greska .= "Ime treba započeti s velikim slovom i biti duže od dva znaka!"
                            . "<br>";
                }
        }elseif ($k === "prez") {
            $uzorak = '/^[A-Z][a-z0-9_-]{2,}$/';
                if (!preg_match($uzorak, $v)) {
                    $greska .= "Prezime treba započeti s velikim slovom i biti duže od dva znaka!"
                            . "<br>";
                }
        }elseif ($k === "korime") {
            $uzorak = '/^[a-z0-9_\-]{5,}$/';
                if (!preg_match($uzorak, $v)) {
                    $greska .= "Korisnicko ime mora biti dugo barem 5 znakova i bez velikih slova!"
                            . "<br>";
                }
        }elseif ($k === "email") {
            $uzorak = '/^[a-zA-Z0-9._]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,}$/';
                if (!preg_match($uzorak, $v)) {
                    $greska .= "Adresa mora biti u obliku primjer@primjer.primjer!"
                            . "<br>";
                }
        }elseif ($k === "lozinka1") {
            $loz1 = $v;
            $uzorak = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
                if (!preg_match($uzorak, $v)) {
                    $greska .= "Lozinka treba biti minimalno 8 znakova, imati bar jedno slovo i broj!"
                            . "<br>";
                }
        }elseif ($k === "lozinka2") {
            if ($v !== $loz1) {
                $greska .= "Lozinka se ne podudara sa ponovljenom lozinkom.<br>";
            }
        }
    }
    if (empty($greska)) {
        $salt = "{$_GET['korime']}"."{$_GET['email']}";
        $hash = hash("sha256", $salt.".".$_GET['lozinka1']);
        
        $veza = new Baza();
        $veza->spojiDB();
        
        $upit = "INSERT INTO `korisnik` (`ime`, `prezime`, `korisnicko_ime`, `lozinka`, `lozinka_sha256`, `email`, `status`, `ID_uloga`) "
                . "VALUES ('{$_GET['ime']}', '{$_GET['prez']}', '{$_GET['korime']}', '{$_GET['lozinka1']}', '{$hash}', '{$_GET['email']}', '', '3')";
        var_dump($upit);
        $rezultat = $veza->selectDB($upit);
        $log->spremiDnevnik(2, $upit);
        Sesija::kreirajKorisnika($_GET['korime'], '3');
        header("Location: ../index.php");

        $veza->zatvoriDB();
    }
    $korime="";
    if(isset($_GET['korime'])){
        $veza = new Baza();
        $veza->spojiDB();
        $username  = $_GET["korime"];
        $sql = $veza->selectDB("SELECT * FROM korisnik WHERE korisnicko_ime  = '$username'");
        if(mysqli_num_rows($sql) > 0){
             $greska.= "Korisnicko ime je zauzeto<br>";
        }else{
            $korime = "Korisnicko ime je slobodno<br>";
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
        <title>Registracija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="naslov" content="Autor">
        <meta name="autor" content="Petar Mihalić">
        <meta name="opis" content="Stranica kreirana 15.3.2021.">
        <meta name="kljucne_rijeci" content="registracija, racun, novi">
        <link rel="stylesheet" type="text/css" href="../css/pmihalic.css">
    </head>
    <body>
        <header>
            <h1 class="naslov"><a href="#sadrzaj">Registracija</a></h1>
    </header>
    <?php
        include '../meni.php';
    ?>
    <section id="sadrzaj">
    <h2>Unesite Vaše podatke kako bi se registrirali</h2>
    <div id="greske" style="color:red; width: 30%; min-width: 350px; margin-left: auto; margin-right: auto;">
        <?php
        if (isset($greska)) {
            echo "<p>$greska</p>";
            echo "<p style='color:green;'>$korime</p>";
        }
        ?>
        <span id="provjerakorimena"></span>
    </div>
    <form novalidate id="form1" method="get" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="ime">Ime: </label>
                <input type="text" id="ime" name="ime" placeholder="Ime"><br>
                <label for="prez">Prezime: </label>
                <input type="text" id="prez" name="prez"  placeholder="Prezime"><br>
                <label for="korime">Korisničko ime: </label>
                <input type="text" id="korime" name="korime" placeholder="korisničko ime"><br>
                <label for="email">Email adresa: </label>
                <input type="text" id="email" name="email" placeholder="korime@posluzitelj.xxx" ><br>
                <label for="lozinka1">Lozinka: </label>
                <input type="password" id="lozinka1" name="lozinka1" placeholder="lozinka"><br>
                <label for="lozinka2">Ponovi pozinku: </label>
                <input type="password" id="lozinka2" name="lozinka2" placeholder="lozinka"><br><br>                
               
                <input id="submit1" name="submit" type="submit" value=" Registriraj se ">
        </form>
    <script type="text/javascript">

    $('document').ready(function(){
          $('#korime').change(function(){
               var username = $(this).val();
                $.ajax ({
                    url : "prijava.php",
                    method : "GET",
                    data :  {username :username },
                    dataType: "text",
                    success:function(html)
                    {
                        $('#provjerakorimena').html(html);
                    }
                });
            });
   });
    </script>
    </section>
    </body>
</html>
