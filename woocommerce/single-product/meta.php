<?php
/*

*/

if (! defined('ABSPATH')) {
	exit;
}

global $product;
?>
<?php do_action('woocommerce_product_meta_start');
global $eura_opt;
if (isset($eura_opt['copyright_text'])):
	$enable_product_meta 	= $eura_opt['enable_product_meta'];
else:
	$enable_product_meta 	= true;
endif;
?>
<?php if ($enable_product_meta == true): ?>
	<ul class="products-info">
		<?php if (wc_product_sku_enabled() && ($product->get_sku() && $product->is_type('variable'))) : ?>
			<li><span><?php esc_html_e('SKU:',  'eura'); ?></span> <?php echo esc_html($product->get_sku()); ?></li>
		<?php endif; ?>

		<?php if ($product->get_stock_quantity() > 0) : ?>
			<li><span><?php esc_html_e('Availability:',  'eura'); ?></span> <?php echo wc_get_stock_html($product);  ?></li>
		<?php else: ?>
			<li><span><?php esc_html_e('Availability:',  'eura'); ?></span> <?php esc_html_e('N/A',  'eura'); ?></li>
		<?php endif; ?>

		<?php echo wc_get_product_category_list($product->get_id(), ', ', '<li><span class="posted_in posted_in__sorsa">' . _n('Category:', 'Categories:', count($product->get_category_ids()),  'eura') . ' ', '</span></li>'); ?>

		<?php echo wc_get_product_tag_list($product->get_id(), ', ', '<li><span class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()),  'eura') . ' ', '</span></li>'); ?>

	</ul>
<?php endif; ?>

<?php do_action('woocommerce_product_meta_end'); ?>