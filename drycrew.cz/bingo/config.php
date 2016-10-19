<?php

if ($_SESSION['pocetTicketu']) {
    $pocetTicketu = $_SESSION['pocetTicketu'];
} else {
    $pocetTicketu = 100;
}

if ($_SESSION['delkaTicketu']) {
    $delkaTicketu = $_SESSION['delkaTicketu'];
} else {
    $delkaTicketu = 7;
}

if ($_SESSION['maxCislo']) {
    $maxCislo = $_SESSION['maxCislo'];
} else {
    $maxCislo = 9;
}
//if ($_SESSION['maxVyhercu']) {
//    $maxVyhercu = $_SESSION['maxVyhercu'];
//} else {
//    $maxVyhercu = 500;
//}

$zeroAllowed = true;
$tickety = $_SESSION['tickety'];