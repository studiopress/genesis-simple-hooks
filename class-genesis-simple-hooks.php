<?php
/**
 * This file handles the creation of the Simple Hooks admin menu.
 *
 * @package genesis-simple-hooks
 */

/**
 * Plugin Name: Genesis Simple Hooks
 * Plugin URI: http://www.studiopress.com/plugins/simple-hooks
 *
 * Description: Genesis Simple Hooks allows you easy access to the 50+ Action Hooks in the Genesis Theme.
 *
 * Author: StudioPress
 * Author URI: http://www.studiopress.com/
 *
 * Version: 2.2.1
 *
 * Text Domain: genesis-simple-hooks
 * Domain Path: /languages
 *
 * License: GNU General Public License v2.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */
class Genesis_Simple_Hooks {

	/**
	 * Plugin version
	 *
	 * @var $plugin_version The plugin version
	 */
	public $plugin_version = '2.2.1';

	/**
	 * Minimum WordPress version.
	 *
	 * @var $min_wp_version The minimum WordPress version
	 */
	public $min_wp_version = '4.7.2';

	/**
	 * Minimum Genesis version.
	 *
	 * @var $min_wp_version The minimum WordPress version
	 */
	public $min_genesis_version = '2.5.0';

	/**
	 * The plugin textdomain, for translations.
	 *
	 * @var $plugin_textdomain The plugin text domain
	 */
	public $plugin_textdomain = 'genesis-simple-hooks';

	/**
	 * The url to the plugin directory.
	 *
	 * @var $plugin_dir_url The plugin directory url
	 */
	public $plugin_dir_url;

	/**
	 * The path to the plugin directory.
	 *
	 * @var $plugin_dir_path The plugin directory path
	 */
	public $plugin_dir_path;

	/**
	 * The main settings field for this plugin.
	 *
	 * @var $settings_field The minimum settings field
	 */
	public $settings_field = 'simplehooks-settings';

	/**
	 * Admin menu and settings page.
	 *
	 * @var $admin The minimum WordPress version
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

		// For backward compatibility.
		define( 'SIMPLEHOOKS_PLUGIN_DIR', $this->plugin_dir_path );

	}

	/**
	 * Initialize.
	 *
	 * @since 2.2.0
	 */
	public function init() {

		$this->load_plugin_textdomain();

		add_action( 'admin_notices', array( $this, 'requirements_notice' ) );

		// Because this is a Genesis-dependent plugin.
		add_action( 'genesis_setup', array( $this, 'includes' ) );
		add_action( 'genesis_admin_init', array( $this, 'instantiate' ) );
		add_action( 'genesis_setup', array( $this, 'execute_hooks' ) );

	}

	/**
	 * Show admin notice if minimum requirements aren't met.
	 *
	 * @since 2.2.0
	 */
	public function requirements_notice() {

		if ( ! defined( 'PARENT_THEME_VERSION' ) || ! version_compare( PARENT_THEME_VERSION, $this->min_genesis_version, '>=' ) ) {

			$plugin = get_plugin_data( $this->plugin_dir_path . 'plugin.php' );

			$action = defined( 'PARENT_THEME_VERSION' ) ? __( 'upgrade to', 'plugin-boilerplate' ) : __( 'install and activate', 'plugin-boilerplate' );

			// Translators: String 1 is the name of the plugin, String 2 is the minimum required version of WordPress, String 3 is a url, String 4 is the minimum required version of Genesis, and String 5 is an expected action.
			$message = sprintf( __( '%1$s requires WordPress %2$s and <a href="%3$s" target="_blank">Genesis %4$s</a>, or greater. Please %5$s the latest version of Genesis to use this plugin.', 'plugin-boilerplate' ), $plugin['Name'], $this->min_wp_version, 'http://my.studiopress.com/?download_id=91046d629e74d525b3f2978e404e7ffa', $this->min_genesis_version, $action );
			echo '<div class="notice notice-warning"><p>' . esc_html( $message ) . '</p></div>';

		}

	}

	/**
	 * Load the plugin textdomain, for translation.
	 *
	 * @since 2.2.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'genesis-simple-hooks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * All general includes.
	 *
	 * @since 2.2.0
	 */
	public function includes() {

		require_once $this->plugin_dir_path . 'includes/functions.php';
		require_once $this->plugin_dir_path . 'includes/deprecated.php';

	}

	/**
	 * Include the class file, instantiate the classes, create objects.
	 *
	 * @since 2.2.0
	 */
	public function instantiate() {

		require_once $this->plugin_dir_path . 'includes/class-genesis-simple-hooks-admin.php';
		$this->admin = new Genesis_Simple_Hooks_Admin();
		$this->admin->init();

	}

	/**
	 * Helper function to retrieve the static object without using globals.
	 *
	 * @since 2.2.0
	 */
	public function execute_hooks() {

		$hooks = get_option( $this->settings_field );

		foreach ( (array) $hooks as $hook => $array ) {

			// Add new content to hook.
			if ( ! empty( $array['content'] ) ) {
				add_action( $hook, array( $this, 'execute_hook' ) );
			}

			// Unhook stuff.
			if ( isset( $array['unhook'] ) ) {

				foreach ( (array) $array['unhook'] as $function ) {
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
			echo esc_html( $value );
		}

	}

}
