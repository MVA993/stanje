<?php

session_start();

include "../classes/dbconnect.class.php";
include "../classes/artikal-model.class.php";
include "../classes/artikal-controller.class.php";                
include "../classes/artikal-view.class.php";


$beleska = $_POST['belezi'];

$baza = new DatabaseConnection();

$stanje = new ArtikalController($baza->conn);
$stanje->promena($beleska);

/*$niz = $_SESSION["artikal"];
unset($niz[0]);
$niz = array_filter($niz);
$_SESSION["artikal"] = $niz;*/

header("location:provera.inc.php?error=none");
