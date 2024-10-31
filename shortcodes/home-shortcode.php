<?php
/*
// ¿QUE MODELOS HONDA BUSCAS?
function shortcode_home_modelos($atts)
{
  ob_start();
  // Categorías a excluir (por slug)
  // $excluded_slugs = array('uncategorized', 'stunt-bike', 'bike-gloves', 'bike-helmate', 'bike-pumper', 'city-bike', 'electric-bike', 'electric-glide', 'featured', 'gear-bike', 'kids-bike', 'mountain-bike', 'ride-bike', 'scooters');
  // Obtener los IDs de las categorías a excluir usando sus slugs
  // $excluded_ids = get_terms(array(
  //   'taxonomy'   => 'product_cat',
  //   'hide_empty' => false,      
  //   'fields'     => 'ids', // Solo obtener los IDs
  // ));

  $included_slugs = array('honda-pistera', 'todo-terreno', 'scooters-honda');
  // Obtener categorías de productos
  $product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    // 'exclude' => $excluded_ids,
    'slug'       => $included_slugs, // Solo incluir estas categorías
    'hide_empty' => false, // true para ocultar las categorías vacías
  ));

  // Comprobar si hay categorías disponibles
  if (! empty($product_categories) && ! is_wp_error($product_categories)) {
    echo '<div class="short-home-modelos">';
    // Recorrer cada categoría de producto
    foreach ($product_categories as $category) {

      $title = esc_html($category->name);
      $words = explode(' ', $title);
      $first_word = array_shift($words);
      $rest_of_title = implode(' ', $words);


      echo '<div class="content-modelos">';
      // echo '<h3 class="content-modelos__title">' . esc_html($category->name) . '</h3>'; // Mostrar el título de la categoría      
      echo '<h3 class="content-modelos__title"><span>' . $first_word . '</span> <span class="rojo-sorsa-01">' . $rest_of_title . '</span></h3>';
      // Crear una consulta para obtener los últimos 2 productos de esta categoría
      $args = array(
        'post_type' => 'product', // Tipo de post: producto de WooCommerce
        'posts_per_page' => 2, // Obtener los últimos 2 productos
        'tax_query' => array(
          array(
            'taxonomy' => 'product_cat', // Relacionar con la categoría de productos
            'field'    => 'term_id',
            'terms'    => $category->term_id, // Obtener productos de la categoría actual
          ),
        ),
      );
      $products_query = new WP_Query($args);
      // Comprobar si hay productos en la categoría
      if ($products_query->have_posts()) {
        echo '<div class="modelos-list">';
        // Recorrer los productos
        while ($products_query->have_posts()) {
          $products_query->the_post();

          // Obtener el enlace del producto
          $product_link = get_permalink();

          // Obtener la imagen del producto
          // $product_image = get_the_post_thumbnail(get_the_ID(), 'medium');
          // $thumbnail_id = get_post_thumbnail_id(get_the_ID()); // Obtener ID del thumbnail
          // $product_image_url = wp_get_attachment_url($thumbnail_id); // Obtener la URL

          // Obtener la imagen personalizada del campo 'imagen_para_el_home'
          // $imagen_home_id = get_field('imagen_para_el_home', get_the_ID()); // Obtener el ID del campo personalizado

          $imagen_home_id = get_post_meta(get_the_ID(), 'imagen_para_el_home', true);
          $imagen_home_url = wp_get_attachment_url($imagen_home_id);
          if (!empty($imagen_home_url)) {
            echo '<div class="modelos-list__item">';
            echo '<a href="' . esc_url($product_link) . '" class="modelos-list__link">';
            echo '<img src="' . esc_url($imagen_home_url) . '" alt="' . get_the_title() . '" class="modelos-list__img" />';
            echo '</a>';
            echo '</div>';
          }
        }

        echo '</div>';
      } else {
        echo '<p>No hay productos en esta categoría.</p>';
      }
      echo '</div>';
      // Restaurar los datos originales después de la consulta
      wp_reset_postdata();
    }
    echo '</div>';
  } else {
    echo 'No hay categorías de productos disponibles.';
  }

  return ob_get_clean();
}
add_shortcode('home_modelos', 'shortcode_home_modelos');
*/

