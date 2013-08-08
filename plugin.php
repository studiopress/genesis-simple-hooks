<?php
/*
	Plugin Name: Genesis Simple Hooks
	Plugin URI: http://www.studiopress.com/plugins/simple-hooks
	Description: Genesis Simple Hooks allows you easy access to the 50+ Action Hooks in the Genesis Theme.
	Author: Nathan Rice
	Author URI: http://www.nathanrice.net/

	Version: 1.7.1

	License: GNU General Public License v2.0 (or later)
	License URI: http://www.opensource.org/licenses/gpl-license.php
*/

register_activation_hook( __FILE__, 'simplehooks_activation' );
/**
 * This function runs on plugin activation. It checks to make sure the required
 * minimum Genesis version is installed. If not, it deactivates itself.
 *
 * @since 0.1.0
 */
function simplehooks_activation() {

		$latest = '1.7.1';

		$theme_info = get_theme_data( TEMPLATEPATH . '/style.css' );

		if ( 'genesis' != basename( TEMPLATEPATH ) ) {
	        deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
			wp_die( sprintf( __( 'Sorry, you can\'t activate unless you have installed <a href="%s">Genesis</a>', 'apl' ), 'http://www.studiopress.com/themes/genesis' ) );
		}

		if ( version_compare( $theme_info['Version'], $latest, '<' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
			wp_die( sprintf( __( 'Sorry, you cannot activate without <a href="%s">Genesis %s</a> or greater', 'apl' ), 'http://www.studiopress.com/support/showthread.php?t=19576', $latest ) );
		}

}

// Define our constants
define( 'SIMPLEHOOKS_SETTINGS_FIELD', 'simplehooks-settings' );
define( 'SIMPLEHOOKS_PLUGIN_DIR', dirname( __FILE__ ) );

// Include files
require_once( SIMPLEHOOKS_PLUGIN_DIR . '/admin.php' );
require_once( SIMPLEHOOKS_PLUGIN_DIR . '/functions.php' );
require_once( SIMPLEHOOKS_PLUGIN_DIR . '/boxes.php' );

/**
 * The following code loops through all the hooks, and attempts to
 * execute the code in the proper location.
 *
 * @since 0.1
 */
add_action( 'genesis_init', 'simplehooks_execute_hooks', 20 );
function simplehooks_execute_hooks() {

	$hooks = get_option( SIMPLEHOOKS_SETTINGS_FIELD );

	foreach ( (array) $hooks as $hook => $array ) {

		// Add new content to hook
		if ( simplehooks_get_option( $hook, 'content' ) ) {
			add_action( $hook, 'simplehooks_execute_hook' );
		}

		// Unhook stuff
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