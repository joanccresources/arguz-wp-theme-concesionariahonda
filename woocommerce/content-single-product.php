<?php
defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
  echo get_the_password_form(); // WPCS: XSS ok.
  return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
  <?php
  /**
   * Hook: woocommerce_before_single_product_summary.
   *
   * @hooked woocommerce_show_product_sale_flash - 10
   * @hooked woocommerce_show_product_images - 20
   */
  //do_action( 'woocommerce_before_single_product_summary' );


  $attachment_ids  = $product->get_gallery_image_ids();

  $reviews_enabled = get_option('woocommerce_enable_reviews');
  $brand_name      = $product->get_attribute('brand_name');
  ?>

  <?php if (function_exists('acf_add_options_page') && get_field('single_pro_style') == 'slider_style') { ?>
    <?php if ($attachment_ids && $product->get_image_id()) { ?>
      <div class="products-details-image-slides owl-carousel owl-theme">
        <?php foreach ($attachment_ids as $attachment_id) { ?>
          <div class="image">
            <img src="<?php echo esc_url(wp_get_attachment_image_src($attachment_id, 'eura_product_card')[0]) ?>" alt="<?php the_title_attribute(); ?>">
          </div>
        <?php } ?>
      </div>
    <?php } ?>

    <div class="products-details-desc p-0">
      <h3><?php the_title(); ?></h3>
      <?php woocommerce_template_loop_price(); ?>

      <?php
      if ($reviews_enabled == 'yes') {
        $rating_count = $product->get_rating_count();
        if ($product->get_rating_count() == 0) { ?>
          <div class="products-review">
            <div class="rating">
              <i class="ri-star-fill"></i>
              <i class="ri-star-fill"></i>
              <i class="ri-star-fill"></i>
              <i class="ri-star-fill"></i>
              <i class="ri-star-fill"></i>
            </div>
          </div>
      <?php } else {
          woocommerce_template_single_rating();
        }
      } ?>

      <?php woocommerce_template_single_excerpt(); ?>

      <div class="product_meta">
        <?php woocommerce_template_single_meta(); ?>
      </div>

      <?php woocommerce_template_single_add_to_cart(); ?>

      <?php if (class_exists('YITH_WCWL')) { ?>
        <?php echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]')); ?>
      <?php } ?>

      <?php global $eura_opt;
      $is_social_share   = !empty($eura_opt['enable_product_share']) ? $eura_opt['enable_product_share'] : '';
      if ($is_social_share == '1'):
        $share_url      = get_the_permalink();
        $share_title    = get_the_title();
        $share_desc     = get_the_excerpt();
      ?>

        <div class="products-share">
          <ul class="social">
            <?php if ($eura_opt['enable_social_share_title'] != ''): ?>
              <li><span><?php echo esc_html($eura_opt['enable_social_share_title']); ?></span></li>
            <?php endif; ?>
            <?php if ($eura_opt['enable_product_fb'] == '1'): ?>
              <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($share_url); ?>" onclick="window.open(this.href, 'facebook-share','width=580,height=296'); return false;" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a></li>
            <?php endif; ?>

            <?php if ($eura_opt['enable_product_tw'] == '1'): ?>
              <li><a href="https://twitter.com/share?text=<?php echo urlencode($share_title); ?>&url=<?php echo esc_url($share_url); ?>" class="twitter" target="_blank"><i class="bx bxl-twitter"></i></a></li>
            <?php endif; ?>

            <?php if ($eura_opt['enable_product_ld'] == '1'): ?>
              <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($share_url); ?>&amp;title=<?php echo urlencode($share_title); ?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>" onclick="window.open(this.href, 'linkedin','width=580,height=296'); return false;" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
            <?php endif; ?>

            <?php if ($eura_opt['enable_product_wp'] == '1'): ?>
              <?php if (wp_is_mobile() != true) : ?>
                <li><a href="https://api.whatsapp.com/send?phone=whatsappphonenumber&text=<?php echo esc_url($share_url); ?>" data-action="share/whatsapp/share" class="whatsapp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
              <?php else : ?>
                <li><a href="whatsapp://send?text=<?php echo esc_url($share_url); ?>" class="whatsapp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($eura_opt['enable_product_email'] == '1'): ?>
              <li><a href="mailto:?subject=<?php echo urlencode($share_title); ?> | <?php echo urlencode($share_desc); ?>&body=<?php echo esc_url($share_url); ?>" class="email" target="_blank"><i class='bx bx-mail-send'></i></a></li>
            <?php endif; ?>

            <?php if ($eura_opt['enable_product_cp'] == '1'): ?>
              <li><a class="copy" href="#" onclick="prompt('Press Ctrl + C, then Enter to copy to clipboard','<?php echo esc_url($share_url); ?>')"><i class='bx bx-copy'></i></a></li>
            <?php endif; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  <?php } elseif (function_exists('acf_add_options_page') && get_field('single_pro_style') == 'thumb_style') { ?>
    <div class="row align-items-center">
      <?php if ($attachment_ids && $product->get_image_id()) { ?>
        <div class="col-lg-5 col-md-12">
          <div class="products-details-thumbs-image">
            <ul class="products-details-thumbs-image-slides">
              <?php foreach ($attachment_ids as $attachment_id) { ?>
                <li>
                  <img src="<?php echo esc_url(wp_get_attachment_image_src($attachment_id, 'eura_product_card')[0]) ?>" alt="<?php the_title_attribute(); ?>">
                </li>
              <?php } ?>
            </ul>
            <div class="slick-thumbs">
              <ul>
                <?php foreach ($attachment_ids as $attachment_id) { ?>
                  <li>
                    <img src="<?php echo esc_url(wp_get_attachment_image_src($attachment_id, 'full')[0]) ?>" alt="<?php the_title_attribute(); ?>">
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      <?php } ?>

      <div class="col-lg-7 col-md-12">
        <div class="products-details-desc">
          <h3><?php the_title(); ?></h3>
          <?php woocommerce_template_loop_price(); ?>

          <?php
          if ($reviews_enabled == 'yes') {
            $rating_count = $product->get_rating_count();
            if ($product->get_rating_count() == 0) { ?>
              <div class="products-review">
                <div class="rating">
                  <i class="ri-star-fill"></i>
                  <i class="ri-star-fill"></i>
                  <i class="ri-star-fill"></i>
                  <i class="ri-star-fill"></i>
                  <i class="ri-star-fill"></i>
                </div>
              </div>
          <?php } else {
              woocommerce_template_single_rating();
            }
          } ?>

          <?php woocommerce_template_single_excerpt(); ?>

          <div class="product_meta">
            <?php woocommerce_template_single_meta(); ?>
          </div>

          <?php woocommerce_template_single_add_to_cart(); ?>

          <?php if (class_exists('YITH_WCWL')) { ?>
            <?php echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]')); ?>
          <?php } ?>

          <?php global $eura_opt;
          $is_social_share   = !empty($eura_opt['enable_product_share']) ? $eura_opt['enable_product_share'] : '';
          if ($is_social_share == '1'):
            $share_url      = get_the_permalink();
            $share_title    = get_the_title();
            $share_desc     = get_the_excerpt();
          ?>

            <div class="products-share">
              <ul class="social">
                <?php if ($eura_opt['enable_social_share_title'] != ''): ?>
                  <li><span><?php echo esc_html($eura_opt['enable_social_share_title']); ?></span></li>
                <?php endif; ?>
                <?php if ($eura_opt['enable_product_fb'] == '1'): ?>
                  <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($share_url); ?>" onclick="window.open(this.href, 'facebook-share','width=580,height=296'); return false;" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_tw'] == '1'): ?>
                  <li><a href="https://twitter.com/share?text=<?php echo urlencode($share_title); ?>&url=<?php echo esc_url($share_url); ?>" class="twitter" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_ld'] == '1'): ?>
                  <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($share_url); ?>&amp;title=<?php echo urlencode($share_title); ?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>" onclick="window.open(this.href, 'linkedin','width=580,height=296'); return false;" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_wp'] == '1'): ?>
                  <?php if (wp_is_mobile() != true) : ?>
                    <li><a href="https://api.whatsapp.com/send?phone=whatsappphonenumber&text=<?php echo esc_url($share_url); ?>" data-action="share/whatsapp/share" class="whatsapp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
                  <?php else : ?>
                    <li><a href="whatsapp://send?text=<?php echo esc_url($share_url); ?>" class="whatsapp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_email'] == '1'): ?>
                  <li><a href="mailto:?subject=<?php echo urlencode($share_title); ?> | <?php echo urlencode($share_desc); ?>&body=<?php echo esc_url($share_url); ?>" class="email" target="_blank"><i class='bx bx-mail-send'></i></a></li>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_cp'] == '1'): ?>
                  <li><a class="copy" href="#" onclick="prompt('Press Ctrl + C, then Enter to copy to clipboard','<?php echo esc_url($share_url); ?>')"><i class='bx bx-copy'></i></a></li>
                <?php endif; ?>
              </ul>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  <?php } else { ?>
    <div class="row align-items-center">
      <div class="col-lg-7 col-md-12">
        <div class="products-details-image">
          <?php
          if ($product->is_type('variable')) {
            do_action('woocommerce_before_single_product_summary');
          } else {
          ?>
            <div class="image">
              <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'eura_product_thumb'); ?>" alt="Image">
            </div>
          <?php
          }
          ?>
        </div>
      </div>

      <div class="col-lg-5 col-md-12">
        <div class="products-details-desc single-product-desc">
          <div class="d-flex align-items-center">
            <p class="mb-0"><?php echo esc_html('Brand:', 'eura'); ?> <strong class="text-title">
                <?php
                if (isset($brand_name) && !empty($brand_name)) {
                  echo esc_html($brand_name);
                } else {
                  echo esc_html('Unavailable', 'eura');
                }
                ?></strong>
            </p>
            <?php
            if ($reviews_enabled == 'yes') {
              $rating_count = $product->get_rating_count();
              if ($product->get_rating_count() == 0) { ?>
                <div class="products-review ratings">
                  <div class="rating">
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                  </div>
                </div>
            <?php } else {
                woocommerce_template_single_rating();
              }
            } ?>
          </div>
          <h3><?php echo get_the_title(); ?></h3>
          <?php woocommerce_template_loop_price(); ?>

          <?php woocommerce_template_single_excerpt(); ?>

          <div class="product_meta">
            <?php woocommerce_template_single_meta(); ?>
          </div>
          <?php if (class_exists('YITH_WCWL')) { ?>
            <?php echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]')); ?>
          <?php } ?>
          <?php woocommerce_template_single_add_to_cart(); ?>

          <?php global $eura_opt;
          $is_social_share   = !empty($eura_opt['enable_product_share']) ? $eura_opt['enable_product_share'] : '';
          if ($is_social_share == '1'):
            $share_url      = get_the_permalink();
            $share_title    = get_the_title();
            $share_desc     = get_the_excerpt();
          ?>

            <div class="products-share">
              <ul class="social">
                <?php if ($eura_opt['enable_social_share_title'] != ''): ?>
                  <li><span><?php echo esc_html($eura_opt['enable_social_share_title']); ?></span></li>
                <?php endif; ?>
                <?php if ($eura_opt['enable_product_fb'] == '1'): ?>
                  <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($share_url); ?>" onclick="window.open(this.href, 'facebook-share','width=580,height=296'); return false;" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_tw'] == '1'): ?>
                  <li><a href="https://twitter.com/share?text=<?php echo urlencode($share_title); ?>&url=<?php echo esc_url($share_url); ?>" class="twitter" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_ld'] == '1'): ?>
                  <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($share_url); ?>&amp;title=<?php echo urlencode($share_title); ?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>" onclick="window.open(this.href, 'linkedin','width=580,height=296'); return false;" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_wp'] == '1'): ?>
                  <?php if (wp_is_mobile() != true) : ?>
                    <li><a href="https://api.whatsapp.com/send?phone=whatsappphonenumber&text=<?php echo esc_url($share_url); ?>" data-action="share/whatsapp/share" class="whatsapp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
                  <?php else : ?>
                    <li><a href="whatsapp://send?text=<?php echo esc_url($share_url); ?>" class="whatsapp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_email'] == '1'): ?>
                  <li><a href="mailto:?subject=<?php echo urlencode($share_title); ?> | <?php echo urlencode($share_desc); ?>&body=<?php echo esc_url($share_url); ?>" class="email" target="_blank"><i class='bx bx-mail-send'></i></a></li>
                <?php endif; ?>

                <?php if ($eura_opt['enable_product_cp'] == '1'): ?>
                  <li><a class="copy" href="#" onclick="prompt('Press Ctrl + C, then Enter to copy to clipboard','<?php echo esc_url($share_url); ?>')"><i class='bx bx-copy'></i></a></li>
                <?php endif; ?>
              </ul>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>

  <?php } ?>

  <?php
  /**
   * Hook: woocommerce_after_single_product_summary.
   *
   * @hooked woocommerce_output_product_data_tabs - 10
   * @hooked woocommerce_upsell_display - 15
   * @hooked woocommerce_output_related_products - 20
   */
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
  do_action('woocommerce_after_single_product_summary');

  ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>