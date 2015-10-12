<?php
/*
	Plugin Name: Genesis Simple Hooks
	Plugin URI: http://www.studiopress.com/plugins/simple-hooks

	Description: Genesis Simple Hooks allows you easy access to the 50+ Action Hooks in the Genesis Theme.

	Author: Nathan Rice
	Author URI: http://www.nathanrice.net/

	Version: 2.1.2

	Text Domain: genesis-simple-hooks
	Domain Path: /languages

	License: GNU General Public License v2.0 (or later)
	License URI: http://www.opensource.org/licenses/gpl-license.php
*/

//* Define our constants
define( 'SIMPLEHOOKS_SETTINGS_FIELD', 'simplehooks-settings' );
define( 'SIMPLEHOOKS_PLUGIN_DIR', dirname( __FILE__ ) );

register_activation_hook( __FILE__, 'simplehooks_activation' );
/**
 * This function runs on plugin activation. It checks to make sure Genesis
 * or a Genesis child theme is active. If not, it deactivates itself.
 *
 * @since 0.1.0
 */
function simplehooks_activation() {

	if ( ! defined( 'PARENT_THEME_VERSION' ) || ! version_compare( PARENT_THEME_VERSION, '2.1.0', '>=' ) )
		simplehooks_deactivate( '2.1.0', '3.9.2' );

}

/**
 * Deactivate Simple Hooks.
 *
 * This function deactivates Simple Hooks.
 *
 * @since 1.8.0.2
 */
function simplehooks_deactivate( $genesis_version = '2.1.0', $wp_version = '3.9.2' ) {

	deactivate_plugins( plugin_basename( __FILE__ ) );
	wp_die( sprintf( __( 'Sorry, you cannot run Simple Hooks without WordPress %s and <a href="%s">Genesis %s</a>, or greater.', 'genesis-simple-hooks' ), $wp_version, 'http://my.studiopress.com/?download_id=91046d629e74d525b3f2978e404e7ffa', $genesis_version ) );

}

add_action( 'plugins_loaded', 'simplehooks_load_textdomain' );
/**
 * Load the plugin textdomain
 */
function simplehooks_load_textdomain() {
	load_plugin_textdomain( 'genesis-simple-hooks', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'genesis_init', 'simplehooks_init', 20 );
/**
 * Load admin menu and helper functions. Hooked to `genesis_init`.
 *
 * @since 1.8.0
 */
function simplehooks_init() {

	//* Admin Menu
	if ( is_admin() )
		require_once( SIMPLEHOOKS_PLUGIN_DIR . '/admin.php' );

	//* Helper functions
	require_once( SIMPLEHOOKS_PLUGIN_DIR . '/functions.php' );

}

add_action( 'genesis_init', 'simplehooks_execute_hooks', 20 );
/**
 * The following code loops through all the hooks, and attempts to
 * execute the code in the proper location.
 *
 * @uses simplehooks_execute_hook() as a callback.
 *
 * @since 0.1
 */
function simplehooks_execute_hooks() {

	$hooks = get_option( SIMPLEHOOKS_SETTINGS_FIELD );

	foreach ( (array) $hooks as $hook => $array ) {

		//* Add new content to hook
		if ( simplehooks_get_option( $hook, 'content' ) ) {
			add_action( $hook, 'simplehooks_execute_hook' );
		}

		//* Unhook stuff
		if ( isset( $array['unhook'] ) ) {

			foreach( (array) $array['unhook'] as $function ) {

				remove_action( $hook, $function );

			}

		}

	}

}

/**
 * The following function executes any code meant to be hooked.
 * It checks to see if shortcodes or PHP should be executed as well.
 *
 * @uses simplehooks_get_option()
 *
 * @since 0.1
 */
function simplehooks_execute_hook() {

	$hook = current_filter();
	$content = simplehooks_get_option( $hook, 'content' );

	if( ! $hook || ! $content )
		return;

	$shortcodes = simplehooks_get_option( $hook, 'shortcodes' );
	$php = simplehooks_get_option( $hook, 'php' );

	$value = $shortcodes ? do_shortcode( $content ) : $content;

	if ( $php )
		eval( "?>$value<?php " );
	else
		echo $value;

}