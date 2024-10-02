<?php
// Función para mostrar las entradas
function comunidad_entradas_shortcode($atts)
{
  // Iniciar el buffer de salida
  ob_start();

  // Definir los parámetros por defecto y sobrescribirlos si se pasan en el shortcode
  $atts = shortcode_atts(array(
    'cantidad' => 4, // Cantidad de entradas por defecto
  ), $atts, 'comunidad_entradas');

  // Consulta para obtener las entradas
  $query = new WP_Query(array(
    'post_type'      => 'post',        // Tipo de post
    'posts_per_page' => $atts['cantidad'], // Número de entradas
  ));

  // Verificar si hay entradas
  if ($query->have_posts()) {
    echo '<div class="entradas-lista">';

    // Recorrer las entradas
    while ($query->have_posts()) {
      $query->the_post();

      // Obtener los datos de la entrada
      $titulo = get_the_title();
      $excerpt = get_the_excerpt();
      $link = get_permalink();
      $imagen = has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'thumbnail') : '';

      // Crear el HTML para cada entrada
      echo '<div class="entrada-item">';
      echo '<div class="entrada-imagen">' . $imagen . '</div>';
      echo '<h3 class="entrada-titulo"><a href="' . $link . '">' . $titulo . '</a></h3>';
      echo '<p class="entrada-excerpt">' . $excerpt . '</p>';
      echo '</div>';
    }

    echo '</div>';

    // Restaurar el post original
    wp_reset_postdata();
  } else {
    echo '<p>No hay entradas disponibles.</p>';
  }

  // Capturar el contenido y limpiar el buffer
  return ob_get_clean();
}

// Registrar el shortcode
add_shortcode('comunidad_entradas', 'comunidad_entradas_shortcode');