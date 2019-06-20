<?php
/**
 * This file handles the creation of the Simple Hooks admin menu.
 *
 * @package genesis-simple-hooks
 */

define( 'GENESIS_SIMPLE_HOOKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'GENESIS_SIMPLE_HOOKS_URL', plugins_url( '', __FILE__ ) );

require_once GENESIS_SIMPLE_HOOKS_DIR . '/class-genesis-simple-hooks.php';

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
