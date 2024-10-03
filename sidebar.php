<?php
if (class_exists('WooCommerce')) {
	if (is_woocommerce()) {
		$eura_sidebar_class = 'shop';
	} elseif (is_product()) {
		$eura_sidebar_class = 'shop';
	} else {
		$eura_sidebar_class = 'sidebar-1';
	}
} else {
	$eura_sidebar_class = 'sidebar-1';
}

if (! is_active_sidebar($eura_sidebar_class)) {
	return;
}
?>

<!-- <div class="col-lg-4 col-md-12"> -->
<div class="col-lg-3 col-md-12">
	<?php if (class_exists('WooCommerce')) {
		if (is_woocommerce()) { ?>
			<div id="secondary" class="shop-sidebar sidebar">
			<?php
		} elseif (is_product()) { ?>
				<div id="secondary" class="sidebar shop-sidebar sidebar">
				<?php
			} else { ?>
					<div id="secondary" class="title sidebar sidebar-widgets widget-area">
					<?php
				}
			} else { ?>
					<div id="secondary" class="title sidebar sidebar-widgets widget-area">
					<?php } ?>
					<?php dynamic_sidebar($eura_sidebar_class); ?>
					</div>
					</div><!-- #secondary -->