<?php

require("model.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);
function readMoviesController() {
    // If no profileId is provided, return an empty array immediately
    if (!isset($_REQUEST['profileId']) || $_REQUEST['profileId'] === 'null') {
        return [];
    }

    $movies = getAllMovies();
    $userAge = getProfileAge($_REQUEST['profileId']);
    
    $filteredMovies = array_filter($movies, function($movie) use ($userAge) {
        return $movie->min_age <= $userAge;
    });

    return array_values($filteredMovies);
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

function addProfileController() {
    $age = $_REQUEST['age'];
    $nom = $_REQUEST['nom'];
    $avatar = $_REQUEST['avatar'];
    $newnom = isset($_REQUEST['newnom']) && $_REQUEST['newnom'] !== '' ? $_REQUEST['newnom'] : null;
    $result = addProfile($nom, $age, $avatar, $newnom);

    if ($result['status']) {
        if ($result['isRename']) {
            return "Le profil a été renommé en \"".$newnom."\" avec succès";
        } elseif ($result['isUpdate']) {
            return "Le profil \"".$nom."\" a été modifié avec succès";
        } else {
            return "Le profil \"".$nom."\" a été ajouté avec succès";
        }
    } else {
        return "Erreur lors de la création du profil";
    }
}


function readMovieDetailController() {
    if (!isset($_REQUEST['id'])) {
        return false;
    }

    return getMovieDetail($_REQUEST['id']);
}

function readProfilesController() {
    return getAllProfiles();
}

function addFavoriteController() {
    $id_p = $_REQUEST['profileId'];
    $id_m = $_REQUEST['movieId'];

    if (!is_numeric($id_m)) return false;

    // On essaie d'ajouter
    $ok = addFavorite($id_p, $id_m);

    if ($ok === false) {
        // Si l'ajout échoue (parce que le favori existe déjà), on le supprime
        $removed = removeFavorite($id_p, $id_m);
        return ($removed > 0) ? "removed" : false;
    }

    return "added";
}

function readFavoritesController() {
    if (!isset($_REQUEST['profileId'])) {
        return false;
    }

    return getFavoritesByProfile($_REQUEST['profileId']);
}