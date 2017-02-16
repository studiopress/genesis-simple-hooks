<?php
/*
Plugin Name: Genesis Simple Hooks
Plugin URI: http://www.studiopress.com/plugins/simple-hooks

Description: Genesis Simple Hooks allows you easy access to the 50+ Action Hooks in the Genesis Theme.

Author: Nathan Rice
Author URI: http://www.nathanrice.net/

Version: 2.2.0

Text Domain: genesis-simple-hooks
Domain Path: /languages

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

class Genesis_Simple_Hooks {

	/**
	 * Plugin version
	 */
	public $plugin_version = '2.2.0';

	/**
	 * Minimum WordPress version.
	 */
	public $min_wp_version = '4.7.2';

	/**
	 * Minimum Genesis version.
	 */
	public $min_genesis_version = '2.4.2';

	/**
	 * The plugin textdomain, for translations.
	 */
	public $plugin_textdomain = 'genesis-simple-hooks';

	/**
	 * The url to the plugin directory.
	 */
	public $plugin_dir_url;

	/**
	 * The path to the plugin directory.
	 */
	public $plugin_dir_path;

	/**
	 * The main settings field for this plugin.
	 */
	public $settings_field = 'simplehooks-settings';

	/**
	 * Admin menu and settings page.
	 */
	public $admin;

	/**
	 * Constructor.
	 *
	 * @since 2.2.0
	 */
	public function __construct() {

		$this->plugin_dir_url  = plugin_dir_url( __FILE__ );
		$this->plugin_dir_path = plugin_dir_path( __FILE__ );

		// For backward compatibility
		define( 'SIMPLEHOOKS_PLUGIN_DIR', $this->plugin_dir_path );

	}

	/**
	 * Initialize.
	 *
	 * @since 2.2.0
	 */
	public function init() {

		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		$this->load_plugin_textdomain();
		$this->includes();
		$this->instantiate();

		add_action( 'genesis_setup', array( $this, 'execute_hooks' ) );

	}

	/**
	 * Plugin activation hook. Runs when plugin is activated.
	 *
	 * @since 2.2.0
	 */
	public function activation() {

		if ( ! defined( 'PARENT_THEME_VERSION' ) || ! version_compare( PARENT_THEME_VERSION, $this->min_genesis_version, '>=' ) ) {

			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( sprintf( __( 'Sorry, you cannot run Simple Hooks without WordPress %s and <a href="%s">Genesis %s</a>, or greater.', 'genesis-simple-hooks' ), $this->min_wp_version, 'http://my.studiopress.com/?download_id=91046d629e74d525b3f2978e404e7ffa', $this->min_genesis_version ) );

		}

	}

	/**
	 * Load the plugin textdomain, for translation.
	 *
	 * @since 2.2.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( $this->plugin_textdomain, false, $this->plugin_dir_path . 'languages/' );
	}

	/**
	 * All general includes.
	 *
	 * @since 2.2.0
	 */
	public function includes() {

		require_once( $this->plugin_dir_path . 'includes/functions.php' );
		require_once( $this->plugin_dir_path . 'includes/deprecated.php' );

	}

	/**
	 * Include the class file, instantiate the classes, create objects.
	 *
	 * @since 2.2.0
	 */
	public function instantiate() {

		add_action( 'genesis_admin_menu', array( $this, 'admin_instantiate' ) );

	}

	/**
	 * Instantiate any classes that depend on Genesis admin classes.
	 *
	 * @since 2.2.0
	 */
	public function admin_instantiate() {

		require_once( $this->plugin_dir_path . 'includes/class-genesis-simple-hooks-admin.php' );
		$this->admin = new Genesis_Simple_Hooks_Admin;
		$this->admin->admin_menu();

	}
	/**
	 * Helper function to retrieve the static object without using globals.
	 *
	 * @since 2.2.0
	 */
	public function execute_hooks() {

		$hooks = get_option( $this->settings_field );

		//print_r( $hooks );

		foreach ( (array) $hooks as $hook => $array ) {

			// Add new content to hook
			if ( $array['content'] ) {
				add_action( $hook, array( $this, 'execute_hook' ) );
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
	 * @uses simplehooks_get_option()
	 *
	 * @since 2.2.0
	 */
	public function execute_hook() {

		$hook    = current_filter();
		$content = simplehooks_get_option( $hook, 'content' );

		if ( ! $hook || ! $content ) {
			return;
		}

		$shortcodes = simplehooks_get_option( $hook, 'shortcodes' );
		$php        = simplehooks_get_option( $hook, 'php' );

		$value = $shortcodes ? do_shortcode( $content ) : $content;

		if ( $php ) {
			eval( "?>$value " );
		} else {
			echo $value;
		}

	}

}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @since 0.9.0
 */
function Genesis_Simple_Hooks() {

	static $object;

	if ( null == $object ) {
		$object = new Genesis_Simple_Hooks;
	}

	return $object;
}
/**
 * Initialize the object on	`plugins_loaded`.
 */
add_action( 'plugins_loaded', array( Genesis_Simple_Hooks(), 'init' ) );