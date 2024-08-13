<?php $this->layout('template', ['title' => 'Uuden tilin luonti']) ?>

<h1>Uuden tilin luonti</h1>

<form action="" method="POST">
  <div>
    <label for="nimi">Nimi:</label>
    <input id="nimi" type="text" name="nimi" value="<?= htmlspecialchars(getValue($formdata,'nimi')) ?>">
    <div class="error"><?= htmlspecialchars(getValue($error,'nimi')); ?></div>
  </div>
  <div>
    <label for="email">Sähköposti:</label>
    <input type="email" name="email" value="<?= htmlspecialchars(getValue($formdata,'email')) ?>">
    <div class="error"><?= htmlspecialchars(getValue($error,'email')); ?></div>
  </div>
  <div>
    <label for="kaupunki">Kaupunki:</label>
    <input id="kaupunki" type="text" name="kaupunki" value="<?= htmlspecialchars(getValue($formdata,'kaupunki')) ?>">
    <div class="error"><?= htmlspecialchars(getValue($error,'kaupunki')); ?></div>
  </div>
  <div>
    <label for="salasana1">Salasana:</label>
    <input id="salasana1" type="password" name="salasana1">
    <div class="error"><?= htmlspecialchars(getValue($error,'salasana')); ?></div>
  </div>
  <div>
    <label for="salasana2">Salasana uudelleen:</label>
    <input id="salasana2" type="password" name="salasana2">
  </div>
  <div>
    <input type="submit" name="laheta" value="Luo tili">
  </div>
</form>
