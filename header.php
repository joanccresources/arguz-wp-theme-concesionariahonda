<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>

  <!-- Global css -->
  <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/css/main.css?v=<?= time() ?>">
  <?php
  $page_styles = [
    'home' => 'home.css',
    'agenda-tu-cita' => 'agenda-tu-cita.css',
    'sorsa-motors' => 'sorsa-motors.css',
    'concesionaria-honda' => 'concesionaria-honda.css',
    'repuestos-honda' => 'repuestos-honda.css',
    'servicio-tecnico-autorizado' => 'servicio-tecnico-autorizado.css',
    'comunidad-motera' => 'comunidad-motera.css'
  ];

  // Verifica si la página actual está en el array y carga la hoja de estilo correspondiente
  $current_page = get_post_field('post_name', get_post());
  if (array_key_exists($current_page, $page_styles)) {
    echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/assets/css/' . $page_styles[$current_page] . '?v=' . time() . '">';
  }
  // Shop de woocommerce
  if (is_shop() || is_product_category() || is_product()) {
    echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/assets/css/shop.css?v=' . time() . '">';
  }
  ?>
</head>

<body <?php body_class(); ?>>
  <?php
  // Body open
  wp_body_open();

  // Preloder
  eura_preloader();

  // Header
  eura_nav_area();
