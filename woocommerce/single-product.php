<?php
/*
  URL: honda.sorsa.pe/shop/producto-01
  UI: All
*/
global $eura_opt;

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

get_header('shop');
$product_sidebar = isset($eura_opt['product_sidebar']) ? $eura_opt['product_sidebar'] : '';
$title = get_the_title();

// Blog breadcrumb
// Single Product breadcrumb
if (isset($eura_opt['hide_product_banner'])) {
  $hide_product_breadcrumb = $eura_opt['hide_product_breadcrumb'];
  $hide_product_banner = $eura_opt['hide_product_banner'];
  $hide_page_title = $eura_opt['hide_page_title'];
  $blog_banner_shape = $eura_opt['blog_banner_shape']['url'];
  $blog_banner_img = $eura_opt['blog_banner_img']['url'];
} else {
  $hide_product_breadcrumb = false;
  $hide_product_banner = false;
  $hide_page_title = false;
  $blog_banner_shape = false;
  $blog_banner_img = false;
}


// Blog page link
if (get_option('page_for_posts')) {
  $product_link = get_permalink(get_option('page_for_posts'));
} else {
  $product_link = home_url('/');
}

$eura_product_single_layout = !empty($eura_opt['eura_product_single_layout']) ? $eura_opt['eura_product_single_layout'] : 'container';

if (isset($eura_opt['page_title_tag'])):
  $tag = $eura_opt['page_title_tag'];
else:
  $tag = 'h2';
endif;

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
?>

<?php if ($hide_product_banner == false): ?>
  <div class="breadcrumb-wrap bg-aqua">
    <div class="container position-relative">
      <div class="row">
        <div class="col-lg-6">
          <div class="br-content">
            <?php if ($hide_page_title == false): ?>
              <?php if (isset($tag)): ?>
                <<?php echo esc_attr($tag); ?> class="br-title"><?php echo esc_html($title); ?></<?php echo esc_attr($tag); ?>>
              <?php else: ?>
                <<?php echo esc_attr($tag); ?> class="br-title"><?php esc_html_e('Blog Details', 'eura'); ?></<?php echo esc_attr($tag); ?>>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($hide_product_breadcrumb == false): ?>
              <?php
              if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<p class="eura-seo-breadcrumbs" id="breadcrumbs">', '</p>');
              } else { ?>
                <ul class="br-menu list-unstyle">
                  <li class="d-inline-block position-relative"><a
                      href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'eura'); ?></a></li>
                  <li class="d-inline-block position-relative"><a
                      href="<?php echo esc_url(home_url('/shop/')); ?>"><?php esc_html_e('Shop', 'eura'); ?></a></li>
                  <li class="d-inline-block position-relative active"><?php the_title(); ?></li>
                  <?php ?>
                </ul>
                <?php
              }
            endif; ?>
          </div>
        </div>
      </div>
      <?php if ($blog_banner_shape): ?>
        <img src="<?php echo esc_url($blog_banner_shape) ?>" class="br-shape position-absolute"
          alt="<?php echo esc_attr__('images', 'eura'); ?>">
      <?php else: ?>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/br-shape.webp') ?>"
          class="br-shape position-absolute" alt="Shape">
      <?php endif; ?>
      <?php if ($blog_banner_img): ?>
        <img src="<?php echo esc_url($blog_banner_img) ?>" class="br-img position-absolute"
          alt="<?php echo esc_attr__('images', 'eura'); ?>">
      <?php else: ?>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/br-img.webp') ?>"
          class="br-img position-absolute" alt="Shape">
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>


