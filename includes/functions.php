<?php

/**
 * Pull an Simple Hooks option from the database, return value
 *
 * @since 0.1
 */
function simplehooks_get_option( $hook = null, $field = null, $all = false ) {

	static $options = array();

	$options = $options ? $options : get_option( Genesis_Simple_Hooks()->settings_field );

	if ( $all ) {
		return $options;
	}

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
