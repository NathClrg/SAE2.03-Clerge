let templateFile = await fetch("./component/Actualité/template.html");
let template = await templateFile.text();

let Actu = {};

Actu.format = function (MovieName, TrailerUrl) {
  let html = template;
  html = html.replace("{{titre_film}}", MovieName);
  html = html.replace("{{trailer_url}}", TrailerUrl);
  return html;
};

export { Actu };
