<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
  session_start();

  // Suoritetaan projektin alustusskripti.
  require_once '../src/init.php';

  // Haetaan kirjautuneen käyttäjän tiedot.
  if (isset($_SESSION['user'])) {
    require_once MODEL_DIR . 'henkilo.php';
    $loggeduser = haeHenkilo($_SESSION['user']);
  } else {
    $loggeduser = NULL;
  }

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
        require_once MODEL_DIR . 'ilmoittautuminen.php';
        $tapahtuma = haeTapahtuma($_GET['id']);
        if ($tapahtuma) {
          if ($loggeduser) {
            $ilmoittautuminen = haeIlmoittautuminen($loggeduser['jäsen_id'],$tapahtuma['tapahtuma_id']);
          } else {
            $ilmoittautuminen = NULL;
          }
          echo $templates->render('tapahtuma',['tapahtuma' => $tapahtuma,
                                                'ilmoittautuminen' => $ilmoittautuminen,
                                                'loggeduser' => $loggeduser]);
        } else {
          echo $templates->render('tapahtumanotfound');
        }
        break;
  
      case '/lisaa_tili':
        if (isset($_POST['laheta'])) {                                                              
          $formdata = cleanArrayData($_POST);                                                             
          require_once CONTROLLER_DIR . 'tili.php';
          $tulos = lisaaTili($formdata,$config['urls']['baseUrl']);
          if ($tulos['status'] == "200") {
            echo $templates->render('tili_luotu', ['formdata' => $formdata]);
            break;
          }
          echo $templates->render('lisaa_tili', ['formdata' => $formdata, 'error' => $tulos['error']]);
          break;
        } else {
          echo $templates->render('lisaa_tili', ['formdata' => [], 'error' => []]);
          break;
        }
      case "/kirjaudu":
        if (isset($_POST['laheta'])) {
          require_once CONTROLLER_DIR . 'kirjaudu.php';
          if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
            require_once MODEL_DIR . 'henkilo.php';
            $user = haeHenkilo($_POST['email']);
            if ($user['vahvistettu']) {
              session_regenerate_id();
              $_SESSION['user'] = $user['email'];
              header("Location: " . $config['urls']['baseUrl']);
            } else {
              echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Tili on vahvistamatta! Ole hyvä, ja vahvista tili sähköpostissasi olevalla linkillä.']]);
            }
          } else {
            echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
          }
        } else {
          echo $templates->render('kirjaudu', [ 'error' => []]);
        }
        break;
      case "/logout":
        require_once CONTROLLER_DIR . 'kirjaudu.php';
        logout();
        header("Location: " . $config['urls']['baseUrl']);
        break;
      case '/ilmoittaudu':
        if ($_GET['id']) {
          require_once MODEL_DIR . 'ilmoittautuminen.php';
          $tapahtuma_id = $_GET['id'];
          if ($loggeduser) {
            lisaaIlmoittautuminen($loggeduser['jäsen_id'],$tapahtuma_id);
          }
          header("Location: tapahtuma?id=$tapahtuma_id");
        } else {
          header("Location: tapahtumat");
        }
        break;
      case '/peru':
        if ($_GET['id']) {
          require_once MODEL_DIR . 'ilmoittautuminen.php';
          $tapahtuma_id = $_GET['id'];
          if ($loggeduser) {
            poistaIlmoittautuminen($loggeduser['jäsen_id'],$tapahtuma_id);
          }
          header("Location: tapahtuma?id=$tapahtuma_id");
        } else {
          header("Location: tapahtumat");  
        }
        break;
      case "/vahvista":
        if (isset($_GET['key'])) {
          $key = $_GET['key'];
          require_once MODEL_DIR . 'henkilo.php';
          if (vahvistaTili($key)) {
            echo $templates->render('tili_aktivoitu');
          } else {
            echo $templates->render('tili_aktivointi_virhe');
          }
        } else {
          header("Location: " . $config['urls']['baseUrl']);
        }
        break;
    
      default:
      echo $templates->render('notfound');
    } 

?> 
