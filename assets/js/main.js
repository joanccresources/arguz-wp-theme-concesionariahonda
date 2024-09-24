// Header
// Menu
// Footer
(() => {
  const urlAssets =
    "https://concesionariahonda.sorsa.pe/wp-content/themes/eura-child-sorsa/assets";

  const addButtonInHeader = () => {
    const container = document.querySelector(
      "#navbar #menu-primary-menu + .others-option"
    );
    if (!container) return;
    console.log(container);
    container.innerHTML = `
      <button class="btn-menu">
        <img src="${urlAssets}/img/menu-burger.svg" alt="menu-icon" class="btn-menu__img"/>
      </button>
    `;
  };

  const initDomReady = () => {
    addButtonInHeader();
  };

  document.addEventListener("DOMContentLoaded", initDomReady);
})();
