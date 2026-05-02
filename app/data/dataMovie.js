// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "..";

let DataMovie = {};

/**
 * Récupère tous les films (filtrés par âge si profileId est fourni)
 */
DataMovie.requestMovies = async function (profileId = null) {
  let url = HOST_URL + "/server/script.php?todo=readmovies";
  if (profileId !== null) {
    url += "&profileId=" + profileId;
  }
  let answer = await fetch(url);
  let data = await answer.json();
  return data;
};

/**
 * Récupère les détails d'un film
 */
DataMovie.requestMovieDetails = async function (id, profileId = null) {
  let url = HOST_URL + "/server/script.php?todo=readmoviedetail&id=" + id;
  if (profileId !== null) {
    url += "&profileId=" + profileId;
  }
  let answer = await fetch(url);
  let data = await answer.json();
  return data;
};

/**
 * Ajoute ou supprime un favori
 */
DataMovie.requestAddFavorite = async function (profileId, movieId) {
  let url =
    HOST_URL +
    `/server/script.php?todo=addfavorite&profileId=${profileId}&movieId=${movieId}`;
  let answer = await fetch(url);
  return await answer.json();
};

/**
 * NOUVEAU : Récupère la liste des favoris
 * Note : On utilise "readfavorites" pour correspondre au switch dans script.php
 */
DataMovie.requestFavorites = async function (profileId) {
  let url =
    HOST_URL + `/server/script.php?todo=readfavorites&profileId=${profileId}`;
  let answer = await fetch(url);
  let data = await answer.json();
  return data;
};

export { DataMovie };
