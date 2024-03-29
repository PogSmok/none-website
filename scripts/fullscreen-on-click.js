/**
 * Enlarges image to fullscreen on click, reverts to earlier view when user clicks anywhere once in fullscreen
 */

const images = [...document.getElementsByClassName("gallery-image")];
const fullSize = document.getElementById("fullscreen");
const wrapper = document.getElementById("wrapper");

//Hide fullscreen when clicked
fullscreen.onclick = () => {
    fullscreen.removeChild(fullscreen.children[0]);
    fullscreen.style.display = "none";
    document.body.style.overflowY = "auto";
}

//Display fullscreen on image click
images.forEach(image => {
    image.onclick = () => {
        const img = document.createElement("img");
        img.src = image.src;
        fullscreen.appendChild(img);
        fullscreen.style.display = "block";
        document.body.style.overflowY = "hidden";
    }
});