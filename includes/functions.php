<?php

/**
 * Pull an Simple Hooks option from the database, return value
 *
 * @since 0.1
 */
function simplehooks_get_option( $hook = null, $field = null, $all = false ) {

	static $options = array();

	$options = $options ? $options : get_option( SIMPLEHOOKS_SETTINGS_FIELD );

	if ( $all )
		return $options;

	if ( ! array_key_exists( $hook, (array) $options ) )
				return '';

	$option = isset( $options[$hook][$field] ) ? $options[$hook][$field] : '';

	return wp_kses_stripslashes( wp_kses_decode_entities( $option ) );

}
/**
 * Pull an EasyHook option from the database, echo value
 *
 * @since 0.1
 */
function simplehooks_option($hook = null, $field = null) {

	echo simplehooks_get_option( $hook, $field );

}

/**
 * This function generates the form code to be used in the metaboxes
 *
 * @since 0.1
 */
function simplehooks_form_generate( $args = array() ) {

?>

	<h4><code><?php echo $args['hook']; ?></code> <?php _e( 'Hook', 'genesis-simple-hooks' ); ?></h4>
	<p><span class="description"><?php echo $args['desc']; ?></span></p>

	<?php
		if ( isset( $args['unhook'] ) ) {

			foreach ( (array) $args['unhook'] as $function ) {
			?>

				<input type="checkbox" name="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]" id="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]" value="<?php echo $function; ?>" <?php if ( in_array( $function, (array) simplehooks_get_option( $args['hook'], 'unhook' ) ) ) echo 'checked'; ?> /> <label for="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]"><?php printf( __( 'Unhook <code>%s()</code> function from this hook?', 'genesis-simple-hooks' ), $function ); ?></label><br />

			<?php
			}

		}
	?>

	<p><textarea name="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][content]" cols="70" rows="5"><?php echo htmlentities( simplehooks_get_option( $args['hook'], 'content' ), ENT_QUOTES, 'UTF-8' ); ?></textarea></p>

	<p>
		<input type="checkbox" name="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]" id="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]" value="1" <?php checked( 1, simplehooks_get_option( $args['hook'], 'shortcodes' ) ); ?> /> <label for="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]"><?php _e( 'Execute Shortcodes on this hook?', 'genesis-simple-hooks' ); ?></label><br />
		<input type="checkbox" name="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]" id="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]" value="1" <?php checked( 1, simplehooks_get_option( $args['hook'], 'php' ) ); ?> /> <label for="<?php echo SIMPLEHOOKS_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]"><?php _e( 'Execute PHP on this hook?', 'genesis-simple-hooks' ); ?></label>
	</p>

	<hr class="div" />

<?php
}