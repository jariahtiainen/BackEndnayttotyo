<?php

  require_once HELPERS_DIR . 'DB.php';

  function lisaaHenkilo($nimi,$email,$kaupunki,$salasana) {  //lisää henkilön tietokantaan
    DB::run('INSERT INTO jäsen (nimi, email, kaupunki, salasana) VALUE  (?,?,?,?);',[$nimi,$email,$kaupunki,$salasana]); 
    return DB::lastInsertId();  //funktio palauttaa lisätyn henkilön idhenkilo-tunnisteen
  }

  function haeHenkiloSahkopostilla($email) {
    return DB::run('SELECT * FROM jäsen WHERE email = ?;', [$email])->fetchAll();
  }

  function haeHenkilo($email) {
    return DB::run('SELECT * FROM jäsen WHERE email = ?;', [$email])->fetch();
  }

  function paivitaVahvavain($email,$avain) {
    return DB::run('UPDATE jäsen SET vahvavain = ? WHERE email = ?', [$avain,$email])->rowCount();
  }

  function vahvistaTili($avain) {
    return DB::run('UPDATE jäsen SET vahvistettu = TRUE WHERE vahvavain = ?', [$avain])->rowCount();
  }


?>
