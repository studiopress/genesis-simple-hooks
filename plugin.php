<?php
/*
Plugin Name: Genesis Simple Hooks
*/

add_action( 'admin_init', 'genesis_simple_hooks_switch_plugin_file' );
/**
 * Make WordPress switch from using this file, to using the main plugin file.
 */
function genesis_simple_hooks_switch_plugin_file() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
	activate_plugin( plugin_dir_path( __FILE__ ) . 'genesis-simple-hooks.php' );
}
