<?php
class STM_Custom_Colors_Helper {
	
	private $cssListForCustom = '';
	private $cssListForCustomCF = '';
	private $wpFileSystem;
	private $themeCssDir;
	
	public function __construct()
	{
		global $wp_filesystem;
		
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		
		$this->wpFileSystem = $wp_filesystem;
		$this->themeCssDir = get_stylesheet_directory() . '/assets/css/dist/';
		
		$this->stm_cch_get_mega_menu_css_list();
		$this->stm_cch_get_vc_modules_css_list();
		$this->stm_cch_get_vc_modules_css_list_classified_five();
		$this->stm_cch_get_vc_modules_css_list_classified_six();
		$this->stm_cch_get_vc_modules_css_list_events();
		$this->stm_cch_get_vc_modules_css_list_review();
	}
	
	private function stm_cch_get_mega_menu_css_list () {
		if(defined('STM_MM_DIR_NAME')) {
			$this->cssListForCustom .= $this->wpFileSystem->get_contents( STM_MM_DIR_NAME . '/assets/css/megamenu.css' );
			$this->cssListForCustom .= $this->wpFileSystem->get_contents( $this->themeCssDir . 'vc_template_styles/stm_mm_top_vehicles.css' );
			$this->cssListForCustom .= $this->wpFileSystem->get_contents( $this->themeCssDir . 'vc_template_styles/stm_mm_top_makes_tab.css' );
			$this->cssListForCustom .= $this->wpFileSystem->get_contents( $this->themeCssDir . 'vc_template_styles/stm_mm_top_categories.css' );
		}
	}
	
	private function stm_cch_get_vc_modules_css_list () {
		$cssMap = array(
			'cars_on_top',
			'stm_aircraft_data_table',
			'stm_category_info_box',
			'stm_icon_filter',
			'stm_image_filter_by_type',
			'stm_info_block_animate',
			'stm_info_box',
			'stm_inventory_no_filter',
			'stm_inventory_on_map',
			'stm_inventory_with_filter',
			'stm_listing_categories_grid',
			'stm_listing_search',
			'stm_listing_search_with_car_rating',
			'stm_listing_search_without_tabs',
			'stm_listing_tabs_2',
			'stm_listing_two_search',
			'stm_popular_makes',
			'stm_popular_searches',
			'stm_special_offers',
		);
		
		foreach ($cssMap as $vc_css) {
			$this->cssListForCustom .= $this->wpFileSystem->get_contents( $this->themeCssDir . 'vc_template_styles/' . $vc_css . '.css' );
		}
	}
	
	private function stm_cch_get_vc_modules_css_list_classified_five () {
		if(defined('STM_MOTORS_CLASSIFIED_FIVE')) {
			
			$cssMap = array(
				'stm_browse_by_type',
				'stm_c_f_category_tabs',
				'stm_c_f_latest_posts',
				'stm_c_f_recent_items'
			);
			
			foreach ( $cssMap as $vc_css ) {
				$this->cssListForCustom .= $this->wpFileSystem->get_contents( STM_MOTORS_C_F_PATH . '/assets/css/vc_ss/' . $vc_css . '.css' );
			}
		}
	}
	
	private function stm_cch_get_vc_modules_css_list_classified_six () {
		if(defined('STM_MOTORS_CLASSIFIED_SIX')) {
			
			$cssMap = array(
				'stm_browse_by_type',
				'stm_c_six_featured_listings',
				'stm_company_info'
			);
			
			foreach ( $cssMap as $vc_css ) {
				$this->cssListForCustom .= $this->wpFileSystem->get_contents( STM_MOTORS_C_SIX_PATH . '/assets/css/vc_ss/' . $vc_css . '.css' );
			}
		}
	}
	
	private function stm_cch_get_vc_modules_css_list_events () {
		if(defined('STM_EVENTS')) {
			$this->cssListForCustom .= $this->wpFileSystem->get_contents( STM_EVENTS_PATH . '/assets/css/style.css' );
		}
	}
	
	private function stm_cch_get_vc_modules_css_list_review () {
		if(defined('STM_REVIEW')) {
			$this->cssListForCustom .= $this->wpFileSystem->get_contents( STM_REVIEW_PATH . '/assets/css/style.css' );
		}
	}
	
	public function stm_cch_get_css_modules () {
		return $this->cssListForCustom;
	}
}