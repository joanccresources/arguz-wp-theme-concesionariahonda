<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>

  <!-- Global css -->
  <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/css/main.css?v=<?= time() ?>">
  <?php if (is_page("home")): ?>
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/css/home.css?v=<?= time() ?>">
  <?php endif; ?>
  <?php if (is_page("agenda-tu-cita")): ?>
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/css/agenda-tu-cita.css?v=<?= time() ?>">
  <?php endif; ?>
</head>

<body <?php body_class(); ?>>
  <?php
  // Body open
  wp_body_open();

  // Preloder
  eura_preloader();

  // Header
  eura_nav_area();
