<?php

/*** Editor clasico ***/
add_filter('use_block_editor_for_post', '__return_false', 10);

/*** Agregar estilos al editor WP ***/
/*
add_action('admin_init', 'custom_editor_styles_inline');
function custom_editor_styles_inline()
{
  // Estilos personalizados para el editor
  $custom_css = "
      body#tinymce.wp-editor {
          background-color: #333; 
          color: #fff;
      }
      body#tinymce.wp-editor p {
          color: #fff;
      }
  ";
  // Agregar el estilo inline en el editor
  add_editor_style(); // Esto asegura que cargue los estilos del editor
  wp_add_inline_style('editor-buttons', $custom_css);
}
*/

/*** Retorna un array con nuestros campos creados con PODS sobre ajustes_del_tema ***/
function get_pods_variables()
{
  $settings = pods('ajustes_del_tema');
  return array(
    // TOP HEADER
    'facebook' => $settings->field('top_header_facebook'),
    'instagram' => $settings->field('top_header_instagram'),
    'btn_reserva' => $settings->field('top_header_agenda_tu_cita'),
    // BOTON FLOTANTE
    'whatsapp' => $settings->field('flotante_whatsapp'),
    // FOOTER
    // 'footer_col1'     => $settings->field('footer_enlaces_columna_1'),
    // 'footer_col2'     => $settings->field('footer_enlaces_columna_2'),
    // 'footer_copyright'     => $settings->field('footer_copyright'),
  );
}

function eura_enqueue_style()
{
  wp_enqueue_script('main-script', get_stylesheet_directory_uri() . '/assets/js/main.js?v=' . time(), array(), null, true);
  wp_enqueue_style('font-awesome', 'https://honda.sorsa.pe/wp-content/plugins/yith-woocommerce-wishlist/assets/css/font-awesome.css?ver=4.7.0', array(), '4.7.0', 'all');

  // Obtener las variables desde Pods
  $variables_pods = get_pods_variables();
  wp_localize_script('main-script', 'settingsTheme', $variables_pods);


  if (is_page("home")) {
    wp_enqueue_script('home-script', get_stylesheet_directory_uri() . '/assets/js/home.js?v=' . time(), array(), null, true);
  }
  if (is_page("agenda-tu-cita")) {
    // Agregar el CSS de Flatpickr
    wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
    // Agregar el script de Flatpickr
    wp_enqueue_script('flatpickr-script', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), null, true);
    wp_enqueue_script('agenda-tu-cita-script', get_stylesheet_directory_uri() . '/assets/js/agenda-tu-cita.js?v=' . time(), array(), null, true);
    wp_enqueue_script('agenda-tu-cita-contact-form-script', get_stylesheet_directory_uri() . '/assets/js/agenda-tu-cita-contact-form.js?v=' . time(), array(), null, true);
  }
  if (is_product()) {
    wp_enqueue_script('product-detail-script', get_stylesheet_directory_uri() . '/assets/js/product-detail.js?v=' . time(), array(), null, true);
  }
  if (is_shop() || is_product_category()) {
    wp_enqueue_script('shop-script', get_stylesheet_directory_uri() . '/assets/js/shop.js?v=' . time(), array(), null, true);
  }
  // if (is_product()) {
  //   wp_enqueue_script('single-product-script', get_stylesheet_directory_uri() . '/assets/js/single-product.js?v=' . time(), array(), null, true);
  // }
  wp_enqueue_style("parent-style", get_parent_theme_file_uri("/style.css"));
}
add_action('wp_enqueue_scripts', 'eura_enqueue_style');

