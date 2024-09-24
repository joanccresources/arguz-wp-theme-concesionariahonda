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
    const container = document.querySelector(
      "#navbar #menu-primary-menu + .others-option"
    );
    if (!container) return;
    container.innerHTML = `
      <button class="btn-menu">
        <img src="${urlAssets}/img/menu-burger.svg" alt="menu-icon" class="btn-menu__img"/>
      </button>
    `;
  };

  const initDomReady = () => {
    addButtonInHeader();
    changeFormContactFooter();
  };

  document.addEventListener("DOMContentLoaded", initDomReady);
})();
