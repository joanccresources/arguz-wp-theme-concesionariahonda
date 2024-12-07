<?php
/*
URL: honda.sorsa.pe/shop/
UI: All page
*/
defined('ABSPATH') || exit;

get_header('shop');

global $eura_opt;

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

do_action('woocommerce_before_main_content');

$post_page_id = get_option('woocommerce_shop_page_id');
$product_sidebar = isset($eura_opt['product_sidebar']) ? $eura_opt['product_sidebar'] : '';

// Blog breadcrumb
if (isset($eura_opt['blog_title'])) {
  $hide_breadcrumb = $eura_opt['hide_breadcrumb'];
  $hide_blog_banner = $eura_opt['hide_blog_banner'];
  $hide_page_title = $eura_opt['hide_page_title'];
  $blog_banner_shape = $eura_opt['blog_banner_shape']['url'];
  $blog_banner_img = $eura_opt['blog_banner_img']['url'];
} else {
  $hide_breadcrumb = false;
  $hide_blog_banner = false;
  $hide_page_title = false;
  $blog_banner_shape = false;
  $blog_banner_img = false;
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
                  <li class="d-inline-block position-relative"><a
                      href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'eura'); ?></a></li>
                  <li class="d-inline-block position-relative active"><?php woocommerce_page_title(); ?></li>
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


<!-- MOSTRAR IMAGEN DESTACADA DE SHOP V1 -->
<?php
// Obtener el ID de la página Shop
$shop_page_id = get_option('woocommerce_shop_page_id');
// Verificar si la página Shop tiene una imagen destacada
echo '<div class="concesionaria-hero" id="concesionaria-hero">';
echo '  <div class="container">';
echo '    <div class="row align-items-md-center">';
echo '      <div class="order-2 order-lg-1 col-lg-4 mt-3 mt-lg-0">';

$included_slugs = array('moto', 'motokar', 'alta-gama');
$product_categories = get_terms(array(
  'taxonomy' => 'product_cat',
  'slug' => $included_slugs,
  'hide_empty' => false,
  'meta_key' => 'orden_modelo',
  'orderby' => 'meta_value_num',
  'order' => 'ASC',
));
if (!empty($product_categories) && !is_wp_error($product_categories)) {
  echo '        <ul class="modelos-shop-sorsa">';
  foreach ($product_categories as $category) {
    $title = esc_html($category->name);
    $category_link = esc_url(get_term_link($category));
    $miniatura_id = get_term_meta($category->term_id, 'thumbnail_id', true);
    echo '        <li class="card-modelo-shop">';
    echo '          <a class="card-modelo-shop__link" href="' . $category_link . '">';
    echo '            <div class="card-modelo-shop__body">';
    if ($miniatura_id) {
      $miniatura_url = wp_get_attachment_url($miniatura_id);
      if ($miniatura_url) {
        echo '              <div class="card-modelo-shop__figure">';
        echo '                <img src="' . esc_url($miniatura_url) . '" alt="' . esc_attr($category->name) . '" class="card-modelo-shop__img"/>';
        echo '              </div>';
      }
    }
    echo '              <div class="mt-1">';
    echo '                <p class="card-modelo-shop__title">' . $title . '</p>';
    echo '              </div>';

    echo '            </div>';
    echo '          </a>';
    echo '        </li>';
  }
  echo '        </ul>';
} else {
  echo 'No hay categorías de productos disponibles.';
}

echo '      </div>';
echo '      <div class="order-1 order-lg-2 col-lg-8 col-img-hero">';
echo '        <div class="concesionaria-hero__figure">';
if ($shop_page_id && has_post_thumbnail($shop_page_id)) {
  echo get_the_post_thumbnail($shop_page_id, 'full', array('class' => 'concesionaria-hero__img'));
} else {
  echo '    <img fetchpriority="high" width="1368" height="525" src="' . get_site_url() . '/wp-content/uploads/2024/10/0.png" class="concesionaria-hero__img" alt="" decoding="async" srcset="' . get_site_url() . '/wp-content/uploads/2024/10/0.png 1368w, ' . get_site_url() . '/wp-content/uploads/2024/10/0-300x115.png 300w, ' . get_site_url() . '/wp-content/uploads/2024/10/0-1024x393.png 1024w, ' . get_site_url() . '/wp-content/uploads/2024/10/0-768x295.png 768w, ' . get_site_url() . '/wp-content/uploads/2024/10/0-530x203.png 530w" sizes="(max-width: 1368px) 100vw, 1368px">';
}
echo '        </div>'; /*.concesionaria-hero__figure*/
echo '      </div>'; /*.col-lg-8*/
echo '    </div>'; /*.row*/
echo '  </div>'; /*.container*/
echo '</div>'; /*.concesionaria-hero*/
?>

<div class="special-products-area py-3 py-md-5" id="main-content-shop">
  <div class="container">
    <!-- TITULO -->
    <div class="row">
      <div class="offset-md-0 col-md-12 offset-lg-3 col-lg-9 mt-0 mt-md-4 mt-lg-0">
        <div class="title-motors text-center mb-3">
          <!--
          <h2><span class="first">NUEVOS</span> MODELOS <?= date("Y") ?></h2>
          -->
          <h2><span class="first">ELIGE TU</span> MOTO IDEAL</h2>
        </div>
      </div>
    </div>
    <!-- CONTENIDO -->
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
                  <div class="col-lg-9 col-md-12 mt-md-4 mt-lg-0">
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
                      if ($eura_shop_cat_sidebar == 'right')
                        do_action('woocommerce_sidebar');
                    } else {
                      if ($product_sidebar == 'right-sidebar')
                        do_action('woocommerce_sidebar');
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
              ?>
              <!-- BEFORE FOOTER  -->
              <?php
              $banner_footer_id = get_post_meta($shop_page_id, 'banner_footer', true);
              $banner_footer_url = wp_get_attachment_url($banner_footer_id);
              if ($banner_footer_url):
                ?>
                <div class="banner-footer" id="banner-footer">
                  <div class="banner-footer__figure">
                    <img src="<?= esc_url($banner_footer_url) ?>" alt="Banner Footer" class="banner-footer__img">
                  </div>
                  <div class="banner-footer__content">
                    <div class="container">
                      <div class="row">
                        <div class="col-12">
                          <a target="_blank"
                            href="https://api.whatsapp.com/send/?phone=51984707798&text&type=phone_number&app_absent=0"
                            class="banner-footer__btn">COTIZA <span>AQUI</span></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              <?php
              /**
               * Hook: woocommerce_sidebar.
               *
               * @hooked woocommerce_get_sidebar - 10
               */
              get_footer('shop'); ?>