<?php
/**
 * Plugin Name: Genesis Simple Hooks
 * Plugin URI: https://studiopress.com
 * Description: Creates a new Genesis settings page that allows you to insert code (HTML, Shortcodes, and PHP), and attach it to any of the 50+ action hooks throughout the Genesis Theme Framework, from StudioPress.
 * Author: StudioPress
 * Author URI: https://www.studiopress.com/
 * Version: 2.3.1
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: genesis-simple-hooks
 * Domain Path: /languages
 *
 * @package genesis-simple-hooks
 */

define( 'GENESIS_SIMPLE_HOOKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'GENESIS_SIMPLE_HOOKS_URL', plugins_url( '', __FILE__ ) );
define( 'GENESIS_SIMPLE_HOOKS_VERSION', '2.3.0' );

require_once GENESIS_SIMPLE_HOOKS_DIR . '/includes/class-genesis-simple-hooks.php';

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @since 0.9.0
 */
function genesis_simple_hooks() {

	static $object;

	if ( null === $object ) {
		$object = new Genesis_Simple_Hooks();
	}

	return $object;
}
/**
 * Initialize the object on `plugins_loaded`.
 */
add_action( 'plugins_loaded', array( Genesis_Simple_Hooks(), 'init' ) );
