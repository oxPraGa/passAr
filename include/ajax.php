<?php
  require_once("config.php");
  if($_POST["action"] == "getAuthetType"){
    $rezult = fetchone("SELECT * FROM `user` WHERE `username` = ? ",array($_POST["username"]));
    if( count($rezult) == 0 ) echo -1;
    else echo $rezult['type_pass'];
  }
  if($_POST["action"] == "authentet"){
    $rezult = getnum("SELECT * FROM `user` WHERE `username` = ? AND `password` = ? ",array($_POST["username"] , $_POST['password']));
    if($rezult != 0 ){
      $_SESSION["admin"] = true;
      echo 1;
    }else{
      echo -1;
    }
  }

  if($_POST["action"] == "segment"){
    $str = "python ../python/slic.py ../data/".$_SESSION["img"]." ".$_POST["regionSize"];
    echo $str;
    echo shell_exec($str);
  }

  if($_POST["action"] == "saveImagePass"){
      req("UPDATE `user` SET `password`=?,`type_pass`=1 WHERE `id` = 1",array($_POST["pass"]));
      echo "ok";
  }
  if($_POST["action"] == "authentet_image"){
    $rezult = getnum("SELECT * FROM `user` WHERE `username` = ? AND `password` = ? ",array($_POST["username"] , $_POST['password']));
    if($rezult != 0 ){
      $_SESSION["admin"] = true;
      echo 1;
    }else{
      echo -1;
    }
  }
  if($_POST["action"] == "authentet_3D"){
    $rezult = getnum("SELECT * FROM `user` WHERE `username` = ? AND `password` = ? ",array($_POST["username"] , $_POST['password']));
    if($rezult != 0 ){
      $_SESSION["admin"] = true;
      echo 1;
    }else{
      echo -1;
    }
  }
  if($_POST["action"] == "save3dPass"){
      req("UPDATE `user` SET `password`=?,`type_pass`=2 WHERE `id` = 1",array($_POST["pass"]));
      echo "ok";
  }
  if($_POST["action"] == "save3dPassAr"){
      req("UPDATE `user` SET `password`=?,`type_pass`=3 WHERE `id` = 1",array($_POST["pass"]));
      echo "ok";
  }
  if($_POST["action"] == "saveMarker"){
    file_put_contents("../markerOk.pat",$_POST["marker"] );
  }
?>
