<?php
  // Suoritetaan projektin alustusskripti.
  require_once '../src/init.php';

  // Siistitään polku urlin alusta ja mahdolliset parametrit urlin lopusta.
  // Siistimisen jälkeen osoite /~koodaaja/lanify/tapahtuma?id=1 on 
  // lyhentynyt muotoon /tapahtuma.
  $request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);
  $request = strtok($request, '?');

    // Luodaan uusi Plates-olio ja kytketään se sovelluksen sivupohjiin.
    $templates = new League\Plates\Engine(TEMPLATE_DIR);


    // Selvitetään mitä sivua on kutsuttu ja suoritetaan sivua vastaava
    // käsittelijä.
   
    switch ($request) {
      case '/':
      case '/tapahtumat':
        require_once MODEL_DIR . 'tapahtuma.php';
        $tapahtumat = haeTapahtumat();                                       //hae tapahtumat tietokannasta
        echo $templates->render('tapahtumat',['tapahtumat' => $tapahtumat]); //ja välitetään eteenpäin plates-luokan render-funktion parametrinä
        break;
      case '/tapahtuma':
        require_once MODEL_DIR . 'tapahtuma.php';
        $tapahtuma = haeTapahtuma($_GET['id']);
        if ($tapahtuma) {
          echo $templates->render('tapahtuma',['tapahtuma' => $tapahtuma]);
        } else {
          echo $templates->render('tapahtumanotfound');
        }
        break;
      case '/lisaa_tili':
        if (isset($_POST['laheta'])) {                                                              //jos laheta nappi on painettu eli POST[] on jotain
          $formdata = cleanArrayData($_POST);                                                       //siivotaan POST[] sisältö      
          require_once MODEL_DIR . 'henkilo.php';
          $salasana = password_hash($formdata['salasana1'], PASSWORD_DEFAULT);                      //hashaa (nyt siivottu) käyttäjän antama salasana
          $id = lisaaHenkilo($formdata['nimi'],$formdata['email'],$formdata['kaupunki'],$salasana); //lisää käyttäjän antamat tiedot tietokantaan
          echo "Tili on luotu tunnisteella $id";                                           //näytä teksti ja lisaaHenkilo funktion palauttama id
          break;
        } else {
          echo $templates->render('lisaa_tili');  //näytä lisää-tili sivu
          break;
        }
      default:
        echo $templates->render('notfound');
    } 

?> 
