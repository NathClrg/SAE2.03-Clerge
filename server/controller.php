<?php

require("model.php");

function readMoviesController() {
    return getAllMovies();
}

function readMoviesByCategoryController() {
    $movies = getAllMovies();
    $grouped = [];

    foreach ($movies as $movie) {
        $grouped[$movie->label][] = $movie;
    }

    return $grouped;
}

function addMoviesController() {
    $t = $_REQUEST['titre'];
    $r = $_REQUEST['realisateur'];
    $y = $_REQUEST['annee'];
    $dur = $_REQUEST['duree'];
    $des = $_REQUEST['description'];
    $cat = $_REQUEST['categorie'];
    $img = $_REQUEST['cover'];
    $url = $_REQUEST['trailer'];
    $age = $_REQUEST['age_min'];

    $ok = addMovie($t, $r, $y, $dur, $des, $cat, $img, $url, $age);

    return ($ok != 0) ? "$t a été ajouté" : false;
}

function readMovieDetailController() {
    if (!isset($_REQUEST['id'])) {
        return false;
    }

    return getMovieDetail($_REQUEST['id']);
}