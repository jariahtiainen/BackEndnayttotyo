<!DOCTYPE html>
<html lang="fi">
  <head>
    <title>liikuntaryhma - <?=$this->e($title)?></title>
    <meta charset="UTF-8">
    <link href="styles/styles.css" rel="stylesheet">
        
  </head>
  <body>
  
    <header>
      <h1><a href="<?=BASEURL?>">Liikuntaryhmät</a></h1>

     <div class="header-content">
      <form action="tapahtumat" method="get" class="search-bar">
        <input type="text" name="kaupunki" placeholder="Hae kaupungin mukaan" value="<?= isset($_GET['kaupunki']) ? htmlspecialchars($_GET['kaupunki']) : '' ?>">
      <button type="submit">Hae</button>
      </form>
    
     <div class="actions">
      <a class="luotapahtumabutton" href="lisaa_tapahtuma">Luo oma tapahtuma</a>

      <div class="profile">
        <?php
          if (isset($_SESSION['user'])) {
            echo "<div>$_SESSION[user]</div>";
            echo "<div><a href='logout'>Kirjaudu ulos</a></div>";
            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
              echo "<div><a href='admin'>Ylläpitosivut</a></div>";  
            }
          } else {
            echo "<div><a href='kirjaudu'>Kirjaudu</a></div>";
          }
          
        ?>
      </div>
     </div>
     </div>
    </header>
  
    <section>

      <?=$this->section('content')?>
      
    </section>
        
    <footer>
      
      <div>Liikuntaryhmät by Kurpitsa</div>
    </footer>
  </body>
</html>
