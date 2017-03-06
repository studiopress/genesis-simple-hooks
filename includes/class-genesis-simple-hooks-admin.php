<?php
/**
 * This file handles the creation of the Simple Hooks admin menu.
 */


/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Simple Hooks Settings page.
 *
 * @since 1.8.0
 */
class Genesis_Simple_Hooks_Admin extends Genesis_Admin_Boxes {

	/**
	 * Settings field.
	 *
	 * @since 2.2.0
	 */
	public $settings_field = 'simplehooks-settings';

	public $wp_hooks;

	public $document_hooks;

	public $header_hooks;

	public $content_hooks;

	public $loop_hooks;

	public $entry_hooks;

	public $post_hooks;

	public $comment_hooks;

	public $sidebar_hooks;

	public $footer_hooks;

	public $admin_hooks;

	/**
	 * Constructor.
	 *
	 * @since 1.8.0
	 *
	 */
	public function __construct() {

		// For backward compatibility
		define( 'SIMPLEHOOKS_SETTINGS_FIELD', $this->settings_field );

		$this->define_hooks();

	}

	/**
	 * Create the admin menu item and settings page.
	 *
	 * @since 2.2.0
	 */
	public function admin_menu() {

		$page_id = 'simplehooks';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Genesis - Simple Hooks', 'genesis-simple-hooks' ),
				'menu_title'  => __( 'Simple Hooks', 'genesis-simple-hooks' )
			)
		);

		$page_ops = array(
			'screen_icon' => 'plugins',
		);

		// Create the page
		$this->create( $page_id, $menu_ops, $page_ops, $this->settings_field, $this->get_default_settings() );

	}

	/**
	 * Load the necessary scripts for this admin page.
	 *
	 * @since 1.8.0
	 *
	 */
	public function scripts() {

		// Load parent scripts as well as Genesis admin scripts */
		parent::scripts();
		genesis_load_admin_js();

	}

	/**
	 * Save method. Allows for data manipulation and sanitization before saving.
	 *
	 * @since 2.2.0
	 */
	public function save( $newvalue, $oldvalue ) {

		foreach ( $newvalue as $hook => $data ) {

			if ( empty( $data ) ) {
				continue;
			}

			if ( ! current_user_can( 'unfiltered_html' ) ) {

				// kses post, if value of content changed.
				if ( $newvalue[ $hook ]['content'] !== $oldvalue[ $hook ]['content'] ) {
					$newvalue[ $hook ]['content'] = wp_kses_post( $data['content'] );
				}

				// Maintain php selection, since option is hidden for lower users.
				$newvalue[ $hook ]['php'] = $oldvalue[ $hook ]['php'];

			}

		}

		return $newvalue;

	}

	/**
	 * Assign all our hooks to class variables.
	 *
	 * @since 2.2.0
	 */
	public function define_hooks() {

		$this->wp_hooks = array(
			'wp_head' => array(
				'description' => __( 'Executes immediately before the closing <code>&lt;/head&gt;</code> tag.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_load_favicon', 'genesis_do_meta_pingback', 'genesis_paged_rel', 'genesis_meta_name', 'genesis_meta_url', 'genesis_header_scripts', 'genesis_custom_header_style' ),
			),
			'wp_footer' => array(
				'description' => __( 'Executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_footer_scripts' ),
			),
		);

		$this->document_hooks = array(
			'genesis_doctype' => array(
				'description' => __( 'Executes in the document head. Genesis uses this to output the doctype.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_doctype' ),
			),
			'genesis_title' => array(
				'description' => __( 'Executes in the document head. Genesis uses this to output the document title.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_title' ),
			),
			'genesis_meta' => array(
				'description' => __( 'Executes in the document head. Genesis uses this to output meta tags.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_seo_meta_description', 'genesis_seo_meta_keywords', 'genesis_robots_meta', 'genesis_responsive_viewport',  ),
			),
			'genesis_before' => array(
				'description' => __( 'Executes immediately after the opening <code>&lt;body&gt;</code> tag.', 'genesis-simple-hooks' ),
			),
			'genesis_after' => array(
				'description' => __( 'Executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'genesis-simple-hooks' ),
			),
		);

		$this->header_hooks = array(
			'genesis_before_header' => array(
				'description' => __( 'Executes immediately before the header.', 'genesis-simple-hooks' )
			),
			'genesis_header' => array(
				'description' => __( 'Genesis uses this hook to output the default header.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_header' ),
			),
			'genesis_header_right' => array(
				'description' => __( 'Executes inside the page header, immediately before the header widget area.', 'genesis-simple-hooks' ),
			),
			'genesis_after_header' => array(
				'description' => __( 'Executes immediately after the header.', 'genesis-simple-hooks' )
			),
			'genesis_site_title' => array(
				'description' => __( 'Executes inside the header. Genesis uses this hook to output the site title.' , 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_seo_site_title' ),
			),
			'genesis_site_description' => array(
				'description' => __( 'Executes inside the header. Genesis uses this hook to output the site description.' , 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_seo_site_description' ),
			),
		);

		$this->content_hooks = array(
			'genesis_before_content_sidebar_wrap' => array(
				'description' => __( 'Executes before the content-sidebar-wrap opening markup.', 'genesis-simple-hooks' ),
			),
			'genesis_after_content_sidebar_wrap' => array(
				'description' => __( 'Executes after the content-sidebar-wrap closing markup.', 'genesis-simple-hooks' ),
			),
			'genesis_before_content' => array(
				'description' => __( 'Executes before the content opening markup.', 'genesis-simple-hooks' ),
			),
			'genesis_after_content' => array(
				'description' => __( 'Executes after the content closing markup.', 'genesis-simple-hooks' ),
			),
		);

		$this->loop_hooks = array(
			'genesis_before_loop' => array(
				'description' => __( 'Executes before the loop.', 'genesis-simple-hooks' ),
			),
			'genesis_loop' => array(
				'description' => __( 'Executes in the content section. Genesis uses this hook to output the loop.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_loop' ),
			),
			'genesis_after_loop' => array(
				'description' => __( 'Executes after the loop.', 'genesis-simple-hooks' ),
			),
			'genesis_after_endwhile' => array(
				'description' => __( 'Executes after the WordPress loop endwhile.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_posts_nav' ),
			),
			'genesis_loop_else' => array(
				'description' => __( "Executes in the loop's else statement.", 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_noposts' ),
			),
			'genesis_reset_loops' => array(
				'description' => __( 'Executes if the loop actions are reset.', 'genesis-simple-hooks' ),
			),
		);

		/**
		 * HTML5 entry hooks
		 */
		$this->entry_hooks = array(
			'genesis_before_entry' => array(
				'description' => __( 'Executes before the entry.', 'genesis-simple-hooks' ),
			),
			'genesis_entry_header' => array(
				'description' => __( 'Executes as part of the entry. Genesis uses this hook to output the entry header.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_post_title' ),
			),
			'genesis_before_entry_content' => array(
				'description' => __( 'Executes before the entry content', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_post_content' ),
			),
			'genesis_entry_content' => array(
				'description' => __( 'Executes as part of the entry. Genesis uses this hook to output the entry content.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_post_content' ),
			),
			'genesis_after_entry_content' => array(
				'description' => __( 'Executes after the entry content', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_post_content' ),
			),
			'genesis_entry_footer' => array(
				'description' => __( 'Executes as part of the entry. Genesis uses this hook to output the entry footer.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_post_meta' ),
			),
			'genesis_after_entry' => array(
				'description' => __( 'Executes after the entry.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_adjacent_entry_nav', 'genesis_get_comments_template' ),
			),
		);

		/**
		 * xHTML post hooks
		 */
		$this->post_hooks = array(
			'genesis_before_post' => array(
				'description' => __( 'Executes before the post opening markup.', 'genesis-simple-hooks' ),
			),
			'genesis_after_post' => array(
				'description' => __( 'Executes after the post closing markup.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_author_box_single', 'genesis_get_comments_template' ),
			),
			'genesis_before_post_title' => array(
				'description' => __( 'Executes before the post title.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_post_format_image' ),
			),
			'genesis_post_title' => array(
				'description' => __( 'Executes as part of the post. Genesis uses this hook to output the post title.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_post_title' ),
			),
			'genesis_after_post_title' => array(
				'description' => __( 'Executes after the post title.', 'genesis-simple-hooks' ),
			),
			'genesis_before_post_content' => array(
				'description' => __( 'Executes before the post content.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_post_info' ),
			),
			'genesis_post_content' => array(
				'description' => __( 'Executes as part of the post. Genesis uses this hook to output the post content.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_post_image', 'genesis_do_post_content', 'genesis_do_post_permalink', 'genesis_do_post_content_nav' ),
			),
			'genesis_after_post_content' => array(
				'description' => __( 'Executes after the post content.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_post_meta' ),
			),
		);

		$this->comment_hooks = array(
			'genesis_before_comments' => array(
				'description' => __( 'Executes before the comments section opening markup.', 'genesis-simple-hooks' ),
			),
			'genesis_comments' => array(
				'description' => __( 'Executes after an entry. Genesis uses this hook to output the comments section.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_comments' ),
			),
			'genesis_list_comments' => array(
				'description' => __( 'Executes in the comments section. Genesis uses this hook to output the comment list.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_default_list_comments' ),
			),
			'genesis_after_comments' => array(
				'description' => __( 'Executes after the comments section closing markup.', 'genesis-simple-hooks' ),
			),
			'genesis_before_pings' => array(
				'description' => __( 'Executes before the pings section opening markup.', 'genesis-simple-hooks' ),
			),
			'genesis_pings' => array(
				'description' => __( 'Executes after an entry. Genesis uses this hook to output the pings section.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_pings' ),
			),
			'genesis_list_pings' => array(
				'description' => __( 'Executes in the pings section. Genesis uses this hook to output the ping list.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_default_list_pings' ),
			),
			'genesis_after_pings' => array(
				'description' => __( 'Executes after the ping section closing markup.', 'genesis-simple-hooks' ),
			),
			'genesis_before_comment' => array(
				'description' => __( 'Executes before a single comment.', 'genesis-simple-hooks' ),
			),
			'genesis_comment' => array(
				'description' => __( 'Executes in the comment list. Genesis uses this hook to output a single comment.', 'genesis-simple-hooks' ),
			),
			'genesis_after_comment' => array(
				'description' => __( 'Executes after a single comment.', 'genesis-simple-hooks' ),
			),
			'genesis_before_comment_form' => array(
				'description' => __( 'Executes before the comment form.', 'genesis-simple-hooks' ),
			),
			'genesis_comment_form' => array(
				'description' => __( 'Executes after the comment and ping list. Genesis uses this hook to output the comment form.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_comment_form' ),
			),
			'genesis_after_comment_form' => array(
				'description' => __( 'Executes after the comment form.', 'genesis-simple-hooks' ),
			),
		);

		$this->sidebar_hooks = array(
			'genesis_before_sidebar' => array(
				'description' => __( 'Executes before the primary sidebar.', 'genesis-simple-hooks' ),
			),
			'genesis_sidebar' => array(
				'description' => __( 'Executes after the content section in 2+ column layouts. Genesis uses this hook to output the primary sidebar.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_sidebar' ),
			),
			'genesis_after_sidebar' => array(
				'description' => __( 'Executes after the primary sidebar.', 'genesis-simple-hooks' ),
			),
			'genesis_before_sidebar_widget_area' => array(
				'description' => __( 'Executes before the primary sidebar widget area.', 'genesis-simple-hooks' ),
			),
			'genesis_after_sidebar_widget_area' => array(
				'description' => __( 'Executes after the primary sidebar widget area.', 'genesis-simple-hooks' ),
			),
			'genesis_before_sidebar_alt' => array(
				'description' => __( 'Executes before the secondary sidebar.', 'genesis-simple-hooks' ),
			),
			'genesis_sidebar_alt' => array(
				'description' => __( 'Executes after the primary sidebar in 3+ column layouts. Genesis uses this hook to output the secondary sidebar.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_sidebar_alt' ),
			),
			'genesis_after_sidebar_alt' => array(
				'description' => __( 'Executes after the secondary sidebar.', 'genesis-simple-hooks' ),
			),
			'genesis_before_sidebar_alt_widget_area' => array(
				'description' => __( 'Executes before the secondary sidebar widget area.', 'genesis-simple-hooks' ),
			),
			'genesis_after_sidebar_alt_widget_area' => array(
				'description' => __( 'Executes after the secondary sidebar widget area.', 'genesis-simple-hooks' ),
			),
		);

		$this->footer_hooks = array(
			'genesis_before_footer' => array(
				'description' => __( 'Executes before the site footer.', 'genesis-simple-hooks' ),
			),
			'genesis_footer' => array(
				'description' => __( 'Executes after the content and sidebars. Genesis uses this hook to output the site footer.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_do_footer' ),
			),
			'genesis_after_footer' => array(
				'description' => __( 'Executes after the site footer.', 'genesis-simple-hooks' ),
			),
		);

		$this->admin_hooks = array(
			'genesis_import_export_form' => array(
				'description' => __( 'Executes after the form on the the import/export screen.', 'genesis-simple-hooks' ),
			),
			'genesis_export' => array(
				'description' => __( 'Executes during the export function.', 'genesis-simple-hooks' ),
			),
			'genesis_import' => array(
				'description' => __( 'Executes during the import function.', 'genesis-simple-hooks' ),
			),
			'genesis_theme_settings_metaboxes' => array(
				'description' => __( 'Executes in the function that adds metaboxes to the theme settings screen.', 'genesis-simple-hooks' ),
			),
			'genesis_upgrade' => array(
				'description' => __( 'Executes after Genesis upgrades itself.', 'genesis-simple-hooks' ),
				'unhook'      => array( 'genesis_upgrade_redirect' ),
			),
		);

	}

	/**
	 * Get default settings (hooks + blank/false values).
	 *
	 * @since 2.2.0
	 */
	public function get_default_settings() {

		return array_fill_keys( $this->get_hooks(), array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ) );

	}

	/**
	 * Combine and return all hooks as an array.
	 *
	 * @since 2.2.0
	 */
	public function get_hooks() {

		// Merge all hooks arrays
		$hooks = array_merge(
			$this->wp_hooks,
			$this->document_hooks,
			$this->header_hooks,
			$this->content_hooks,
			$this->loop_hooks,
			$this->entry_hooks,
			$this->post_hooks,
			$this->comment_hooks,
			$this->sidebar_hooks,
			$this->footer_hooks,
			$this->admin_hooks
		);

		// Just the keys
		$hooks = array_keys( $hooks );

		return $hooks;

	}

	/**
	 * Generate form markup from an array of hooks.
	 *
	 * @since 2.2.0
	 */
	public function generate_form_markup_from_hooks( $hooks ) {

		foreach ( (array) $hooks as $hook => $info ) {

			// Check for existence in hooks array
			if ( ! in_array( $hook, $this->get_hooks() ) ) {
				continue;
			}

			printf( '<h4><code>%s</code> %s</h4>', esc_html( $hook ), __( 'Hook', 'genesis-simple-hooks' ) );
			printf( '<p><span class="description">%s</span></p>', esc_html( $info['description'] ) );

			if ( isset( $info['unhook'] ) ) {

				foreach ( (array) $info['unhook'] as $function ) {
					printf(
						'<input type="checkbox" name="%s" id="%s" value="%s" %s/>',
						$this->settings_field . "[{$hook}][unhook][]",
						$this->settings_field . "[{$hook}][unhook][]",
						$function,
						in_array( $function, (array) simplehooks_get_option( $hook, 'unhook' ) ) ? 'checked' : ''
					);
					printf(
						'<label for="%s">%s</label><br />',
						$this->settings_field . "[{$hook}][unhook][]",
						sprintf( __( 'Unhook <code>%s()</code> function from this hook?', 'genesis-simple-hooks' ), $function )
					);
				}

			}

			printf(
				'<p><textarea name="%s" cols="70" rows="5">%s</textarea></p>',
				$this->settings_field . "[{$hook}][content]",
				htmlentities( simplehooks_get_option( $hook, 'content' ), ENT_QUOTES, 'UTF-8' )
			);

			echo '<p>';

			printf(
				'<input type="checkbox" name="%1$s" id="%1$s" value="1" %2$s/> <label for="%1$s">%3$s</label><br />',
				$this->settings_field . "[{$hook}][shortcodes]",
				checked( 1, simplehooks_get_option( $hook, 'shortcodes' ), 0 ),
				__( 'Execute Shortcodes on this hook?', 'genesis-simple-hooks' )
			);

			if ( current_user_can( 'unfiltered_html' ) ) {
				printf(
					'<input type="checkbox" name="%1$s" id="%1$s" value="1" %2$s/> <label for="%1$s">%3$s</label><br />',
					$this->settings_field . "[{$hook}][php]",
					checked( 1, simplehooks_get_option( $hook, 'php' ), 0 ),
					__( 'Execute PHP on this hook?', 'genesis-simple-hooks' )
				);
			}

			echo '</p>';

			echo '<hr class="div" />';

		}

	}

	/**
 	 * Register meta boxes on the Simple Hooks Settings page.
 	 *
 	 * @since 1.8.0
 	 *
 	 */
	public function metaboxes() {

		add_meta_box( 'simplehooks-wp-hooks', __( 'WordPress Hooks', 'genesis-simple-hooks' ), array( $this, 'wp_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'simplehooks-document-hooks', __( 'Document Hooks', 'genesis-simple-hooks' ), array( $this, 'document_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'simplehooks-header-hooks', __( 'Header Hooks', 'genesis-simple-hooks' ), array( $this, 'header_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'simplehooks-content-hooks', __( 'Content Hooks', 'genesis-simple-hooks' ), array( $this, 'content_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'simplehooks-loop-hooks', __( 'Loop Hooks', 'genesis-simple-hooks' ), array( $this, 'loop_hooks_box' ), $this->pagehook, 'main' );

		if ( current_theme_supports( 'html5' ) )
			add_meta_box( 'simplehooks-entry-hooks', __( 'Entry Hooks', 'genesis-simple-hooks' ), array( $this, 'html5_entry_hooks_box' ), $this->pagehook, 'main' );
		else
			add_meta_box( 'simplehooks-post-hooks', __( 'Post/Page Hooks', 'genesis-simple-hooks' ), array( $this, 'post_hooks_box' ), $this->pagehook, 'main' );

		add_meta_box( 'simplehooks-comment-hooks', __( 'Comment Hooks', 'genesis-simple-hooks' ), array( $this, 'comment_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'simplehooks-sidebar-hooks', __( 'Sidebar Hooks', 'genesis-simple-hooks' ), array( $this, 'sidebar_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'simplehooks-footer-hooks', __( 'Footer Hooks', 'genesis-simple-hooks' ), array( $this, 'footer_hooks_box' ), $this->pagehook, 'main' );

	}

	public function wp_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->wp_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function internal_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->internal_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function document_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->document_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function header_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->header_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function content_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->content_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function loop_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->loop_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function html5_entry_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->entry_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function post_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->post_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function comment_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->comment_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function sidebar_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->sidebar_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

	public function footer_hooks_box() {

		$this->generate_form_markup_from_hooks( $this->footer_hooks );

		submit_button( __( 'Save Changes', 'genesis-simple-hooks' ), 'primary' );

	}

}
