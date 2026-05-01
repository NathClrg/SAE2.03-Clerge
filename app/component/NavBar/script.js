let HOST_URL = "..";

let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};
let storedProfiles = [];

window.NavBar = NavBar;

NavBar.format = function (
  hAbout,
  hHome,
  profiles,
  handlerSelect,
  handlerLogOut,
) {
  storedProfiles = profiles || [];

  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace(
    "{{handlerSelect}}",
    handlerSelect || "C.handlerProfileSelect",
  );
  html = html.replace("{{handlerLogOut}}", handlerLogOut || "C.handlerLogOut");

  let profilesHtml = "";
  if (profiles && profiles.length > 0) {
    profiles.forEach((profile) => {
      profilesHtml += `<option value="${profile.nom}">${profile.nom}</option>`;
    });
  } else {
    profilesHtml = "<option>Aucun profil</option>";
  }

  html = html.replace("{{profiles}}", profilesHtml);
  return html;
};

NavBar.showProfileAvatar = function (profileName) {
  const avatarImg = document.getElementById("current-avatar");
  if (!avatarImg) return;

  if (!profileName || profileName === "") {
    avatarImg.style.display = "none";
    avatarImg.src = "";
    return;
  }

  const profile = storedProfiles.find((p) => p.nom === profileName);
  if (profile) {
    avatarImg.src = `${HOST_URL}/server/images/${profile.avatar}`;
    avatarImg.style.display = "inline-block";
  } else {
    avatarImg.style.display = "none";
    avatarImg.src = "";
  }
};

NavBar.resetProfileUI = function () {
  const avatarImg = document.getElementById("current-avatar");
  if (avatarImg) {
    avatarImg.style.display = "none";
    avatarImg.src = "";
  }

  const selectElement = document.querySelector(".profiles");
  if (selectElement) {
    selectElement.value = "";
  }
};

export { NavBar };
