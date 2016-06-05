<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.iazami.ir/
 * @since      1.0.0
 *
 * @package    Picowall
 * @subpackage Picowall/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Picowall
 * @subpackage Picowall/includes
 * @author     mohammad azami <iazami@outlook.com>
 */
class Picowall_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		add_rewrite_rule(
		'download/?([^/]*)',
		'index.php?pagename=download&picowall_file_name=$matches[1]',
		'top'
		);
		flush_rewrite_rules();
	}

}
