<?php
$includes = get_template_directory() . '/admin/includes/';
$admin = get_template_directory() . '/admin/';
define('STM_ITEM_NAME', 'Motors');
define('STM_API_URL', 'https://panel.stylemixthemes.com/api/');

/*Connect Envato market plugin.*/
if(!class_exists('Envato_Market')) {
	require_once($includes . 'envato-market/envato-market.php');
}

require_once $admin . 'layout_config.php';
require_once $includes . 'theme.php';
require_once $includes . 'admin_screens.php';
require_once $admin . 'screens/addvert_popup.php';

add_action('init', 'motors_remove_woo_redirect', 10);

function motors_remove_woo_redirect() {
    delete_transient( '_wc_activation_redirect' );
}

function motors_show_wpcfto_notice () {
	$pluginsList = get_plugins();
	
	$wpcftoNeededVersion = array(
		'stm_importer' => '4.8.2',
		'stm-post-type' => '4.6.9',
		'stm_vehicles_listing' => '6.7',
		'stm-motors-car-rental' => '1.4',
		'stm-motors-extends' => '1.4.6',
		'stm_motors_review' => '1.3.8',
		'stm_motors_events' => '1.3.5',
		'stm-motors-equipment' => '1.0.4',
		'stm-motors-classified-six' => '1.0.2',
		'stm-motors-classified-five' => '1.0.9',
		'stm-woocommerce-motors-auto-parts' => '1.0.7',
		'stm-megamenu' => '2.1',
	);
	
	foreach (motors_layout_plugins(stm_get_current_layout()) as $plugin) {
		if(isset($wpcftoNeededVersion[$plugin]) && isset($pluginsList[$plugin . '/' . $plugin . '.php'])) {
			if(version_compare( $wpcftoNeededVersion[$plugin], $pluginsList[$plugin . '/' . $plugin . '.php']['Version'], '>' )) {
				echo "<div class='notice notice-error is-dismissible stm-admin-notice'>
						<p>
							<span><img src='" . get_stylesheet_directory_uri() . "/admin/assets/images/warning.svg' width='20'/></span>
							The " . $pluginsList[$plugin . '/' . $plugin . '.php']['Name'] . " plugin should be updated!
							<a href='" . esc_url_raw( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ) . "'>Update</a>
						</p>
						</div>";
			}
		}
		
	}
}

add_action('admin_notices', 'motors_show_wpcfto_notice');

function stm_show_completed_date($order) {
    if($order->get_status() == 'completed') {
        $orderId = $order->get_id();
        printf("<p><strong>Order Completed Date</strong><br />%s</p>", get_post_meta($orderId, '_completed_date', true));
    }
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'stm_show_completed_date', 10, 1 );