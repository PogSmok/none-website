/**
 *  Adds highlight to tiers plus content and funcitonality of the confirmation page before entering the form
 *  
 *  Tiers and their ids
 *      sketch 0
 *      drawing 1
 *      painting 2
 *      special 3
 *  !WHEN CHANGING THE STRUCTURE OF THE contact/tiers THE CODE MUST BE CHANGED!
 **/

/**
 * Highlights tiers on hover
 * @param {Element} tier Tier to be highlighted on hover
 * @return {Void}
 */
function addHighlight(tier){
    const tierImg = tier.children[0];
    const tierImgPath = tierImg.src;
    tier.onmouseover = () => tierImg.src = tierImgPath.replace("default", "highlight");
    tier.onmouseout = () => tierImg.src = tierImgPath;
}

/**
 * Displays confirmation screen before entering the form after selecting a tier
 * @return {Void}
 */
function showConfirmation(){
    const confirmation = document.getElementsByClassName("confirmation-container")[0];
    document.body.style.overflow = "hidden";
    confirmation.style.display = "block";
}

/**
 * Adds description to the confirmation page, based on what tier has been selected
 * @param {Integer} tierNumber Tier id, of currently selected tier
 * @returns {Void}
 */
function addDescription(tierNumber){
    const sketch = {
        name: "Sketch",
        left: null,
        right: "Drawing",
        label : "Starting at 10$",
        description: `
                    - Basic Sketches <br/>
                    - Many versions <br/>
                    - Simple, but efficient <br/>
                    - No stinky colours
                    `,
    };
    const drawing = {
        name: "Drawing",
        left: "Sketch",
        right: "Painting",
        label: "Starting at 20$",
        description: `
                    - simple character concepts <br/>
                    - cell shading <br/>
                    - cartooney style <br/>
                    - colours <br/>
                    `,
    };
    const painting = {
        name: "Painting",
        left: "Drawing",
        right: "Special",
        label: "Starting at 40$",
        description: `
                    - complex environments <br/>
                    - any style <br/>
                    - full resolution <br/>
                    - professional finish <br/>         
                    `,
    };
    const special = {
        name: "Special",
        left: "Painting",
        right: null,
        label: "Prices are individual",
        description: `
                    - 3d printing <br/>
                    - sculpture modeling <br/>
                    - experimental drawing style <br/>
                    - everything, just ask! <br/>         
                    `,
    };

    const descriptions = [sketch, drawing, painting, special];
    document.getElementsByClassName("label")[0].innerHTML = descriptions[tierNumber].label;
    document.getElementsByClassName("current-tier-text")[0].innerHTML = '[' + descriptions[tierNumber].name + ']';
    if(descriptions[tierNumber].left){
        document.getElementById("left-tier").innerHTML = '[' + descriptions[tierNumber].left + ']';
    } else {
        document.getElementById("left-tier").innerHTML = "";
    }
    if(descriptions[tierNumber].right){
        document.getElementById("right-tier").innerHTML = '[' + descriptions[tierNumber].right  + ']';
    } else {
        document.getElementById("right-tier").innerHTML = "";   
    }
    document.getElementsByClassName("about-tier")[0].innerHTML = "<b>Choose this if you want</b><br />" + descriptions[tierNumber].description;
}

/**
 * Sets visibility of all example images to hidden
 * @returns {Void}
 */
function hideImgs(){
    [...document.getElementsByClassName("type")].forEach(e => [...e.children].forEach(child => child.style.visibility = "hidden"));
}

/**
 * Translates integer id into the section it represents  (0 -> sketch 1 -> drawing 2 -> painting 3 -> special)
 * @param {Integer} id Id to be translated from 0 to 3 inclusive.
 * @returns {Void}
 */
function nextImg(id){
    if(id == 0){
        tier = "sketch";
    } else if(id == 1){
        tier = "drawing";
    } else if(id == 2) {
        tier = "painting";
    } else {
        tier = "special";
    }
    const leftArrow = document.getElementById("img-left");
    const rightArrow = document.getElementById("img-right");
    const images = document.getElementById(tier).children;
    hideImgs();
    images[0].style.visibility = "visible";
    let curImg = 0;
    leftArrow.onclick = () => {
        images[curImg].style.visibility = "hidden";
        curImg--;
        if(curImg < 0){
            curImg = images.length-1;
        }
        images[curImg].style.visibility = "visible";
    }
    rightArrow.onclick = () => {
        images[curImg].style.visibility = "hidden";
        curImg++;
        if(curImg > images.length-1){
            curImg = 0;
        }
        images[curImg].style.visibility = "visible";
    }
}

/**
 * Sets confirmation screen to given tier
 * @param {Integer} id Id of the tier to be set to from 0 to 3 inclusive.
 * @returns {Void}
 */
function swapTiers(id){
        hideImgs();
        addDescription(id);
        showConfirmation();
        nextImg(id);
}


//Load content before changing display
const confirmationContainer = document.getElementsByClassName("confirmation-container")[0];
confirmationContainer.style.display = "none";
confirmationContainer.style.visibility = "visible";


const tiers = [...document.getElementsByClassName("tier")];
tiers.forEach(tier => {
    addHighlight(tier);
    tier.onclick = () => {
        swapTiers(tier.id);
    }
});

//Handle mobile tiers
const mobileTiers = [...document.getElementsByClassName("mobile-tier")];
mobileTiers.forEach(tier => {
    tier.onclick = () => {
        swapTiers(tier.id);
    }
});

//Arrows for swapping the tiers
document.getElementById("left-arrow").onclick = () => {  
    const currentTier = document.getElementsByClassName("current-tier-text")[0].textContent.toLowerCase();
    if(currentTier == "[drawing]"){
        swapTiers(0);
    } else if(currentTier == "[painting]") {
        swapTiers(1);
    } else if(currentTier == "[special]") {
        swapTiers(2);
    }
}
document.getElementById("right-arrow").onclick = () => {
    const currentTier = document.getElementsByClassName("current-tier-text")[0].textContent.toLowerCase();
    if(currentTier == "[sketch]"){
        swapTiers(1);
    } else if(currentTier == "[drawing]") {
        swapTiers(2);
    } else if(currentTier == "[painting]") {
        swapTiers(3);
    }
}


//Add exit button
const exit = document.getElementsByClassName("exit")[0];
exit.onclick = () => {
    document.getElementsByClassName("confirmation-container")[0].style.display = "none";
    document.body.style.overflowY = "auto";
    hideImgs();
}

exit.onmouseover = () => exit.src = "./resources/contact/close1.webp";
exit.onmouseout = () => exit.src = "./resources/contact/close.webp";