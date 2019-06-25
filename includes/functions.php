<?php
/**
 * Additional Functions for Simple Hooks
 *
 * @package genesis-simple-hooks
 */

/**
 * Pull an Simple Hooks option from the database, return value
 *
 * @since 0.1
 *
 * @param Array $hook Hook.
 * @param Array $field Field.
 * @param Array $all All.
 */
function simplehooks_get_option( $hook = null, $field = null, $all = false ) {

	static $options = array();

	$options = $options ? $options : get_option( Genesis_Simple_Hooks()->settings_field );

	if ( $all ) {
		return $options;
	}

	if ( ! array_key_exists( $hook, (array) $options ) ) {
		return '';
	}

	$option = isset( $options[ $hook ][ $field ] ) ? $options[ $hook ][ $field ] : '';

	return wp_kses_stripslashes( wp_kses_decode_entities( $option ) );

}
/**
 * Pull an EasyHook option from the database, echo value
 *
 * @since 0.1
 *
 * @param Array $hook Hook.
 * @param Array $field Field.
 */
function simplehooks_option( $hook = null, $field = null ) {

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo simplehooks_get_option( $hook, $field );

}
