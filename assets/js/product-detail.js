(() => {
  const sendContactForm = () => {
    const subject = document.querySelector(`form input[name="your-subject"]`);
    const category = document.querySelector(".woo-product__category a");
    const product = document.querySelector(".woo-product__title");
    if (!subject || !category || !product) return;

    subject.value = `Consulta sobre la Honda ${product.textContent || ""} - ${
      category.textContent || ""
    }`;
  };

  const addInput = () => {
    const changeTextInput = () => {
      setTimeout(() => {
        const departamento = document.querySelector(`#departamento`)?.value;
        const provincia = document.querySelector(
          `[data-class="wpcf7cf_group"]:not(.wpcf7cf-hidden) [name="provincia"]`
        )?.value;
        const concesionario = document.querySelector("#concesionario");

        console.log({ departamento, provincia });

        if (departamento === "San Martín" && provincia === "Tarapoto") {
          concesionario.value = "Jr. Libertad Nro 150";
        }
        if (departamento === "Ucayali" && provincia === "Pucallpa") {
          concesionario.value = "Jr. Amazonas 1340";
        }
      }, 500);
    };

    changeTextInput();

    // Selecciona todos los elementos <select> en la página
    const selects = document.querySelectorAll("select");

    // Recorre cada <select> y añade un listener para el evento 'change'
    selects.forEach((select) => {
      select.addEventListener("change", (event) => {
        // Obtén el elemento que desencadenó el evento
        const target = event.target;
        console.log(target);
        if (target.name === "departamento") {
          console.log("departamento");
          changeTextInput();
        }
        if (target.name === "provincia") {
          console.log("provincia");
          changeTextInput();
        }
      });
    });
  };

  const initDomReady = () => {
    sendContactForm();
    addInput();
  };

  document.addEventListener("DOMContentLoaded", () => {
    initDomReady();
  });
})();
