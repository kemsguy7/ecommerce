<?php 

//This script defines the basic

//turn on output buffering to prevent (header redirect error)
ob_start(); 

//turn on sessions
@session_start();

//defining the directory seperator
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");

//Admin pages
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");

//Image upload directory
defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads/");
/*
echo TEMPLATE_FRONT;
echo "<br/>";
echo TEMPLATE_BACK; 
*/
//echo the directory path
//echo __DIR__;


//defining the database constants.
defined("DB_HOST") ? null : define("DB_HOST", "localhost");
defined("DB_USER") ? null : define("DB_USER", "root");

defined("DB_PASS") ? null : define("DB_PASS", "");

defined("DB_NAME") ? null : define("DB_NAME", "ecom_db");

$connection = mysqli_connect(DB_HOST, DB_USER,DB_PASS,DB_NAME);

require_once("functions.php");
require_once("cart_func.php");
require_once("cart.php");
?>