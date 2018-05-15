<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    M8wp_Integration
 * @subpackage M8wp_Integration/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    M8wp_Integration
 * @subpackage M8wp_Integration/includes
 * @author     Your Name <email@example.com>
 */
class M8wp_Integration_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// empty options array
		$options = array(
			'm8wp_username' => '',
			'm8wp_password' => '',
			'm8wp_baseURL' => '',
		);
		
		// init option on activation using empty array
		if ( get_option( 'm8wp_admin_options' ) == false ) { 
			add_option("m8wp_admin_options", $options); 
		}
	}

}
