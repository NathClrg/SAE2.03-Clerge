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
      "<p class='Profile__Warning'>Veuillez sélectionner un profil</p>",
    );
  } else {
    let htmlMovie = "";
    for (let movie of data) {
      let card = templateMovie;

      card = card.replace(/{{name}}/g, movie.name);
      card = card.replaceAll(/{{image}}/g, "../server/images/" + movie.image);
      card = card.replace(/{{id}}/g, movie.id);

      htmlMovie += card;
    }

    html = html.replace("{{movie}}", htmlMovie);
  }
  return html;
};

export { Movie };
