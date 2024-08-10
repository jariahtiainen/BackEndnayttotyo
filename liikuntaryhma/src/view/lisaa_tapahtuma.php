<?php $this->layout('template', ['title' => 'Uuden tapahtuman luonti']) ?>

<h1>Uuden tapahtuman luonti</h1>

<form action="" method="POST">
  <div>
    <label for="nimi">Laji:</label>
    <input id="nimi" type="text" name="nimi">
  </div>
  <div>
    <label for="kuvaus">Kuvaus:</label>
    <input id="kuvaus" type="text" name="kuvaus">
  </div>
  <div>
    <label for="tap_alkaa">Tapahtuma alkaa:</label>
    <input id="tap_alkaa" type="datetime-local" name="tap_alkaa">
  </div>
  <div>
    <label for="kesto">Kesto:</label>
    <input id="kesto" type="text" name="kesto">
  </div>
  <div>
    <label for="kaupunki">Kaupunki:</label>
    <input id="kaupunki" type="text" name="kaupunki">
  </div>
  <div>
    <label for="aloituspaikka">Sijainti:</label>
    <input id="aloituspaikka" type="text" name="aloituspaikka">
  </div>
  <div>
    <input type="submit" name="laheta" value="Luo tapahtuma">
  </div>
</form>