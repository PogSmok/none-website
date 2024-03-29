/**
 *  Displays form and adjusts its content to what has been selected by the user
 **/


/**
 * @return {Void}
 */
function hideConfirmationShowForm(){
    //From tier-style-and-confirmation.js   
    hideImgs();
    document.getElementsByClassName("form-container")[0].style.display = "block";
    document.getElementsByClassName("confirmation-container")[0].style.display = "none";
}

//Load content before changing display
const formContainer = document.getElementsByClassName("form-container")[0];
formContainer.style.display = "none";
formContainer.style.visibility = "visible";

const proceed = document.getElementsByClassName("proceed")[0];
proceed.onmouseover = () => {
    proceed.src = "./resources/contact/proceed1.webp";
}
proceed.onmouseout = () => {
    proceed.src = "./resources/contact/proceed.webp";
}

proceed.onclick = () => {
    hideConfirmationShowForm();
    let type = document.getElementsByClassName("current-tier-text")[0].innerHTML.slice(1, -1);
    document.getElementById("selected-tier").innerHTML = "Selected Tier: " + type;
    document.getElementById("type").value = type;
    console.log(document.getElementById("type"));
}

//Add exit button
const exitForm = document.getElementsByClassName("exit-form")[0];
exitForm.onclick = () => {
    document.getElementsByClassName("form-container")[0].style.display = "none";
    document.body.style.overflowY = "auto";
}

exitForm.onmouseover = () => exit.src = "./resources/contact/close1.webp";
exitForm.onmouseout = () => exit.src = "./resources/contact/close.webp";