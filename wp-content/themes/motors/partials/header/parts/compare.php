    <?php
if ( empty( $_COOKIE['compare_ids'] ) ) {
	$_COOKIE['compare_ids'] = array();
}

$compare_page = (stm_is_listing_five()) ? \uListing\Classes\StmListingSettings::getPages("compare_page") : stm_me_get_wpcfto_mod( 'compare_page', 156 );
$show_compare_page = stm_me_get_wpcfto_mod( 'header_compare_show', false );

if($show_compare_page && !empty($compare_page)): ?>
	<div class="pull-right hdn-767">
		<a
			class="lOffer-compare"
			href="<?php echo esc_url(get_the_permalink($compare_page)); ?>"
			title="<?php esc_attr_e('Watch compared', 'motors'); ?>">
			<?php if(!is_listing()): ?>
				<span class="heading-font"><?php esc_html_e('Compare', 'motors'); ?></span>
			<?php endif; ?>
			<?php echo stm_me_get_wpcfto_icon('header_compare_icon', 'stm-boats-icon-compare-boats', 'list-icon'); ?>
			<span class="list-badge"><span class="stm-current-cars-in-compare"><?php if(!empty($_COOKIE['compare_ids']) and count($_COOKIE['compare_ids'])){ echo esc_attr(count($_COOKIE['compare_ids'])); } ?></span></span>
		</a>
	</div>
<?php endif; ?>
