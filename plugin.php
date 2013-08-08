<?php
/*
Plugin Name: Genesis Simple Hooks
Plugin URI: http://www.studiopress.com/plugins/simple-hooks
Description: Genesis Simple Hooks allows you easy access to the 50+ Action Hooks in the Genesis Theme.
Version: 1.3.1
Author: Nathan Rice
Author URI: http://www.nathanrice.net/
*/

// require Genesis 1.3.1 upon activation
register_activation_hook(__FILE__, 'simplehooks_activation_check');
function simplehooks_activation_check() {

		$latest = '1.3.1';
		
		$theme_info = get_theme_data(TEMPLATEPATH.'/style.css');
	
        if( basename(TEMPLATEPATH) != 'genesis' ) {
	        deactivate_plugins(plugin_basename(__FILE__)); // Deactivate ourself
            wp_die('Sorry, you can\'t activate unless you have installed <a href="http://www.studiopress.com/themes/genesis">Genesis</a>');
		}

		if( version_compare( $theme_info['Version'], $latest, '<' ) ) {
                deactivate_plugins(plugin_basename(__FILE__)); // Deactivate ourself
                wp_die('Sorry, you can\'t activate without <a href="http://www.studiopress.com/support/showthread.php?t=19576">Genesis '.$latest.'</a> or greater');
        }

}

// Define our constants
define('SIMPLEHOOKS_SETTINGS_FIELD', 'simplehooks-settings');
define('SIMPLEHOOKS_PLUGIN_DIR', dirname(__FILE__));

// Include files
require_once(SIMPLEHOOKS_PLUGIN_DIR . '/admin.php');
require_once(SIMPLEHOOKS_PLUGIN_DIR . '/functions.php');
require_once(SIMPLEHOOKS_PLUGIN_DIR . '/boxes.php');

/**
 * The following code loops through all the hooks, and attempts to
 * execute the code in the proper location.
 *
 * @since 0.1
 */
add_action('genesis_init', 'simplehooks_execute_hooks');
function simplehooks_execute_hooks() {
	
	$hooks = get_option(SIMPLEHOOKS_SETTINGS_FIELD);
	
	foreach( (array)$hooks as $hook => $array ) {
		
		// Add new content to hook
		if( simplehooks_get_option($hook, 'content') ) {
			add_action($hook, 'simplehooks_execute_hook');
		}
		
		// Unhook stuff
		if( isset( $array['unhook'] ) ) {
			
			foreach( (array)$array['unhook'] as $function ) {
				
				remove_action($hook, $function);
				
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
	$content = simplehooks_get_option($hook, 'content');
	
	if( !$hook || !$content ) return;
	
	$shortcodes = simplehooks_get_option($hook, 'shortcodes');
	$php = simplehooks_get_option($hook, 'php');
		
	$value = $shortcodes ? do_shortcode($content) : $content;
	
	if( $php )
		eval( "?>$value<?php " );
	else 
		echo $value;

}