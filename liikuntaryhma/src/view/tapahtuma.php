<?php $this->layout('template', ['title' => $tapahtuma['nimi']]) ?>

<?php
  $start = new DateTime($tapahtuma['tap_alkaa']);
  
?>

<h1><?=$tapahtuma['nimi']?></h1>
<div>Kuvaus: <?=$tapahtuma['kuvaus']?></div>
<div>Alkaa: <?=$start->format('j.n.Y G:i')?></div>
<div>Kesto: <?=$tapahtuma['kesto']?></div>


