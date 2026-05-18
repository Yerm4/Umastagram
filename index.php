<?php 

$ruta = isset($_GET["ruta"]) ? trim ($_GET["ruta"], "/") : "home";
$partesRuta = explode("/", $ruta);
$paginaActual = $partesRuta[0];

switch($paginaActual) {
    case "home":
        include "home.php";
        break;

    case "registro":
        include "registro.php";
        break;

    case "login": 
        include "login.php";
        break;

    case "perfil": 
        include "perfil.php";
        break;

    case "logout";
        include "logout.php";
        break;

    default: 
        include "home.php";
        break;
    }