<!-- *****************************HERO BEGIN***************************** -->
<?php
$product_id = get_the_ID();
$product_cats = wp_get_post_terms($product_id, 'product_cat');
if (!empty($product_cats) && !is_wp_error($product_cats)):

  // Selecciona la categoría principal o la primera del array
  $main_category = array_filter($product_cats, function ($cat) {
    return $cat->parent === 0;
  });


  // $product_cat = $product_cats[0];
  $product_cat = !empty($main_category) ? array_values($main_category)[0] : $product_cats[0];
  $category_id = $product_cat->term_id;

  $hero_logo = "";
  $hero_logo_id = get_term_meta($category_id, 'hero_logo', true);
  if (!empty($hero_logo_id)):
    $hero_logo = wp_get_attachment_url($hero_logo_id);
  else:
    $hero_logo = get_stylesheet_directory_uri() . '/assets/img/logo-honda-detalle-producto.png';
  endif;

  $hero_imagen = "";
  $hero_imagen_id = get_term_meta($category_id, 'hero_imagen', true);
  if (!empty($hero_imagen_id)):
    $hero_imagen = wp_get_attachment_url($hero_imagen_id);
  else:
    $hero_imagen = get_stylesheet_directory_uri() . '/assets/img/banner-pisteras.jpg';
  endif;

  $hero_titulo = get_term_meta($category_id, 'hero_titulo', true);
  if (!$hero_titulo)
    $hero_titulo = $product_cat->name; // Nombre de la categoría

  if ($hero_imagen && $hero_titulo):
    ?>
    <div class="hero-product d-none" id="hero-product">
      <div class="container">
        <div class="row">
          <div class="col-md-4 align-self-center py-3 py-md-0">
            <div class="pe-md-3 text-center text-md-start">
              <div class="hero-product__figure-logo">
                <!-- <img src="<?php /*echo get_stylesheet_directory_uri() */ ?>/assets/img/logo-honda-detalle-producto.png" alt="Logo Honda"
                  class="hero-product__logo"> -->
                <img src="<?= esc_url($hero_logo) ?>" alt="Logo Honda" class="hero-product__logo">
              </div>
              <div class="hero-product__title-content">
                <p class="hero-product__title"><?= esc_html($hero_titulo) ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-8 px-md-0">
            <div class="hero-product__figure-banner">
              <img src="<?= esc_url($hero_imagen) ?>" alt="<?= esc_attr($hero_titulo) ?>" class="hero-product__banner">
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <p>No hay datos de hero en esta categoría.</p>
  <?php endif; ?>
<?php endif; ?>
<!-- HERO END-->

<div class="products_details ptb-150 joan_02" id="show-product">
  <div class="container">
    <div class="row">
      <?php if (is_active_sidebar('shop')): ?>
        <?php if (isset($_GET['shop'])): ?>
          <?php $eura_shop_cat_sidebar = $_GET['shop']; ?>
          <?php if ($eura_shop_cat_sidebar == 'none'): ?>
            <div class="col-lg-12 col-md-12">
            <?php elseif ($eura_shop_cat_sidebar == 'left'): ?>
              <?php do_action('woocommerce_sidebar'); ?>
              <div class="col-lg-8 col-md-12 _prod_1">
              <?php elseif ($eura_shop_cat_sidebar == 'right'): ?>
                <div class="col-lg-8 col-md-12 _prod_2">
                <?php endif; ?>
              <?php else: ?>
                <?php if ($product_sidebar == 'left-sidebar'): ?>
                  <!-- Sorsa -->
                  <?php /*do_action('woocommerce_sidebar');*/ ?>
                  <!-- <div class="col-lg-8 col-md-12 _prod_3"> -->
                  <div class="col-12 _prod_3">
                  <?php elseif ($product_sidebar == 'right-sidebar'): ?>
                    <div class="col-lg-8 col-md-12 _prod_4">
                    <?php else: ?>
                      <div class="col-lg-12 col-md-12">
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php else: ?>
                    <div class="col-lg-12 col-md-12">
                    <?php endif; ?>

                    <?php
                    /**
                     * woocommerce_before_main_content hook.
                     *
                     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                     * @hooked woocommerce_breadcrumb - 20
                     */

                    do_action('woocommerce_before_main_content');

                    while (have_posts()):
                      the_post();
                      // Nos lleva a la plantilla content-single-product.php
                      wc_get_template_part('content', 'single-product');

                    endwhile;

                    /**
                     * woocommerce_after_main_content hook.
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action('woocommerce_after_main_content');
                    ?>
                  </div>
                  <?php
                  if (isset($_GET['shop'])):
                    if ($eura_shop_cat_sidebar == 'right'):
                      do_action('woocommerce_sidebar');
                    endif;
                  else:
                    if ($product_sidebar == 'right-sidebar'):
                      do_action('woocommerce_sidebar');
                    endif;
                  endif;
                  ?>
                </div>
              </div>
            </div>

            <?php get_footer('shop');
            /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
            ?>