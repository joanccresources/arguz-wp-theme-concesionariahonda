<?php
/*
URL: concesionariahonda.sorsa.pe/shop/
UI: Card de cada Producto
*/
defined('ABSPATH') || exit;

global $product;
global $eura_opt;

$price        = $product->get_price_html();
$brand_name   = $product->get_attribute('brand_name');
$review_count = $product->get_rating_count();

// Ensure visibility.
if (empty($product) || ! $product->is_visible()) {
  return;
} ?>

<div class="col-lg-4 col-sm-6 col-md-6">
  <!-- mb-30 -->
  <div class="product-card style-five mb-3">
    <div class="product-img overflow-hidden position-relative">
      <a href="<?php the_permalink(); ?>" class="d-block">
        <?php the_post_thumbnail('eura_product_card'); ?>
      </a>
      <?php if ($product->is_on_sale()): ?>
        <span class="sale ps-3"><?php esc_html_e('SALE', 'eura'); ?></span>
      <?php endif; ?>
      <div class="card-btns">
        <?php
        if ($product->is_type('variable')) {
          woocommerce_variable_add_to_cart();
        } else {
          woocommerce_template_loop_add_to_cart();
        }
        ?>
      </div>
    </div>
    <div class="product-info mt-2 px-3 pb-4">
      <div class="product-ratings d-flex justify-content-between">
        <div class="ratings">
          <div class="d-flex align-items-center">
            <ul class="rating list-unstyle">
              <li><i class="ri-star-s-fill"></i></li>
              <li><i class="ri-star-s-fill"></i></li>
              <li><i class="ri-star-s-fill"></i></li>
              <li><i class="ri-star-s-fill"></i></li>
              <li><i class="ri-star-s-fill"></i></li>
            </ul>
            <span class="fs-14"><?php echo esc_html($review_count); ?><?php esc_html_e(' Reviews', 'eura'); ?></span>
          </div>
          <!-- sorsa -->
          <!-- <p class="fs-14"> -->
          <?php /*esc_html_e('Brand:', 'eura'); */ ?>
          <!-- <strong class="text-title"> -->
          <?php
          /*
              if (isset($brand_name) && !empty($brand_name)) {
                echo esc_html($brand_name);
              } else {
                echo esc_html_e('Unavailable', 'eura');
              }
              */
          ?>
          <!-- </strong> -->
          <!-- </p> -->
          <!-- Categoria -->
          <p class="fs-14">
            <?php /*esc_html_e('Category:', 'eura'); */ ?>
            <strong class="text-title ms-0">
              <?php
              $categories = wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in ms-0">', '</span>');
              if (!empty($categories)) {
                echo $categories;
              } else {
                echo esc_html_e('No category', 'eura');
              }
              ?>
            </strong>
          </p>

        </div>
      </div>
      <div class="product-title d-flex flex-wrap justify-content-between align-items-center">
        <h3 class="mb-0 fw-semibold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <!-- Precio oculto -->
        <!-- <h6 class="mb-0 fw-bold"> -->
        <?php /*woocommerce_template_loop_price();*/ ?>
        <!-- </h6> -->
         
        <h6 class="mb-0 fw-bold card-shop-main__price"><?php woocommerce_template_loop_price(); ?></h6>
        <!-- Precio oculto -->
      </div>
    </div>
  </div>
</div>