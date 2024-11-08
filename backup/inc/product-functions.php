<?php
// get_product() - ya existe en woocommerce

function get_custom_posttypeasdasdasdasdadasdsad($args = [], $custom_fields = []): array
{
  $query = new WP_Query($args);
  $data = [];
  // ¿El query tiene publicaciones para recorrer en bucle?
  if ($query->have_posts()) {
    // Recorre el query
    while ($query->have_posts()) {
      $query->the_post();
      // Obtener el id del post
      $post_id = get_the_ID();

      // Obteniendo la imagen destacada
      $thumbnail_id = get_post_thumbnail_id();
      // Array de URLs de todos los tamaños o string vacío
      $thumbnails = $thumbnail_id ? [
        'full' => wp_get_attachment_image_src($thumbnail_id, 'full')[0],
        'large' => wp_get_attachment_image_src($thumbnail_id, 'large')[0],
        'medium' => wp_get_attachment_image_src($thumbnail_id, 'medium')[0],
        'thumbnail' => wp_get_attachment_image_src($thumbnail_id, 'thumbnail')[0],
      ] : '';

      // Agregar campos personalizados
      $custom_data = [];
      foreach ($custom_fields as $field_name) {
        // Obtener todos los valores del campo personalizado
        $custom_field_value = get_post_meta($post_id, $field_name, false);
        // Si el array no esta vacio le asignamos ese array a $custom_data[$field_name]
        // En caso el array tenga un elemento solo mandamos ese elemento
        // Sino mandamos el array
        $custom_data[$field_name] = !empty($custom_field_value)
          ? count($custom_field_value) == 1 ? $custom_field_value[0] : $custom_field_value
          : '';
      }

      $data[] = [
        'id' => $post_id, /* id del post*/
        'title' => get_the_title(), /* titulo del post*/
        'link' => get_permalink(), /* slug del post*/
        'excerpt' => get_the_excerpt() ?: '',  /* El excerpt o resumen */
        'thumbnail' => $thumbnails, /* La url de la imagen destacada */
        'custom_fields' => $custom_data, /* Aquí se incluyen todos los campos personalizados solicitados */
      ];
    }
    wp_reset_postdata();
  }

  return $data;
}

function get_custom_posttype($args = [], $single_fields = [], $multi_fields = []): array
{
  $query = new WP_Query($args);
  $data = [];
  // ¿El query tiene publicaciones para recorrer en bucle?
  if ($query->have_posts()) {
    // Recorre el query
    while ($query->have_posts()) {
      $query->the_post();
      // Obtener el id del post
      $post_id = get_the_ID();

      // Obteniendo la imagen destacada
      $thumbnail_id = get_post_thumbnail_id();
      // Array de URLs de todos los tamaños o string vacío
      $thumbnails = $thumbnail_id ? [
        'full' => wp_get_attachment_image_src($thumbnail_id, 'full')[0],
        'large' => wp_get_attachment_image_src($thumbnail_id, 'large')[0],
        'medium' => wp_get_attachment_image_src($thumbnail_id, 'medium')[0],
        'thumbnail' => wp_get_attachment_image_src($thumbnail_id, 'thumbnail')[0],
      ] : [];

      // Obtener el valor del campo único (ej: imagen_para_el_home)
      $single_data = [];
      foreach ($single_fields as $field_name) {
        $single_data[$field_name] = get_post_meta($post_id, $field_name, true) ?: ''; // string vacio en caso no haya
      }

      // Obtener los valores de los campos múltiples (ej: carrusel)
      $multi_data = [];
      foreach ($multi_fields as $field_name) {
        // `false` para obtener todos los valores nos devuelve los ids
        $file_ids = get_post_meta($post_id, $field_name, false) ?: []; // array vacio en caso no tenga
        // Mapear los IDs a sus URL
        $file_urls = array_map(function ($file_id) {
          return wp_get_attachment_url($file_id);
        }, $file_ids);

        $multi_data[$field_name] = $file_urls; // Guardar las URL en lugar de los IDs
      }

      $data[] = [
        'id' => $post_id, /* id del post*/
        'title' => get_the_title(), /* titulo del post*/
        'link' => get_permalink(), /* slug del post*/
        'excerpt' => get_the_excerpt() ?: '',  /* El excerpt o resumen */
        'thumbnail' => $thumbnails, /* La url de la imagen destacada */
        'single_fields' => $single_data, /* Aquí se incluyen todos los campos personalizados simples */
        'multi_fields' => $multi_data, /* Aquí se incluyen todos los campos personalizados arrays */
      ];
    }
    wp_reset_postdata();
  }

  return $data;
}