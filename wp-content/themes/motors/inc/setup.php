<?php
if ( !function_exists( 'stm_is_use_plugin' ) ) {
	function stm_is_use_plugin( $plug )
	{
		
		if ( !function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}
		
		return in_array( $plug, (array)get_option( 'active_plugins', array() ) ) || is_plugin_active_for_network( $plug );
	}
}

if ( !function_exists( 'stm_is_not_use_plugin' ) ) {
	function stm_is_not_use_plugin( $plug )
	{
		return !stm_is_use_plugin( $plug );
	}
}

if ( !function_exists( 'stm_get_header_layout' ) ) {
	function stm_get_header_layout()
	{
		
		$selLayout = get_option( 'stm_motors_chosen_template' );
		
		if ( empty( $selLayout ) ) return 'car_dealer';
		
		$arrHeader = array(
			'service' => 'car_dealer',
			'listing_two' => 'listing',
			'listing_three' => 'listing',
			'listing_four' => 'car_dealer',
		);
		
		$defaultHeader = ( !empty( $arrHeader[$selLayout] ) ) ? $arrHeader[$selLayout] : $selLayout;
		
		/*
		 * aircrafts
		 * boats
		 * car_dealer
		 * car_dealer_two
		 * equipment
		 * listing
		 * listing_five
		 * magazine
		 * motorcycle
		 * car_rental
		 * */
		
		if ( stm_is_listing_six() ) return 'listing_five';
		
		return apply_filters( 'stm_selected_header', get_theme_mod( 'header_layout', $defaultHeader ) );
	}
}

