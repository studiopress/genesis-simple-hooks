<?php
/**
 * Return the defaults array
 *
 * @since 0.1
 */
function simplehooks_defaults() {
	return array( // define our defaults
		
		##################### globals
		'wp_head' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'wp_footer' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		##################### internals
		'genesis_pre' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_pre_framework' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_init' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		##################### document head
		'genesis_title' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_meta' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		##################### structural
		'genesis_before' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_header' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_header' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_header' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_site_title' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_site_description' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_content_sidebar_wrap' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_content_sidebar_wrap' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_content' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_content' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_sidebar' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_sidebar' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_sidebar' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_sidebar_widget_area' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_sidebar_widget_area' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_sidebar_alt' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_sidebar_alt' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_sidebar_alt' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_sidebar_alt_widget_area' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_sidebar_alt_widget_area' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_footer' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_footer' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_footer' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		##################### loop
		'genesis_before_loop' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_loop' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_loop' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_after_endwhile' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_loop_else' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_post' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_post' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_post_title' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_post_title' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_post_title' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_post_content' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_post_content' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_post_content' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		##################### comments
		'genesis_before_comments' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_comments' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_list_comments' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_comments' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_pings' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_pings' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_list_pings' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_pings' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_comment' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_comment' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_comment' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_comment' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_comment' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		
		'genesis_before_comment_form' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_comment_form' => array('content' => '', 'php' => 0, 'shortcodes' => 0),
		'genesis_after_comment_form' => array('content' => '', 'php' => 0, 'shortcodes' => 0)
	
	);

}

/**
 * This registers the settings field and adds defaults to the options table
 */
add_action('admin_init', 'register_simplehooks_settings');
function register_simplehooks_settings() {
	register_setting(SIMPLEHOOKS_SETTINGS_FIELD, SIMPLEHOOKS_SETTINGS_FIELD);
	add_option(SIMPLEHOOKS_SETTINGS_FIELD, simplehooks_defaults(), '', 'yes');
}

/**
 * This is a necessary go-between to get our scripts and boxes loaded
 * on the theme settings page only, and not the rest of the admin
 */
add_action('admin_menu', 'simplehooks_settings_init', 15);
function simplehooks_settings_init() {
	global $_simplehooks_settings_pagehook;
	
	// Add "Design Settings" submenu
	$_simplehooks_settings_pagehook = add_submenu_page('genesis', __('Simple Hooks','simplehooks'), __('Simple Hooks','simplehooks'), 'manage_options', 'simplehooks', 'simplehooks_settings_admin');
	
	add_action('load-'.$_simplehooks_settings_pagehook, 'simplehooks_settings_scripts');
	add_action('load-'.$_simplehooks_settings_pagehook, 'simplehooks_settings_boxes');
}

function simplehooks_settings_scripts() {	
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
}

function simplehooks_settings_boxes() {
	global $_simplehooks_settings_pagehook;
	
	add_meta_box('simplehooks-wp-hooks', __('WordPress Hooks', 'simplehooks'), 'simplehooks_wp_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-document-hooks', __('Document Hooks', 'simplehooks'), 'simplehooks_document_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-header-hooks', __('Header Hooks', 'simplehooks'), 'simplehooks_header_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-content-hooks', __('Content Hooks', 'simplehooks'), 'simplehooks_content_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-loop-hooks', __('Loop Hooks', 'simplehooks'), 'simplehooks_loop_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-post-hooks', __('Post/Page Hooks', 'simplehooks'), 'simplehooks_post_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-comment-list-hooks', __('Comment List Hooks', 'simplehooks'), 'simplehooks_comment_list_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-ping-list-hooks', __('Ping List Hooks', 'simplehooks'), 'simplehooks_ping_list_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-comment-hooks', __('Single Comment Hooks', 'simplehooks'), 'simplehooks_comment_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-comment-form-hooks', __('Comment Form Hooks', 'simplehooks'), 'simplehooks_comment_form_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-sidebar-hooks', __('Sidebar Hooks', 'simplehooks'), 'simplehooks_sidebar_hooks_box', $_simplehooks_settings_pagehook, 'column1');
	add_meta_box('simplehooks-footer-hooks', __('Footer Hooks', 'simplehooks'), 'simplehooks_footer_hooks_box', $_simplehooks_settings_pagehook, 'column1');
}

/**
 * Tell WordPress that we want only 1 column available for our meta-boxes
 */
add_filter('screen_layout_columns', 'simplehooks_settings_layout_columns', 10, 2);
function simplehooks_settings_layout_columns($columns, $screen) {
	global $_simplehooks_settings_pagehook;
	if ($screen == $_simplehooks_settings_pagehook) {
		// This page should have 3 column options
		$columns[$_simplehooks_settings_pagehook] = 1;
	}
	return $columns;
}

/**
 * This function is what actually gets output to the page. It handles the markup,
 * builds the form, outputs necessary JS stuff, and fires <code>do_meta_boxes()</code>
 */
function simplehooks_settings_admin() { 
global $_simplehooks_settings_pagehook, $screen_layout_columns;

	$width = "width: 99%;";
	$hide2 = $hide3 = " display: none;";
	
?>	
	<div id="simplehooks" class="wrap genesis-metaboxes">
	<form method="post" action="options.php">
		
		<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
		<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
		<?php settings_fields(SIMPLEHOOKS_SETTINGS_FIELD); // important! ?>
		
		<?php screen_icon('plugins'); ?>
		<h2>
			<?php _e('Genesis - Simple Hooks', 'genesis'); ?>
			<input type="submit" class="button-primary add-new-h2" value="<?php _e('Save Changes', 'simplehooks') ?>" />
			<?php $reset_onclick = 'onclick="if ( confirm(\'' . esc_js( __('Are you sure you want to reset?', 'simplehooks') ) . '\') ) {return true;}return false;"'; ?>
			<input type="submit" <?php echo $reset_onclick; ?> class="button-highlighted add-new-h2" name="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset All', 'simplehooks'); ?>" />
		</h2>
		
		<?php
		if(genesis_get_option('reset', SIMPLEHOOKS_SETTINGS_FIELD)) {
			update_option(SIMPLEHOOKS_SETTINGS_FIELD, simplehooks_defaults());
			echo '<div id="message" class="updated" id="message"><p><strong>'.__('Modifications Reset', 'simplehooks').'</strong></p></div>';
		}
		elseif( isset($_REQUEST['updated']) && $_REQUEST['updated'] == 'true') {  
			echo '<div id="message" class="updated" id="message"><p><strong>'.__('Modifications Saved', 'simplehooks').'</strong></p></div>';
		}
		?>
		
		<div class="metabox-holder">
			<div class="postbox-container" style="<?php echo $width; ?>">
				<?php do_meta_boxes($_simplehooks_settings_pagehook, 'column1', null); ?>
			</div>
		</div>
		
	</form>
	</div>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $_simplehooks_settings_pagehook; ?>');
		});
		//]]>
	</script>

<?php
}