// WOOCOMMERCE
// Filtro para el taxonomy "tipo_de_vehiculo"
/* 
  URLS:
  ?filter_tipo_de_vehiculo=motokar
  ?filter_tipo_de_vehiculo=motokar,moto
  ?filter_tipo_de_vehiculo=alta-gama,motokar
  ?filter_tipo_de_vehiculo=alta-gama,motokar,moto
*/
/*
add_action('pre_get_posts', 'filtrar_productos_por_tipo_de_vehiculo');
function filtrar_productos_por_tipo_de_vehiculo($query)
{
  if (! is_admin() && $query->is_main_query() && (is_shop() || is_product_taxonomy())) {
    if (isset($_GET['filter_tipo_de_vehiculo']) && ! empty($_GET['filter_tipo_de_vehiculo'])) {
      $tipo_de_vehiculo_slugs = array_map('sanitize_text_field', explode(',', $_GET['filter_tipo_de_vehiculo']));
      // Añadimos la tax_query a la consulta
      $tax_query = array(
        array(
          'taxonomy' => 'tipo_de_vehiculo',
          'field'    => 'slug',
          'terms'    => $tipo_de_vehiculo_slugs,
          'operator' => 'IN',
        ),
      );
      $query->set('tax_query', $tax_query);
    }
  }
}
*/


/*** Cambiar el texto de WooCommerce ***/
add_filter('gettext', 'divi_engine_wc_translations', 20);
function divi_engine_wc_translations($translated)
{
  $text = array(
    "Apply coupon" => "Aplicar cupón",
    "Coupon code" => "Código promocional",
    "Proceed to checkout" => "Proceder al pago",
    "Update cart" => "Actualizar carrito",
    "Reviews" => "Reseñas"
  );
  $translated = str_ireplace(array_keys($text), $text, $translated);
  return $translated;
}
add_action('wp_footer', 'custom_shop_translation_script');
function custom_shop_translation_script()
{
  if (is_shop()) { // Asegúrate de que se aplique solo en la página de tienda
    ?>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function () {
        const resultCountElement = document.querySelector(".woocommerce-topbar .woocommerce-result-count");
        if (resultCountElement) {
          resultCountElement.textContent = resultCountElement.textContent
            .replace("Showing", "Mostrando")
            .replace("of", "de")
            .replace("results", "resultados");
        }
      });
    </script>
    <?php
  }
}

/*** Quitar decimales si no los tiene en WooCommerce ***/
add_filter('woocommerce_price_trim_zeros', 'remover_decimales_woocommerce', 10, 1);
function remover_decimales_woocommerce($trim)
{
  return true;
}


// Shortcodes
require_once get_stylesheet_directory() . '/shortcodes/load-shortcodes.php';

// Functions
// require_once get_stylesheet_directory() . '/inc/load-functions.php';
require_once get_stylesheet_directory() . '/inc/load-functions.php';

// Add clases
function custom_body_class($classes)
{
  // Array de páginas y sus respectivas clases
  $page_classes = [
    'home' => 'page-slug-home',
    'sorsa-motors' => 'page-slug-sorsa-motors',
    'repuestos-honda' => 'page-slug-repuestos-honda',
    'servicio-tecnico-autorizado' => 'page-slug-servicio-tecnico-autorizado',
    'comunidad-motera' => 'page-slug-comunidad-motera',
    'terminos-y-condiciones' => 'page-slug-terminos-y-condiciones',
  ];
  // Asignar clases según el slug de la página
  foreach ($page_classes as $slug => $class) {
    if (is_page($slug))
      $classes[] = $class;
  }

  if (is_single())
    $classes[] = 'single-slug-all'; // Clase para entradas individuales
  if (is_category())
    $classes[] = 'category-slug-all'; // Clase para páginas de categoría
  if (is_shop())
    $classes[] = 'woo-slug-shop';
  if (is_product_category())
    $classes[] = 'woo-slug-product-category';
  if (is_product())
    $classes[] = 'woo-slug-product';
  return $classes;
}
add_filter('body_class', 'custom_body_class');

/****************************************************************************/

