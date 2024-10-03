<?php

/*** Editor clasico ***/
add_filter('use_block_editor_for_post', '__return_false', 10);
function eura_enqueue_style()
{
  wp_enqueue_script('main-script', get_stylesheet_directory_uri() . '/assets/js/main.js?v=' . time(), array(), null, true);

  if (is_page("home")) {
    wp_enqueue_script('home-script', get_stylesheet_directory_uri() . '/assets/js/home.js?v=' . time(), array(), null, true);
  }
  if (is_page("agenda-tu-cita")) {
    // Agregar el CSS de Flatpickr
    wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
    // Agregar el script de Flatpickr
    wp_enqueue_script('flatpickr-script', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), null, true);
    wp_enqueue_script('agenda-tu-cita-script', get_stylesheet_directory_uri() . '/assets/js/agenda-tu-cita.js?v=' . time(), array(), null, true);
  }

  wp_enqueue_style("parent-style", get_parent_theme_file_uri("/style.css"));
}
add_action('wp_enqueue_scripts', 'eura_enqueue_style');


/*** Cambiar el texto de WooCommerce ***/
function divi_engine_wc_translations($translated)
{
  $text = array(
    "Apply coupon" => "Aplicar cupón",
    "Coupon code" => "Código promocional",
    "Proceed to checkout" => "Proceder al pago",
    "Update cart" => "Actualizar carrito",
    "Reviews" => "Reseñas"
  );
  $translated = str_ireplace(array_keys($text),  $text,  $translated);
  return $translated;
}
add_filter('gettext', 'divi_engine_wc_translations', 20);



/*** Cambio de nombre en los taxonomies ***/
// function custom_taxonomy_permalink($url, $term, $taxonomy)
// {
//   if ($taxonomy === 'producto_categoria') {
//     return home_url('/' . $term->slug);
//   }
//   return $url;
// }
// function custom_rewrite_rules()
// {
//   add_rewrite_rule(
//     '^([^/]+)/?$',
//     'index.php?producto_categoria=$matches[1]',
//     'top'
//   );
// }
// Cambio de nombre en los taxonomies
// add_filter('term_link', 'custom_taxonomy_permalink', 10, 3);
// add_action('init', 'custom_rewrite_rules');


// Flushing rewrite rules temporarily
/* se usa temporalmente para asegurarse de que las reglas de 
reescritura de WordPress se actualicen*/
// add_action('init', function () {
//   flush_rewrite_rules();
// });


// Shortcodes
require_once get_stylesheet_directory() . '/shortcodes/load-shortcodes.php';


// Woocommerce
// add_action('woocommerce_before_main_content', 'agregar_contenido_arriba');
// function agregar_contenido_arriba()
// {
//   echo '<div class="contenido-arriba"><h1>Encabezado Personalizado</h1></div>';
// }

// add_action('woocommerce_before_main_content', 'agregar_contenido_arriba');
function agregar_contenido_arriba()
{
?>
  <div class="concesionaria-hero" id="concesionaria-hero">
    <div class="concesionaria-hero__figure">
      <img src="<?= get_site_url() ?>/wp-content/uploads/2024/10/0-768x295.png"
        srcset="<?= get_site_url() ?>/wp-content/uploads/2024/10/0.png 768w"
        sizes="(min-width: 768px) 768px, 100vw"
        alt="Concesionaria Honda Banner"
        class="concesionaria-hero__img" />
    </div>
  </div>
  <div class="concesionaria-cards" id="concesionaria-cards">

    <div class="concesionaria-hero__figure">
      <img src="<?= get_site_url() ?>/wp-content/uploads/2024/10/0-768x295.png"
        srcset="<?= get_site_url() ?>/wp-content/uploads/2024/10/0.png 768w"
        sizes="(min-width: 768px) 768px, 100vw"
        alt="Concesionaria Honda Banner"
        class="concesionaria-hero__img" />
    </div>
    
  </div>
<?php
}
?>