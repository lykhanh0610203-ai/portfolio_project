<?php
/**
 * Product.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.19.0
 */

?>
<?php echo do_shortcode('[block id="banner-chi-tiet-san-pham"]'); ?>
<div class="product-container">

	<div class="product-main">
		<div class="row content-row mb-0">

			<div class="product-gallery col large-8 <?php echo flatsome_option('product_image_width'); ?>">
				<?php flatsome_sticky_column_open('product_sticky_gallery'); ?>
				<?php
				/**
				 * woocommerce_before_single_product_summary hook
				 *
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action('woocommerce_before_single_product_summary');
				?>
				<?php flatsome_sticky_column_close('product_sticky_gallery'); ?>
			</div>
			<div
				class="product-info summary col-fit col large-4 entry-summary <?php flatsome_product_summary_classes(); ?>">
				<?php
				// Xoá toàn bộ các hook mặc định (phòng ngừa)
				remove_all_actions('woocommerce_single_product_summary');
				remove_action('woocommerce_before_single_product_summary', 'woocommerce_output_all_notices', 10);

				// Hiển thị block tuỳ chỉnh
				echo do_shortcode('[block id="2-button-details-prod"]');
				echo '<hr class="custom-divider">';

				echo do_shortcode('[mobile_mockup]');

				?>
			</div>


		</div>
	</div>

	<div class="product-footer">
		<div class="container">
			<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action('woocommerce_after_single_product_summary');
			?>
		</div>
	</div>
</div>