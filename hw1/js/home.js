ì

const languageBtn = document.querySelector('img[src="img/italy-flag.svg"]');
const languageMenu = document.getElementById('language-menu');
const languageCloseBtn = document.querySelector('#language-menu .close-btn');
const menuOverlay = document.getElementById('menu-overlay');
function openLanguageMenu() {
    languageMenu.classList.add('visible');
    menuOverlay.classList.add('visible');
    document.body.classList.add('menu-open'); 
}

function closeLanguageMenu() {
    languageMenu.classList.remove('visible');
    menuOverlay.classList.remove('visible');
    document.body.classList.remove('menu-open');
}

languageBtn?.addEventListener('click', openLanguageMenu);
languageCloseBtn?.addEventListener('click', closeLanguageMenu);
menuOverlay?.addEventListener('click', closeLanguageMenu);

const foodImage = document.getElementById('foodImage');

function handleFoodImageHover() {
    if (!foodImage) return;

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
        currentImageIndex = 0;
        foodImage.src = imageList[currentImageIndex]; 
    }

    foodImage.addEventListener('mouseenter', startSlideshow);
    foodImage.addEventListener('mouseleave', stopSlideshow);
}

handleFoodImageHover();
