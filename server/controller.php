<?php


require("model.php");


function readMoviesController(){
    $movies = getAllMovies();
    return $movies;
}

function updateController(){
  
  $semaine = $_REQUEST['semaine'];
  $jour = $_REQUEST['jour'];
  $entree = $_REQUEST['entree'];
  $plat = $_REQUEST['plat'];
  $dessert = $_REQUEST['dessert'];
  $ok = updateMenu($jour, $entree, $plat, $dessert);

  if ($ok!=0){
    return "Le menu du $jour est à jour";
  }
  else{
    return false;
  }
}
