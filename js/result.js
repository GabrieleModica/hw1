

let allRestaurants = [];
let displayOnlyFavorites = false;
let currentCategory = INITIAL_CATEGORY;

document.addEventListener("DOMContentLoaded", initializePage);

function initializePage() {
    loadRestaurants(currentCategory);
    setupFilters();
}

function loadRestaurants(categoryString) {
    const url = "restaurants.php?lat=" + encodeURIComponent(LATITUDE) +
                "&lng=" + encodeURIComponent(LONGITUDE) +
                "&category=" + encodeURIComponent(categoryString);

    fetch(url)
        .then(function(response) {
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return response.json();
            } 
        })
        .then(function(restaurantList) {
            allRestaurants = restaurantList.slice();
            displayFilteredRestaurants();
        })
        .catch(function(error) {
            console.error("Errore:", error);
            const container = document.getElementById("places-container");
            container.textContent = "Errore nel caricamento dei risultati.";
        });
}

function displayFilteredRestaurants() {
    let restaurantsToShow = allRestaurants.slice();
    if (displayOnlyFavorites) {
        restaurantsToShow = restaurantsToShow.filter(function(restaurant) {
            return restaurant.isFavorite === true;
        });
    }
    renderRestaurants(restaurantsToShow);
}

function renderRestaurants(restaurantsList) {
    const container = document.getElementById("places-container");
    container.innerHTML = "";

    if (restaurantsList.length === 0) {
        container.textContent = "Nessun ristorante trovato.";
        return;
    }

    for (let i = 0; i < restaurantsList.length; i++) {
        const restaurant = restaurantsList[i];

        const placeDiv = document.createElement("div");
        placeDiv.className = "place" + (restaurant.isFavorite ? " favorite" : "");
        placeDiv.setAttribute("data-id", restaurant.id);

        if (restaurant.photo_url) {
            const imageDiv = document.createElement("div");
            imageDiv.className = "place-image";
            const imageElement = document.createElement("img");
            imageElement.src = restaurant.photo_url;
            imageElement.alt = restaurant.name;
            imageDiv.appendChild(imageElement);
            placeDiv.appendChild(imageDiv);
        }

        const infoDiv = document.createElement("div");
        infoDiv.className = "place-info";

        const nameHeading = document.createElement("h2");
        const nameLink = document.createElement("a");
        nameLink.href = "detail.php?fsq_id=" + encodeURIComponent(restaurant.id);
        nameLink.textContent = restaurant.name;
        nameHeading.appendChild(nameLink);

        const addressParagraph = document.createElement("p");
        const addressStrong = document.createElement("strong");
        addressStrong.textContent = "Indirizzo:";
        addressParagraph.appendChild(addressStrong);
        addressParagraph.appendChild(document.createTextNode(" " + restaurant.address));

        infoDiv.appendChild(nameHeading);
        infoDiv.appendChild(addressParagraph);
        placeDiv.appendChild(infoDiv);

        const actionDiv = document.createElement("div");
        actionDiv.className = "place-action";
        const favoriteButton = document.createElement("button");
        favoriteButton.className = "favorite-button";
        favoriteButton.textContent = restaurant.isFavorite
            ? "✅ Rimuovi dai preferiti"
            : "❤️ Aggiungi ai preferiti";
        actionDiv.appendChild(favoriteButton);
        placeDiv.appendChild(actionDiv);

        container.appendChild(placeDiv);
    }

    setupFavoriteButtons();
}

function setupFavoriteButtons() {
    const favoriteButtons = document.querySelectorAll(".favorite-button");
    for (let i = 0; i < favoriteButtons.length; i++) {
        const button = favoriteButtons[i];
        button.removeEventListener("click", handleFavoriteClick);
        button.addEventListener("click", handleFavoriteClick);
    }
}

function handleFavoriteClick(event) {
    const button = event.currentTarget;
    const placeElement = button.closest(".place");
    const restaurantId = placeElement.getAttribute("data-id");

    fetch("add_favorite.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "restaurant_id=" + encodeURIComponent(restaurantId)
    })
    .then(function(response) {
        return response.text();
    })
    .then(function(result) {
        if (result === "ADDED") {
            button.textContent = "✅ Rimuovi dai preferiti";
            placeElement.classList.add("favorite");
            allRestaurants = allRestaurants.map(function(r) {
                if (r.id === restaurantId) r.isFavorite = true;
                return r;
            });
        } else if (result === "REMOVED") {
            button.textContent = "❤️ Aggiungi ai preferiti";
            placeElement.classList.remove("favorite");
            allRestaurants = allRestaurants.map(function(r) {
                if (r.id === restaurantId) r.isFavorite = false;
                return r;
            });
        } else {
            alert("Errore: " + result);
        }
        displayFilteredRestaurants();
    })
    .catch(function(error) {
        console.error("Errore preferiti:", error);
        alert("Errore durante l'aggiornamento dei preferiti.");
    });
}

function setupFilters() {
    const filterFavoritesButton = document.getElementById("filter-favorites");
    if (filterFavoritesButton) {
        filterFavoritesButton.removeEventListener("click", handleFavoriteFilterClick);
        filterFavoritesButton.addEventListener("click", handleFavoriteFilterClick);
    }

    const categoryButtons = document.querySelectorAll(".filter-options button[data-category]");
    for (let k = 0; k < categoryButtons.length; k++) {
        const categoryButton = categoryButtons[k];
        categoryButton.removeEventListener("click", handleCategoryFilterClick);
        categoryButton.addEventListener("click", handleCategoryFilterClick);
    }
}

function handleFavoriteFilterClick() {
    displayOnlyFavorites = !displayOnlyFavorites;
    const filterFavoritesButton = document.getElementById("filter-favorites");
    filterFavoritesButton.textContent = displayOnlyFavorites
        ? "Mostra tutti"
        : "Mostra solo preferiti";
    displayFilteredRestaurants();
}

function handleCategoryFilterClick(event) {
    const selectedCategory = event.currentTarget.getAttribute("data-category");
    currentCategory = selectedCategory;
    loadRestaurants(selectedCategory);
}
