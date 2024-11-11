(() => {
  const addHTMLFilterCategories = (categoriesAndSub) => {
    const container = document.querySelector(
      "#secondary .woocommerce-product-search"
    );
    if (!container) return;

    let categories = categoriesAndSub.filter(
      (item) => item.slug.split("/").length === 3
    );
    const newSubCategories = categoriesAndSub.filter(
      (item) => item.slug.split("/").length === 4
    );

    categories = categories.map((category) => {
      return {
        ...category,
        subcategories: newSubCategories.filter((subcategory) => {
          return category.slug.split("/")[1] === subcategory.slug.split("/")[1];
        }),
      };
    });

    let html = `
      <div id="cat-sub-categories">
        <ul class="filter-categories">`;
    // Recorremos el array de categorías
    categories.forEach((category, index) => {
      html += `
        <li class="filter-categories__item">
          <div class="d-flex justify-content-between align-items-center">
            <a href="${
              location.origin + "/product-category" + category.slug
            }" class="filter-categories__link">${category.name}</a>
            <button class="btn">
              <i class="fa fa-chevron-down open open-${
                index + 1
              }" aria-hidden="true"></i>
            </button>
          </div>
          <ul class="filter-subcategories">
        `;
      // Recorremos las subcategorías de cada categoría
      category.subcategories.forEach((subcategory) => {
        html += `
          <li class="filter-subcategories__item">
            <a href="${
              location.origin + "/product-category" + subcategory.slug
            }" class="filter-subcategories__link">${subcategory.name}</a>
          </li>
      `;
      });

      html += `
          </ul>
        </li>`;
    });
    html += `
        </ul>
      </div>
      <style>
        #cat-sub-categories{
          padding-left: 15px;
        }
        #cat-sub-categories .filter-categories__link {
          font-size: 20px;
          font-weight: bold;
          position: relative;
        }
        /*
        #cat-sub-categories .filter-categories__link::before {
          content: '';
          position: absolute;
          left: calc(-32px + -8px);
          bottom: 11px;
          background-color: #999999;
          height: 2px;
          width: 32px;
        }
        */
        #cat-sub-categories .filter-subcategories__link{
          font-size: 16px;
          font-weight: bold;
          display: inline-block;
          padding-left: 15px;
        }
        #cat-sub-categories .filter-categories__item{
          margin-bottom: 6px !important;
        }
        #cat-sub-categories .filter-subcategories__item{
          margin-bottom: 0 !important;
        }

        /*CLOSE*/
        #cat-sub-categories .filter-categories__item .filter-subcategories{
          display: none;
        }
        /*OPEN*/
        #cat-sub-categories .filter-categories__item.open .filter-subcategories{
          display: block;
        }
        #cat-sub-categories .filter-categories__item.open .fa-chevron-down{
          transform: rotate(180deg);
        }
        /*SUBCATEGORY*/
        /*
        #cat-sub-categories .filter-categories__item:has(.filter-subcategories__link.active) .filter-subcategories{
          display: block;
        }
        #cat-sub-categories .filter-categories__item:has(.filter-subcategories__link.active) .fa-chevron-down{
          transform: rotate(180deg);
        }
        */

        #cat-sub-categories a:hover,
        #cat-sub-categories a.active{
          color: red !important;
        }       

        /*Ocultando el original y el search*/
        .widget_product_categories,
        .woocommerce-product-search{
          display: none !important;
        }
      </style>`;

    container.insertAdjacentHTML("beforebegin", html);
  };

  const handleLoadPageOpenMenu = () => {
    const categoryItem = document.querySelectorAll(".filter-categories__item");
    if (categoryItem.length === 0) return;
    Array.from(categoryItem).map((category) => {
      const subMenuLink = category.querySelectorAll(
        ".filter-subcategories__link"
      );
      if (Array.from(subMenuLink).length === 0) {
        const btn = category.querySelector("button.btn");
        btn && btn.classList.add("d-none");
      } else {
        Array.from(subMenuLink).forEach((item) => {
          if (item.classList.contains("active")) {
            category.classList.add("open");
          }
        });
      }
    });
  };

  const handleClickOpenMenu = () => {
    const categoryItem = document.querySelectorAll(".filter-categories__item");
    if (categoryItem.length === 0) return;
    Array.from(categoryItem).map((category) => {
      const btn = category.querySelector("button.btn");
      btn &&
        btn.addEventListener("click", () => category.classList.toggle("open"));
    });
  };

  const activateCategories = () => {
    const catSubCategories = document.querySelectorAll("#cat-sub-categories a");

    Array.from(catSubCategories).forEach((item) => {
      if (item.getAttribute("href").trim() === location.href) {
        item.classList.add("active");
      }
    });
  };

  const initDOMReady = () => {
    const slugs = document.querySelectorAll("#secondary .product-categories a");
    if (slugs.length === 0) return;
    const categoriesAndSub = Array.from(slugs).map((slug) => ({
      slug: slug.getAttribute("href").split("product-category")[1],
      name: slug.textContent.trim().toUpperCase(),
    }));
    addHTMLFilterCategories(categoriesAndSub);
    activateCategories();
    // Filtrado desplegable
    handleLoadPageOpenMenu();
    handleClickOpenMenu();
  };

  document.addEventListener("DOMContentLoaded", () => {
    initDOMReady();
  });
})();
