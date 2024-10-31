<?php get_header(); ?>

<?php
$args = array(
  'post_type' => 'product',
  'posts_per_page' => -1,
  'post_status' => 'publish', // Los post publicados
);

$products = get_custom_posttype(
  // args
  $args,
  // single custom fields
  ['imagen_para_el_home', 'producto_popular'], // Campos personalizados a incluir
  // multi custom fields
  []
);
?>

<div class="container">
  <pre>
    <?php
    foreach ($products as $product) {
      print_r($product);
    }
    ?>
  </pre>
</div>
<?php get_footer(); ?>