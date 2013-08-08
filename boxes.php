<?php
/**
 * This next section defines functions that contain the content of the "boxes" that will be
 * output by default on the "SEO Settings" page. There's a bunch of them.
 *
 */

function simplehooks_wp_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'wp_head',
		'desc' => __( 'This hook executes immediately before the closing <code>&lt;/head&gt;</code> tag.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'wp_footer',
		'desc' => __( 'This hook executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_document_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_title',
		'desc' => __( 'This hook executes between the main document <code>&lt;title&gt;&lt;/title&gt;</code> tags.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_meta',
		'desc' => __( 'This hook executes in the document <code>&lt;head&gt;</code>.<br /> It is commonly used to output <code>META</code> information about the document.', 'simplehooks' ),
		'unhook' => array( 'genesis_load_favicon' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_before',
		'desc' => __( 'This hook executes immediately after the opening <code>&lt;body&gt;</code> tag.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after',
		'desc' => __( 'This hook executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_header_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_header',
		'desc' => __( 'This hook executes immediately before the header (outside the <code>#header</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_header',
		'desc' => __( 'This hook outputs the default header (the <code>#header</code> div)', 'simplehooks' ),
		'unhook' => array( 'genesis_do_header' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_header',
		'desc' => __( 'This hook executes immediately after the header (outside the <code>#header</code> div).', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_content_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_content_sidebar_wrap',
		'desc' => __( 'This hook executes immediately before the div block that wraps the content and the primary sidebar (outside the <code>#content-sidebar-wrap</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_content_sidebar_wrap',
		'desc' => __( 'This hook executes immediately after the div block that wraps the content and the primary sidebar (outside the <code>#content-sidebar-wrap</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_content',
		'desc' => __( 'This hook executes immediately before the content column (outside the <code>#content</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_content',
		'desc' => __( 'This hook executes immediately after the content column (outside the <code>#content</code> div).', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_loop_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_loop',
		'desc' => __( 'This hook executes immediately before all loop blocks.<br /> Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_loop',
		'desc' => __( 'This hook executes both default and custom loops.', 'simplehooks' ),
		'unhook' => array( 'genesis_do_loop' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_loop',
		'desc' => __( 'This hook executes immediately after all loop blocks.<br /> Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_endwhile',
		'desc' => __( 'This hook executes after the <code>endwhile;</code> statement.', 'simplehooks' ),
		'unhook' => array( 'genesis_posts_nav' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_loop_else',
		'desc' => __( 'This hook executes after the <code>else :</code> statement in all loop blocks. The content attached to this hook will only display if there are no posts available when a loop is executed.', 'simplehooks' ),
		'unhook' => array( 'genesis_do_noposts' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_post_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_post',
		'desc' => __( 'This hook executes before each post in all loop blocks (outside the <code>post_class()</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_post',
		'desc' => __( 'This hook executes after each post in all loop blocks (outside the <code>post_class()</code> div).', 'simplehooks' ),
		'unhook' => array( 'genesis_do_author_box' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_post_title',
		'desc' => __( 'This hook executes immediately before each post/page title within the loop.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_post_title',
		'desc' => __( 'This hook outputs the post/page title.', 'simplehooks' ),
		'unhook' => array( 'genesis_do_post_title' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_post_title',
		'desc' => __( 'This hook executes immediately after each post/page title within the loop.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_post_content',
		'desc' => __( 'This hook executes immediately before the <code>genesis_post_content</code> hook for each post/page within the loop.', 'simplehooks' ),
		'unhook' => array( 'genesis_post_info' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_post_content',
		'desc' => __( 'This hook outputs the content of the post/page, by default.', 'simplehooks' ),
		'unhook' => array( 'genesis_do_post_image', 'genesis_do_post_content' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_post_content',
		'desc' => __( 'This hook executes immediately after the <code>genesis_post_content</code> hook for each post/page within the loop.', 'simplehooks' ),
		'unhook' => array( 'genesis_post_meta' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_comment_list_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_comments',
		'desc' => __( 'This hook executes immediately before the comments block (outside the <code>#comments</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_comments',
		'desc' => __( 'This hook outputs the comments block, including the <code>#comments</code> div.', 'simplehooks' ),
		'unhook' => array( 'genesis_do_comments' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_list_comments',
		'desc' => __( 'This hook executes inside the comments block, inside the <code>.comment-list</code> OL. By default, it outputs a list of comments associated with a post via the <code>genesis_default_list_comments()</code> function.', 'simplehooks' ),
		'unhook' => array( 'genesis_default_list_comments' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_comments',
		'desc' => __( 'This hook executes immediately after the comments block (outside the <code>#comments</code> div).', 'simplehooks' )
	) );

}

function simplehooks_ping_list_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_pings',
		'desc' => __( 'This hook executes immediately before the pings block (outside the <code>#pings</code> div).', 'simplehooks' ),
		'unhook' => array( 'genesis_do_pings' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_pings',
		'desc' => __( 'This hook outputs the pings block, including the <code>#pings</code> div.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_list_pings',
		'desc' => __( 'This hook executes inside the pings block, inside the <code>.ping-list</code> OL. By default, it outputs a list of pings associated with a post via the <code>genesis_default_list_pings()</code> function.', 'simplehooks' ),
		'unhook' => array( 'genesis_default_list_pings' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_pings',
		'desc' => __( 'This hook executes immediately after the pings block (outside the <code>#pings</code> div).', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_comment_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_comment',
		'desc' => __( 'This hook executes immediately before each individual comment (inside the <code>.comment</code> list item).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_comment',
		'desc' => __( 'This hook executes immediately after each individual comment (inside the <code>.comment</code> list item).', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_comment_form_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_comment_form',
		'desc' => __( 'This hook executes immediately before the comment form, outside the <code>#respond</code> div.', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_comment_form',
		'desc' => __( 'This hook outputs the entire comment form, including the <code>#respond</code> div.', 'simplehooks' ),
		'unhook' => array( 'genesis_do_comment_form' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_comment_form',
		'desc' => __( 'This hook executes immediately after the comment form, outside the <code>#respond</code> div.', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_sidebar_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_sidebar',
		'desc' => __( 'This hook executes immediately before the primary sidebar column (outside the <code>#sidebar</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_sidebar',
		'desc' => __( 'This hook outputs the content of the primary sidebar, including the widget area output.', 'simplehooks' ),
		'unhook' => array( 'genesis_do_sidebar' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_sidebar',
		'desc' => __( 'This hook executes immediately after the primary sidebar column (outside the <code>#sidebar</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_sidebar_widget_area',
		'desc' => __( 'This hook executes immediately before the primary sidebar widget area (inside the <code>#sidebar</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_sidebar_widget_area',
		'desc' => __( 'This hook executes immediately after the primary sidebar widget area (inside the <code>#sidebar</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_sidebar_alt',
		'desc' => __( 'This hook executes immediately before the alternate sidebar column (outside the <code>#sidebar-alt</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_sidebar_alt',
		'desc' => __( 'This hook outputs the content of the secondary sidebar, including the widget area output.', 'simplehooks' ),
		'unhook' => array( 'genesis_do_sidebar_alt' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_sidebar_alt',
		'desc' => __( 'This hook executes immediately after the alternate sidebar column (outside the <code>#sidebar-alt</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_sidebar_alt_widget_area',
		'desc' => __( 'This hook executes immediately before the alternate sidebar widget area (inside the <code>#sidebar-alt</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_sidebar_alt_widget_area',
		'desc' => __( 'This hook executes immediately after the alternate sidebar widget area (inside the <code>#sidebar-alt</code> div).', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

function simplehooks_footer_hooks_box() {

	simplehooks_form_generate( array(
		'hook' => 'genesis_before_footer',
		'desc' => __( 'This hook executes immediately before the footer (outside the <code>#footer</code> div).', 'simplehooks' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_footer',
		'desc' => __( 'This hook, by default, outputs the content of the footer (inside the <code>#footer</code> div).', 'simplehooks' ),
		'unhook' => array( 'genesis_do_footer' )
	) );

	simplehooks_form_generate( array(
		'hook' => 'genesis_after_footer',
		'desc' => __( 'This hook executes immediately after the footer (outside the <code>#footer</code> div).', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}

/* Sample box and box content
function simplehooks__hooks_box() {

	simplehooks_form_generate(array(
		'hook' => 'genesis_',
		'desc' => __( '', 'simplehooks' )
	) );

	submit_button( __( 'Save Changes', 'simplehooks' ), 'primary' );

}
*/