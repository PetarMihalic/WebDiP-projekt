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
    
    if (isset($_POST["submit"])&& !empty($_FILES['datoteka'])) {
            $userfile = $_FILES['datoteka']['tmp_name'];
            $userfile_name = $_FILES['datoteka']['name'];
            $userfile_size = $_FILES['datoteka']['size'];
            $userfile_type = $_FILES['datoteka']['type'];
            $userfile_error = $_FILES['datoteka']['error'];
            if ($userfile_error > 0) {
               echo 'Problem: ';
               switch ($userfile_error) {
                   case 1: echo 'Veličina veća od ' . ini_get('upload_max_filesize');
                       break;
                   case 2: echo 'Veličina veća od ' . $_POST["MAX_FILE_SIZE"] . 'B';
                       break;
                   case 3: echo 'Datoteka djelomično prenesena';
                       break;
                   case 4: echo 'Datoteka nije prenesena';
                       break;
               }
               exit;
            }

            $upfile = 'multimedija/dokumenti/' . $userfile_name;
            
            

            if (is_uploaded_file($userfile)) {
               if (!move_uploaded_file($userfile, $upfile)) {
                   echo 'Problem: nije moguće prenijeti datoteku na odredište';
                   exit;
               }
               else{
                    $veza = new Baza();
                    $veza->spojiDB();

                    $korisnik = $_SESSION[Sesija::KORISNIK];
                    $upit2 = "SELECT ID_korisnik"
                            . " FROM korisnik"
                            . " WHERE korisnicko_ime = '{$korisnik}'";
                    $rezultat2 = $veza->selectDB($upit2);
                    $row2 = mysqli_fetch_array($rezultat2);
                    $IDkorisnika = $row2["ID_korisnik"];
                    
                    $upitid = "SELECT ID_cesta"
                            . " FROM cesta"
                            . " WHERE oznaka = '{$_POST['oznaka']}'";
                    var_dump($upitid);
                    $rezultatid = $veza->selectDB($upitid);
                    $rowid = mysqli_fetch_array($rezultatid);
                    $upit3 = "INSERT INTO dokument (naziv_dokumenta, vrsta_dokumenta, status, ID_korisnik, ID_cesta) VALUES"
                            . "('{$userfile_name}',"
                            . "'{$userfile_type}',"
                            . "'nije potvrđeno',"
                            . "{$IDkorisnika},"
                            . "{$rowid['ID_cesta']});";
                    var_dump($upit3);
                    $rezultat = $veza->selectDB($upit3);
                    $veza->zatvoriDB();
                    $log->spremiDnevnik(2, $upit3);
                    header("Location: dokumenti.php");
                    exit();
               }
            } else {
               echo 'Problem: mogući napad prijenosom. Datoteka: ' . $userfile_name;
               exit;
           }
    }
    
    $ispis = "";
    
    if(isset($_GET['nazivdoc'])){
        $doc = $_GET['nazivdoc'];
        $ispis = "<form novalidate name='status' id='status' method='get' action='dokumenti.php'>"
        . "<label>Odabrani dokument: {$doc}</label>"
        . "<input name='naziv' id='naziv' type='hidden' value='{$doc}'/>"
        . "<label><br><br>Status dokumenta:<br></label>"
        . "<select name='status' id='status' style='width: 100%; margin: 8px 0; height: 41px; padding: 12px 16px;'>"
            . "<option value='potvrđeno' ".(($_GET['stat'] === 'potvrđeno') ? "selected" : '').">potvrđeno</option>"
            . "<option value='odbijeno' ".(($_GET['stat'] === 'odbijeno') ? 'selected' : '').">odbijeno</option>"
            . "<option value='nije potvrđeno' ".(($_GET['stat'] === 'nije potvrđeno') ? 'selected' : '').">nije potvđeno</option>"
        . "</select>"
        . "<input id='submit1' name='promijenistatus' type='submit' value='Promijeni status' /></form>";
    }
    
    if (isset($_GET['promijenistatus'])) {
        $naziv_dokumenta = $_GET['naziv'];
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "UPDATE dokument SET "
                    . "status = '{$_GET["status"]}' "
                    . "WHERE naziv_dokumenta = '{$naziv_dokumenta}'";
        $rezultat = $veza->selectDB($upit);
        $veza->zatvoriDB();
        $log->spremiDnevnik(2, $upit);
        if($rezultat!=null){
            $ispis="Uspješno promijenjeno!";
        }
        header("Location: dokumenti.php?poruka={$ispis}");
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
        <title>Dokumenti</title>
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
            <h1 class="naslov"><a href="#sadrzaj">Dokumenti</a></h1>
        </header>
        <br>
    <?php
        include 'meni.php';
    ?>  
    <section id="sadrzaj">
        <br>
        <p id="uvod">Na ovoj stranici možete vidjeti sve potvrđene dokumente te postaviti vlastite.</p>
        <form name="obrazac" method="post" enctype="multipart/form-data"
                  action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <label>Oznaka dionice za koju dodajete dokument:<br></label>
                    <select name='oznaka' id='oznaka' style='width: 100%; margin: 8px 0; height: 41px;'>
                        <?php 
                            $veza = new Baza();
                            $veza->spojiDB();
                            $upit = "SELECT oznaka"
                                    . " FROM cesta ORDER BY ID_kategorija, oznaka";
                            $rezultat = $veza->selectDB($upit);
                            while ($row = mysqli_fetch_array($rezultat)) {
                                echo "<option value='{$row["oznaka"]}'>{$row["oznaka"]}</option>";
                            }
                        ?>
                   </select>
                    <label for="datoteka">Odaberite datoteku: </label>
                    <input type="file" name="datoteka" />
                    <input type="hidden" name="MAX_FILE_SIZE" value="30000"/>
                    <input id="submit1" name="submit" type="submit" value="Prenesi datoteku"/>
            </form>
    </section>
        <table style="width: 30%;">
            <caption><h3>Potvrđeni dokumenti</h3></caption>
        <thead>
            <tr>
                <th>Naziv dokumenta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $veza = new Baza();
            $veza->spojiDB();
            $upit = "SELECT naziv_dokumenta "
                    . "FROM dokument "
                    . "WHERE status = 'potvrđeno'";
            $rezultat = $veza->selectDB($upit);
            while ($row = mysqli_fetch_array($rezultat)) {
                echo "<tr>";
                    echo "<td>{$row['naziv_dokumenta']}</td>";
                echo"</tr>";
                }
            ?>
        </tbody>
    </table>
       <br>
       <?php
            echo "<p style='text-align: center;'>";
            echo $ispis;
            echo "</p>";
        
            if(isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 3){
            echo "<table>
                <caption><h3>Svi dokumenti</h3></caption>
                <thead>
                    <tr>
                        <th>Naziv dokumenta</th>
                        <th>Oznaka dionice</th>
                        <th>Status dokumenta</th>
                    </tr>
                </thead>
                <tbody>";
            
            $veza = new Baza();
            $veza->spojiDB();
            $upit = "SELECT dokument.naziv_dokumenta, cesta.oznaka, dokument.status "
                    . "FROM dokument "
                    . "INNER JOIN cesta ON dokument.ID_cesta = cesta.ID_cesta";
            $rezultat = $veza->selectDB($upit);
            while ($row = mysqli_fetch_array($rezultat)) {
                $bojanje = "";
                if($row['status'] === 'nije potvrđeno'){
                    $bojanje = "style='color: orange;'";
                }
                elseif ($row['status'] === 'odbijeno') {
                    $bojanje = "style='color: red;'";
                }
                echo "<tr>";
                    echo "<td><a {$bojanje} href='dokumenti.php?nazivdoc={$row['naziv_dokumenta']}&stat={$row['status']}'>{$row['naziv_dokumenta']}</a></td>";
                    echo "<td>{$row['oznaka']}</td>";
                    echo "<td>{$row['status']}</td>";
                echo"</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <footer>
    </footer>
    </body>
</html>

