<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.iazami.ir/
 * @since      1.0.0
 *
 * @package    Picowall
 * @subpackage Picowall/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Picowall
 * @subpackage Picowall/includes
 * @author     mohammad azami <iazami@outlook.com>
 */
class Picowall_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
