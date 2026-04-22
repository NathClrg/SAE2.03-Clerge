let templateFile = await fetch("./component/Movie_Card/template.html");
let template = await templateFile.text();

let Movie_Card = {};

Movie_Card.format = function (data, tab) {
  let html = template;
  html = html.replace("{{title}}", data.name);
  html = html.replace("{{image}}", data.image);
  return html;
};

export { Movie_Card };
