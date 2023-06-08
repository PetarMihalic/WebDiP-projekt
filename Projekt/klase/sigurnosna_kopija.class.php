<?php

class sigurnosna_kopija {
    public function sigkopija() {
        $connect = new PDO("mysql:host=localhost;dbname=WebDiP2020x060", "WebDiP2020x060", "admin_2JYM");

        $tables = array();
        $tables[] = 'cesta';
        $tables[] = 'dokument';


         $output = '';
         foreach($tables as $table)
         {
          $show_table_query = "SHOW CREATE TABLE " . $table . "";
          $statement = $connect->prepare($show_table_query);
          $statement->execute();
          $show_table_result = $statement->fetchAll();
          foreach($show_table_result as $show_table_row)
          {
           $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
          }
          $select_query = "SELECT * FROM " . $table . "";
          $statement = $connect->prepare($select_query);
          $statement->execute();
          $total_row = $statement->rowCount();

          for($count=0; $count<$total_row; $count++)
          {
           $single_result = $statement->fetch(PDO::FETCH_ASSOC);
           $table_column_array = array_keys($single_result);
           $table_value_array = array_values($single_result);
           $output .= "\nINSERT INTO $table (";
           $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
           $output .= "'" . implode("','", $table_value_array) . "');\n";
          }
         }
         $upis = $output;
         $file_handle = fopen('sigurnosne_kopije/sigurnosna_kopija.txt', 'w') or die ("Ne može se otvoriti datoteka!");
         fwrite($file_handle, $upis);
         fclose($file_handle);
         header('Content-Description: File Transfer');
         header('Content-Type: text/plain');
         header('Content-Disposition: attachment; filename=' . basename("sigurnosna_kopija.txt"));
         header('Content-Transfer-Encoding: binary');
         header('Expires: 0');
         header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize("sigurnosna_kopija.txt"));
            ob_clean();
            flush();
            readfile("sigurnosne_kopije/sigurnosna_kopija.txt");
            unlink("sigurnosne_kopije/sigurnosna_kopija.txt");
    }
}