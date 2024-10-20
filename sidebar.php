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

<div class="col-lg-3 col-md-12">
	<?php if (class_exists('WooCommerce')) {
		// sidebar ecommerce
		if (is_woocommerce()) { ?>
			<div class="new-filters">
				<div class="breadcrumb">
					<a style="color: #000000ff;" href="https://concesionariahonda.sorsa.pe/">
						<i class="fa fa-home" style="font-style: normal;" aria-hidden="true"></i>
					</a>
					<span class="ubuntu-light" style="color: #000000ff; font-size: 16px; font-weight: 400;">
						/ MOTOS Y MOTOKARS</span>
				</div>
				<div class="clean-filters">
					<a class="clean-filters__link" href="https://concesionariahonda.sorsa.pe/shop/#main-content-shop" onclick="location.reload();">Limpiar todo</a>
				</div>
			</div>
			<!-- sorsa -->
			<div id="secondary" class="shop-sidebar sidebar">
			<?php
		} elseif (is_product()) { ?>
				<!-- sidebar blog -->
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