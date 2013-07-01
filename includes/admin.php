<?php
/**
 * Controls the creation, deletion, and editing of Simple Sidebar.
 *
 * @author StudioPress
 */

/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Genesis Simple Sidebars plugin.
 *
 * @since 1.0.0
 */
class Genesis_Simple_Sidebars_Admin extends Genesis_Admin_Basic {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.0.0
	 *
	 * @uses Genesis_Admin::create() Register the admin page
	 *
	 * @see Genesis_Admin_Import_Export::actions() Handle creating, editing, and deleting sidebars.
	 */
	public function __construct() {

		$page_id = 'simple-sidebars';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Genesis - Simple Sidebars', 'ss' ),
				'menu_title'  => __( 'Simple Sidebars', 'ss' )
			)
		);

		/** Empty, as we'll be building the page manually */
		$page_ops = array();

		$settings_field = SS_SETTINGS_FIELD;

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field );

		/** Simpe Sidebar actions (create, edit, or delete) */
		add_action( 'admin_init', array( $this, 'actions' ) );

	}

	/**
	 * Callback for displaying the Simple Sidebars admin page.
	 *
	 * Echoes out HTML.
	 *
	 * @since 1.0.0
	 *
	 */
	public function admin() {

		$_sidebars = get_option( $this->settings_field );

		echo '<div class="wrap">';

			if ( isset( $_REQUEST['action'] ) && 'edit' == $_REQUEST['action'] )
				require_once( SS_PLUGIN_DIR . '/includes/views/edit.php' );
			else
				require_once( SS_PLUGIN_DIR . '/includes/views/main.php' );

		echo '</div>';

	}

	/**
	 * Display sidebar table rows.
	 *
	 * Displays table rows of sidebars for viewing and editing on the main admin page.
	 *
	 * @since 1.0.0
	 *
	 */
	public function table_rows() {

		global $wp_registered_sidebars;

		$_sidebars = $wp_registered_sidebars;

		$alt = true;

		foreach ( (array) $_sidebars as $id => $info ) :

			$is_editable = isset( $info['editable'] ) && $info['editable'] ? true : false;

		?>

			<tr <?php if ( $alt ) { echo 'class="alternate"'; $alt = false; } else { $alt = true; } ?>>
				<td class="name column-name">
					<?php
						if ( $is_editable ) {
							printf( '<a class="row-title" href="%s" title="Edit %s">%s</a>', admin_url('admin.php?page=simple-sidebars&amp;action=edit&amp;id=' . esc_html( $id ) ), esc_html( $info['name'] ), esc_html( $info['name'] ) );
						} else {
							printf( '<strong class="row-title">%s</strong>', esc_html( $info['name'] ) );
						}
					?>

					<?php if ( $is_editable ) : ?>
					<br />
					<div class="row-actions">
						<span class="edit"><a href="<?php echo admin_url('admin.php?page=simple-sidebars&amp;action=edit&amp;id=' . esc_html( $id ) ); ?>"><?php _e('Edit', 'ss'); ?></a> | </span>
						<span class="delete"><a class="delete-tag" href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=simple-sidebars&amp;action=delete&amp;id=' . esc_html( $id ) ), 'simple-sidebars-action_delete-sidebar' ); ?>"><?php _e('Delete', 'ss'); ?></a></span>
					</div>
					<?php endif; ?>

				</td>
				<td class="slug column-slug"><?php echo esc_html( $id ); ?></td>
				<td class="description column-description"><?php echo esc_html( $info['description'] )?></td>
			</tr>

		<?php
		endforeach;

	}

	/**
	 * Action handler.
	 *
	 * Depending on what action was intended by the user, this method calls the appropriate action method.
	 * 
	 * @since 1.0.0
	 *
	 */
	public function actions() {

		if ( ! genesis_is_menu_page( 'simple-sidebars' ) )
			return;

		/**
		 * This section handles the data if a new sidebar is created
		 */
		if ( isset( $_REQUEST['action'] ) && 'create' == $_REQUEST['action'] ) {
			$this->create_sidebar( $_POST['new_sidebar'] );
		}

		/**
		 * This section will handle the data if a sidebar is deleted
		 */
		if ( isset( $_REQUEST['action'] ) && 'delete' == $_REQUEST['action'] && isset( $_REQUEST['id'] ) ) {
			$this->delete_sidebar( $_REQUEST['id'] );
		}

		/**
		 * This section will handle the data if a sidebar is to be modified
		 */
		if ( isset( $_REQUEST['action'] ) && 'edit' == $_REQUEST['action'] && ! isset( $_REQUEST['id'] ) ) {
			$this->edit_sidebar( $_POST['edit_sidebar'] );
		}

	}

	/**
	 * Add custom notices that display when you successfully create, edit, or delete a sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @return null Returns null if not on the correct admin page.
	 */
	public function notices() {

		if ( ! genesis_is_menu_page( 'simple-sidebars' ) )
			return;

		$pattern = '<div id="message" class="updated"><p><strong>%s</strong></p></div>';

		if ( isset( $_REQUEST['created'] ) && 'true' === $_REQUEST['created'] ) {
			printf( $pattern, __( 'New sidebar successfully created!', 'ss' ) );
			return;
		}

		if ( isset( $_REQUEST['edited'] ) && 'true' === $_REQUEST['edited'] ) {
			printf( $pattern, __( 'Sidebar successfully edited!', 'ss' ) );
			return;
		}

		if ( isset( $_REQUEST['deleted'] ) && 'true' === $_REQUEST['deleted'] ) {
			printf( $pattern, __( 'Sidebar successfully deleted.', 'ss' ) );
			return;
		}

		return;

	}

	/**
	 * Create a sidebar.
	 *
	 * @since 1.0.0
	 *
	 */
	protected function create_sidebar( $args = array() ) {

		if ( empty( $args['name'] ) || empty( $args['id'] ) ) {
			wp_die( $this->error( 1 ) );
			exit;
		}

		//	nonce verification
		check_admin_referer( 'simple-sidebars-action_create-sidebar' );

		// WP changes a numeric sidebar id to sidebar-id which makes it inaccessible to the user
		if ( is_numeric( $args['id'] ) )
			$args['id'] = sanitize_title_with_dashes( $args['name'] );

		$db = (array) get_option( SS_SETTINGS_FIELD );
		$new = array(
			sanitize_title_with_dashes( $args['id'] ) => array(
				'name' => esc_html( $args['name'] ),
				'description' => esc_html( $args['description'] )
			)
		);

		if ( array_key_exists( $args['id'], $db ) ) {
			wp_die( $this->error( 2 ) );
			exit;
		}

		$_sidebars = wp_parse_args( $new, $db );

		update_option( SS_SETTINGS_FIELD, $_sidebars );
		wp_redirect( admin_url( 'admin.php?page=simple-sidebars&created=true' ) );
		exit;

	}

	/**
	 * Edit a sidebar.
	 *
	 * @since 1.0.0
	 *
	 */
	protected function edit_sidebar( $args = array() ) {

		if ( empty( $args['name'] ) || empty( $args['id'] ) ) {
			wp_die( $this->error( 3 ) );
			exit;
		}

		//	nonce verification
		check_admin_referer( 'simple-sidebars-action_edit-sidebar' );

		// WP changes a numeric sidebar id to sidebar-id which makes it inaccessible to the user
		if ( is_numeric( $args['id'] ) )
			$args['id'] = sanitize_title_with_dashes( $args['name'] );

		$db = (array) get_option( SS_SETTINGS_FIELD );
		$new = array(
			sanitize_title_with_dashes( $args['id'] ) => array(
				'name' => esc_html( $args['name'] ),
				'description' => esc_html( $args['description'] )
			)
		);

		if ( ! array_key_exists( $args['id'], $db ) ) {
			wp_die( $this->error( 3 ) );
			exit;
		}

		$_sidebars = wp_parse_args( $new, $db );

		update_option( SS_SETTINGS_FIELD, $_sidebars );
		wp_redirect( admin_url( 'admin.php?page=simple-sidebars&edited=true' ) );
		exit;

	}

	/**
	 * Delete a sidebar.
	 *
	 * @since 1.0.0
	 *
	 */
	protected function delete_sidebar( $id = '' ) {

		if ( empty( $id ) ) {
			wp_die( $this->error( 4 ) );
			exit;
		}

		//	nonce verification
		check_admin_referer( 'simple-sidebars-action_delete-sidebar' );

		$_sidebars = (array) get_option( SS_SETTINGS_FIELD );

		if ( ! isset( $_sidebars[$id] ) ) {
			wp_die( $this->error( 4 ) );
			exit;
		}

		unset( $_sidebars[$id] );

		update_option( SS_SETTINGS_FIELD, $_sidebars );
		wp_redirect( admin_url( 'admin.php?page=simple-sidebars&deleted=true' ) );
		exit;

	}

	/**
	 * Returns an error message by ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string Returns an error string based on an error ID.
	 */
	protected function error( $error = false ) {

		if ( ! $error )
			return false;

		switch( (int) $error ) {

			case 1:
				return __( 'Oops! Please choose a valid Name and ID for this sidebar', 'ss' );
				break;
			case 2:
				return __( 'Oops! That sidebar ID already exists', 'ss' );
				break;
			case 3:
				return __( 'Oops! You are trying to edit a sidebar that does not exist, or is not editable', 'ss' );
				break;
			case 4:
				return __( 'Oops! You are trying to delete a sidebar that does not exist, or cannot be deleted', 'ss' );
				break;
			default:
				return __( 'Oops! Something went wrong. Try again.', 'ss' );

		}

	}

}

add_action( 'genesis_admin_menu', 'simplesidebars_settings_menu' );
/**
 * Instantiate the class to create the menu.
 *
 * @since 1.0.0
 */
function simplesidebars_settings_menu() {

	new Genesis_Simple_Sidebars_Admin;

}