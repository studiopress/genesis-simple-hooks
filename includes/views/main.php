<?php screen_icon('themes'); ?>
<h2><?php _e('Genesis - Simple Sidebars', 'ss'); ?></h2>

<div id="col-container">

<div id="col-right">
<div class="col-wrap">

<h3><?php _e('Current Sidebars', 'ss'); ?></h3>
<table class="widefat tag fixed" cellspacing="0">
	<thead>
	<tr>
	<th scope="col" id="name" class="manage-column column-name"><?php _e('Name', 'ss'); ?></th>
	<th scope="col" class="manage-column column-slug"><?php _e('ID', 'ss'); ?></th>
	<th scope="col" id="description" class="manage-column column-description"><?php _e('Description', 'ss'); ?></th>
	</tr>
	</thead>

	<tfoot>
	<tr>
	<th scope="col" class="manage-column column-name"><?php _e('Name', 'ss'); ?></th>
	<th scope="col" class="manage-column column-slug"><?php _e('ID', 'ss'); ?></th>
	<th scope="col" class="manage-column column-description"><?php _e('Description', 'ss'); ?></th>
	</tr>
	</tfoot>

	<tbody id="the-list" class="list:tag">

		<?php $this->table_rows(); ?>

	</tbody>
</table>

</div>
</div><!-- /col-right -->

<div id="col-left">
<div class="col-wrap">


<div class="form-wrap">
<h3><?php _e('Add New Sidebar', 'ss'); ?></h3>

<form method="post" action="<?php echo admin_url( 'admin.php?page=simple-sidebars&amp;action=create' ); ?>">
<?php wp_nonce_field('simple-sidebars-action_create-sidebar'); ?>

<div class="form-field form-required">
	<label for="sidebar-name"><?php _e('Name', 'ss'); ?></label>
	<input name="new_sidebar[name]" id="sidebar-name" type="text" value="" size="40" aria-required="true" />
	<p><?php _e('A recognizable name for your new sidebar widget area', 'ss'); ?></p>
</div>

<div class="form-field">
	<label for="sidebar-id"><?php _e('ID', 'ss'); ?></label>
	<input name="new_sidebar[id]" id="sidebar-id" type="text" value="" size="40" />
	<p><?php _e('The unique ID is used to register the sidebar widget area', 'ss'); ?></p>
</div>

<div class="form-field">
	<label for="sidebar-description"><?php _e('Description', 'ss'); ?></label>
	<textarea name="new_sidebar[description]" id="sidebar-description" rows="5" cols="40"></textarea>
</div>

<p class="submit"><input type="submit" class="button" name="submit" id="submit" value="<?php _e('Add New Sidebar', 'ss'); ?>" /></p>
</form></div>

</div>
</div><!-- /col-left -->

</div><!-- /col-container -->