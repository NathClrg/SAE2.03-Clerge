let HOST_URL = "..";

let DataProfile = {};

DataProfile.requestProfiles = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readprofiles");
  let data = await answer.json();
  return data;
};

export { DataProfile };
