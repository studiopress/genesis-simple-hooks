=== Plugin Name ===
Contributors: nathanrice, studiopress
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5553118
Tags: hooks, genesis, genesiswp, studiopress
Requires at least: 3.9.2
Tested up to: 4.3.1
Stable tag: 2.1.2

This plugin creates a new Genesis settings page that allows you to insert code (HTML, Shortcodes, and PHP), and attach it to any of the 50+ action hooks throughout the Genesis Theme Framework, from StudioPress.

== Description ==

This plugin creates a new Genesis settings page that allows you to insert code (HTML, Shortcodes, and PHP), and attach it to any of the 50+ action hooks throughout the Genesis Theme Framework, from StudioPress.

Instead of the sometimes tedious and unfamiliar process of creating functions in your theme files, this plugin gives you an attractive, easy to use interface for modifying your Genesis theme via the hook system. The plugin accepts HTML, Shortcodes, and PHP and gives you access to all 50+ hooks built into the Genesis theme, and a few built-in WordPress hooks as well.

== Installation ==

1. Upload the entire `genesis-simple-hooks` folder to the `/wp-content/plugins/` directory
1. DO NOT change the name of the `genesis-simple-hooks` folder
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Find a hook that you'd like to use (they're grouped together logically)
1. Insert the code you'd like to execute on that hook
1. Choose whether or not to execute Shortcodes and PHP on that hook
1. Save the changes

== Frequently Asked Questions ==

= What are Shortcodes? =

Check out the [Shortcodes API](http://codex.wordpress.org/Shortcode_API) for an explanation.

= My PHP isn't working =

Make sure the checkbox that says "Execute PHP on this hook" is checked.

If so, be sure to wrap any PHP code in `<?php ?>` tags. That's how the system recognizes code that needs to be executed as PHP.

= The plugin won't activate =

You must have Genesis or a Genesis child theme installed and activated on your site.

== Code Snippets ==

The most common request from Genesis users is how to properly modify their footer, post-info, and post-meta text. Here are some code snippets that might prove helpful in doing this:

**Modifying the post-info**
`
<div class="post-info">
	<span class="time"><?php the_time('F j, Y'); ?></span> <span class="author">by <?php the_author_posts_link(); ?></span> <span class="post-comments"><a href="<?php the_permalink(); ?>#respond"><?php comments_number('Leave a Comment', '1 Comment', '% Comments'); ?></a></span> <a class="post-edit-link"><?php edit_post_link('(Edit)', '', ''); ?></a>   
</div>
`

**Modifying the post-meta**
`
<div class="post-meta">
	<span class="categories">Filed under: <?php the_category(', ') ?></span>  <span class="tags">Tagged with <?php the_tags('') ?></span>      
</div>
`

**Modifying the Footer**
`
<div class="gototop">
	<p><a href="#wrap" rel="nofollow">Return to top of page</a></p>
</div>
<div class="creds">
	<p>Copyright &copy; <?php echo date('Y'); ?> &middot; <a href="http://www.studiopress.com/themes/genesis" title="Genesis Theme Framework">Genesis Theme Framework</a> by <a href="http://www.studiopress.com/">StudioPress</a> &middot; <a href="http://wordpress.org/" title="WordPress">WordPress</a> &middot; <?php wp_loginout(); ?></p>
</div>
`

*Note: You must have the `Execute PHP on this hook` option selected in order to use template tags*

== Changelog ==

= 2.1.2 =
* Load textdomain
* Add plugin header i18n

= 2.1.1 =
* Generate POT file.

= 2.1.0 =
* Increased requirement to Genesis 2.1.0.
* Site title and description hooks.
* Fixed outdated hook descriptions.

= 2.0.1 =
* Genesis 2.0 favicon unhook location fix.

= 2.0.0 =
* Updated to use new entry hooks in Genesis 2.0.
* Remove unused boxes.php file.

= 1.8.0.2 =
* Fixed yet another fatal error but for people using less than Genesis 1.8.0. It should now deactivate gracefully.

= 1.8.0.1 =
* Removed an unnecessary version compare check that was causing some fatal errors.

= 1.8.0 =
* Increased requirement to Genesis 1.8.0.
* Switched over to the Genesis 1.8 admin menu class to build admin menu.

= 1.7.1 =
* Increased requirement to Genesis 1.7.1
* Fixed display issues in the admin screen
* Added new hooks to the defaults array
* Whitespace, standards, and documentation

= 1.6 =
* Increased requirement to Genesis 1.6
* Fixed bug with things not unhooking

= 1.4 =
* Increased requirement to Genesis 1.4
* Fixed undefined index bug in functions.php

= 1.3.1.1 =
* Reduce requirement to Genesis 1.3
* Increase requirement to WordPress 3.0

= 1.3.1 =
* Bump to match Genesis version
* Require Genesis 1.3.1
* Added new unhook options
* Fixed bug with foreign language compatibility

= 1.2 =
* Bump to match Genesis version
* Require Genesis 1.2.1
* Update hooks for Genesis 1.2.1

= 0.9 =
* Add new hooks, remove deprecated hooks
* Fix textarea bug with HTML entities
* Bump to pre-release 0.9 branch

= 0.1 =
* Initial Release