// DATABASE****************************************************************
// Se crea Tabla de Reservas
function crear_tabla_reservas()
{
  global $wpdb;

  $tabla_reservas = $wpdb->prefix . 'reservas';
  $charset_collate = $wpdb->get_charset_collate();

  // Verificar si la tabla ya existe
  if ($wpdb->get_var("SHOW TABLES LIKE '$tabla_reservas'") != $tabla_reservas) {
    $sql = "CREATE TABLE $tabla_reservas (
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      asesor_id bigint(20) unsigned NOT NULL,
      fecha date NOT NULL,
      hora_inicio time NOT NULL,
      hora_fin time NOT NULL,
      nombre_cliente varchar(255) NOT NULL,
      correo_cliente varchar(255) NOT NULL,
      PRIMARY KEY (id),
      FOREIGN KEY (asesor_id) REFERENCES {$wpdb->prefix}posts(ID) ON DELETE CASCADE
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
}
// register_activation_hook(__FILE__, 'crear_tabla_reservas');
add_action('after_setup_theme', 'crear_tabla_reservas');
// Temporalmente, puedes usar esto en functions.php para crear la tabla
// add_action('init', 'crear_tabla_reservas');

// Insertar una reserva
function insertar_reserva($asesor_id, $fecha, $hora_inicio, $hora_fin, $nombre_cliente, $correo_cliente)
{
  global $wpdb;

  $tabla_reservas = $wpdb->prefix . 'reservas'; // Nombre de tu tabla de reservas

  $resultado = $wpdb->insert(
    $tabla_reservas,
    array(
      'asesor_id' => $asesor_id,
      'fecha' => $fecha,
      'hora_inicio' => $hora_inicio,
      'hora_fin' => !empty($hora_fin) ? $hora_fin : null, // Inserta null si hora_fin está vacío
      'nombre_cliente' => $nombre_cliente,
      'correo_cliente' => $correo_cliente,
    ),
    array('%d', '%s', '%s', '%s', '%s', '%s')  // Formatos: %d para números, %s para strings
  );
  return $resultado !== false;
}
// Validar disponibilidad antes de la reserva
// Si alguien ya reservo esa fecha con esa hora entonces retorna false
function verificar_disponibilidad($asesor_id, $fecha, $hora_inicio, $hora_fin)
{
  global $wpdb;

  $tabla_reservas = $wpdb->prefix . 'reservas';

  $existe_reserva = $wpdb->get_var(
    $wpdb->prepare(
      "SELECT COUNT(*) FROM $tabla_reservas WHERE asesor_id = %d AND fecha = %s AND hora_inicio = %s",
      $asesor_id,
      $fecha,
      $hora_inicio
    )
  );
  return $existe_reserva == 0; // Devuelve true si no hay reserva
}


// AGREGANDO AL ADMIN****************************************************************
function agregar_menu_reservas()
{
  add_menu_page(
    'Reservas de Asesores',     // Título de la página
    'Reservas',                 // Título del menú
    'manage_options',           // Capacidad requerida
    'reservas-asesores',        // Slug del menú
    'mostrar_reservas',         // Función callback
    'dashicons-calendar',       // Icono del menú
    20                          // Posición en el menú
  );
}
add_action('admin_menu', 'agregar_menu_reservas');

function mostrar_reservas()
{
  global $wpdb;

  $tabla_reservas = $wpdb->prefix . 'reservas';
  $tabla_asesores = $wpdb->prefix . 'posts';  // Tabla donde están los asesores

  // Si se envía una solicitud para eliminar una reserva
  if (isset($_GET['eliminar_reserva'])) {
    $reserva_id = intval($_GET['eliminar_reserva']);
    $wpdb->delete($tabla_reservas, array('id' => $reserva_id));
    echo '<div class="notice notice-success is-dismissible"><p>Reserva eliminada exitosamente.</p></div>';
  }

  // Obtener filtros de búsqueda
  $busqueda = isset($_GET['busqueda']) ? sanitize_text_field($_GET['busqueda']) : '';
  $fecha_filtro = isset($_GET['fecha']) ? sanitize_text_field($_GET['fecha']) : '';

  // Parámetros de paginación
  $results_per_page = 10; // Número de resultados por página
  $current_page = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
  $offset = ($current_page - 1) * $results_per_page;

  // Consulta SQL para contar registros
  $where_clauses = [];
  $where_params = [];

  if (!empty($busqueda)) {
    $where_clauses[] = "(a.post_title LIKE %s OR r.nombre_cliente LIKE %s)";
    $where_params[] = '%' . $wpdb->esc_like($busqueda) . '%';
    $where_params[] = '%' . $wpdb->esc_like($busqueda) . '%';
  }
  if (!empty($fecha_filtro)) {
    $where_clauses[] = "r.fecha = %s";
    $where_params[] = $fecha_filtro;
  }

  $where_sql = !empty($where_clauses) ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

  $count_query = "
        SELECT COUNT(*) 
        FROM $tabla_reservas r
        INNER JOIN $tabla_asesores a ON r.asesor_id = a.ID
        $where_sql
    ";
  $total_results = $wpdb->get_var($wpdb->prepare($count_query, ...$where_params));
  $total_pages = ceil($total_results / $results_per_page);

  // Consulta SQL con paginación
  $query = "
        SELECT r.id, r.fecha, r.hora_inicio, r.hora_fin, r.nombre_cliente, r.correo_cliente, a.post_title AS asesor, a.ID AS asesor_id
        FROM $tabla_reservas r
        INNER JOIN $tabla_asesores a ON r.asesor_id = a.ID
        $where_sql
        ORDER BY r.fecha DESC
        LIMIT %d OFFSET %d
    ";
  $where_params[] = $results_per_page;
  $where_params[] = $offset;

  $sql = $wpdb->prepare($query, ...$where_params);
  $reservas = $wpdb->get_results($sql);

  echo '<div class="wrap">';
  echo '<h1>Reservas de Asesores</h1>';

  // Formulario de búsqueda y filtro por fecha
  echo '<form method="GET" action="" style="text-align: right;margin-bottom: 12px;">';
  echo '<input type="hidden" name="page" value="reservas-asesores">';
  echo '<input type="text" name="busqueda" value="' . esc_attr($busqueda) . '" placeholder="Buscar por nombre de asesor o cliente" style="min-width: 200px;">';
  echo '<input type="date" name="fecha" value="' . esc_attr($fecha_filtro) . '" style="min-width: 150px;">';
  echo '<input type="submit" value="Filtrar" class="button">';
  echo '</form>';

  // Tabla de resultados
  echo '<table class="widefat fixed" cellspacing="0">';
  echo '<thead><tr><th>ID</th><th>Asesor</th><th>Fecha Reservada</th><th>Hora Inicio</th><th>Ubicación</th><th>Nombre Cliente</th><th>Correo Cliente</th><th>Acciones</th></tr></thead>';
  echo '<tbody>';

  foreach ($reservas as $reserva) {
    // Obtener la ubicación del asesor (taxonomía)
    $ubicacion = get_the_terms($reserva->asesor_id, 'ubicacion');
    $ubicacion_nombre = $ubicacion && !is_wp_error($ubicacion) ? esc_html($ubicacion[0]->name) : 'Sin ubicación';

    echo '<tr>';
    echo '<td>' . esc_html($reserva->id) . '</td>';
    echo '<td>' . esc_html($reserva->asesor) . '</td>';
    echo '<td>' . esc_html($reserva->fecha) . '</td>';
    echo '<td>' . esc_html($reserva->hora_inicio) . '</td>';
    echo '<td>' . $ubicacion_nombre . '</td>';
    echo '<td>' . esc_html($reserva->nombre_cliente) . '</td>';
    echo '<td>' . esc_html($reserva->correo_cliente) . '</td>';
    echo '<td><a href="?page=reservas-asesores&eliminar_reserva=' . esc_html($reserva->id) . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta reserva?\');">Eliminar</a></td>';
    echo '</tr>';
  }

  echo '</tbody></table>';

  // Paginación
  echo '<div class="tablenav bottom">';
  echo '<div class="tablenav-pages">';
  echo '<span class="displaying-num">Página ' . $current_page . ' de ' . $total_pages . '</span>';

  echo '<style>#sorsa-pagination-links .page-numbers.current{font-weight: bold;font-size: 14px;}</style>';
  echo '<span class="pagination-links" id="sorsa-pagination-links">';

  if ($current_page > 1) {
    echo '<a style="margin-inline:5px;" class="prev page-numbers" href="?page=reservas-asesores&busqueda=' . esc_attr($busqueda) . '&fecha=' . esc_attr($fecha_filtro) . '&paged=' . ($current_page - 1) . '">« Anterior</a>';
  }

  for ($i = 1; $i <= $total_pages; $i++) {
    echo '<a style="margin-inline:5px;" class="page-numbers' . ($i == $current_page ? ' current' : '') . '" href="?page=reservas-asesores&busqueda=' . esc_attr($busqueda) . '&fecha=' . esc_attr($fecha_filtro) . '&paged=' . $i . '">' . $i . '</a>';
  }

  if ($current_page < $total_pages) {
    echo '<a style="margin-inline:5px;" class="next page-numbers" href="?page=reservas-asesores&busqueda=' . esc_attr($busqueda) . '&fecha=' . esc_attr($fecha_filtro) . '&paged=' . ($current_page + 1) . '">Siguiente »</a>';
  }
  echo '</span>';
  echo '</div>';
  echo '</div>';

  echo '</div>';
}


// ENDPOINT 1****************************************************************
function verificar_disponibilidad_endpoint()
{
  register_rest_route('asesores/v1', '/disponibilidad', array(
    'methods' => 'GET',
    'callback' => 'verificar_disponibilidad_callback',
    'permission_callback' => '__return_true', // Puedes ajustar los permisos si es necesario
  ));
}
add_action('rest_api_init', 'verificar_disponibilidad_endpoint');

function verificar_disponibilidad_callback(WP_REST_Request $request)
{
  global $wpdb;

  // Obtener los parámetros del request
  $asesor_id = intval($request->get_param('asesor_id'));
  $fecha = sanitize_text_field($request->get_param('fecha'));
  $hora_inicio = sanitize_text_field($request->get_param('hora_inicio'));


  // Validar que los parámetros obligatorios estén presentes
  if (empty($asesor_id) || empty($fecha) || empty($hora_inicio)) {
    return new WP_REST_Response(array('success' => false, 'message' => 'asesor_id, fecha y hora_inicio son obligatorios'), 400);
  }

  // Validar el formato de la fecha (YYYY-MM-DD)
  if (!preg_match('/\d{4}-\d{2}-\d{2}/', $fecha)) {
    return new WP_REST_Response(array('success' => false, 'message' => 'Formato de fecha incorrecto. Use YYYY-MM-DD'), 400);
  }

  // Verificar si el asesor existe en la base de datos (suponiendo que los asesores son posts en WP)
  $asesor_existe = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM {$wpdb->prefix}posts WHERE ID = %d AND post_type = 'asesor' AND post_status = 'publish'",
    $asesor_id
  ));
  if (!$asesor_existe) {
    return new WP_REST_Response(array('success' => false, 'message' => 'El asesor no existe o no está disponible'), 404);
  }


  // Usar la función verificar_disponibilidad para ver si el asesor está disponible
  // De esta manera si se selecciona una hora, ya no podra seleccionarse dicha hora  
  $disponible = verificar_disponibilidad($asesor_id, $fecha, $hora_inicio, $hora_fin = null); // Puedes ajustar los parámetros según lo que necesites
  // Retornar la respuesta en formato JSON
  if ($disponible) {
    return new WP_REST_Response(array('success' => true), 200);
  } else {
    // return new WP_REST_Response(array('success' => false, 'message' => 'El asesor ya tiene una reserva en esa fecha y hora'), 409);
    return new WP_REST_Response(array('success' => false, 'message' => 'El asesor ya tiene una reserva en esa fecha y hora'), 200);
  }
}


