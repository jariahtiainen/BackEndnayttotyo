<?php

  require_once HELPERS_DIR . 'DB.php';

  function haeTapahtumat() {
    return DB::run('SELECT * FROM liikuntatapahtuma ORDER BY tap_alkaa;')->fetchAll();
  }

?>
