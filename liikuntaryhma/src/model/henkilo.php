<?php

  require_once HELPERS_DIR . 'DB.php';

  function lisaaHenkilo($nimi,$email,$kaupunki,$salasana) {  //lisää henkilön tietokantaan
    DB::run('INSERT INTO jäsen (nimi, email, kaupunki, salasana) VALUE  (?,?,?,?);',[$nimi,$email,$kaupunki,$salasana]); 
    return DB::lastInsertId();  //funktio palauttaa lisätyn henkilön idhenkilo-tunnisteen
  }

?>