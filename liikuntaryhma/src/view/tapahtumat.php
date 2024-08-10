<?php $this->layout('template', ['title' => !empty($kaupunki) ? "Tulevat tapahtumat haetussa kaupungissa" : "Tulevat tapahtumat"]) ?>

<h1><?php echo !empty($kaupunki) ? "Tulevat liikuntaryhmät haetun kaupungin mukaan" : "Tulevat liikuntaryhmät"; ?></h1>


<?php

foreach ($tapahtumat as $tapahtuma) {
  $start = new DateTime($tapahtuma['tap_alkaa']);
?>
  <div class="event">
    <div class="event-name"><?php echo htmlspecialchars($tapahtuma['nimi']); ?></div>
    <div class="event-time"><?php echo $start->format('j.n.Y ') . "klo " . $start->format('G:i'); ?></div>
    <div class="event-city"><?php echo htmlspecialchars($tapahtuma['kaupunki']); ?></div>
    <div class="event-details"><a href="tapahtuma?id=<?php echo htmlspecialchars($tapahtuma['tapahtuma_id']); ?>">TIEDOT</a></div>
  </div>
<?php
}
?>


