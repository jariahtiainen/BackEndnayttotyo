<?php $this->layout('template', ['title' => 'Tulevat tapahtumat']) ?>

<h1>Tulevat liikuntaryhmät</h1>

<div class='tapahtumat'>
<?php

foreach ($tapahtumat as $tapahtuma) {

  $start = new DateTime($tapahtuma['tap_alkaa']);
  
/*
  echo "<div>";
    echo "<div>$tapahtuma[nimi]</div>";
    echo "<div>" . $start->format('j.n.Y ') . "klo " . $start->format('G:i') . "</div>";
    echo "<div>$tapahtuma[kaupunki]</div>";
    echo "<div><a href='tapahtuma?id=" . $tapahtuma['tapahtuma_id'] . "'>TIEDOT</a></div>";
  echo "</div>";
  */
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

</div>