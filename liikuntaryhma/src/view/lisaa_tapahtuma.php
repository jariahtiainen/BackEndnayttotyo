<?php $this->layout('template', ['title' => 'Uuden tapahtuman luonti']) ?>

<h1>Uuden tapahtuman luonti</h1>

<form action="" method="POST">
  <div>
    <label for="nimi">Laji:</label>
    <input 
      id="nimi" 
      type="text" 
      name="nimi" 
      class="<?php echo isset($error['nimi']) ? 'error-field' : ''; ?>" 
      value="<?php echo htmlspecialchars($formdata['nimi'] ?? ''); ?>"
    >
  </div>
  <div>
    <label for="kuvaus">Kuvaus:</label>
    <input 
      id="kuvaus" 
      type="text" 
      name="kuvaus" 
      class="<?php echo isset($error['kuvaus']) ? 'error-field' : ''; ?>" 
      value="<?php echo htmlspecialchars($formdata['kuvaus'] ?? ''); ?>"
    >
  </div>
  <div>
    <label for="tap_alkaa">Tapahtuma alkaa:</label>
    <input 
      id="tap_alkaa" 
      type="datetime-local" 
      name="tap_alkaa" 
      class="<?php echo isset($error['tap_alkaa']) ? 'error-field' : ''; ?>" 
      value="<?php echo htmlspecialchars($formdata['tap_alkaa'] ?? ''); ?>"
    >
  </div>
  <div>
    <label for="kesto">Kesto:</label>
    <input 
      id="kesto" 
      type="text" 
      name="kesto" 
      class="<?php echo isset($error['kesto']) ? 'error-field' : ''; ?>" 
      value="<?php echo htmlspecialchars($formdata['kesto'] ?? ''); ?>"
    >
  </div>
  <div>
    <label for="kaupunki">Kaupunki:</label>
    <input 
      id="kaupunki" 
      type="text" 
      name="kaupunki" 
      class="<?php echo isset($error['kaupunki']) ? 'error-field' : ''; ?>" 
      value="<?php echo htmlspecialchars($formdata['kaupunki'] ?? ''); ?>"
    >
  </div>
  <div>
    <label for="aloituspaikka">Sijainti:</label>
    <input 
      id="aloituspaikka" 
      type="text" 
      name="aloituspaikka" 
      class="<?php echo isset($error['aloituspaikka']) ? 'error-field' : ''; ?>" 
      value="<?php echo htmlspecialchars($formdata['aloituspaikka'] ?? ''); ?>"
    >
  </div>
  <div class="tooltip">
  <div class="button-container">
    <input type="submit" name="laheta" value="Luo tapahtuma" class="button">
    
    <span class="tooltiptext">Bugi: valkoinen ruutu tapahtuman luomisen jälkeen. </span></div>
  </div>
</form>
