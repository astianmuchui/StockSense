const lines = document.getElementById("lines");
const cancel = document.getElementById("cancel");
const menu = document.getElementById("menu");
const bio_trigger = document.getElementById("bio-trigger");
const bio_cancel = document.getElementById("cancel-profile");
const bio = document.getElementById("profile");

lines.onclick = ()=>{
    menu.style.display = "flex";
    bio.style.display = "none";

}
cancel.onclick = ()=>{
    menu.style.display = "none";
}


bio_trigger.onclick = ()=>{
    bio.style.display = "flex";
    menu.style.display = "none";
}

bio_cancel.onclick = ()=>{
    bio.style.display = "none";
}