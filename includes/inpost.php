<?php
/**
 * This bit of code registers the meta box on posts/pages,
 * so that users can choose what sidebar to use.
 */
add_action('admin_menu', 'ss_add_inpost_metabox');
function ss_add_inpost_metabox() {

	foreach ( (array)get_post_types( array( 'public' => true ) ) as $type ) {

		if ( post_type_supports( $type, 'genesis-simple-sidebars' ) || $type == 'post' || $type == 'page' ) {
			add_meta_box('ss_inpost_metabox', __('Sidebar Selection', 'ss'), 'ss_inpost_metabox', $type, 'side', 'low');
		}

	}

}

function ss_inpost_metabox() {

	$_sidebars = stripslashes_deep( get_option( SS_SETTINGS_FIELD ) );

?>

	<input type="hidden" name="ss_inpost_nonce" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" />

	<p>
		<label class="howto" for="_ss_sidebar"><span><?php _e('Primary Sidebar', 'ss'); ?><span></label>
		<select name="_ss_sidebar" id="_ss_sidebar" style="width: 99%">
			<option value=""><?php _e('Default', 'ss'); ?></option>
			<?php
			foreach ( (array)$_sidebars as $id => $info ) {
				printf( '<option value="%s" %s>%s</option>', esc_html( $id ), selected( $id, genesis_get_custom_field('_ss_sidebar'), false), esc_html( $info['name'] ) );
			}
			?>
		</select>
	</p>
<?php
	// don't show the option if there are no 3 column layouts registered
	if ( ! ss_has_3_column_layouts() )
		return;
?>
	<p>
		<label class="howto" for="_ss_sidebar_alt"><span><?php _e('Secondary Sidebar', 'ss'); ?><span></label>
		<select name="_ss_sidebar_alt" id="_ss_sidebar_alt" style="width: 99%">
			<option value=""><?php _e('Default', 'ss'); ?></option>
			<?php
			foreach ( (array)$_sidebars as $id => $info ) {
				printf( '<option value="%s" %s>%s</option>', esc_html( $id ), selected( $id, genesis_get_custom_field('_ss_sidebar_alt'), false), esc_html( $info['name'] ) );
			}
			?>
		</select>
	</p>

<?php
}

/**
 * This bit of code saves the sidebars chosen as post meta.
 */
add_action('save_post', 'ss_inpost_metabox_save', 1, 2);
function ss_inpost_metabox_save( $post_id, $post ) {

	//	verify the nonce
	if ( !isset($_POST['ss_inpost_nonce']) || !wp_verify_nonce( $_POST['ss_inpost_nonce'], plugin_basename(__FILE__) ) )
		return $post->ID;

	//	don't try to save the data under autosave, ajax, or future post.
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if ( defined('DOING_AJAX') && DOING_AJAX ) return;
	if ( defined('DOING_CRON') && DOING_CRON ) return;

	//	is the user allowed to edit the post or page?
	if ( ( 'page' == $_POST['post_type'] && !current_user_can('edit_page', $post->ID) ) || !current_user_can('edit_post', $post->ID ) )
		return $post->ID;

	$_sidebars = array(
		'_ss_sidebar' => $_POST['_ss_sidebar'],
		'_ss_sidebar_alt' => $_POST['_ss_sidebar_alt']
	);

	//	store the custom fields
	foreach ( $_sidebars as $key => $value ) {

		if ( $post->post_type == 'revision' ) return; // don't try to store data during revision save

		if ( $value ) {
			//	save/update
			update_post_meta($post->ID, $key, $value);
		} else {
			//	delete if blank
			delete_post_meta($post->ID, $key);
		}

	}

}