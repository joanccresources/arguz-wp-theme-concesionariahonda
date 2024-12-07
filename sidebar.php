<?php
if (class_exists('WooCommerce')) {
  if (is_woocommerce()) {
    $eura_sidebar_class = 'shop';
  } elseif (is_product()) {
    $eura_sidebar_class = 'shop';
  } else {
    $eura_sidebar_class = 'sidebar-1';
  }
} else {
  $eura_sidebar_class = 'sidebar-1';
}

if (!is_active_sidebar($eura_sidebar_class)) {
  return;
}
?>

<div class="col-lg-3 col-md-12">
  <?php if (class_exists('WooCommerce')) {
    // sidebar ecommerce
    if (is_woocommerce()) { ?>
      <div class="new-filters">
        <div class="breadcrumb">
          <a style="color: #000000ff;" href="https://honda.sorsa.pe/">
            <i class="fa fa-home" style="font-style: normal;" aria-hidden="true"></i>
          </a>
          <span class="ubuntu-light" style="color: #000000ff; font-size: 16px; font-weight: 400;">
            / MOTOS Y MOTOKARS</span>
        </div>
        <div class="clean-filters">
          <a class="clean-filters__link" href="https://honda.sorsa.pe/shop/#main-content-shop"
            onclick="location.reload();">Limpiar todo</a>
        </div>
      </div>
      <!-- sorsa -->
      <div id="secondary" class="shop-sidebar sidebar">
        <?php
    } elseif (is_product()) { ?>
        <!-- sidebar blog -->
        <div id="secondary" class="sidebar shop-sidebar sidebar">
          <?php
    } else { ?>
          <div id="secondary" class="title sidebar sidebar-widgets widget-area">
            <?php
    }
  } else { ?>
          <div id="secondary" class="title sidebar sidebar-widgets widget-area">
          <?php } ?>

          <!-- <sorsa> -->
          <div class="test-filter d-none">
            <h3 class="mb-3">Filtrar por Tipo de Vehículo</h3>
            <?php
            /*
            // Obtenemos los términos de la taxonomía 'tipo_de_vehiculo'
            $tipos_de_vehiculo = get_terms(array(
              'taxonomy' => 'tipo_de_vehiculo',
              'hide_empty' => false,
            ));

            // Mostramos los checkbox para cada término
            if (! empty($tipos_de_vehiculo) && ! is_wp_error($tipos_de_vehiculo)):*/ ?>
            <ul class="woocommerce-widget-layered-nav-list">
              <?php /*foreach ($tipos_de_vehiculo as $tipo) { */ ?>
              <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term">
                <a data-tipo-de-vehiculo="<?php /* esc_attr($tipo->slug) */ ?>" rel="nofollow"
                  href="<?php /* home_url() */ ?>/shop?filter_tipo_de_vehiculo=<?php /*esc_attr($tipo->slug)*/ ?>">
                  <?php /*esc_html($tipo->name)*/ ?>
                </a>
              </li>
              <?php /*}*/ ?>
            </ul>
            <?php /*endif;*/ ?>
          </div>
          <script>
            (() => {
              const getFilterTipoDeVehiculo = (url = location.href) => {
                const urlObj = new URL(url);
                const filterValue = urlObj.searchParams.get("filter_tipo_de_vehiculo");
                return filterValue ? filterValue.split(",") : [];
              }

              // Array<string>
              const getAllSlugsTipoDeVehiculo = (checkboxs) => {
                return Array.from(checkboxs).map(checkbox => {
                  return {
                    slug: checkbox.getAttribute("data-tipo-de-vehiculo"),
                    active: checkbox.classList.contains("active")
                  }
                });
              }

              const activateCheckbox = (checkboxs) => {
                const filterTipoVehiculo = getFilterTipoDeVehiculo();

                if (checkboxs.length === 0 || filterTipoVehiculo.length === 0) return;

                Array.from(checkboxs).forEach((tipoVehiculo) => {
                  const data = tipoVehiculo.getAttribute("data-tipo-de-vehiculo");

                  if (filterTipoVehiculo.includes(data)) {
                    tipoVehiculo.classList.add("active");
                    tipoVehiculo.parentNode.classList.add("woocommerce-widget-layered-nav-list__item--chosen", "chosen");
                  }
                });
              }

              const changeSlugCheckbox = (checkboxs) => {
                const filterTipoVehiculo = getFilterTipoDeVehiculo();
                if (filterTipoVehiculo.length === 0) return;

                // Todos los tipos de vehiculos de los checboxes
                const tipoDeVehiculos = getAllSlugsTipoDeVehiculo(checkboxs);
                // Asignamos las urls
                tipoDeVehiculos.forEach((item, index) => {
                  if (item.active) {
                    const newTipoVehiculos = filterTipoVehiculo.filter(tipo => tipo !== item.slug);
                    const newSlugQuery = newTipoVehiculos.join(",");
                    checkboxs[index].setAttribute("href", `${location.origin}/shop?filter_tipo_de_vehiculo=${newSlugQuery}`)
                  } else {
                    const newTipoVehiculos = [...filterTipoVehiculo, item.slug]
                    const newSlugQuery = newTipoVehiculos.join(",");
                    checkboxs[index].setAttribute("href", `${location.origin}/shop?filter_tipo_de_vehiculo=${newSlugQuery}`)
                  }
                });
              }

              const initDOMReady = () => {
                const checkboxs = document.querySelectorAll(`[data-tipo-de-vehiculo]`);
                activateCheckbox(checkboxs);
                changeSlugCheckbox(checkboxs);
              }

              document.addEventListener("DOMContentLoaded", () => {
                initDOMReady();
              })
            })();
          </script>
          <!-- </sorsa> -->

          <!-- <SorsaShowColores> -->
          <?php
          $colores = get_terms(array(
            'taxonomy' => 'pa_color',
            'hide_empty' => true, // Solo muestra los colores con productos
          ));

          if (!empty($colores) && !is_wp_error($colores)) {
            echo '<ul class="sidebar-colores d-flex align-items-center" id="sidebar-colores">';
            foreach ($colores as $color) {
              // Obtener el valor hexadecimal del campo personalizado
              $color_hex = get_term_meta($color->term_id, 'color', true);
              // Mostrar el nombre del color y un cuadrado con el color
              echo '<li class="mb-0">';
              echo '<a class="d-inline-flex d-none" data-name=' . $color->name . '>';
              if ($color_hex)
                echo '<span class="shadow d-inline-block" style="background-color:' . esc_attr($color_hex) . ';"></span>';
              echo '</a>';
              echo '</li>';
            }
            echo '</ul>'; ?>
            <script>
              (() => {
                const initDOMReady = () => {
                  const container = document.querySelector(".widget_layered_nav .woocommerce-widget-layered-nav-list");
                  const sidebarColores = document.querySelector("#sidebar-colores");
                  if (!container || !sidebarColores) return;
                  container.insertAdjacentElement("afterend", sidebarColores);

                  const slugsFilters = container.querySelectorAll("a");
                  // All colors
                  const slugsSidebar = sidebarColores.querySelectorAll("a");

                  // Recorremos los filtrados
                  Array.from(slugsFilters).forEach(filter => {
                    // Nuevos cuadros
                    Array.from(slugsSidebar).forEach(sidebar => {
                      if (filter.textContent.trim() === sidebar.getAttribute("data-name").trim()) {
                        sidebar.setAttribute("href", filter.getAttribute("href") || "");
                        // Todos estan ocultos en caso , pero como este item existe en los filtros le quitamos el d-none
                        sidebar.classList.remove("d-none")
                        if (filter.parentNode.classList.contains("woocommerce-widget-layered-nav-list__item--chosen")) {
                          sidebar.classList.add("active");
                        }
                      }
                    });
                  })
                }
                document.addEventListener("DOMContentLoaded", () => {
                  initDOMReady();
                })
              })();
            </script>
            <style>
              .widget_layered_nav .woocommerce-widget-layered-nav-list {
                display: none !important;
              }

              /* width:20px;height:20px; */
              #sidebar-colores {
                column-gap: 4px;
                flex-wrap: wrap;
              }

              #sidebar-colores a span {
                width: 39px;
                height: 39px;
                border-radius: 50%;
              }

              #sidebar-colores a.active span {
                border: 2px solid white;
                outline: 1px solid red;
              }

              /* Ocultando el filtrado por colores */
              .widget_layered_nav:has(>#sidebar-colores) {
                display: none !important;
              }
            </style>
          <?php } ?>


          <!-- </SorsaShowColores> -->

          <?php dynamic_sidebar($eura_sidebar_class); ?>
        </div>
      </div><!-- #secondary -->