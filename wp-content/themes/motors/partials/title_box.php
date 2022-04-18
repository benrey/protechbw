<?php
$post_id = get_the_ID();
if ( is_post_type_archive( stm_listings_post_type() ) ) {
	$post_id = stm_listings_user_defined_filter_page();
}

$show_title_box = 'hide';

$title_style = '';

$is_shop = false;
$is_product = false;
$is_product_category = false;

if ( function_exists( 'is_shop' ) && is_shop() ) {
	$is_shop = true;
}

if ( function_exists( 'is_product_category' ) && is_product_category() || function_exists( 'is_product_tag' ) && is_product_tag() ) {
	$is_product_category = true;
}

if ( function_exists( 'is_product' ) && is_product() ) {
	$is_product = true;
}

if ( is_home() || is_category() || is_search() ) {
	$post_id = get_option( 'page_for_posts' );
}

if ( $is_shop ) {
	$post_id = get_option( 'woocommerce_shop_page_id' );
}

$title = '';

if ( is_home() ) {
	if ( !get_option( 'page_for_posts' ) ) {
		$title = __( 'News', 'motors' );
	} else {
		$title = get_the_title( $post_id );
	}
} elseif ( $is_product ) {
	$title = esc_html__( 'Shop', 'motors' );
} elseif ( $is_product_category ) {
	$title = single_cat_title( '', false );
	$post_id = get_option( 'woocommerce_shop_page_id' );
} elseif ( is_post_type_archive( stm_listings_post_type() ) ) {
	$title = stm_me_get_wpcfto_mod( 'classic_listing_title', esc_html__( 'Inventory', 'motors' ) );
	$image = stm_me_get_wpcfto_img_src( 'classic_listing_title_bg', '' );
	if ( !empty( $image ) ) {
		$title_style .= "background-image:url('" . $image . "');";
	}
} elseif ( is_category() ) {
	$title = single_cat_title( '', false );
} elseif ( is_tax() ) {
	$title = single_term_title('', false);
} elseif ( is_tag() ) {
	$title = single_tag_title( '', false );
} elseif ( is_search() ) {
	$title = __( 'Search', 'motors' );
} elseif ( is_day() ) {
	$title = get_the_time( 'd' );
} elseif ( is_month() ) {
	$title = get_the_time( 'F' );
} elseif ( is_year() ) {
	$title = get_the_time( 'Y' );
} else {
	$title = get_the_title( $post_id );
}

$alignment = get_post_meta( $post_id, 'alignment', true );
$title_style_h1 = array();
$title_style_subtitle = array();
$title_box_bg_color = get_post_meta( $post_id, 'title_box_bg_color', true );
$title_box_font_color = get_post_meta( $post_id, 'title_box_font_color', true );
$title_box_line_color = get_post_meta( $post_id, 'title_box_line_color', true );
$title_box_custom_bg_image = get_post_meta( $post_id, 'title_box_custom_bg_image', true );
$title_tag = ( empty( get_post_meta( $post_id, 'stm_title_tag', true ) ) ) ? 'h2' : get_post_meta( $post_id, 'stm_title_tag', true );
$sub_title = get_post_meta( $post_id, 'sub_title', true );
$breadcrumbs = get_post_meta( $post_id, 'breadcrumbs', true );
$breadcrumbs_font_color = get_post_meta( $post_id, 'breadcrumbs_font_color', true );
$title_box_subtitle_font_color = get_post_meta( $post_id, 'title_box_subtitle_font_color', true );
$sub_title_instead = get_post_meta( $post_id, 'sub_title_instead', true );


if ( empty( $alignment ) || is_post_type_archive( stm_listings_post_type() ) ) {
	$alignment = 'left';
}

if ( $title_box_bg_color ) {
	$title_style .= 'background-color: ' . $title_box_bg_color . ';';
}

if ( $title_box_font_color ) {
	$title_style_h1['font_color'] = 'color: ' . $title_box_font_color . ';';
}

if ( $title_box_subtitle_font_color ) {
	$title_style_subtitle['font_color'] = 'color: ' . $title_box_subtitle_font_color . ';';
}

if ( $title_box_custom_bg_image = wp_get_attachment_image_src( $title_box_custom_bg_image, 'full' ) ) {
	$title_style .= "background-image: url('" . $title_box_custom_bg_image[0] . "');";
}

if ( stm_is_dealer_two() && empty( $title_box_custom_bg_image ) ) {
	$title_style .= "background-image: url('" . stm_me_get_wpcfto_img_src( 'classic_listing_title_bg', '' ) . "');";
}

$show_title_box = get_post_meta( $post_id, 'title', true );

if ( $show_title_box == 'hide' ) {
	$show_title_box = false;
} else {
	$show_title_box = true;
}

$additional_classes = '';

