<?php
/**
 *
 * @link              http://www.iazami.ir/
 * @since             1.0.0
 * @package           Picowall
 *
 * @wordpress-plugin
 * Plugin Name:       picowall
 * Plugin URI:        http://www.wordpress.com/plugins/picowall
 * Description:       Resize images on the fly.
 * Version:           1.0.0
 * Author:            mohammad azami
 * Author URI:        http://www.iazami.ir/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       picowall
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-picowall-activator.php
 */
function activate_picowall() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-picowall-activator.php';
	Picowall_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-picowall-deactivator.php
 */
function deactivate_picowall() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-picowall-deactivator.php';
	Picowall_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_picowall' );
register_deactivation_hook( __FILE__, 'deactivate_picowall' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-picowall.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_picowall() {

	$plugin = new Picowall();
	$plugin->run();

}
run_picowall();
