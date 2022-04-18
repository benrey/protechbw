<?php
$showCompare = stm_me_get_wpcfto_mod('header_compare_show', false);
$compare_page = (stm_is_listing_five() || stm_is_listing_six()) ? \uListing\Classes\StmListingSettings::getPages("compare_page") : stm_me_get_wpcfto_mod( 'compare_page', 156 );
$compareIcon = (stm_is_listing_five() || stm_is_listing_six()) ? 'stm-all-icon-listing-compare' : 'list-icon stm-boats-icon-compare-boats';

if ($compare_page):
    $compareCookie = (!empty($_COOKIE['ulisting_compare'])) ? (array) $_COOKIE['ulisting_compare'] : array();
    $compareCount = (!empty($compareCookie)) ? count((array) json_decode(stripslashes($compareCookie[0]))) : 0;

    if($showCompare) :
?>
<div class="stm-compare">
    <a class="lOffer-compare" href="<?php echo esc_url(get_the_permalink($compare_page)); ?>"
       title="<?php esc_attr_e('Watch compared', 'motors'); ?>">
		<?php echo stm_me_get_wpcfto_icon('header_compare_icon', $compareIcon); ?>
        <span class="list-badge">
            <span class="stm-current-cars-in-compare">
                <?php if ($compareCount != 0) {
                    echo esc_html($compareCount);
                } ?>
            </span>
        </span>
    </a>
</div>
<?php
    endif;
endif;
?>