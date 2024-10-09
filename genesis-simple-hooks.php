<?php
/**
 * This file handles the creation of the Simple Hooks admin menu.
 *
 * @package genesis-simple-hooks
 */

define( 'GENESIS_SIMPLE_HOOKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'GENESIS_SIMPLE_HOOKS_URL', plugins_url( '', __FILE__ ) );
define( 'GENESIS_SIMPLE_HOOKS_VERSION', '2.3.1' );

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

/**
 * Initialize checking of plugin updates from WP Engine.
 */
function genesis_simple_hooks_check_for_upgrades() {
	$properties = array(
		'plugin_slug'     => 'genesis-simple-hooks',
		'plugin_basename' => plugin_basename( dirname(__FILE__) . '/plugin.php' ),
	);

	require_once __DIR__ . '/includes/class-genesis-simple-hooks-plugin-updater.php';
	new Genesis_Simple_Hooks_Plugin_Updater( $properties );
}
add_action( 'admin_init', 'genesis_simple_hooks_check_for_upgrades' );
