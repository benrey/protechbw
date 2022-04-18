<?php
$logo_main = stm_me_get_wpcfto_img_src( 'logo', get_template_directory_uri() . '/assets/images/tmp/logo.png' );

$compare_page = stm_me_get_wpcfto_mod( 'compare_page', 156 );
if ( function_exists( 'WC' ) ) {
    $woocommerce_shop_page_id = wc_get_cart_url();
}

$user = wp_get_current_user();

if(!is_wp_error($user) && !empty($user->data->ID)) {
    $link = (stm_is_listing_five()) ? stm_c_f_get_page_url('account_page') : stm_get_author_link($user->data->ID);
} else {
	$link = (stm_is_listing_five()) ? stm_c_f_get_page_url('account_page') : stm_get_author_link('register');
}

$link = (stm_is_listing_six()) ? stm_c_six_get_page_url('account_page') : $link;

?>

<div class="header-main <?php echo (wp_is_mobile()) ? 'header-main-mobile' : ''; ?>">
    <div class="container">
        <div class="clearfix">
            <!--Logo-->
            <div class="logo-main" style="<?php echo stm_me_wpcfto_parse_spacing(stm_me_get_wpcfto_mod( 'logo_margin_top', '')); ?>">
                <?php if ( empty( $logo_main ) ): ?>
                    <a class="blogname" href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       title="<?php _e( 'Home', 'motors' ); ?>">
                        <h1><?php echo esc_attr( get_bloginfo( 'name' ) ) ?></h1>
                    </a>
                <?php else: ?>
                    <a class="bloglogo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo esc_url( $logo_main ); ?>"
                                style="width: <?php echo stm_me_get_wpcfto_mod( 'logo_width', '138' ); ?>px;"
                                title="<?php esc_attr_e( 'Home', 'motors' ); ?>"
                                alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"
                        />
                    </a>
                <?php endif; ?>

                <?php if(is_listing() && stm_get_header_layout() == 'car_dealer'): ?>
                    <div class="mobile-pull-right">
                        <?php
                        $header_listing_btn_link = stm_me_get_wpcfto_mod( 'header_listing_btn_link', '/add-car' );
                        $header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', 'Add your item' );
                        ?>
                        <?php if ( !empty( $header_listing_btn_link ) and !empty( $header_listing_btn_text ) ): ?>
                            <a href="<?php echo esc_url( $header_listing_btn_link ); ?>"
                               class="listing_add_cart heading-font">
                                <div>
                                    <i class="stm-lt-icon-add_car"></i>
                                </div>
                            </a>
                        <?php endif; ?>
	
						<?php
						$header_profile = stm_me_get_wpcfto_mod('header_show_profile', false);
						if($header_profile) :
							?>
                            <div class="lOffer-account-unit">
                                <a href="<?php echo esc_url(stm_get_author_link('register')); ?>" class="lOffer-account">
                                    <?php
                                    if(is_user_logged_in()): $user_fields = stm_get_user_custom_fields('');
                                        if(!empty($user_fields['image'])):
                                            ?>
                                            <div class="stm-dropdown-user-small-avatar">
                                                <img src="<?php echo esc_url($user_fields['image']); ?>" class="im-responsive"/>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php echo stm_me_get_wpcfto_icon('header_profile_icon', 'stm-service-icon-user'); ?>
                                </a>
                                <?php get_template_part('partials/user/user', 'dropdown'); ?>
                                <?php get_template_part('partials/user/private/mobile/user'); ?>
                            </div>
						<?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="mobile-menu-trigger visible-sm visible-xs">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div class="mobile-menu-holder">
                <ul class="header-menu clearfix">
                    <?php
                    $location = ( has_nav_menu( 'primary' ) ) ? 'primary' : '';

                    wp_nav_menu( array(
                            'theme_location' => $location,
                            'depth' => 5,
                            'container' => false,
                            'items_wrap' => '%3$s',
                            'fallback_cb' => false
                        )
                    );
                    ?>
                    <?php
                    if ( is_listing() && stm_get_header_layout() == 'car_dealer' ) {
                        $header_listing_btn_link = stm_me_get_wpcfto_mod( 'header_listing_btn_link', 'add-car' );
                        $header_listing_btn_text = stm_me_get_wpcfto_mod( 'header_listing_btn_text', 'Add your item' );

                        if ( !empty( $header_listing_btn_link ) and !empty( $header_listing_btn_text ) ) {
                            ?>
                            <li class="stm_add_car_mobile">
                                <a href="<?php echo esc_url( $header_listing_btn_link ); ?>"
                                   class="listing_add_cart heading-font">
                                    <?php stm_dynamic_string_translation_e( 'Add A Car Button label in header', $header_listing_btn_text ); ?>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                    <li class="stm_compare_mobile">
                        <a href="<?php echo esc_url( $link ); ?>">
                            <?php echo esc_html__('Account', 'motors'); ?>
                        </a>
                    </li>
                    <?php if ( !empty( $compare_page ) && stm_me_get_wpcfto_mod( 'header_compare_show', false ) ): ?>
                        <li class="stm_compare_mobile"><a
                                    href="<?php echo esc_url( get_the_permalink( $compare_page ) ); ?>"><?php _e( 'Compare', 'motors' ); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ( !empty( $woocommerce_shop_page_id ) && stm_me_get_wpcfto_mod( 'header_cart_show', false ) ): ?>
                        <li class="stm_cart_mobile"><a
                                    href="<?php echo esc_url( $woocommerce_shop_page_id ); ?>"><?php _e( 'Cart', 'motors' ); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="header-top-info">
                <div class="clearfix">

                    <!--Socials-->
                    <?php $socials = stm_get_header_socials( 'header_socials_enable' ); ?>
                    
                    <!-- Header top bar Socials -->
                    <?php if ( !empty( $socials ) ): ?>
                        <div class="pull-right">
                            <div class="header-main-socs">
                                <ul class="clearfix">
                                    <?php foreach ( $socials as $key => $val ): ?>
                                        <li>
                                            <a href="<?php echo esc_url( $val ) ?>" target="_blank">
                                                <i class="fa fa-<?php echo esc_attr( $key ); ?>"></i>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $header_secondary_phone_1 = stm_me_get_wpcfto_mod( 'header_secondary_phone_1', '878-3971-3223' );
                    $header_secondary_phone_2 = stm_me_get_wpcfto_mod( 'header_secondary_phone_2', '878-0910-0770' );
                    $header_secondary_phone_label_1 = stm_me_get_wpcfto_mod( 'header_secondary_phone_label_1', 'Service' );
                    $header_secondary_phone_label_2 = stm_me_get_wpcfto_mod( 'header_secondary_phone_label_2', 'Parts' );

					$showSecondaryPhoneOnMobile = true;

					if(wp_is_mobile() && !stm_me_get_wpcfto_mod('header_secondary_phones_show_on_mobile', false)) {
						$showSecondaryPhoneOnMobile = false;
					}
                    
                    ?>
                    <!--Header secondary phones-->
                    <?php if($showSecondaryPhoneOnMobile) : ?>
                        <?php if ( !empty( $header_secondary_phone_1 ) and !empty( $header_secondary_phone_2 ) ): ?>
                            <div class="pull-right">
                                <div class="header-secondary-phone">
                                    <div class="phone">
                                        <?php if ( !empty( $header_secondary_phone_label_1 ) ): ?>
                                            <span class="phone-label"><?php stm_dynamic_string_translation_e( 'Phone Label One', $header_secondary_phone_label_1 ); ?>
                                                :</span>
                                        <?php endif; ?>
                                        <span class="phone-number heading-font"><a
                                                    href="tel:<?php stm_dynamic_string_translation_e( 'Phone Number One', $header_secondary_phone_1 ); ?>"><?php stm_dynamic_string_translation_e( 'Phone Number One', $header_secondary_phone_1 ); ?></a></span>
                                    </div>
                                    <div class="phone">
                                        <?php if ( !empty( $header_secondary_phone_label_2 ) ): ?>
                                            <span class="phone-label"><?php stm_dynamic_string_translation_e( 'Phone Label Two', $header_secondary_phone_label_2 ); ?>
                                                :</span>
                                        <?php endif; ?>
                                        <span class="phone-number heading-font"><a
                                                    href="tel:<?php stm_dynamic_string_translation_e( 'Phone Number Two', $header_secondary_phone_2 ); ?>"><?php stm_dynamic_string_translation_e( 'Phone Number Two', $header_secondary_phone_2 ); ?></a></span>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ( !empty( $header_secondary_phone_1 ) or !empty( $header_secondary_phone_2 ) ): ?>
                            <div class="pull-right">
                                <div class="header-secondary-phone header-secondary-phone-single">
                                    <?php if ( !empty( $header_secondary_phone_1 ) ): ?>
                                        <div class="phone">
                                            <?php if ( !empty( $header_secondary_phone_label_1 ) ): ?>
                                                <span class="phone-label"><?php stm_dynamic_string_translation_e( 'Phone Label One', $header_secondary_phone_label_1 ); ?>
                                                    :</span>
                                            <?php endif; ?>
                                            <span class="phone-number heading-font"><a
                                                        href="tel:<?php stm_dynamic_string_translation_e( 'Phone Number One', $header_secondary_phone_1 ); ?>"><?php stm_dynamic_string_translation_e( 'Phone Number One', $header_secondary_phone_1 ); ?></a></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( !empty( $header_secondary_phone_2 ) ): ?>
                                        <div class="phone">
                                            <?php if ( !empty( $header_secondary_phone_label_2 ) ): ?>
                                                <span class="phone-label"><?php stm_dynamic_string_translation_e( 'Phone Label Two', $header_secondary_phone_label_2 ); ?>
                                                    :</span>
                                            <?php endif; ?>
                                            <span class="phone-number heading-font"><a
                                                        href="tel:<?php stm_dynamic_string_translation_e( 'Phone Number Two', $header_secondary_phone_2 ); ?>"><?php stm_dynamic_string_translation_e( 'Phone Number One', $header_secondary_phone_2 ); ?></a></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php
                    $header_main_phone = stm_me_get_wpcfto_mod( 'header_main_phone', '878-9671-4455' );
                    $header_main_phone_label = stm_me_get_wpcfto_mod( 'header_main_phone_label', 'Sales' );
                    
                    $showMainPhoneOnMobile = true;
                    
                    if(wp_is_mobile() && !stm_me_get_wpcfto_mod('header_main_phone_show_on_mobile', false)) {
                        $showMainPhoneOnMobile = false;
                    }
                    
                    ?>
                    <!--Header main phone-->
                    <?php if ( !empty( $header_main_phone ) && $showMainPhoneOnMobile ): ?>
                        <div class="pull-right">
                            <div class="header-main-phone heading-font">
                                <?php echo stm_me_get_wpcfto_icon('header_main_phone_icon', 'stm-icon-phone'); ?>
                                <div class="phone">
                                    <?php if ( !empty( $header_main_phone_label ) ): ?>
                                        <span class="phone-label"><?php stm_dynamic_string_translation_e( 'Header Phone Label', $header_main_phone_label ); ?>
                                            :</span>
                                    <?php endif; ?>
                                    <span class="phone-number heading-font"><a
                                                href="tel:<?php echo preg_replace( '/\s/', '', $header_main_phone ); ?>"><?php stm_dynamic_string_translation_e( 'Header Phone', $header_main_phone ); ?></a></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $header_address = stm_me_get_wpcfto_mod( 'header_address', '1840 E Garvey Ave South West Covina, CA 91791' );
                    $header_address_url = stm_me_get_wpcfto_mod( 'header_address_url' );

					$showAddressOnMobile = true;

					if(wp_is_mobile() && !stm_me_get_wpcfto_mod('address_show_on_mobile', false)) {
						$showAddressOnMobile = false;
					}
                    
                    ?>
                    <!--Header address-->
                    <?php if ( !empty( $header_address ) && $showAddressOnMobile ): ?>
                        <div class="pull-right">
                            <div class="header-address">
								<?php echo stm_me_get_wpcfto_icon('header_address_icon', 'stm-icon-pin'); ?>
                                <div class="address">
                                    <?php if ( !empty( $header_address ) ): ?>
                                        <span class="heading-font"><?php stm_dynamic_string_translation_e( 'Header address', $header_address ); ?></span>
                                        <?php if ( !empty( $header_address_url ) ): ?>
                                            <span id="stm-google-map" class="fancy-iframe" data-iframe="true"
                                                  data-src="<?php echo esc_url( $header_address_url ); ?>">
												<?php _e( 'View on map', 'motors' ); ?>
											</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div> <!--clearfix-->
            </div> <!--header-top-info-->
        </div> <!--clearfix-->
    </div> <!--container-->
</div> <!--header-main-->
<?php get_template_part( 'partials/header/header-nav' );?>