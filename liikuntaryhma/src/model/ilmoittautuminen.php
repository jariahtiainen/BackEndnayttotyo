<?php

  require_once HELPERS_DIR . 'DB.php';

  function haeIlmoittautuminen($idhenkilo,$idtapahtuma) {
    return DB::run('SELECT * FROM liik_ilmoittautuminen WHERE jäsen_id = ? AND tapahtuma_id = ?',
                   [$idhenkilo, $idtapahtuma])->fetchAll();
  }

  function lisaaIlmoittautuminen($idhenkilo,$idtapahtuma) {
    DB::run('INSERT INTO liik_ilmoittautuminen (jäsen_id, tapahtuma_id) VALUE (?,?)',
            [$idhenkilo, $idtapahtuma]);
    return DB::lastInsertId();
  }

  function poistaIlmoittautuminen($idhenkilo, $idtapahtuma) {
    return DB::run('DELETE FROM liik_ilmoittautuminen  WHERE jäsen_id = ? AND tapahtuma_id = ?',
                   [$idhenkilo, $idtapahtuma])->rowCount();
  }

?>
