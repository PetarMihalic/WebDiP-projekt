<?php
class Dnevnik {
    
    private $nazivDatoteke = "izvorne_datoteke/dnevnik.log";
    
    public function setNazivDatoteke($nazivDatoteke): void {
        $this->nazivDatoteke = $nazivDatoteke;
    }
        
    /**
     * Funkcija za dodavanje u dnevnik!
     * @param type $tekst
     * @param type $baza - koristi bazu
     */
    public function spremiDnevnik($tip, $upit) {
            $navodnik = '"';
            $veza = new Baza();
            $veza->spojiDB();
            
            $korisnik = null;
            if(isset($_SESSION[Sesija::KORISNIK])){
            $korisnik = $_SESSION[Sesija::KORISNIK];
            }
            if($korisnik != null){
                $upit2 = "SELECT ID_korisnik"
                        . " FROM korisnik"
                        . " WHERE korisnicko_ime = '{$korisnik}'";
                $rezultat2 = $veza->selectDB($upit2);
                $row2 = mysqli_fetch_array($rezultat2);
                $IDkorisnika = "'".$row2["ID_korisnik"]."'";
            }
            else{
                $IDkorisnika = "null";
            }
            //$stranica=$_SERVER['HTTP_REFERER'];
            $stranica2=$_SERVER['REQUEST_URI'];
            //$ip=$_SERVER['REMOTE_ADDR'];
            $insertlog = "INSERT INTO dnevnik_rada(radnja, sql_upit, ID_korisnik, ID_tip) "
                    . "VALUES('$stranica2', $navodnik$upit$navodnik, $IDkorisnika, '$tip')";
            $rezultat = $veza->selectDB($insertlog);
    }
    
    public function citajDnevnik($baza=false){
        if($baza){
            //TODO spremi u bazu
        } else {
            return file($this->nazivDatoteke);
        }
    }
}
?>