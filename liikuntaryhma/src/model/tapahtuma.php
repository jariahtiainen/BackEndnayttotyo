<?php

  require_once HELPERS_DIR . 'DB.php';

  function haeTapahtumat() {
    return DB::run('SELECT * FROM liikuntatapahtuma ORDER BY tap_alkaa;')->fetchAll();
  }
  
  function haeTapahtuma($id) {
    return DB::run('SELECT * FROM liikuntatapahtuma WHERE tapahtuma_id = ?;',[$id])->fetch();
  }

  function lisaaTapahtuma($luoja_id,$nimi,$kuvaus,$tap_alkaa,$kesto,$kaupunki,$aloituspaikka) {
    return DB::run('INSERT INTO liikuntatapahtuma (luoja_id,nimi, kuvaus, tap_alkaa, kesto, kaupunki, aloituspaikka) VALUE (?,?,?,?,?,?,?);',[$luoja_id,$nimi,$kuvaus,$tap_alkaa,$kesto,$kaupunki,$aloituspaikka]);
    return DB::lastInsertId();  //funktio palauttaa lisätyn tapahtuman id-tunnisteen
  }
  
?>