/*
// ¿QUE MODELOS HONDA BUSCAS?
function shortcode_home_modelos($atts)
{
  ob_start();

  $included_slugs = array('moto', 'motokar', 'alta-gama');
  // Obtener categorías de productos
  $product_categories = get_terms(array(
    'taxonomy' => 'product_cat',    
    'slug'       => $included_slugs, // Solo incluir estas categorías
    'hide_empty' => false, // true para ocultar las categorías vacías
    'meta_key' => 'orden_modelo',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
  ));

  // Comprobar si hay categorías disponibles
  if (! empty($product_categories) && ! is_wp_error($product_categories)) {
    echo '<div class="short-home-modelos">';
    // Recorrer cada categoría de producto
    foreach ($product_categories as $category) {

      $title = esc_html($category->name);

      echo '<div class="content-modelos">';
      // echo '<h3 class="content-modelos__title">' . esc_html($category->name) . '</h3>'; // Mostrar el título de la categoría      
      echo '<h3 class="content-modelos__title">' . $title . '</h3>';
      // Crear una consulta para obtener los últimos 2 productos de esta categoría
      $args = array(
        'post_type' => 'product', // Tipo de post: producto de WooCommerce
        'posts_per_page' => 2, // Obtener los últimos 2 productos
        'tax_query' => array(
          array(
            'taxonomy' => 'product_cat', // Relacionar con la categoría de productos
            'field'    => 'term_id',
            'terms'    => $category->term_id, // Obtener productos de la categoría actual
          ),
        ),
      );
      $products_query = new WP_Query($args);
      // Comprobar si hay productos en la categoría
      if ($products_query->have_posts()) {
        echo '<div class="modelos-list">';
        // Recorrer los productos
        while ($products_query->have_posts()) {
          $products_query->the_post();

          // Obtener el enlace del producto
          $product_link = get_permalink();

          $imagen_home_id = get_post_meta(get_the_ID(), 'imagen_para_el_home', true);
          $imagen_home_url = wp_get_attachment_url($imagen_home_id);
          if (!empty($imagen_home_url)) {
            echo '<div class="modelos-list__item">';
            // echo '<a href="' . esc_url($product_link) . '" class="modelos-list__link">';
            echo '<div class="modelos-list__link">';
            echo '<img src="' . esc_url($imagen_home_url) . '" alt="' . get_the_title() . '" class="modelos-list__img" />';
            echo '</div>';
            // echo '</a>';
            echo '</div>';
          }
        }

        echo '</div>';
      } else {
        echo '<p>No hay productos en esta categoría.</p>';
      }
      echo '</div>';
      // Restaurar los datos originales después de la consulta
      wp_reset_postdata();
    }
    echo '</div>';
  } else {
    echo 'No hay categorías de productos disponibles.';
  }

  return ob_get_clean();
}
add_shortcode('home_modelos', 'shortcode_home_modelos');
*/

// ¿QUE MODELOS HONDA BUSCAS?
function shortcode_home_modelos($atts)
{
  ob_start();
  $included_slugs = array('moto', 'motokar', 'alta-gama');
  $product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'slug'       => $included_slugs, // Solo incluir estas categorías
    'hide_empty' => false, // true para ocultar las categorías vacías
    'meta_key' => 'orden_modelo',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
  ));

  // Comprobar si hay categorías disponibles
  if (! empty($product_categories) && ! is_wp_error($product_categories)) {
    echo '<div class="short-home-modelos">';    
    foreach ($product_categories as $category) {
      $title = esc_html($category->name);
      // FALSE para obtener todas las imagenes como array
      $galeria = get_term_meta($category->term_id, 'galeria', false); 

      echo '<div class="content-modelos">';
      echo '  <h3 class="content-modelos__title">' . $title . '</h3>';
      if (! empty($galeria) && is_array($galeria)) {
        echo '<div class="modelos-list">';
        foreach ($galeria as $imagen_id) {
          $imagen_url = wp_get_attachment_url($imagen_id);
          if ($imagen_url) {
            echo '<div class="modelos-list__item">';
            echo '  <div class="modelos-list__link">';
            echo '    <img src="' . esc_url($imagen_url) . '" alt="' . esc_attr($title) . '" class="modelos-list__img" />';
            echo '  </div>';
            echo '</div>';
          }
        }
        echo '</div>'; // .modelos-list
      }
      echo '</div>'; // .content-modelos
      wp_reset_postdata();
    }
    echo '</div>';  // .short-home-modelos
  } else {
    echo 'No hay categorías de productos disponibles.';
  }
  return ob_get_clean();
}
add_shortcode('home_modelos', 'shortcode_home_modelos');

