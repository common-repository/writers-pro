<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://contentlocalized.com
 * @since             1.1.0
 * @package           Translation_Pro
 *
 * @wordpress-plugin
 * Plugin Name:       Writers.Pro
 * Plugin URI:        https://www.contentlocalized.com/writers-pro
 * Description:       Our winning combo: local translators + professional writers!
 * Version:           1.0.0
 * Author:            ContentLocalized
 * Author URI:        https://contentlocalized.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contentlocalized
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CLWP_WRITERSPRO_PLUGIN_VERSION', '1.0.0' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-writers-pro-activator.php
 */
function activate_clwp_writers_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-writers-pro-activator.php';
	\Contentlocalized\CLWP_WritersPro_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-writers-pro-deactivator.php
 */
function deactivate_clwp_writers_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-writers-pro-deactivator.php';
	\Contentlocalized\CLWP_WritersPro_Deactivator ::deactivate();
}

register_activation_hook( __FILE__, 'activate_clwp_writers_pro' );
register_deactivation_hook( __FILE__, 'deactivate_clwp_writers_pro' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-writers-pro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_clwp_writers_pro() {

	$plugin = new \Contentlocalized\CLWP_WritersPro();
	$plugin->run();

}

run_clwp_writers_pro();
