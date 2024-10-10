const sendContactForm = () => {
  const subject = document.querySelector(`form input[name="your-subject"]`);
  const category = document.querySelector(".woo-product__category a");
  const product = document.querySelector(".woo-product__title");
  if (!subject || !category || !product) return;

  subject.value = `Consulta sobre la Honda ${product.textContent || ""} - ${
    category.textContent || ""
  }`;
};

const initDomReady = () => {
  sendContactForm();
};

document.addEventListener("DOMContentLoaded", () => {
  initDomReady();
});