if ( !function_exists( 'stm_is_car_dealer' ) ) {
	function stm_is_car_dealer()
	{
		$listing = get_option( 'stm_motors_chosen_template', 'car_dealer' );
		if ( $listing ) {
			if ( $listing == 'car_dealer' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_nccurrent_blog_id() == 1 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_listing' ) ) {
	function stm_is_listing()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'listing' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 2 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_listing_two' ) ) {
	function stm_is_listing_two()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'listing_two' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 10 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_listing_three' ) ) {
	function stm_is_listing_three()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'listing_three' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 11 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_listing_four' ) ) {
	function stm_is_listing_four()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'listing_four' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 13 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_listing_five' ) ) {
	function stm_is_listing_five()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'listing_five' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 17 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_listing_six' ) ) {
	function stm_is_listing_six()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'listing_six' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 18 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'is_listing' ) ) {
	function is_listing( $only = array() )
	{
		if ( count( $only ) > 0 ) {
			$listing = get_option( 'stm_motors_chosen_template' );
			
			foreach ( $only as $layout ) {
				if ( $layout == $listing ) return true;
			}
		} else {
			if ( stm_is_listing() || stm_is_listing_two() || stm_is_listing_three() || stm_is_listing_four() || stm_is_listing_five() || stm_is_listing_six() ) return true;
		}
		
		return false;
	}
}

if ( !function_exists( 'is_dealer' ) ) {
	function is_dealer( $only = array() )
	{
		if ( count( $only ) > 0 ) {
			$listing = get_option( 'stm_motors_chosen_template' );
			
			foreach ( $only as $layout ) {
				if ( $layout == $listing ) return true;
			}
		} else {
			if ( stm_is_car_dealer() || stm_is_dealer_two() ) return true;
		}
		
		return false;
	}
}

if ( !function_exists( 'stm_is_boats' ) ) {
	function stm_is_boats()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'boats' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 4 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_motorcycle' ) ) {
	function stm_is_motorcycle()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'motorcycle' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 5 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_service' ) ) {
	function stm_is_service()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'service' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 3 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_rental' ) ) {
	function stm_is_rental()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		if ( $listing ) {
			if ( $listing == 'car_rental' || $listing == 'rental_two' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 7 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_rental_two' ) ) {
	function stm_is_rental_two()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		return ( $listing == 'rental_two' ) ? true : false;
	}
}

if ( !function_exists( 'stm_is_magazine' ) ) {
	function stm_is_magazine()
	{
		$listing = get_option( 'stm_motors_chosen_template' );
		
		
		if ( $listing ) {
			if ( $listing == 'car_magazine' ) {
				$listing = true;
			} else {
				$listing = false;
			}
		} else {
			if ( get_current_blog_id() == 8 ) return true;
			else return false;
		}
		
		return $listing;
	}
}

if ( !function_exists( 'stm_is_dealer_two' ) ) {
	function stm_is_dealer_two()
	{
		$dealer = get_option( 'stm_motors_chosen_template' );
		
		
		if ( $dealer ) {
			if ( $dealer == 'car_dealer_two' ) {
				$dealer = true;
			} else {
				$dealer = false;
			}
		} else {
			if ( get_current_blog_id() == 9 ) return true;
			else return false;
		}
		
		return $dealer;
	}
}

if ( !function_exists( 'stm_is_aircrafts' ) ) {
	function stm_is_aircrafts()
	{
		$dealer = get_option( 'stm_motors_chosen_template' );
		
		
		if ( $dealer ) {
			if ( $dealer == 'aircrafts' ) {
				$dealer = true;
			} else {
				$dealer = false;
			}
		} else {
			if ( get_current_blog_id() == 14 ) return true;
			else return false;
		}
		
		return $dealer;
	}
}

if ( !function_exists( 'stm_is_auto_parts' ) ) {
	function stm_is_auto_parts()
	{
		$dealer = get_option( 'stm_motors_chosen_template' );
		
		
		if ( $dealer ) {
			if ( $dealer == 'auto_parts' ) {
				$dealer = true;
			} else {
				$dealer = false;
			}
		} else {
			if ( get_current_blog_id() == 12 ) return true;
			else return false;
		}
		
		return $dealer;
	}
}

if ( !function_exists( 'stm_is_equipment' ) ) {
	function stm_is_equipment()
	{
		$dealer = get_option( 'stm_motors_chosen_template' );
		
		if ( $dealer == 'equipment' ) {
			$dealer = true;
		} else {
			$dealer = false;
		}
		
		return $dealer;
	}
}

if ( !function_exists( 'stm_get_current_layout' ) ) {
	function stm_get_current_layout()
	{
		$layout = get_option( 'stm_motors_chosen_template' );
		
		if ( empty( $layout ) ) {
			$layout = 'car_dealer';
		}
		
		return $layout;
	}
}

if ( !isset( $content_width ) ) $content_width = 1170;

add_action( 'after_setup_theme', 'stm_local_theme_setup' );
function stm_local_theme_setup()
{
	
	//Adding user role
	if ( is_listing() ) {
		$exist_dealer_role = get_role( 'dealer' );
		if ( empty( $exist_dealer_role ) ) {
			add_role( 'stm_dealer', 'STM Dealer', array( 'read' => true, 'level_0' => true ) );
		}
		
		remove_action( 'template_redirect', 'wc_disable_author_archives_for_customers' );
	}
	
	add_editor_style();
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'video' ) );
	add_post_type_support( 'page', 'excerpt' );
	
	
	if ( !stm_is_listing_five() && !stm_is_listing_six() ) {
		add_image_size( 'stm-img-1110-577', 1110, 577, true );
		add_image_size( 'stm-img-825-483', 825, 483, true );
		add_image_size( 'stm-img-796-466', 798, 466, true );
		add_image_size( 'stm-img-790-404', 790, 404, true );
		add_image_size( 'stm-img-690-410', 690, 410, true );
		add_image_size( 'stm-img-200-200', 200, 200, true );
		add_image_size( 'stm-img-350-205', 350, 205, true );
		add_image_size( 'stm-img-350-205-x-2', 700, 410, true );
		add_image_size( 'stm-img-350-216', 350, 216, true );
		add_image_size( 'stm-img-350-356', 350, 356, true );
		add_image_size( 'stm-img-350-181', 350, 181, true );
		add_image_size( 'stm-img-398-206', 398, 206, true );
		add_image_size( 'stm-img-398-223', 398, 223, true );
		add_image_size( 'stm-img-398-223-x-2', 796, 446, true );
		add_image_size( 'stm-img-255-135', 255, 135, true );
		add_image_size( 'stm-img-240-140', 240, 140, true );
		add_image_size( 'stm-img-255-135-x-2', 510, 270, true );
		add_image_size( 'stm-img-275-205', 275, 205, true );
		add_image_size( 'stm-img-275-205-x-2', 550, 410, true );
		add_image_size( 'stm-img-255-160', 255, 160, true );
		add_image_size( 'stm-img-255-160-x-2', 510, 320, true );
		add_image_size( 'stm-img-190-132', 190, 132, true );
		add_image_size( 'stm-mag-img-472-265', 472, 265, true );
		
		add_image_size( 'stm-img-280-165', 280, 165, true );
		add_image_size( 'stm-img-280-165-x-2', 560, 330, true );
		add_image_size( 'stm-img-350-255', 350, 255, true );
		add_image_size( 'stm-img-445-255', 445, 255, true );
		add_image_size( 'stm-img-635-255', 635, 255, true );
		add_image_size( 'stm-img-445-540', 445, 540, true );
		add_image_size( 'stm-img-100-68', 100, 68, true );
	}
	
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	) );
	
	
	load_theme_textdomain( 'motors', get_template_directory() . '/languages' );
	
}

