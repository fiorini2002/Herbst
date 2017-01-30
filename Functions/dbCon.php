<?php

function connectToDb()
{

$username = "joro16.wi5";
$password = "q3p2q5pk";
$database = "joro16_wi5_sde_dk";
$host     = "localhost";
  
  $objCon = new mysqli($host, $username, $password, $database);
  
  if($objCon->connect_errno){
      die('Der er ingen forbindelse til DB '. $objCon->error);
  } else {
      $objCon->set_charset('UTF8');
      return $objCon;
  }
}
