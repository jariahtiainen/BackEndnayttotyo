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
    </header>
    
    <section>
      <?=$this->section('content')?>
    </section>
    
    <footer>
      <hr>
      <div>Liikuntaryhmät by Kurpitsa</div>
    </footer>
  </body>
</html>
