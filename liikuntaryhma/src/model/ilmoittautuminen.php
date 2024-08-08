<?php

  require_once HELPERS_DIR . 'DB.php';

  function haeIlmoittautuminen($jäsen_id,$tapahtuma_id) {
    return DB::run('SELECT * FROM liik_ilmoittautuminen WHERE jäsen_id = ? AND tapahtuma_id = ?',
                   [$jäsen_id, $tapahtuma_id])->fetchAll();
  }

  function lisaaIlmoittautuminen($jäsen_id,$tapahtuma_id) {
    DB::run('INSERT INTO liik_ilmoittautuminen (jäsen_id, tapahtuma_id) VALUE (?,?)',
            [$jäsen_id, $tapahtuma_id]);
    return DB::lastInsertId();
  }

  function poistaIlmoittautuminen($jäsen_id, $tapahtuma_id) {
    return DB::run('DELETE FROM liik_ilmoittautuminen  WHERE jäsen_id = ? AND tapahtuma_id = ?',
                   [$jäsen_id, $tapahtuma_id])->rowCount();
  }

?>
