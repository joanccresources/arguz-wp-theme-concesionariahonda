<?php
/*
URL: concesionariahonda.sorsa.pe/shop/
UI: All page
*/
defined('ABSPATH') || exit;

get_header('shop');

global $eura_opt;

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

do_action('woocommerce_before_main_content');

$post_page_id       = get_option('woocommerce_shop_page_id');
$product_sidebar    = isset($eura_opt['product_sidebar']) ? $eura_opt['product_sidebar'] : '';

// Blog breadcrumb
if (isset($eura_opt['blog_title'])) {
  $hide_breadcrumb        = $eura_opt['hide_breadcrumb'];
  $hide_blog_banner       = $eura_opt['hide_blog_banner'];
  $hide_page_title        = $eura_opt['hide_page_title'];
  $blog_banner_shape      = $eura_opt['blog_banner_shape']['url'];
  $blog_banner_img        = $eura_opt['blog_banner_img']['url'];
} else {
  $hide_breadcrumb        = false;
  $hide_blog_banner       = false;
  $hide_page_title        = false;
  $blog_banner_shape      = false;
  $blog_banner_img        = false;
}

// Blog page link
if (get_option('page_for_posts')) {
  $blog_link = get_permalink(get_option('page_for_posts'));
} else {
  $blog_link = home_url('/');
}

$eura_blog_layout = !empty($eura_opt['eura_blog_layout']) ? $eura_opt['eura_blog_layout'] : 'container';
if (isset($eura_opt['page_title_tag'])):
  $tag = $eura_opt['page_title_tag'];
else:
  $tag = 'h2';
endif;
?>

<?php if ($hide_blog_banner == false): ?>
  <div class="breadcrumb-wrap bg-aqua ___123">
    <div class="container position-relative">
      <div class="row">
        <div class="col-lg-6">
          <div class="br-content">
            <?php if ($hide_page_title == false): ?>
              <?php if (isset($tag)): ?>
                <<?php echo esc_attr($tag); ?> class="br-title"><?php woocommerce_page_title(); ?></<?php echo esc_attr($tag); ?>>
              <?php else: ?>
                <<?php echo esc_attr($tag); ?> class="br-title"><?php esc_html_e('Shop', 'eura'); ?></<?php echo esc_attr($tag); ?>>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($hide_breadcrumb == false): ?>
              <?php
              if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<p class="eura-seo-breadcrumbs" id="breadcrumbs">', '</p>');
              } else { ?>
                <ul class="br-menu list-unstyle">
                  <li class="d-inline-block position-relative"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'eura'); ?></a></li>
                  <li class="d-inline-block position-relative active"><?php woocommerce_page_title(); ?></li>
                  <?php ?>

                </ul>
            <?php
              }
            endif; ?>
          </div>
        </div>
      </div>
      <?php if ($blog_banner_shape):  ?>
        <img src="<?php echo esc_url($blog_banner_shape) ?>" class="br-shape position-absolute" alt="<?php echo esc_attr__('images', 'eura'); ?>">
      <?php else: ?>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/br-shape.webp') ?>" class="br-shape position-absolute" alt="Shape">
      <?php endif; ?>
      <?php if ($blog_banner_img):  ?>
        <img src="<?php echo esc_url($blog_banner_img) ?>" class="br-img position-absolute" alt="<?php echo esc_attr__('images', 'eura'); ?>">
      <?php else: ?>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/br-img.webp') ?>" class="br-img position-absolute" alt="Shape">
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

