<?php
    $putanja = dirname($_SERVER['REQUEST_URI']);
    $direktorij = dirname(getcwd());
    
    require "$direktorij/WebDiP2020x060/klase/sigurnosna_kopija.class.php";
    require "$direktorij/WebDiP2020x060/klase/dnevnik.class.php";
    require "$direktorij/WebDiP2020x060/klase/baza.class.php";
    require "$direktorij/WebDiP2020x060/klase/sesija.class.php";
    
    $log = new Dnevnik();
    if(!strpos($_SERVER['REQUEST_URI'], '?')){
        $log->spremiDnevnik(2, "Kreirana sigurnosna kopija");
    }
    
    $sk = new sigurnosna_kopija();
    
    $sk->sigkopija();

    header("Location: index.php");
