<?php $this->layout('template', ['title' => 'Tulevat tapahtumat']) ?>

<h1>Tulevat liikuntaryhmät</h1>

<div class='tapahtumat'>
<?php

foreach ($tapahtumat as $tapahtuma) {

  $start = new DateTime($tapahtuma['tap_alkaa']);
  

  echo "<div>";
    echo "<div>$tapahtuma[nimi]</div>";
    echo "<div>" . $start->format('j.n.Y ') . "klo " . $start->format('G:i') . "</div>";
    echo "<div><a href='tapahtuma?id=" . $tapahtuma['tapahtuma_id'] . "'>TIEDOT</a></div>";
  echo "</div>";

}

?>
</div>