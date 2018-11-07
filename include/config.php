<?php
error_reporting(0);
session_start();

// change your database infomation
$host = "localhost";
$dbname = 'pfe';
$dbuser = 'root';
$dbpass = 'praga_mysql' ;

// dont touche
$db = new PDO ("mysql:dbname=$dbname;host=$host;charset=utf8",$dbuser,$dbpass);

function req($sql , $data ) {
  GLOBAL $db;
  $query=$db->prepare($sql);
  $data=$query->execute($data);
  if( $data ) return true;
  return false;
}

function fetch($sql , $data ) {
  GLOBAL $db;
  $query=$db->prepare($sql);
  $query->execute($data);
  return $query->fetchall();
}

function fetchone($sql , $data ) {
  $res = fetch($sql , $data );
  foreach ($res as $key ) {
    return $key;
  }
}

function redirect($url){
  echo "<script>window.location.replace('$url');</script>";
  die();
}

function getnum($sql, $data){
  GLOBAL $db;
  $query=$db->prepare($sql);
  $query->execute($data);
  return $query->rowCount();
}


?>