function stm_register_sidebars()
{
	register_nav_menus( array(
		'primary' => __( 'Top primary menu', 'motors' ),
		'top_bar' => __( 'Top bar menu', 'motors' ),
		'bottom_menu' => __( 'Bottom menu', 'motors' ),
	) );
	
	register_sidebar( array(
		'name' => __( 'Primary Sidebar', 'motors' ),
		'id' => 'default',
		'description' => __( 'Main sidebar that appears on the right or left.', 'motors' ),
		'before_widget' => '<aside id="%1$s" class="widget widget-default %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="widget-title"><h4>',
		'after_title' => '</h4></div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer', 'motors' ),
		'id' => 'footer',
		'description' => __( 'Footer Widgets Area', 'motors' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
		'after_widget' => '</div></aside>',
		'before_title' => '<div class="widget-title"><h6>',
		'after_title' => '</h6></div>',
	) );
	
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar( array(
			'name' => __( 'Shop', 'motors' ),
			'id' => 'shop',
			'description' => __( 'Woocommerce pages sidebar', 'motors' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget_title"><h3>',
			'after_title' => '</h3></div>',
		) );
	}
	
	if ( !stm_is_auto_parts() ) {
		if ( !stm_is_listing_six() ) {
			register_sidebar( array(
				'name' => __( 'STM Listing Car Sidebar', 'motors' ),
				'id' => 'stm_listing_car',
				'description' => __( 'Default sidebar for Single Car Page (Listing layout)', 'motors' ),
				'before_widget' => '<aside id="%1$s" class="single-listing-car-sidebar-unit %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<div class="stm-border-bottom-unit"><div class="title heading-font">',
				'after_title' => '</div></div>',
			) );
		}
		
		if ( stm_is_listing_six() ) {
			register_sidebar( array(
				'name' => __( 'uListing Inventory Sidebar', 'motors' ),
				'id' => 'ulisting_inventory_sidebar',
				'description' => __( 'Default sidebar for inventory page', 'motors' ),
				'before_widget' => '<aside id="%1$s" class="ulisting-sidebar-unit %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<div class="stm-border-bottom-unit"><div class="title heading-font">',
				'after_title' => '</div></div>',
			) );
		}
		
		if ( stm_is_boats() ) {
			register_sidebar( array(
				'name' => __( 'STM Single Boat Sidebar', 'motors' ),
				'id' => 'stm_boats_car',
				'description' => __( 'Default sidebar for Single Boat Page (Boats layout)', 'motors' ),
				'before_widget' => '<aside id="%1$s" class="single-listing-car-sidebar-unit %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<div class="stm-border-bottom-unit"><h4 class="title heading-font">',
				'after_title' => '</h4></div>',
			) );
		}
	}
}

add_action( 'widgets_init', 'stm_register_sidebars' );