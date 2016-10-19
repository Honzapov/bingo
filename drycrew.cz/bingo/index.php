<?php
session_start();

if (isset($_POST['config'])) {
    $_SESSION['pocetTicketu'] = $_POST['pocetTicketu'];
    $_SESSION['delkaTicketu'] = $_POST['delkaTicketu'];
    $_SESSION['maxCislo'] = $_POST['maxCislo'];
//    $_SESSION['maxVyhercu'] = $_POST['maxVyhercu'];
    $_SESSION['tickety'] = NULL;
    $_SESSION['tazeno'] = NULL;
    $_SESSION['tah'] = NULL;
    $_POST['config'] = NULL;
    $_SESSION['generateOnInit'] = FALSE;
    header("Location: " . $_SERVER['REQUEST_URI']);

} else {
    $_SESSION['generateOnInit'] = TRUE;
}

include 'config.php';
include 'functions.php';

if (empty($tickety)) {
    vygenerujTickety();
    $tickety = $_SESSION['tickety'];
}

if($_SESSION['generateOnInit']) {

    // aktualne tazene cislo
    $tah = rand(0, $maxCislo);
    $_SESSION['tah'] = $tah;

    if (!empty($_SESSION['tazeno'])) {
     $tazeno = $_SESSION['tazeno'];
    } else {
        $tazeno = array();
    }

    array_push($tazeno, $tah);
    $_SESSION['tazeno'] = $tazeno;

    kontrolujShody();
    $shody = spocitejShody($tickety);
}

$stopro = oznacStoprocentni($shody, $tazeno);
$plne = oznacPlne($shody);
$vyherci = oznacVyherce($shody);

//kolik shod maji vyherci
$shodVyhercu = $shody[$vyherci[0]];

?>


<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BINGO</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Mono" rel="stylesheet">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        <div class="row align-center">
            <div class="columns small-centered">
                <center><h1>Welcome to our new BINGO game!</h1></center>
                <center>
                    <h2 class="row">TAŽENO: </h2>
                    <div class="row align-center align-middle">
                    <?php vypisTazeno($tazeno); ?>
                    <div class='column' id='spin'><button class="success button large" onclick="window.location.reload(true);">Spin!</button></div>
                    </div>
                </center>
            </div>
            
            <div class="clearfix paddingtop">
            <section class="float-right medium-3 columns row">
                <div id="config" class="">
                    <form method="post" action="">
                        <fieldset class="fieldset nomargin" name="konfigurace">
                            <legend>Konfigurace</legend>
                            <div class="row ">
                                <label>Počet ticketů
                                    <input type="number" min="1" max="10000" name="pocetTicketu" id="pocetTicketu" value="<?php print $pocetTicketu; ?>">
                                </label>
                            </div>
                            <div class="row ">
                                <label>Délka jednoho ticketu
                                    <input type="number" min="1" max="10000" name="delkaTicketu" id="delkaTicketu" value="<?php print $delkaTicketu; ?>">
                                </label>
                            </div>
                            <div class="row ">
                                <label>Maximální číslo
                                    <input type="number" min="1" max="10000" name="maxCislo" id="maxCislo" value="<?php print $maxCislo; ?>">
                                </label>
                            </div>
<!--                            <div class="row ">
                                <label>Počet výherců
                                    <input type="number" min="1" max="10000" name="maxVyhercu" id="maxVyhercu" value="<?php //print $maxVyhercu; ?>">
                                </label>
                            </div>-->
                            <div class="row ">
                                <input type="submit" name="config" id="configButton" value="Uložit" class="button">
                            </div>
                        </fieldset>
                    </form>

                </div>
            </section>
                              
           <section class="float-left medium-9 columns">
            <ul class="ticketList">

                <?php

                if($pocetTicketu < 5001) {
                    vypisTickety($tickety);
                } else {
                    echo '~moc ticketů pro výpis~';
                }
                
                ?>

            </ul>        
           </section>
            
                
           <section class="float-right medium-3 columns row">
                <div id="stats">
                    <fieldset class="fieldset" name="stats">
                        <legend>Statistiky</legend>
                        <div class="row">
                            Počet tahů: <?php print count($tazeno); ?>
                        </div>
                        
                        <div class="row">
                            Počet 100% ticketů: <?php print count($stopro); ?>
                            (<?php echo count($stopro)/$pocetTicketu*100; ?>%)
                        </div>
                        <div class="row">
                            Počet plných ticketů: <?php print count($plne); ?>
                            (<?php echo count($plne)/$pocetTicketu*100; ?>%)
                        </div>
                        <div class="row">
                            Počet výherců: <?php print count($vyherci); ?>
                            (<?php echo count($vyherci)/$pocetTicketu*100; ?>%)
                        </div>
                        <div class="row">
                            Stačí shod pro výhru: <?php print $shodVyhercu; ?>
                        </div>
                        <hr>
                        <div class="row">
                            Stoprocentní tickety: 
                            <?php 
                            if($pocetTicketu<5001) {
                                foreach ($stopro as $value) {
                                    print_r($value);
                                    echo ', ';
                                }
                            } else {
                                echo '~moc ticketů~';
                            } ;
                            ?>
                        </div>
                        <hr>
                        <div class="row">
                            Plné tickety: 
                            <?php 
                            foreach ($plne as $value) {
                                print_r($value);
                                echo ', ';
                            } ;
                            ?>
                        </div>
                        <hr>
                        <div class="row">
                            Výherci: 
                            <?php 
                            foreach ($vyherci as $value) {
                                print_r($value);
                                echo ', ';
                            } ;
                            ?>
                        </div>
                    </fieldset>
                </div>
            </section>

            </div>
        </div>
        
        <script src="js/vendor/jquery.js"></script>
        <script src="js/vendor/what-input.js"></script>
        <script src="js/vendor/foundation.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
