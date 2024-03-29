/**
 *  Hides and displays tables with images for easier navigation
 **/

const buttons = [...document.getElementsByClassName("display-img")];

buttons.forEach(button => {
    const id = button.id;

    button.onclick = () => {
        const targetTable = document.getElementById(`table-${id}`);
        if(targetTable.style.visibility !== "visible"){
            targetTable.style.visibility = "visible";
            targetTable.style.position = "relative";
        } else {
            targetTable.style.visibility = "hidden";
            targetTable.style.position = "absolute";
        }
    };
});