// ENDPOINT 2****************************************************************
function insertar_reserva_endpoint()
{
  register_rest_route('asesores/v1', '/reservar', array(
    'methods' => 'POST',
    'callback' => 'insertar_reserva_callback',
    'permission_callback' => '__return_true', // Puedes ajustar permisos si es necesario
  ));
}

add_action('rest_api_init', 'insertar_reserva_endpoint');
function insertar_reserva_callback(WP_REST_Request $request)
{
  global $wpdb;

  // Obtener los parámetros enviados en la solicitud POST
  $asesor_id = intval($request->get_param('asesor_id'));
  $fecha = sanitize_text_field($request->get_param('fecha'));
  $hora_inicio = sanitize_text_field($request->get_param('hora_inicio'));
  $hora_fin = sanitize_text_field($request->get_param('hora_fin'));
  $nombre_cliente = sanitize_text_field($request->get_param('nombre_cliente'));
  $correo_cliente = sanitize_email($request->get_param('correo_cliente'));

  // Validar que los campos obligatorios no estén vacíos
  // if (empty($asesor_id) || empty($fecha) || empty($hora_inicio) || empty($nombre_cliente) || empty($correo_cliente)) {
  if (empty($asesor_id) || empty($fecha) || empty($hora_inicio) || empty($nombre_cliente)) {
    return new WP_REST_Response(array('success' => false, 'message' => 'Datos incompletos'), 400);
  }

  // Convertir la fecha al formato YYYY-MM-DD si es necesario
  if (!preg_match('/\d{4}-\d{2}-\d{2}/', $fecha)) {
    return new WP_REST_Response(array('success' => false, 'message' => 'Formato de fecha incorrecto. Use YYYY-MM-DD'), 400);
  }

  // Verificar si el asesor existe en la base de datos (suponiendo que los asesores son posts en WP)
  $asesor_existe = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM {$wpdb->prefix}posts WHERE ID = %d AND post_type = 'asesor' AND post_status = 'publish'",
    $asesor_id
  ));
  if (!$asesor_existe) {
    return new WP_REST_Response(array('success' => false, 'message' => 'El asesor no existe o no está disponible'), 404);
  }

  // Verificar que la fecha de reserva no sea anterior a la fecha actual
  date_default_timezone_set('America/Lima'); // Ajusta la zona horaria si es necesario
  $fecha_actual = date('Y-m-d');  // Fecha actual con la zona horaria correcta
  if ($fecha < $fecha_actual) {
    return new WP_REST_Response(array('success' => false, 'message' => 'No puedes reservar en una fecha anterior a la actual'), 409);
  }
  // Verificar que la hora de reserva no sea anterior a la hora actual (en la misma fecha)
  if ($fecha === $fecha_actual) {
    $hora_actual = date('H:i');  // Hora actual con la zona horaria correcta
    if ($hora_inicio < $hora_actual) {
      return new WP_REST_Response(array('success' => false, 'message' => 'No puedes reservar en una hora que ya ha pasado'), 409);
    }
  }

  // CLIENTE: AHORA SE PUEDEN AGENDAR N reservas a la misma hora
  /*
  // Llamar a la función para verificar disponibilidad
  $disponible = verificar_disponibilidad($asesor_id, $fecha, $hora_inicio, $hora_fin);
  // Si ya existe una reserva, devolver un error
  if (!$disponible) {
    return new WP_REST_Response(array('success' => false, 'message' => 'Ya existe una reserva para este asesor en esta fecha y hora'), 409); // Código 409: conflicto
  }
  */

  // Llamar a la función que inserta la reserva
  // $resultado = insertar_reserva($asesor_id, $fecha, $hora_inicio, $hora_fin);
  $resultado = insertar_reserva($asesor_id, $fecha, $hora_inicio, $hora_fin, $nombre_cliente, $correo_cliente);

  if ($resultado) {
    return new WP_REST_Response(array('success' => true, 'message' => 'Reserva insertada con éxito'), 200);
  } else {
    return new WP_REST_Response(array('success' => false, 'message' => 'Error al insertar la reserva' . ' - ' . print_r($resultado)), 500);
  }
}
