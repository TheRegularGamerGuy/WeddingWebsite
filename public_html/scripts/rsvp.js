function insertAfter(newNode, existingNode) {
    existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
}

function checkForm(e) {
    const firstName = getElementByID("firstname");
    const lastName = getElementByID("lastname");
    if (firstName.value == "") {
        const errorMessage = document.createElement("p");
        const em = document.createElement("em");
        const errorText = document.createTextNode("Please enter your first name");
        em.appendChild(errorText);
        errorMessage.appendChild(em);
        insertAfter(errorMessage, firstName);
        e.preventDefault();
    }
    if (lastName.value == "") {
        const errorMessage = document.createElement("p");
        const em = document.createElement("em");
        const errorText = document.createTextNode("Please enter your last name");
        em.appendChild(errorText);
        errorMessage.appendChild(em);
        insertAfter(errorMessage, lastName);
        e.preventDefault();
    }
}

const form = document.getElementById("form");
form.addEventListener("submit", checkForm);