<?php
function llenar_select_con_taxonomia($atts)
{
  // Extraer atributos opcionales del shortcode
  $atts = shortcode_atts(array(
    'taxonomy' => 'ubicacion', // Taxonomía personalizada
    'select_name' => 'local_preferencia' // Nombre del select
  ), $atts, 'llenar_select');

  // Iniciar el almacenamiento en buffer
  ob_start();

  // Obtener términos de la taxonomía
  $terms = get_terms(array(
    'taxonomy' => $atts['taxonomy'],
    'hide_empty' => false, // false: Muestra todo | true: Solo los que tienen almenos 1 elemento
  ));

  echo '<select name="' . esc_attr($atts['select_name']) . '" class="form-select">';
  echo '<option value="">-</option>';
  // Verificar si hay términos en la taxonomía
  if (!empty($terms) && !is_wp_error($terms)) {
    foreach ($terms as $term) {
      echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
    }
  }
  echo '</select>';

  // Devolver el contenido del buffer y limpiarlo
  return ob_get_clean();
}
add_shortcode('llenar_select', 'llenar_select_con_taxonomia');
