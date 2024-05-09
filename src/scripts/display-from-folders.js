/**
 *  "opens" folders on click by displaying images inside it and implements returning back to folder view
 **/

const folders = [...document.getElementsByClassName("folder")];
const returnButtons = [...document.getElementsByClassName("return-button")];

/**
 * Hides all content except images which parent has given id
 * @param {String} id id of the folder to display images from
 * @returns {Void}
 */
function displayImages(id){
    //Hide all folders
    [...document.getElementsByClassName("folders")][0].style.display = "none";

    //Display images from given folder
    document.getElementById(`parent-id-${id}`).style.display = "flex";
}

/**
 * Hides given element (container of all displayed images) and displays folders
 * @param {Element} images Container of all displayed images to hide
 * @returns {Void}
 */
function returnToFolders(images){
    //Hide the images that were displayed
    images.style.display = "none";

    //Display all folders
    [...document.getElementsByClassName("folders")][0].style.display = "grid";
}

//Display images on folder click
folders.forEach(folder => {
    const id = folder.id;
    folder.onclick = () => {
        displayImages(id);
    };

    //Trigger also when user clicks on the image on the folder, not the folder itself
    folder.parentNode.children[2].onclick = () => {
        displayImages(id);
    };
});

//Return to base view on return button click
returnButtons.forEach(returnButton => {
    const rawId = returnButton.id;
    const id = rawId.split("-").slice(-1).join();
    const imagesElement = document.getElementById(`parent-id-${id}`);
    returnButton.onclick = () => {
        returnToFolders(imagesElement);
    }

    //Animate hover for desktops
    returnButton.onmouseover = () => {
        returnButton.style.transform = "rotate(25)";
    }
});