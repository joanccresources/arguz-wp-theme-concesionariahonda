// Header
// Menu
// Footer
(() => {
  const urlAssets =
    "https://concesionariahonda.sorsa.pe/wp-content/themes/eura-child-sorsa/assets";

  const changeFormContactFooter = () => {
    const form = document.querySelector("form:has(>.form-footer-contact)");
    if (!form) return;

    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (mutation.attributeName === "class") {
          const classList = form.classList;
          if (classList.contains("invalid")) {
            console.log("El formulario es inválido.");
            const newForm = document.querySelector(
              "form.invalid:has(>.form-footer-contact)"
            );
            if (!newForm) return;
            setTimeout(() => {
              const box1 = newForm.querySelector(".wpcf7-not-valid-tip");
              if (!box1) return;
              box1.innerHTML = "Por favor, rellene este campo.";

              const box2 = newForm.querySelector(".wpcf7-response-output");
              if (!box2) return;
              if (
                box2.textContent ===
                "One or more fields have an error. Please check and try again."
              ) {
                box2.textContent =
                  "Hay un error en uno o más campos. Por favor, compruébelo y vuelva a intentarlo.";
              }
            }, 150);
          } else if (classList.contains("sent")) {
            console.log("El formulario se envió con éxito.");
            const newForm = document.querySelector(
              "form.sent:has(>.form-footer-contact)"
            );
            if (!newForm) return;
            setTimeout(() => {
              const box2 = newForm.querySelector(".wpcf7-response-output");
              if (!box2) return;
              if (
                box2.textContent ===
                "Thank you for your message. It has been sent."
              ) {
                box2.textContent = "Gracias por tu mensaje. Ha sido enviado.";
              }
            }, 150);
          }
        }
      });
    });
    observer.observe(form, { attributes: true });
  };

  const addButtonInHeader = () => {
    // const container = document.querySelector(
    //   "#navbar #menu-primary-menu + .others-option"
    // );
    const container = document.querySelector("#navbar .navbar-toggler");
    if (!container) return;
    container.innerHTML = `      
      <img src="${urlAssets}/img/menu-burger.svg" alt="menu-icon" class="btn-menu__img"/>
    `;
    // container.innerHTML = `
    //   <button class="btn-menu">
    //     <img src="${urlAssets}/img/menu-burger.svg" alt="menu-icon" class="btn-menu__img"/>
    //   </button>
    // `;
  };

  const changePlaceholderSearch = () => {
    const search = document.querySelector(
      "#woocommerce-product-search-field-0"
    );
    if (!search) return;
    search.placeholder = "BUSCAR";
  };

  const addMenuTopInHeader = () => {
    const container = document.querySelector(
      "#navbar .container .collapse.navbar-collapse"
    );
    if (!container) return;
    const html = `
      <div id="top-header" class="top-header">
        <ul class="top-list-rrss">
          <li class="top-list-rrss__item">
            <a href="#0" target="_blank" class="top-list-rrss__link">
              <i class="fa fa-facebook top-list-rrss__icon" aria-hidden="true"></i>
            </a>            
          </li>
          <li class="top-list-rrss__item">
            <a href="#0" target="_blank" class="top-list-rrss__link">
              <i class="fa fa-instagram top-list-rrss__icon" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
        <div>
          <a class="btn-agenda-cita">
            <img src="${urlAssets}/img/top-moto-logo.png" width="59" height="42" class="btn-agenda-cita__img" />
            <span class="btn-agenda-cita__txt">AGENDA TU CITA</span>
          </a>
        </div>
      </div>
    `;
    container.insertAdjacentHTML("beforebegin", html);
  };

  const addCTAWhatsapp = () => {
    const container = document.querySelector("body");
    const html = `
      <div class="whatsapp-container">
        <a class="cta-wsp" href="#0">
          <img src="${urlAssets}/img/btn-wsp.png" alt="Boton Whatsapp" width="113" height="113" class="cta-wsp__img"/>
          <div class="cta-wsp__content">
            <span class="cta-wsp__title">¿TIENES UNA DUDA?</span>
            <span class="cta-wsp__txt">Escríbenos</span>
          </div>
        </a>
      </div>
    `;
    container.insertAdjacentHTML("beforeend", html);
  };

  const initDomReady = () => {
    addButtonInHeader();
    changeFormContactFooter();
    changePlaceholderSearch();

    addMenuTopInHeader();
    addCTAWhatsapp();
  };

  document.addEventListener("DOMContentLoaded", initDomReady);
})();
