<?php

  require_once HELPERS_DIR . 'DB.php';
/* alkuperäinen
  function haeTapahtumat() {
    return DB::run('SELECT * FROM liikuntatapahtuma ORDER BY tap_alkaa;')->fetchAll();
  }*/

  function haeTapahtumat($kaupunki = '') {
    // Construct the base query
    $query = 'SELECT * FROM liikuntatapahtuma';
    $params = [];

    // If a kaupunki is specified, modify the query to include a WHERE clause
    if (!empty($kaupunki)) {
        $query .= ' WHERE kaupunki LIKE ?';
        $params[] = '%' . $kaupunki . '%';  // Use LIKE for partial matches
    }

    // Add ordering
    $query .= ' ORDER BY tap_alkaa;';

    // Execute the query with parameters
    return DB::run($query, $params)->fetchAll();
}

  
  function haeTapahtuma($id) {
    return DB::run('SELECT * FROM liikuntatapahtuma WHERE tapahtuma_id = ?;',[$id])->fetch();
  }

  function lisaaTapahtuma($luoja_id,$nimi,$kuvaus,$tap_alkaa,$kesto,$kaupunki,$aloituspaikka) {
    return DB::run('INSERT INTO liikuntatapahtuma (luoja_id,nimi, kuvaus, tap_alkaa, kesto, kaupunki, aloituspaikka) VALUE (?,?,?,?,?,?,?);',[$luoja_id,$nimi,$kuvaus,$tap_alkaa,$kesto,$kaupunki,$aloituspaikka]);
    return DB::lastInsertId();  //funktio palauttaa lisätyn tapahtuman id-tunnisteen
  }

  
?>
