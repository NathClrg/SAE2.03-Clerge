let categoryTemplateFile = await fetch(
  "./component/MovieCategory/template.html",
);
let categoryTemplate = await categoryTemplateFile.text();

let movieTemplateFile = await fetch("./component/Movie/templateMovie.html");
let movieTemplate = await movieTemplateFile.text();

export function MovieCategory(movies) {
  let categories = {};

  for (let movie of movies) {
    let cat = movie.label;

    if (!categories[cat]) {
      categories[cat] = "";
    }

    categories[cat] += movieTemplate
      .replace(/{{id}}/g, movie.id)
      .replace(/{{image}}/g, "../server/images/" + movie.image)
      .replace(/{{name}}/g, movie.name);
  }

  let html = "";

  for (let cat in categories) {
    html += categoryTemplate
      .replace(/{{category}}/g, cat)
      .replace(/{{movie}}/g, categories[cat]);
  }

  return html;
}
