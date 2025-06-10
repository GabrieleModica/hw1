
const menuToggleBtn = document.getElementById('menù');
const accountMenu = document.getElementById('account-menu');
const menuOverlay = document.getElementById('menu-overlay');
const menuCloseBtn = document.querySelector('.close-btn');

const languageBtn = document.querySelector('img[src="img/italy-flag.svg"]');
const languageMenu = document.getElementById('language-menu');
const languageCloseBtn = document.querySelector('#language-menu .close-btn');

const footerToggles = document.querySelectorAll('.footer-toggle');
const foodImage = document.getElementById('foodImage');

const form = document.getElementById('address-form');
const input = document.getElementById('address-input');
const suggestions = document.getElementById('suggestions');

const MAPBOX_API_KEY = 'secret';

let coord = null;

// Funzioni per mostrare/nascondere i menu
function openMenu() {
    accountMenu?.classList.add('visible');
    menuOverlay?.classList.add('visible');
    document.body.classList.add('menu-open');
}

function closeMenu() {
    accountMenu?.classList.remove('visible');
    menuOverlay?.classList.remove('visible');
    document.body.classList.remove('menu-open');
}

menuToggleBtn?.addEventListener('click', openMenu);
menuCloseBtn?.addEventListener('click', closeMenu);

function openLanguageMenu() {
    languageMenu?.classList.add('visible');
    menuOverlay?.classList.add('visible');
    document.body.classList.add('menu-open');
}

function closeLanguageMenu() {
    languageMenu?.classList.remove('visible');
    menuOverlay?.classList.remove('visible');
    document.body.classList.remove('menu-open');
}

languageBtn?.addEventListener('click', openLanguageMenu);
languageCloseBtn?.addEventListener('click', closeLanguageMenu);

// Gestione apertura/chiusura delle sezioni del footer
function handleFooterToggle(event) {
    const toggle = event.currentTarget;
    const footerSection = toggle.closest('.footer-section');
    const icon = toggle.querySelector('.toggle-icon');

    if (footerSection?.classList.contains('visible')) {
        footerSection.classList.remove('visible');
        icon.textContent = '+';
    } else {
        footerSection.classList.add('visible');
        icon.textContent = '-';
    }
}

footerToggles.forEach(function(toggle) {
    toggle.addEventListener('click', handleFooterToggle);
});

// Slideshow immagini cibo nella home
const imageList = [
    'img/cheeseburger_home_dss_desktop_it.5bf7d9e2.png',
    'img/margherita_pizza_home_dss_desktop_it.cb7f849f.png',
    'img/falafel_salad_home_dss_desktop_it.45ec9a5d.png'
];

let currentImageIndex = 0;
let imageInterval = null;

function updateSlideshow() {
    currentImageIndex = (currentImageIndex + 1) % imageList.length;
    foodImage.src = imageList[currentImageIndex];
}

function startSlideshow() {
    currentImageIndex = 1;
    foodImage.src = imageList[currentImageIndex];
    imageInterval = setInterval(updateSlideshow, 1500);
}

function stopSlideshow() {
    clearInterval(imageInterval);
}

// Attiva slideshow al passaggio del mouse sull'immagine
function handleFoodImageHover() {
    if (!foodImage) return;
    foodImage.addEventListener('mouseenter', startSlideshow);
    foodImage.addEventListener('mouseleave', stopSlideshow);
}

handleFoodImageHover();


function showCurrentBlock(container, blocks, currentBlock) {
    for (let i = 0; i < blocks.length; i++) {
        blocks[i].style.display = (i === currentBlock) ? 'block' : 'none';
    }
}

function handleCarouselArrowClick(blocks, state) {
    state.currentBlock = (state.currentBlock + 1) % blocks.length;
    showCurrentBlock(state.container, blocks, state.currentBlock);
}

function handleCarouselResize(section, state) {
    const blocks = state.blocks;
    const arrowBtn = state.arrowBtn;
    if (window.innerWidth <= 900) {
        if (!state.container.contains(arrowBtn)) {
            state.container.appendChild(arrowBtn);
        }
        showCurrentBlock(state.container, blocks, state.currentBlock);
    } else {
        if (state.container.contains(arrowBtn)) {
            state.container.removeChild(arrowBtn);
        }
        for (let i = 0; i < blocks.length; i++) {
            blocks[i].style.display = 'block';
        }
    }
}

// Inizializza il carosello per ogni sezione
function initCarousel() {
    const sections = document.querySelectorAll('section.how-to-order, section.util');

    sections.forEach(function(section) {
        const container = section.querySelector('.indicazioni');
        const blocks = container?.querySelectorAll('.block');
        if (!container || !blocks || blocks.length === 0) return;

        const arrowBtn = document.createElement('button');
        arrowBtn.className = 'carousel-arrow';
        const arrowIcon = document.createElement('img');
        arrowIcon.src = 'img/freccia.svg';
        arrowBtn.appendChild(arrowIcon);

        const state = {
            container: container,
            blocks: blocks,
            arrowBtn: arrowBtn,
            currentBlock: 0
        };

        arrowBtn.addEventListener('click', function() {
            handleCarouselArrowClick(blocks, state);
        });
        window.addEventListener('resize', function() {
            handleCarouselResize(section, state);
        });

        handleCarouselResize(section, state);
    });
}

initCarousel();

function onResponse(response) {
    return response.json();
}

// Mostra i suggerimenti di indirizzo sotto il campo input
function mostraSuggerimenti(json) {
    suggestions.innerHTML = '';
    for (let i = 0; i < json.features.length; i++) {
        const feature = json.features[i];
        const div = document.createElement('div');
        div.textContent = feature.place_name;
        div.addEventListener('click', function() {
            input.value = feature.place_name;
            coord = feature.center;
            suggestions.innerHTML = '';
        });
        suggestions.appendChild(div);
    }
}

// Ottiene coordinate da Mapbox e reindirizza ai risultati
function fetchCoordAndRedirect(address) {
    const url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
              + encodeURIComponent(address)
              + '.json?access_token=' + MAPBOX_API_KEY
              + '&country=IT&limit=1';

    fetch(url)
      .then(onResponse)
      .then(function(json) {
          if (json.features.length > 0) {
              const feature = json.features[0];
              const lat = feature.center[1];
              const lng = feature.center[0];
              const indirizzo = encodeURIComponent(feature.place_name);
            
              window.location.href = 'result.php?lat='
                  + lat + '&lng=' + lng + '&address=' + indirizzo;
          } else {
              alert('Indirizzo non trovato.');
          }
      });
}

// Suggerimenti mentre l'utente scrive l'indirizzo
input.addEventListener('input', function() {
    if (input.value.length > 2) {
        const url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
                  + encodeURIComponent(input.value)
                  + '.json?access_token=' + MAPBOX_API_KEY
                  + '&country=IT&limit=5';

        fetch(url)
          .then(onResponse)
          .then(mostraSuggerimenti);
    } else {
        suggestions.innerHTML = '';
    }
});

// Gestione invio del form indirizzo
form.addEventListener('submit', function(event) {
    event.preventDefault();
    if (coord) {
        const lng = coord[0];
        const lat = coord[1];
        const indirizzo = encodeURIComponent(input.value);
    
        window.location.href = 'result.php?lat='
            + lat + '&lng=' + lng + '&address=' + indirizzo;
    } else if (input.value.length > 2) {
        fetchCoordAndRedirect(input.value);
    } else {
        alert('Inserisci un indirizzo valido.');
    }
});