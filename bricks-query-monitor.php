<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://justin-vogt.com
 * @since             1.0.0
 * @package           Bricks_Query_Monitor
 *
 * @wordpress-plugin
 * Plugin Name:       Bricks Query Monitor
 * Author:            Justin Vogt
 * Author URI:        https://justin-vogt.com
 * Description:       Allows you to easily debug bricks loops with the query monitor plugin
 * Version:           1.0.1
 * Requires PHP:      7.4
 * Requires Plugins:  query-monitor
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bricks-query-monitor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
use Bricks_Query_Monitor\Activator;
use Bricks_Query_Monitor\Deactivator;
use Bricks_Query_Monitor\Bricks_Query_Monitor;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin absolute path
 */
define( 'BRICKS_QUERY_MONITOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'BRICKS_QUERY_MONITOR_URL', plugin_dir_url( __FILE__ ) );

/**
 * Use Composer PSR-4 Autoloading
 */
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require plugin_dir_path( __FILE__ ) . 'vendor/vendor-prefixed/autoload.php';

/**
 * The code that runs during plugin activation.
 */
function activate_bricks_query_monitor() {
    Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_bricks_query_monitor() {
    Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bricks_query_monitor' );
register_deactivation_hook( __FILE__, 'deactivate_bricks_query_monitor' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bricks_query_monitor() {

	$version = "1.0.1";
	$plugin = new Bricks_Query_Monitor($version);
	$plugin->run();

}
run_bricks_query_monitor();
