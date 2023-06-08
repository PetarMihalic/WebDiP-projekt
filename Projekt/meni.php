<?php

echo "<nav><br><ul>";
if (!isset($_SESSION["uloga"]) || $_SESSION["uloga"] === '4') {
    echo "<li><a href=\"$putanja/index.php\">Početna stranica</a></li>
          <li><a href=\"$putanja/dionice.php\">Dionice</a></li>
          <li><a href=\"$putanja/obrasci/prijava.php\">Prijava</a></li>
          <li><a href=\"$putanja/obrasci/registracija.php\">Registracija</a></li>";
}
if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 4) {
    echo "<li><a href=\"$putanja/index.php\">Početna stranica</a></li>
          <li><a href=\"$putanja/dionice.php\">Dionice</a></li>
          <li><a href=\"$putanja/obilasci.php\">Obilasci</a></li>
          <li><a href=\"$putanja/dokumenti.php\">Dokumenti</a></li>";
}

if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 3) {
    echo "<li><a href=\"$putanja/problemi.php\">Problemi</a></li>";
}

if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 2) {
    echo "<li><a href=\"$putanja/statistika.php\">Statistika korištenja</a></li>
          <li><a href=\"$putanja/kategorije.php\">Kategorije cesta</a></li>";
}
if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 4) {
echo "<li><a href=\"$putanja/obrasci/prijava.php\">Odjava</a></li>";     
}
echo "</ul></nav>";