function shortcode_home_promocion($atts)
{
  ob_start();

  $included_slugs = array('promocion-sorsa');
  // Obtener categorías de productos
  $product_categories = get_terms(array(
    'taxonomy' => 'promociones',
    'slug'       => $included_slugs, // Solo incluir estas categorías
    'hide_empty' => false, // true para ocultar las categorías vacías 
  ));

  // Comprobar si hay categorías disponibles
  if (! empty($product_categories) && ! is_wp_error($product_categories)) {
    echo '<div class="short-home-promocion">';
    // Recorrer cada categoría de producto
    foreach ($product_categories as $category) {
      echo '<div class="content-promocion">';
      // echo '<h3 class="content-promocion__title">' . esc_html($category->name) . '</h3>'; // Mostrar el título de la categoría

      // Obtener la URL del campo personalizado "imagen_principal" utilizando get_term_meta
      $image_id = get_term_meta($category->term_id, 'imagen_principal', true); // Obtener ID de la imagen
      $image_url = wp_get_attachment_url($image_id); // Obtener URL de la imagen a partir del ID

      // Comprobar si la imagen existe y mostrarla
      if ($image_url) {
        // echo '<a class="#0" class="content-promocion__link">';
        echo '<div class="content-promocion__link">';
        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '" class="content-promocion__img"/>';
        echo '</div>';
        // echo '</a>';
      }

      echo '</div>';

      // Restaurar los datos originales después de la consulta
      wp_reset_postdata();
    }
    echo '</div>';
  } else {
    echo 'No hay Promociones disponibles.';
  }

  return ob_get_clean();
}
add_shortcode('home_promocion', 'shortcode_home_promocion');

/*
function shortcode_home_mas_vendidos($atts)
{
  ob_start();

  // Definir los argumentos de la consulta
  $args = array(
    'post_type' => 'product',
    'posts_per_page' => 4, // Obtener todos los productos
    'meta_query' => array(
      array(
        'key' => 'producto_popular', // Nombre del campo en Pods
        // 'value' => 'yes', // Valor para que se considere como popular
        "value" => true,
        'compare' => '='
      )
    )
  );

  // Realizar la consulta
  $productos_query = new WP_Query($args);

  // Comprobar si hay productos
  if ($productos_query->have_posts()) {
    echo '<div class="productos-populares">';
    echo '<ul class="list-mas-vendidos">';
    while ($productos_query->have_posts()) {
      $productos_query->the_post();

      $thumbnail_id = get_post_thumbnail_id(get_the_ID()); // Obtener ID del thumbnail
      $product_image_url = wp_get_attachment_url($thumbnail_id); // Obtener la URL

      // Obtener las categorías del producto
      $terms = get_the_terms(get_the_ID(), 'product_cat');

      echo '<li class="card-mas-vendidos">';
      echo '<a href="' . get_permalink() . '" class="card-mas-vendidos__link">';
      echo '<figure class="card-mas-vendidos__figure">';
      echo '<img src="' . $product_image_url . '" alt="' . get_the_title() . '" class="card-mas-vendidos__img"/>';
      echo '</figure>';
      if ($terms && ! is_wp_error($terms)) {
        foreach ($terms as $term) {
          echo '<p class="card-mas-vendidos__category">' . esc_html($term->name) . '</p>'; // Mostrar el nombre de la categoría
        }
      }
      echo '<p class="card-mas-vendidos__title">' . get_the_title() . '</p>';
      echo '</a>';
      echo '</li>';
    }

    echo '</ul>';
    echo '</div>';

    // Restaurar los datos originales después de la consulta
    wp_reset_postdata();
  } else {
    echo '<p>No hay productos populares disponibles.</p>';
  }

  return ob_get_clean();
}
add_shortcode('home_mas_vendidos', 'shortcode_home_mas_vendidos');
*/

