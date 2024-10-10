<?php

/*

*/

if (! defined('ABSPATH')) {
	exit;
}

$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (! empty($product_tabs)) : ?>
	<div class="row pb-5">
		<div class="col-lg-10 mx-auto">
			<div class="woocommerce-tabs wc-tabs-wrapper products-details-tabs _sorsa_tabs">
				<ul class="nav nav-tabs tabs wc-tabs" role="tablist" id="tabs">
					<?php foreach ($product_tabs as $key => $tab) : ?>
						<li class="<?php echo esc_attr($key); ?>_tab" id="tab-title-<?php echo esc_attr($key); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
							<a href="#tab-<?php echo esc_attr($key); ?>">
								<?php
								$text = apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key);
								if ($text == "Descripción") {
									echo "DESCRIPCIÓN / <span class='txt-rojo-02'>FICHA TÉCNICA</span>";
								} else {
									echo $text;
								}
								?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php foreach ($product_tabs as $key => $tab) : ?>
					<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab content" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
						<?php if (isset($tab['callback'])) {
							call_user_func($tab['callback'], $key, $tab);
						} ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

<?php endif; ?>