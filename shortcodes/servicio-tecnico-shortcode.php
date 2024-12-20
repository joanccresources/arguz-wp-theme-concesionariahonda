<?php

function shortcode_servicio_tecnico_sorsa_cards($atts)
{
  // Inicia la salida del buffer
  ob_start();
  $atts = shortcode_atts(array(
    'post' => '', // Atributo opcional para el código del post
    'title' => '',
  ), $atts, 'talleres_sorsa_cards');
?>
  <div class="card-tienda__container">
    <?php
    // Consulta personalizada para obtener los posts del custom post type "punto-de-venta"
    $args = array(
      'post_type' => 'punto_de_venta',
      'posts_per_page' => -1
    );

    // Si se proporciona un código de post, agregar la condición de post__in
    if (!empty($atts['post'])) {
      // Convertir los códigos de post a un array
      $post_ids = array_map('trim', explode(',', $atts['post']));
      $post_ids = array_filter($post_ids, 'is_numeric'); // Asegurarse de que solo contenga valores numéricos
      $args['post__in'] = $post_ids;
      $args['orderby'] = 'post__in'; // Mantener el orden de los IDs especificados
    }

    $query = new WP_Query($args);

    // Verifica si hay posts
    if ($query->have_posts()):
      $contador = 0;

      while ($query->have_posts()):
        $query->the_post();
        $contador++;
        $is_par = $contador % 2 == 0;
        $is_multiple =  $contador > 1;

        $post_id = get_the_ID();

        $title = get_the_title();

        if (!empty($atts['title'])) {
          // Procesar el título para quitar la primera parte ("Agencia") y agregar el prefijo
          $title = trim($title); // Eliminar espacios alrededor
          $post_title_parts = explode(' ', $title, 2); // Dividir en dos partes
          if (count($post_title_parts) > 1) {
            $title = wp_kses_post('<span class="txt-rojo-02">' . $atts['title']) . '</span> ' . $post_title_parts[1]; // Eliminar la primera parte y agregar el prefijo
          } else {
            $title = wp_kses_post('<span class="txt-rojo-02">' . $atts['title']) . '</span> ' . $title; // Si el título solo tiene una parte
          }
        } else {
          $words = explode(' ', $title, 2);
          $first_word = $words[0];
          $rest = $words[1] ?? '';
          $title = wp_kses_post('<span class="txt-rojo-02">' . $first_word . '</span>' . ' ' . $rest); // Si el título solo tiene una parte
        }

        // Obtiene los datos necesarios
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Imagen destacada        
        $content = get_the_content(); // Contenido del post

        $url_mapa = get_post_meta($post_id, 'url_mapa', true); // Campo personalizado "url_mapa"
        // Genera el HTML con los datos obtenidos
    ?>
        <div class="card-tienda wow fadeIn slow" data-wow-delay="0.2s">
          <div class="row justify-content-between align-items-center <?= $is_multiple ? 'mt-0 mt-md-2 mt-xl-5' : '' ?>">
            <div class="col-md-6 col-xl-5 <?= $is_par ? 'order-md-2' : 'order-md-1' ?>">
              <div class="card-tienda__info">
                <!--
                <div class="card-tienda__logo-parent">
                  <img src="https://honda.sorsa.pe/wp-content/uploads/2024/09/logo-sorsa-main.svg" alt="Logo" class="card-tienda__logo">
                </div>
                -->
                <h6 class="card-tienda__title">
                  <a href="<?= esc_url($url_mapa); ?>" target="_blank"><?= wp_kses_post($title); ?></a>
                </h6>
                <div class="card-tienda__description pb-2">
                  <?= wp_kses_post($content); ?>
                </div>

                <div class="card-tienda__btn-group">
                  <div class="btn-negro-blanco">
                    <a href="<?= esc_url($url_mapa); ?>" target="_blank">VER EN EL MAPA</a>
                  </div>
                  <!--
                  <div class="btn-rojo-blanco">
                    <a href="https://honda.sorsa.pe/agenda-tu-cita/">AGENDA TU CITA</a>
                  </div>
                  -->
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-7 <?= $is_par ? 'order-md-1' : 'order-md-2' ?>">
              <a
                target="_blank"
                href="<?= esc_url($url_mapa); ?>"
                class="card-tienda__figure">
                <img decoding="async" src="<?= esc_url($featured_img_url); ?>" alt="" class="card-tienda__img" />
              </a>
            </div>
          </div>
        </div>
    <?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </div>
<?php
  return ob_get_clean();
}
add_shortcode("servicio_tecnico_sorsa_cards", "shortcode_servicio_tecnico_sorsa_cards");
