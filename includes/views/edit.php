<?php
if ( array_key_exists( $_REQUEST['id'], (array) $_sidebars ) ) {
	$_sidebar = stripslashes_deep( $_sidebars[$_REQUEST['id']] );
} else {
	wp_die( __( 'Nice try, partner. But that sidebar doesn\'t exist. Click back and try again.', 'ss' ) );
}

screen_icon('themes'); ?>
<h2><?php _e('Edit Sidebar', 'ss'); ?></h2>

<form method="post" action="<?php echo admin_url( 'admin.php?page=simple-sidebars&amp;action=edit' ); ?>">
<?php wp_nonce_field('simple-sidebars-action_edit-sidebar'); ?>

<table class="form-table">

	<tr class="form-field">
		<th scope="row" valign="top"><label for="edit_sidebar[name]"><?php _e('Name', 'ss'); ?></label></th>
		<td><input name="edit_sidebar[name]" id="edit_sidebar[name]" type="text" value="<?php echo esc_html( $_sidebar['name'] ); ?>" size="40" />
		<p class="description"><?php _e('A recognizable name for your new sidebar widget area', 'ss'); ?></p></td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="edit_sidebar[id]"><?php _e('ID', 'ss'); ?></label></th>
		<td>
		<input type="text" value="<?php echo esc_html( $_REQUEST['id'] ); ?>" size="40" disabled="disabled" />
		<input name="edit_sidebar[id]" id="edit_sidebar[id]" type="hidden" value="<?php echo esc_html( $_REQUEST['id'] ); ?>" size="40" />
		<p class="description"><?php _e('The unique ID is used to register the sidebar widget area (cannot be changed)', 'ss'); ?></p></td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="edit_sidebar[description]"><?php _e('Description', 'ss'); ?></label></th>
		<td><textarea name="edit_sidebar[description]" id="edit_sidebar[description]" rows="3" cols="50" style="width: 97%;"><?php echo esc_html( $_sidebar['description'] ); ?></textarea></td>
	</tr>

</table>

<p class="submit"><input type="submit" class="button-primary" name="submit" value="<?php _e('Update', 'ss'); ?>" /></p>

</form>