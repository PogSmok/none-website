/**
 *  Generates navigation bar from navigation images and applies onhover and onclick functions for user interaction
 *  All the elements are created as children of the div with "nav-bar" class name to allow easy styling, additionally each image has a "nav-img" class name
 * 
 *  Uses current file structure for navigation and finding the files
 *  !WHEN CHANGING THE STRUCTURE OF THE resources/nav THE CODE MUST BE CHANGED!
 **/


const targetDiv = document.getElementsByClassName("nav-bar")[0];
const filePath = './resources/nav';
//Name of files holding navigation images in "../nav/" and the websites they are refering to, order declares order of appearences
const directories = ["about.webp", "gallery.webp", "contact.webp"];

/**
 * Checks if the given name is equal to the document name, used to highlight the current directory in navigation bar
 * @param {String} name name to be compared
 * @returns {Boolean} true if the given name and the document name are equal
 */
function isCurDir(name){
    let file = window.location.pathname.split("/");
    file = file[file.length-1].split(".")[0];
    const trueName = name.split(".")[0];
    return trueName === file;
}


/**
 * Creates a hyperlink element with a navigation image inside of it, the navigation image has "nav-img" class name
 * @param {String} filePath filepath to the "nav" folder
 * @param {String} name name of the file (including extension) with the navigation image
 * @param {Element} targetDiv the element which will be the parent of the hyperlink element with navigation image as its child
 * @returns {Element} the created img element (not the hyperlink parent)
 */
function createNavImg(filePath, name, targetDiv){

    const newHref = document.createElement("a");
    //Don't create hyperlink for current directory
    if(!isCurDir(name)){
        //Slice the name to remove the extension (.webp)
        newHref.href = `./${name.slice(0, -5)}.php`;
    }
    targetDiv.appendChild(newHref);

    const newImg = document.createElement("img");
    newImg.src = `${filePath}/default/${name}`;
    newImg.className = "nav-img";
    newHref.appendChild(newImg);

    return newImg;
}

/**
 * Adds the onmouseover, onmouseout and onclick listeners to a navigation image to modify its appearance when user interacts with it. Nav to the current page is styled differently.
 * @param {Element} img the img element holding the navigation image
 * @param {String} name name of the file (including extension) with the navigation image
 * @return {Void}
 */
function addFunctions(img, name){
    //Highlight the current directory
    if(isCurDir(name)){
        img.src = `${filePath}/click/${name}`;
        return;
    }

    img.onmouseover = () => img.src = `${filePath}/hover/${name}`;
    img.onmouseout = () => img.src = `${filePath}/default/${name}`;
    img.onclick = () => img.src = `${filePath}/click/${name}`;
}


directories.forEach(directory => {
    const img = createNavImg(filePath, directory, targetDiv);
    addFunctions(img, directory);
});
