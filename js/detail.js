
document.addEventListener("DOMContentLoaded", initializeDetailPage);

function initializeDetailPage() {
    const detailsContainer = document.getElementById("details-container");
 
    const fsqId = detailsContainer.dataset.fsqId;

    fetch("place_details.php?fsq_id=" + encodeURIComponent(fsqId))
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            displayDetails(data);
        });
}

// Costruisce la pagina dei dettagli con i dati ricevuti
function displayDetails(data) {
    const detailsContainer = document.getElementById("details-container");
    detailsContainer.textContent = ""; 


    const infoSection = document.createElement("div");
    infoSection.id = "info-section";

    const imageSection = document.createElement("div");
    imageSection.id = "image-section";

   
    const nameElement = document.createElement("h2");
    nameElement.textContent = data.name;
    infoSection.appendChild(nameElement);

   
    const addressElement = document.createElement("p");
    addressElement.textContent = "Indirizzo: " + data.address;
    infoSection.appendChild(addressElement);


    const phoneElement = document.createElement("p");
    phoneElement.textContent = data.tel ? "Telefono: " + data.tel : "Telefono non disponibile";
    infoSection.appendChild(phoneElement);

    const ratingElement = document.createElement("p");
    ratingElement.textContent = data.rating ? "Valutazione: " + data.rating : "Valutazione non disponibile";
    infoSection.appendChild(ratingElement);

  
    if (data.photo) {
        const imageElement = document.createElement("img");
        imageElement.src = data.photo;
        imageElement.alt = "Immagine di " + data.name;
        imageElement.className = "local-image";
        imageSection.appendChild(imageElement);
    }

    // Sezione menu
    const menuSection = document.createElement("div");
    menuSection.id = "place-menu";

    if (data.menus && data.menus.length > 0) {
        const menuTitle = document.createElement("h3");
        menuTitle.textContent = "Menu";
        menuSection.appendChild(menuTitle);

        const menuList = document.createElement("ul");

      
        for (let i = 0; i < data.menus.length; i++) {
            const menuGroup = data.menus[i];
            for (let j = 0; j < menuGroup.items.length; j++) {
                const menuItem = menuGroup.items[j];
                const listItem = document.createElement("li");
                listItem.textContent = menuItem.name + " – " + menuItem.description + " (€" + menuItem.price + ")";
                menuList.appendChild(listItem);
            }
        }
        menuSection.appendChild(menuList);
    } 


    detailsContainer.appendChild(infoSection);
    detailsContainer.appendChild(imageSection);
    detailsContainer.appendChild(menuSection);
}