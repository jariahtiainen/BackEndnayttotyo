<!--Remove this debug section when no longer needed -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!--Remove this debug section when no longer needed -->

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

      // Get kaupunki parameter from the URL query string
      $kaupunki = isset($_GET['kaupunki']) ? $_GET['kaupunki'] : '';

      // Fetch events based on the kaupunki parameter
      $tapahtumat = haeTapahtumat($kaupunki);

      // Render the template with the fetched events
      echo $templates->render('tapahtumat', ['tapahtumat' => $tapahtumat, 'kaupunki' => $kaupunki]);
      break;
      /*
      $tapahtumat = haeTapahtumat();   //hae tapahtumat tietokannasta
      echo $templates->render('tapahtumat',['tapahtumat' => $tapahtumat]); //ja välitetään eteenpäin plates-luokan render-funktion parametrinä
      break;
      */
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
    case '/lisaa_tapahtuma':
      if (isset($_POST['laheta'])) {
        // Check if user is logged in
        if (!isset($_SESSION['luoja_id'])) {
          echo $templates->render('login_required', ['error' => ['Kirjaudu sisään luodaksesi tapahtuman.']]);
          break;
        }
        $formdata = cleanArrayData($_POST);
        require_once MODEL_DIR . 'tapahtuma.php';
        // Extract data from $formdata
        $luoja_id = $formdata['luoja_id'];
        $nimi = $formdata['nimi'];
        $kuvaus = $formdata['kuvaus'];
        $tap_alkaa = $formdata['tap_alkaa'];
        $kesto = $formdata['kesto'];
        $kaupunki = $formdata['kaupunki'];
        $aloituspaikka = $formdata['aloituspaikka'];
        
        $luoja_id = $_SESSION['luoja_id'];

        $tulos = lisaaTapahtuma($luoja_id, $nimi, $kuvaus, $tap_alkaa, $kesto, $kaupunki, $aloituspaikka);
        
        if ($tulos['status'] == "200") {
          echo $templates->render('tapahtuma_luotu', ['formdata' => $formdata]);
          break;
        }
        echo $templates->render('lisaa_tapahtuma', ['formdata' => $formdata, 'error' => $tulos['error']]);
        break;
      } else {
        echo $templates->render('lisaa_tapahtuma', ['formdata' => [], 'error' => []]);
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
            $_SESSION['admin'] = $user['admin'];
            $_SESSION['luoja_id'] = $user['jäsen_id'];
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
    case "/tilaa_vaihtoavain":
      $formdata = cleanArrayData($_POST);
      // Tarkistetaan, onko lomakkeelta lähetetty tietoa.
      if (isset($formdata['laheta'])) {    
  
        require_once MODEL_DIR . 'henkilo.php';
        // Tarkistetaan, onko lomakkeelle syötetty käyttäjätili olemassa.
        $user = haeHenkilo($formdata['email']);
        if ($user) {
          // Käyttäjätili on olemassa.
          // Luodaan salasanan vaihtolinkki ja lähetetään se sähköpostiin.
          require_once CONTROLLER_DIR . 'tili.php';
          $tulos = luoVaihtoavain($formdata['email'],$config['urls']['baseUrl']);
          if ($tulos['status'] == "200") {
            // Vaihtolinkki lähetty sähköpostiin, tulostetaan ilmoitus.
            echo $templates->render('tilaa_vaihtoavain_lahetetty');
            break;
          }
          // Vaihtolinkin lähetyksessä tapahtui virhe, tulostetaan
          // yleinen virheilmoitus.
          echo $templates->render('virhe');
          break;
        } else {
          // Tunnusta ei ollut, tulostetaan ympäripyöreä ilmoitus.
          echo $templates->render('tilaa_vaihtoavain_lahetetty');
          break;
        }
    
      } else {
        // Lomakeelta ei ole lähetetty tietoa, tulostetaan lomake.
        echo $templates->render('tilaa_vaihtoavain_lomake');
      }
      break;
    case "/reset":
      // Otetaan vaihtoavain talteen.
      $resetkey = $_GET['key'];

      // Seuraavat tarkistukset tarkistavat, että onko vaihtoavain
      // olemassa ja se on vielä aktiivinen. Jos ei, niin tulostetaan
      // käyttäjälle virheilmoitus ja poistutaan.
      require_once MODEL_DIR . 'henkilo.php';
      $rivi = tarkistaVaihtoavain($resetkey);
      if ($rivi) {
        // Vaihtoavain löytyi, tarkistetaan onko se vanhentunut.
        if ($rivi['aikaikkuna'] < 0) {
          echo $templates->render('reset_virhe');
          break;
        }
      } else {
        echo $templates->render('reset_virhe');
        break;
      }

      // Vaihtoavain on voimassa, tarkistetaan onko lomakkeen kautta
      // syötetty tietoa.
      $formdata = cleanArrayData($_POST);
      if (isset($formdata['laheta'])) {

                // Lomakkeelle on syötetty uudet salasanat, annetaan syötteen
      // käsittely kontrollerille.
      require_once CONTROLLER_DIR . 'tili.php';
      $tulos = resetoiSalasana($formdata,$resetkey);
      // Tarkistetaan kontrollerin tekemän salasanaresetoinnin lopputulos.
      if ($tulos['status'] == "200") {
        // Salasana vaihdettu, tulostetaan ilmoitus.
        echo $templates->render('reset_valmis');
        break;
      }
      // Salasanan vaihto ei onnistunut, tulostetaan lomake virhetekstin kanssa.
      echo $templates->render('reset_lomake', ['error' => $tulos['error']]);
      break;


      } else {
        // Lomakkeen tietoja ei ole vielä täytetty, tulostetaan lomake.
        echo $templates->render('reset_lomake', ['error' => '']);
        break;
      }

      break;
    case (bool)preg_match('/\/admin.*/', $request):
      if ($loggeduser["admin"]) {
        echo "ylläpitosivut";
      } else {
        echo $templates->render('admin_ei_oikeuksia');
      }
      break;
  
    default:
    echo $templates->render('notfound');
  } 

?> 
