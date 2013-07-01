=== Plugin Name ===
Contributors: nathanrice, wpmuguru
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5553118
Tags: hooks, genesis, genesiswp, studiopress
Requires at least: 3.3
Tested up to: 3.4.1
Stable tag: 1.0.0

This plugin allows you to create multiple, dynamic widget areas, and assign those widget areas to sidebar locations within the Genesis Theme Framework on a per post, per page, or per tag/category archive basis.

== Description ==

This plugin allows you to create multiple, dynamic widget areas, and assign those widget areas to sidebar locations within the Genesis Theme Framework on a per post, per page, or per tag/category archive basis.

Creating widget areas programmatically, then using conditional logic to properly assign them to sidebar locations can be a complex task for a beginner. This plugin allows you to do all this from a simple administration menu, and assign widget areas to sidebar locations with simple drop-down menus within the post/page edit screens, or when editing a tag or category.

== Installation ==

1. Upload the entire `genesis-simple-sidebars` folder to the `/wp-content/plugins/` directory
1. DO NOT change the name of the `genesis-simple-sidebars` folder
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to the `Genesis > Simple Sidebars` menu
1. Create as many new sidebar widget areas as you need
1. Choose the widget area you want to display by choosing it from the drop-down menu in the post/page or category/tag edit screen.

== Frequently Asked Questions ==

= Can I assign widget areas to locations other than the sidebars? =

No. You can only assign them to the primary and secondary sidebars, using the plugin.

However, once a widget area has been created, you can use hooks to programmatically display those widget areas throughout the theme. But if you're going to do that, it's very unlikely that you would want to use the plugin to create the widget areas. You might as well just create the widget areas programmatically too.

= Does this plugin give me the option of creating an entirely NEW sidebar? =

Not in the way you're probably thinking. The markup surrounding the widget area never changes. The only thing that changes is the dynamic content that displays within the pre-existing sidebar locations.

== Changelog ==

= 0.1 =
* Initial Alpha Release

= 0.9 =
* Fixed "is not array" errors reported by users
* Added nonce verification for security purposes
* Added error and success messages
* Bump to pre-release 0.9 branch

= 0.9.1 =
* Added support for custom post types

= 0.9.2 =
* Added support for custom taxonomies
* Added translation support
* bug fix to prevent invalid sidebar creation

= 0.9.2.1 =
* Restore default tag/category support
* Default custom taxonomy support to on for public taxonomies
* Remove secondary selection when no 3 column layouts are enabled

= 1.0.0 =
* Increase requirement to WordPress 3.3 and Genesis 1.8.0
* Switch to Genesis Admin class to build admin menu.