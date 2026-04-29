let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, hHome, profiles) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);

  let profilesHtml = "";
  if (profiles && profiles.length > 0) {
    profiles.forEach((profile) => {
      profilesHtml += `<li class="navbar__ProfileUser" onclick="C.handleProfileSelect('${profile.nom}')"><a href="#">${profile.nom}</a></li><img class="navbar__ProfileAvatar" src="${profile.avatar}" alt="Profile Picture" </img>`;
    });
  } else {
    profilesHtml = "<li>Aucun profil</li>";
  }

  html = html.replace("{{profiles}}", profilesHtml);
  return html;
};

export { NavBar };
