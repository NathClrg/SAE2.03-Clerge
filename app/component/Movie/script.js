let templateFile = await fetch("./component/Movie/template.html");
let templateFileMovie = await fetch("./component/Movie/templateMovie.html");
let template = await templateFile.text();
let templateMovie = await templateFileMovie.text();

let Movie = {};

Movie.format = function (data, tab) {
  let html = template;
  if (data.length == 0) {
    html = html.replace(
      "{{movie}}",
      "<p class='Movie_title'>J'ai le seum pour toi mais vas sur Anime-Sama! ;) </p>",
    );
  } else {
    let htmlMovie = "";
    for (let movie of data) {
      let card = templateMovie;
      card = card
        .replaceAll("{{name}}", movie.name)
        .replaceAll("{{image}}", "../server/images/" + movie.image)
        .replaceAll("{{id}}", movie.id);
      htmlMovie += card;
    }
    html = html.replace("{{movie}}", htmlMovie);
  }
  return html;
};

export { Movie };
