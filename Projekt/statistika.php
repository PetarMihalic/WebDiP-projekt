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
    } elseif (isset($_SESSION["uloga"]) && $_SESSION["uloga"] > 1) {
        header("Location: index.php");
        exit();
    }
    
    $log = new Dnevnik();
    if(!strpos($_SERVER['REQUEST_URI'], '?')){
        $log->spremiDnevnik(3, " ");
    }
    
    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
        }
        
    $total_records_per_page = 10;
    $offset = 0;
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";
    
    $veza = new Baza();
    $veza->spojiDB();
    $upit = "SELECT COUNT(*) As total_records FROM dnevnik_rada";
    $result_count = $veza->selectDB($upit);
    $total_records = mysqli_fetch_array($result_count);
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1;
    
    $veza = new Baza();
    $veza->spojiDB();
    if(isset($_GET['korisnik']) && $_GET['korisnik']==='gost'){
        $korisnik = " dnevnik_rada.ID_korisnik IS NULL";
    }
    elseif(isset($_GET['korisnik']) && $_GET['korisnik']!=='svi'){
        $korisnik = " dnevnik_rada.ID_korisnik =".$_GET['korisnik'];
    }
    else{
        $korisnik = "1";
    }
    if(isset($_GET['vrijemeod']) && $_GET['vrijemeod']!=''){
        $vrijemeod = $_GET['vrijemeod'].":00";
        $vrijemeod = str_replace('T', ' ', $vrijemeod);
        $od = " dnevnik_rada.datum_vrijeme_aktivnosti > '{$vrijemeod}' ";
    }
    else{
        $od = "1";
    }
    if(isset($_GET['vrijemedo']) && $_GET['vrijemedo']!=''){
        $vrijemedo = $_GET['vrijemedo'].":00";
        $vrijemedo = str_replace('T', ' ', $vrijemedo);
        $do = " dnevnik_rada.datum_vrijeme_aktivnosti < '{$vrijemedo}' ";
    }
    else{
        $do = "1";
    }
    $upit = "SELECT dnevnik_rada.radnja, dnevnik_rada.sql_upit, dnevnik_rada.datum_vrijeme_aktivnosti, dnevnik_rada.ID_korisnik, tip.naziv "
            . "FROM dnevnik_rada "
            . "INNER JOIN tip ON dnevnik_rada.ID_tip = tip.ID_tip WHERE {$korisnik} AND {$od} AND {$do} ORDER BY 3 DESC LIMIT {$offset}, {$total_records_per_page}";
    $rez = $veza->selectDB($upit);
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        
    </head>
    <body>
        <header>
            <h1 class="naslov"><a href="#sadrzaj">Statistika korištenja</a></h1>
        </header>
        <br>
    <?php
        include 'meni.php';
    ?>  
        
    <section id="sadrzaj">
        <br><br><br>
        <form name="search" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" style="float: right; min-width: 230px; width: 230px; margin-right: 5%;">
            <label>Korisnik :</label>
            <select name='korisnik' id='oznaka' style="width: 155px; height: 24px; ">
                <option value="svi" selected>svi</option>
                <?php 
                    $veza = new Baza();
                    $veza->spojiDB();
                    $upitkor = "SELECT korisnicko_ime, ID_korisnik FROM korisnik ORDER BY ID_uloga";
                    $rezultatkor = $veza->selectDB($upitkor);
                    while ($rowkor = mysqli_fetch_array($rezultatkor)) {
                        echo "<option value='{$rowkor["ID_korisnik"]}'>{$rowkor["korisnicko_ime"]}</option>";
                    }
                ?>
           <option value="gost">gost</option>
            </select><br>
            <label>Od: </label>
            <input name="vrijemeod" type="datetime-local" onchange="console.log(this.value.split('T')[0]);" style="margin: 2px 0px;"><br>
            <label>Do: </label>
            <input name="vrijemedo" type="datetime-local" onchange="console.log(this.value.split('T')[0]);" style="margin: 2px 0px 6px 0px;"><br>
            <input id="submit" name="filtriraj" type="submit" value="Filtriraj"/>
        </form>
        <div style='margin-left: auto; width: 264px; margin-right: 5%;'>
        <?php
        if($page_no > 1){
            echo "<button><a style='color:black;' href='?page_no=1'>First Page</a></button> ";
        }
        if($page_no > 1){
            echo "<button><a style='color:black;' href='?page_no=$previous_page'>Previous</a></button> ";
        } 

        if($page_no >= $total_no_of_pages){
            echo "<button>Next</button> ";
        } 
        if($page_no < $total_no_of_pages) {
            echo "<button><a style='color:black;' href='?page_no=$next_page'>Next</a></button> ";
        } 
        if($page_no < $total_no_of_pages){
            echo "<button><a style='color:black;' href='?page_no=$total_no_of_pages'>Last</a></button> ";
        } ?>
        </div><br>
        <table style="table-layout: fixed;">
        <thead>
            <tr>
                <th>Mjesto radnje</th>
                <th>SQL upit</th>
                <th>Datum i vrijeme aktivnosti</th>
                <th>Korisnicko ime</th>
                <th>Tip radnje</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($row = mysqli_fetch_array($rez)){
            if($row['ID_korisnik'] != null){
            $upitkorime = "SELECT korisnicko_ime FROM korisnik WHERE ID_korisnik = '{$row['ID_korisnik']}'";
            $korime = $veza->selectDB($upitkorime);
            $korimerow = mysqli_fetch_array($korime);
            $row['ID_korisnik']=$korimerow['korisnicko_ime'];
            }
            else{
                $row['ID_korisnik']="gost";
            }
            echo "<tr>";
                echo "<td style='word-wrap: break-word;'>".$row['radnja']."</td>";
                echo "<td>".$row['sql_upit']."</td>";
                echo "<td>".$row['datum_vrijeme_aktivnosti']."</td>";
                echo "<td>".$row['ID_korisnik']."</td>";
                echo "<td>".$row['naziv']."</td>";
            echo"</tr>";
            }
            ?>
        </tbody>
    </table>
         <br>
    <canvas id="myChart" style="width:50%;max-width: 70%; margin-left: auto; margin-right: auto; padding: 10px; background-color: white; "></canvas>
    
    <script>
        var xValues = ["","prijava/odjava", "rad s bazom", "ostale radnje",""];
        <?php
            
            $veza = new Baza();
            $veza->spojiDB();
            echo 'var yValues = [0, ';
            for($i=1;$i<4;$i++){
            $upit = "SELECT SUM(ID_tip) AS stat FROM dnevnik_rada WHERE ID_tip={$i}";
            $rezultat = $veza->selectDB($upit);
            $row = mysqli_fetch_array($rezultat);
            echo $row['stat'].", ";
            }
            echo '0];';
        ?>
        var barColors = ["transparent", "darkgreen", "green", "lightgreen" ,"transparent"];
    new Chart("myChart", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        legend: {display: false},
        title: {
          display: true,
          text: "Grafički prikaz statistike tipa radnj"
        }
      }
    });
    </script>
    </section>
    </body>
</html>