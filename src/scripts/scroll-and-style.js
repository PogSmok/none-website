/**
 *  Scrolls to selected posts on about me page and applies functionality to about-nav, adds highlight to the selected post and styles it accordingly 
 **/

/**
 * Styles highlight depending on the dimension of the screen the website is viewed on
 * @param {Element} newImg The highlight element
 * @param {Integer} imgHeight The height of the image in the about me post, 0 if non existent
 * @returns {Void}
 */
function styleHighlight(newImg, imgHeight){
    const tabletQuery = window.matchMedia("(max-width: 900px) and (min-width: 500px)");
    const phoneQuery = window.matchMedia("(max-width: 500px");
    if(tabletQuery.matches){
        newImg.style.cssText = `
        position: absolute;
        height: 440px;
        max-width: 100%;
        min-width: 100vw;
        margin-top: ${imgHeight ? imgHeight + 20 : 0}px;
        `;
    } else if(phoneQuery.matches){
        newImg.style.cssText = `
        position: absolute;
        height: 370px;
        max-width: 100%;
        min-width: 100vw;
        margin-top: ${imgHeight ? imgHeight + 20 : 0}px;
        `;
    } else {
        newImg.style.cssText = `
        position: absolute;
        height: 500px;
        max-width: 100%;
        min-width: 100vw;
        margin: 0;
        `;
    }
}

/**
 * Creates a highlight image for given post
 * @param {Element} targetDiv the post to be highlighted
 * @returns {Element} the created img element
 */
function createHighlight(targetDiv){
    const newImg = document.createElement("img");
    newImg.src = "./resources/about/post-highlight.webp";
    newImg.className = "highlight";
    targetDiv.insertBefore(newImg, targetDiv.children[0]);

    //Style highlight for mobile and tablets
    let postImg = targetDiv.children[1].children[0], imgHeight;
    if(postImg.tagName !== "IMG") postImg = null;
    imgHeight = postImg ? postImg.height : 0;

    window.matchMedia("(max-width: 900px) and (min-width: 500px)").addEventListener("change", () => styleHighlight(newImg, imgHeight));
    window.matchMedia("(max-width: 500px").addEventListener("change", () => styleHighlight(newImg, imgHeight));

    //Initial style
    styleHighlight(newImg, imgHeight);

    return newImg;
}

/**
 * Styles about containers depending on the viewport resolution
 * @returns {Void}
 */
function styleAbout(){
    const tabletQuery = window.matchMedia("(max-width: 900px) and (min-width: 500px)");
    const phoneQuery = window.matchMedia("(max-width: 500px");
    [...document.getElementsByClassName("about-post-container")].forEach(container => {

        let aboutImg = container.children[0].children[0];
        //Edge case for highlighted post
        if(!aboutImg) aboutImg = container.children[1].children[0];

        if(aboutImg.tagName !== "IMG") aboutImg = null;
        const aboutImgHeight = aboutImg ? aboutImg.height : 0;

        if(aboutImgHeight === 0){
            container.children[0].children[0].style.width = "100%";
            container.children[0].children[0].style.textAlign = "center";
        }

        if(tabletQuery.matches){
            container.style.height = `${aboutImgHeight + 510}px`
        } else if(phoneQuery.matches){
            container.style.height = `${aboutImgHeight + 450}px`
        } else {
            container.style.height = "510px";
        }
    });
}

const aboutNav = document.getElementsByClassName("about-nav")[0];
let lastId = document.getElementsByClassName("about-nav")[0].children[0].children[0].id, lastHighlight = null;

//Highlight the first post by definition
lastHighlight = createHighlight(document.getElementsByClassName("about")[0].children[0]);

[...aboutNav.children].forEach(navContainer => {
    const nav = navContainer.children[0];
    let oldColor = nav.style.color;

    //Style the sketchy border on hover
    nav.onmouseover = () => {
        nav.style.cssText = `
            border: white;
            color: white;
        
            padding: 4px 8px;
            display: inline-block;
            border: 2px solid #ffffff;
            border-radius: 4% 12% 10% 8%/2% 2% 4% 8%;
            position: relative;
            object-fit: cover;
            background-position: 10% 0, 0;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        `;
        nav.style.backgroundImage="url(./resources/about/about-highlight.webp)";
    };

    //Remove the sketchy border on mouse out
    nav.onmouseout = () => {
        nav.style.backgroundImage="";
        nav.style.cssText = `
            position: relative;
            
            color: ${oldColor};
            padding: 8px 10px;

            border: white;
        `;
    }

    //Scroll on click and style the post
    nav.onclick = () => {
        //Remove style from earlier selected post
        lastHighlight.remove();
        lastId = nav.id;
        lastHighlight = createHighlight(document.getElementById(`post-${lastId}`));
        document.getElementById(`post-${lastId}`).scrollIntoView({behavior: "smooth"});
    }
});

//Style about containers depending on the viewport
window.matchMedia("(max-width: 900px) and (min-width: 500px)").addEventListener("change", () => styleAbout());
window.matchMedia("(max-width: 500px").addEventListener("change", () => styleAbout());

styleAbout();