<!-- MOSTRAR IMAGEN DESTACADA DE SHOP -->
<?php
// Obtener el ID de la página Shop
$shop_page_id = get_option('woocommerce_shop_page_id');
// Verificar si la página Shop tiene una imagen destacada
echo '<div class="concesionaria-hero" id="concesionaria-hero">';
echo '<div class="concesionaria-hero__figure">';
if ($shop_page_id && has_post_thumbnail($shop_page_id)) {
  echo get_the_post_thumbnail($shop_page_id, 'full', array('class' => 'concesionaria-hero__img'));
} else {
  echo '<img fetchpriority="high" width="1368" height="525" src="' . get_site_url() . '/wp-content/uploads/2024/10/0.png" class="concesionaria-hero__img" alt="" decoding="async" srcset="' . get_site_url() . '/wp-content/uploads/2024/10/0.png 1368w, ' . get_site_url() . '/wp-content/uploads/2024/10/0-300x115.png 300w, ' . get_site_url() . '/wp-content/uploads/2024/10/0-1024x393.png 1024w, ' . get_site_url() . '/wp-content/uploads/2024/10/0-768x295.png 768w, ' . get_site_url() . '/wp-content/uploads/2024/10/0-530x203.png 530w" sizes="(max-width: 1368px) 100vw, 1368px">';
}
echo '</div>';
echo '</div>';
?>
<!-- MOSTRAR MODELOS -->
<?php
$included_slugs = array('honda-pistera', 'todo-terreno', 'scooters-honda');
$product_categories = get_terms(array(
  'taxonomy' => 'product_cat',
  'slug'       => $included_slugs,
  'hide_empty' => false,
));
if (! empty($product_categories) && ! is_wp_error($product_categories)) {
  echo '<div class="container">';
  echo '<div class="row">';
  echo '<div class="col-12">';
  echo '<div class="concesionaria-modelo__container">';
  foreach ($product_categories as $category) {
    $title = esc_html($category->name);
    $category_link = esc_url(get_term_link($category));
    $miniatura_id = get_term_meta($category->term_id, 'thumbnail_id', true);

    echo '<a class="card-concesionaria-modelo" href="' . $category_link . '">';
    echo '<div class="card-concesionaria-modelo__figure">';
    if ($miniatura_id) {
      $miniatura_url = wp_get_attachment_url($miniatura_id);
      if ($miniatura_url) {
        echo '<img src="' . esc_url($miniatura_url) . '" alt="' . esc_attr($category->name) . '" class="card-concesionaria-modelo__img"/>';
      }
    }
    echo '</div>';
    echo '<h3 class="card-concesionaria-modelo__title">' . $title . '</h3>';
    echo '</a>'; // .card-concesionaria-modelo
  }
  echo '</div>'; // .concesionaria-modelo__container
  echo '</div>'; // .col-12
  echo '</div>'; // .row
  echo '</div>'; // .container
} else {
  echo 'No hay categorías de productos disponibles.';
}
?>

<!-- <div class="special-products-area ptb-150"> -->
<div class="special-products-area py-4 py-md-5">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="title-motors text-center mb-3">
          <h2><span class="first">NUEVOS</span> MODELOS <?= date("Y") ?></h2>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      if (is_active_sidebar('shop')) {
        if (isset($_GET['shop'])) {
          $eura_shop_cat_sidebar = $_GET['shop'];

          if ($eura_shop_cat_sidebar == 'none'): ?>
            <div class="col-lg-12 col-md-12">
            <?php elseif ($eura_shop_cat_sidebar == 'left'): ?>
              <?php do_action('woocommerce_sidebar'); ?>
              <div class="col-lg-8 col-md-12 asd_1">
              <?php elseif ($eura_shop_cat_sidebar == 'right'): ?>
                <div class="col-lg-8 col-md-12 asd_2">
                <?php endif;
            } else {
              if ($product_sidebar == 'left-sidebar'): ?>
                  <?php do_action('woocommerce_sidebar'); ?>
                  <!-- /shop -->
                  <!-- sorsa -->
                  <div class="col-lg-9 col-md-12 mt-4 mt-lg-0">
                  <?php elseif ($product_sidebar == 'right-sidebar'): ?>
                    <div class="col-lg-8 col-md-12 asd_4">
                    <?php elseif ($product_sidebar == 'eura_product_no_sidebar'): ?>
                      <div class="col-lg-12 col-md-12">
                      <?php else: ?>
                        <?php do_action('woocommerce_sidebar'); ?>
                        <div class="col-lg-8 col-md-12 asd_5">
                      <?php endif;
                  }
                } else { ?>
                      <div class="col-lg-12 col-md-12">
                      <?php } ?>
                      <?php if (woocommerce_product_loop()) { ?>
                        <!-- sorsa -->
                        <div class="woocommerce-topbar">
                          <?php do_action('woocommerce_before_shop_loop'); ?>
                        </div>

                      <?Php
                        woocommerce_product_loop_start();

                        if (wc_get_loop_prop('total')) {
                          while (have_posts()) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             *
                             * @hooked WC_Structured_Data::generate_product_data() - 10
                             */
                            do_action('woocommerce_shop_loop');

                            wc_get_template_part('content', 'product');
                          }
                        }

                        woocommerce_product_loop_end();

                        /**
                         * Hook: woocommerce_after_shop_loop.
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                        do_action('woocommerce_after_shop_loop');
                      } else {
                        /**
                         * Hook: woocommerce_no_products_found.
                         *
                         * @hooked wc_no_products_found - 10
                         */
                        do_action('woocommerce_no_products_found');
                      } ?>
                      </div> <!-- end clo-8 -->

                      <?php
                      if (isset($_GET['shop'])) {
                        if ($eura_shop_cat_sidebar == 'right') {
                          do_action('woocommerce_sidebar');
                        }
                      } else {
                        if ($product_sidebar == 'right-sidebar') {
                          do_action('woocommerce_sidebar');
                        }
                      } ?>
                        </div>
                      </div>
                    </div>
                    <?php
                    /**
                     * Hook: woocommerce_after_main_content.
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action('woocommerce_after_main_content');

                    /**
                     * Hook: woocommerce_sidebar.
                     *
                     * @hooked woocommerce_get_sidebar - 10
                     */

                    get_footer('shop'); ?>