let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();
let dataFile = await fetch("./component/Movie_Card/template.html"); // data is the file path
let dataHtml = await dataFile.text();
let Movie = {};

Movie.format = function (data) {
  let html = template;
  html = html.replace("{{li}}", dataHtml);
  return html;
};

export { Movie };
