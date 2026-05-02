// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "..";

let DataMovie = {};

/**
 * Modified: Now accepts profileId to filter movies based on age.
 */
DataMovie.requestMovies = async function (profileId = null) {
  // We start with the base URL
  let url = HOST_URL + "/server/script.php?todo=readmovies";

  // If a profileId is provided, we append it to the query string
  if (profileId !== null) {
    url += "&profileId=" + profileId;
  }

  let answer = await fetch(url);
  let data = await answer.json();
  return data;
};

/**
 * Modified: Also accepts profileId for detail view
 * (In case you want to block the detail page for specific ages too)
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

export { DataMovie };