if ( empty( $sub_title ) and empty( $title_box_line_color ) ) {
	$additional_classes = ' small_title_box';
}
if ( ( $is_shop || $is_product || $is_product_category ) && $breadcrumbs == 'show' ) {
	$additional_classes .= ' no_woo_padding';
}

/*Only for blog*/
$blog_margin = '';
if ( get_post_type() == 'post' ) {
	if ( !empty( $_GET['show-title-box'] ) and $_GET['show-title-box'] = 'hide' ) {
		$show_title_box = false;
	}
	if ( !empty( $_GET['show-breadcrumbs'] ) and $_GET['show-breadcrumbs'] == 'yes' ) {
		$breadcrumbs = 'show';
		$blog_margin = 'stm-no-margin-bc';
	}
}

if ( stm_is_listing() ) {
	$userAddACarPage = stm_me_get_wpcfto_mod( 'user_add_car_page', 1755 );
	$pricingPage = stm_me_get_wpcfto_mod( 'pricing_link', 1678 );
	
	$restricted = false;
	if ( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$user_id = $user->ID;
		$restrictions = stm_get_post_limits( $user_id );
	} else {
		$restrictions = stm_get_post_limits( '' );
	}
	
	if ( $restrictions['posts'] < 1 ) {
		$restricted = true;
	}
	
	$currentPageId = get_the_ID();
	$isAddACar = ( $currentPageId == $userAddACarPage ) ? true : false;
	
	$enablePricingPlans = stm_me_get_wpcfto_mod( 'enable_plans', false );
}
if ( $show_title_box ) {
	$disable_overlay = '';
	if ( stm_is_motorcycle() ):
		$disable_overlay = get_post_meta( $post_id, 'disable_title_box_overlay', true );
		if ( !empty( $disable_overlay ) and $disable_overlay == 'on' ) {
			$disable_overlay = ' disable_overlay';
		}
	endif; ?>
    <div class="entry-header <?php echo esc_attr( $alignment . $additional_classes . $disable_overlay ); ?>"
         style="<?php echo stm_do_lmth( $title_style ); ?>">
        <div class="container">
            <div class="entry-title">
                <<?php echo esc_attr( $title_tag ); ?> class="h1" style="<?php echo implode( ' ', $title_style_h1 ); ?>">
				<?php
				if ( !empty( $sub_title_instead ) and stm_is_motorcycle() ) {
					echo apply_filters( 'stm_balance_tags', $sub_title_instead );
				} else {
					echo apply_filters( 'stm_balance_tags', $title );
				}
				?>
            </<?php echo esc_attr( $title_tag ); ?>>
			<?php if ( $title_box_line_color ): ?>
                <div class="colored-separator">
                    <div class="first-long" <?php if ( !empty( $title_box_line_color ) ): ?> style="background-color: <?php echo esc_attr( $title_box_line_color ); ?>" <?php endif; ?>></div>
                    <div class="last-short" <?php if ( !empty( $title_box_line_color ) ): ?> style="background-color: <?php echo esc_attr( $title_box_line_color ); ?>" <?php endif; ?>></div>
                </div>
			<?php endif; ?>
			<?php if ( $sub_title && !is_search() ) { ?>
                <div class="sub-title h5"
                     style="<?php echo implode( ' ', $title_style_subtitle ); ?>"><?php echo apply_filters( 'stm_balance_tags', $sub_title ); ?></div>
			<?php } ?>
        </div>
    </div>
    </div>
<?php } else { ?>
	<?php if ( $breadcrumbs != 'hide' ): ?>
        <div class="title-box-disabled"></div>
	<?php endif; ?>
<?php } ?>

    <!-- Breads -->
<?php
if ( $breadcrumbs != 'hide' ):
	
	if ( $is_shop || $is_product || $is_product_category ) {
		woocommerce_breadcrumb();
	} else {
		if ( function_exists( 'bcn_display' ) ) { ?>
            <div class="stm_breadcrumbs_unit heading-font <?php echo esc_attr( $blog_margin ); ?>">
                <div class="container">
                    <div class="navxtBreads">
						<?php bcn_display(); ?>
                    </div>
					<?php if ( stm_is_listing() && $isAddACar && $restricted && $enablePricingPlans ): ?>
                        <div class="stm-notice">
                            <div class="notice-text">
                                <i class="fa fa-info-circle"></i>
                                <span class="heading-font"><?php echo esc_html__( 'Ad limit has been reached. Buy a new plan', 'motors' ); ?></span>
                            </div>
                            <div class="btn-plans">
                                <a href="<?php echo get_the_permalink( $pricingPage ); ?>"
                                   class="button"><?php echo esc_html__( 'Plans', 'motors' ); ?></a>
                            </div>
                        </div>
					<?php endif; ?>
                </div>
            </div>
		<?php }
	}
endif;