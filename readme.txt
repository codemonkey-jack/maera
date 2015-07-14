=== Maera ===
Contributors: aristath, fovoc
Tags: theme, twig
Donate link: http://maera.io/
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Change the way you work with themes using the Maera plugin.

== Description ==

Maera allows developers to work with template files in a way previously impossible in WordPress.

It includes a theme that is automatically activated once you install the plugin and allows you to create child themes of the "Maera" theme using twig for your template file instead of plain PHP.
You can also create "shells" as plugins, or choose one of the existing shells to use from https://wordpress.org/plugins/search.php?q=maera

== Installation ==

Install the theme following the instructions on https://codex.wordpress.org/Managing_Plugins#Installing_Plugins

Once you install the plugin, please follow the instructions on your dashboard to install the required plugins.
After that, visit your dashboard and you'll see it now uses the Maera theme.

You can install additional shells from https://wordpress.org/plugins/search.php?q=maera or theme your own site using our docs on http://maera.io

If you want to use a different theme then please deactivate the plugin.

== Changelog ==

More detail on the theme [commit page](https://github.com/presscodes/maera/commits).

= 1.2 =

* New: Kirki & Timber plugins as well as some Jetpack classes are now embedded. Installing external plugins is no longer required for the core theme.
* New: Easy-Digital-Downloads integration
* New: WooCommerce integration
* Fix: Core shell CSS tweaks
* Fix: Change sr-only class to screen-reader-text
* New: Implemented a class autoloader
* Tweak: Deactivate auto-installer
* Tweak: Use dashicons instead of elusive icons
* Tweak: Keep pagination links as anchors
* Fix: Properly use add_query_arg()
* Tweak: Comments template
* Fix: fix incorrect path URLs
* Tweak: better template-hierarchy.php
* Tweak: WordPress coding standards
* Fix: Other minor bugfixes
* Tweak: Add before_widget & after_widget to the logo widget
* Fix: Align left images on the extended-posts widget

= 1.1.1 =

* Fix: Added a default license key
* New: More OOP design
* New: Change the Timber cache folder (soon to be supported by Timber core)
* Fix: Undefined index messages on the admin settings screen
* New: Introducing Maera_Widget_Dropdown_Class.php
* Fix: Move core styles to style.css

= 1.1.0 =

* Fix: Most methods are not non-static.
* New: The theme is now more OOP.
* New: You can now choose a caching method from the admin options.
* Fix: Disabling file caches (there were issues on sites hosted on WPEngine).
* Fix: Updating the Maera_Logo_Widget rendering method.
* Fix: Typo preventing proper template rendering for tag archives.
* Fix: Added check for MAERA_VERSION constant.
* Fix: Code cleanup.
* New: Introducing a Maera_Helper class.
* Fix: Move file requires outside the main Maera object.
* Fix: Moved test_missing method to the Maera_Required_Plugins class.
* Fix: Moved get_search_form method to the Maera_Template class.
* Fix: Moved body_class method to the Maera_Styles class.
* Fix: Renamed the Maera_Template->main method to Maera_Template->render.
* New: Introducing new "screen-reader-text" classes as per https://make.wordpress.org/accessibility/2015/01/27/test-chat-summary-januari-26/

= 1.0.3 =

* Fix: Jetpack was being forced to Dev mode some hosts even when dev mode was disabled from the theme options dashboard.

= 1.0.2 =

* Fix: remote-installer scripts were not loading properly

= 1.0.1 =

* Fix: typo preventing automatic updates

= 1.0.0 =

* Initial release
