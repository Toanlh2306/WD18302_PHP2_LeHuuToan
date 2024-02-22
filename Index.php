<?php
require_once "vendor\autoload.php";
session_start();

define("URL","http://127.0.0.1:7000");
define("URL_ASSET",URL."/App/Views");

use App\Core\Route;



$route=new Route;