function shortcode_home_mas_vendidos($atts)
{
  ob_start();

  // Definir los argumentos de la consulta
  $args = array(
    'post_type' => 'product',
    'posts_per_page' => 4, // Obtener todos los productos
    'meta_query' => array(
      array(
        'key' => 'producto_popular', // Nombre del campo en Pods
        // 'value' => 'yes', // Valor para que se considere como popular
        "value" => true,
        'compare' => '='
      )
    )
  );

  // Realizar la consulta
  $productos_query = new WP_Query($args);

  // Comprobar si hay productos
  if ($productos_query->have_posts()) {
    echo '<div class="swiper-nueva-moto">';
    echo '  <ul class="swiper-wrapper" id="nueva-moto-swiper-wrapper">';

    while ($productos_query->have_posts()) {
      $productos_query->the_post();

      $thumbnail_id = get_post_thumbnail_id(get_the_ID()); // Obtener ID del thumbnail
      $product_image_url = wp_get_attachment_url($thumbnail_id); // Obtener la URL

      // Obtener las categorías del producto
      $terms = get_the_terms(get_the_ID(), 'product_cat');

      echo '<li class="swiper-slide">';
      echo '  <div class="card-mas-vendidos">';
      echo '    <a href="' . get_permalink() . '" class="card-mas-vendidos__link">';
      echo '      <figure class="card-mas-vendidos__figure">';
      echo '        <img src="' . $product_image_url . '" alt="' . get_the_title() . '" class="card-mas-vendidos__img"/>';
      echo '      </figure>';
      echo '      <div class="">';
      if ($terms && ! is_wp_error($terms)) {
        echo '<p class="card-mas-vendidos__category">';
        $categories = array(); // Array para almacenar los nombres de las categorías
        foreach ($terms as $term) {
          $categories[] = esc_html($term->name); // Agregar cada nombre de categoría al array
        }
        echo implode(', ', $categories); // Unir los nombres con comas
        echo '</p>';
      }
      echo '      <p class="card-mas-vendidos__title">' . get_the_title() . '</p>';
      echo '      </div>';
      echo '    </a>';
      echo '  </div>';
      echo '</li>';
    }
    // Swiper
    echo '</ul>'; /*.swiper-wrapper*/

    /*<!-- If we need navigation buttons -->*/
    echo '  <div class="swiper-button-prev-moto">';
    echo '    <img src="' . get_stylesheet_directory_uri() . '/assets/img/arrow-honda-red-left.svg" alt="Previous" />';
    echo '  </div>';

    echo '  <div class="swiper-button-next-moto">';
    echo '    <img src="' . get_stylesheet_directory_uri() . '/assets/img/arrow-honda-red-right.svg" alt="Next" />';
    echo '  </div>';

    echo '</div>'; /*.swiper-nueva-moto*/
    // Style
    echo "
    <style>
      .elementor-widget-container:has(.swiper-nueva-moto){
        overflow: hidden;
      }
      .swiper-nueva-moto [class*='swiper-button-']{
        position: absolute;
        z-index: 9;
        top: 50%;
        transform: translateY(-50%);
        width: 52px;
      }
      .swiper-nueva-moto .swiper-button-prev-moto{
        left: 0;
      }
      .swiper-nueva-moto .swiper-button-next-moto{
        right: 0;
      }
      @media(min-width: 768px){        
      }
      @media(min-width: 992px){
      }
      @media(min-width: 1200px){
        .swiper-nueva-moto .swiper-button-prev-moto{
          left: -30px;
        }
        .swiper-nueva-moto .swiper-button-next-moto{
          right: -30px;
        }
      }
      @media(min-width: 1400px){
        .swiper-nueva-moto [class*='swiper-button-']{
          width: auto;
        }
      }
    </style>
    ";

    // Script
    echo "
    <script>
      (()=> {
        const addSliderSwiper = ()=> {
          console.log('addSliderSwiper');
          const swiper = new Swiper('.swiper-nueva-moto', {
            autoplay: {
              delay: 3000,
              waitForTransition: true,
            },            
            loop: false,
            // slidesPerView: 4, // 4 slides por defecto
            spaceBetween: 30,
  
            // Navigation arrows            
            navigation: {
              nextEl: '.swiper-button-next-moto',
              prevEl: '.swiper-button-prev-moto',
            },
  
            breakpoints: {
              0: {
                slidesPerView: 1,
              },
              768: {
                slidesPerView: 2,
              },
              992: {
                slidesPerView: 3,
              },
              1200: {
                slidesPerView: 4,
              },
            },

          });        
        }

        document.addEventListener('DOMContentLoaded', () => { 
          addSliderSwiper();
        });
      })();
    </script>";

    // Restaurar los datos originales después de la consulta
    wp_reset_postdata();
  } else {
    echo '<p>No hay productos populares disponibles.</p>';
  }

  return ob_get_clean();
}
add_shortcode('home_mas_vendidos', 'shortcode_home_mas_vendidos');
