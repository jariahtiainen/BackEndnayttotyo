<?php $this->layout('template', ['title' => $tapahtuma['nimi']]) ?>

<?php
  $start = new DateTime($tapahtuma['tap_alkaa']);
  
?>
<div class='tapahtumat'>
<h1><?=$tapahtuma['nimi']?></h1>
<div>Kuvaus: <?=$tapahtuma['kuvaus']?></div>
<div>Alkaa: <?=$start->format('j.n.Y G:i')?></div>
<div>Kesto: <?=$tapahtuma['kesto']?></div>
</div>

<?php
  if ($loggeduser) {
    if (!$ilmoittautuminen) {
      echo "<div class='flexarea'><a href='ilmoittaudu?id=$tapahtuma[tapahtuma_id]' class='button'>ILMOITTAUDU</a></div>";
    } else {
      echo "<div class='flexarea'>";
      echo "<div>Olet ilmoittautunut tapahtumaan!</div>";
      echo "<a href='peru?id=$tapahtuma[tapahtuma_id]' class='button'>PERU ILMOITTAUTUMINEN</a>";
      echo "</div>";
    }
  }
  
?>

