<?php

include 'config.php';

//vygeneruje losy dle konfigurace a uloží do session
function vygenerujTickety() {
    global $pocetTicketu;
    global $maxCislo;
    global $delkaTicketu;
    $tickety = '';

    for ($i = 0; $i < $pocetTicketu; $i++) {
        $tickety[$i] = generujCislaDoTicketu($delkaTicketu, $maxCislo);
    }
    $_SESSION['tickety'] = $tickety;
}

function generujCislaDoTicketu ($delkaticketu, $maxCislo) {
    for ($j = 0; $j < $delkaticketu; $j++) { 
            $cislo = '';
            $cislo[0] = rand(0, $maxCislo);
            $cislo[1] = FALSE;
            $ticket[$j] = $cislo;
    }
    return $ticket;
}


// projede pole a pokud se číslo shoduje s tahem, nastaví mu TRUE do [1]
function kontrolujShody() {
    global $tickety;
    global $tah; //zatim jen cislo
       
        foreach ($tickety as $id => $ticket) {

            foreach ($ticket as $key => $cislo) {

                if ($cislo[1] == FALSE && $cislo[0] == $tah) {
                    $tickety[$id][$key][1] = true;
                    break;
                }                     
           }              
        }

    
    $_SESSION['tickety'] = $tickety;


}


function vypisTickety($tickety) {
    global $shody;
    global $delkaTicketu;
    foreach ($tickety as $id => $ticket) {
                    echo '<li>Ticket č. ' . $id . ': ';
                    echo '<span class="outof">('.$shody[$id].'/'.$delkaTicketu.')</span>';
                    echo '<div class="ticket row">';

                    foreach ($ticket as $key => $cislo) {
                    $tag = '';
                    if($cislo[1] == TRUE) {
                        $tag = 'match';
                    }
                        echo '<span class="ticketitem ' . $tag . '">' .$cislo[0]. '</span>';
                    }
 
                   echo '</div>';
                   echo '</li>';
                }
}

function vypisTazeno(array $tazeno) {
    $count = count($tazeno);
    echo '<div class="tazeno column ">';
    
    foreach ($tazeno as $poradi => $tah) {
        $tag = '';
     
        if($poradi == $count-1) $tag = 'last';
        echo '<span class="ticketitem '.$tag.'">';
        print_r($tah);
        
        
        echo '</span>';
    }
    
    echo '</div>';
}

// uloží shody do pole $shody ve form. ID ticketu => pocet
function spocitejShody(array $tickety) {
    $shody = Array();
    
    foreach ($tickety as $id => $ticket) {
        $pocet = 0;
        foreach ($ticket as $key => $cislo) {
            if($cislo[1] == TRUE) {
                $pocet++;
            }
        }
        $shody[$id] = $pocet;
    }

    return $shody;
}

// uloží do pole $stopro tickety, které odpovídají všem tahům
function oznacStoprocentni(array $shody, array $tazeno) {
    $stopro = array();
    foreach ($shody as $id => $pocet) {
        if($pocet == count($tazeno)) {
            array_push($stopro, $id);
        }
        
    }
    return $stopro;
}

// uloží do pole $plne tickety, které jsou plne oznacene
function oznacPlne(array $shody) {
    $plne = array();
    global $delkaTicketu;
    foreach ($shody as $id => $pocet) {
        if($pocet == $delkaTicketu) {
            array_push($plne, $id);
        }
    }
    return $plne;
}

function oznacVyherce(array $shody) {
    $vyherci = array();
    
    $pocty = array();
    foreach ($shody as $id => $pocet) {
        array_push($pocty, $pocet);
    }
    foreach ($shody as $id => $pocet) {
        if($pocet == max($pocty)) {
            array_push($vyherci, $id);
        }
        
    }
    return $vyherci;
}