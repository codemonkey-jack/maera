=== Maera ===

[Maera](https://press.codes/downloads/maera/) is a developer-friendly theme that allows you to quickly prototype sites and extend it with your own custom plugins.

== Instructions ==

Maera includes a blogging shell. You can get more shells from https://press.codes/

== Limitations ==

Maera Requires you to install these plugins:
* [Timber Library](https://wordpress.org/plugins/timber-library/)
* [Jetpack](https://wordpress.org/plugins/jetpack/)
* [Kirki](https://wordpress.org/plugins/kirki/)

Additional plugins may depend on other plugins and in that case you will be notified from your dashboard

== Credits ==

* [_s](https://github.com/Automattic/_s) theme by Automattic, and released under the GPL v2.0.
* [html5shiv](http://code.google.com/p/html5shiv/) script by Remy Sharp, and is dual-licensed under the MIT or GPL Version 2 licenses.

== Browser Support ==

Chrome, Firefox, Safari and IE10+ are supported. IE7, IE8 and IE9 are not supported.

== Changelog ==

More detail on the theme [commit page](https://github.com/presscodes/maera/commits).

## 1.2

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

## 1.1.1

* Fix: Added a default license key
* New: More OOP design
* New: Change the Timber cache folder (soon to be supported by Timber core)
* Fix: Undefined index messages on the admin settings screen
* New: Introducing Maera_Widget_Dropdown_Class.php
* Fix: Move core styles to style.css

## 1.1.0

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

## 1.0.3

* Fix: Jetpack was being forced to Dev mode some hosts even when dev mode was disabled from the theme options dashboard.

## 1.0.2

* Fix: remote-installer scripts were not loading properly

## 1.0.1

* Fix: typo preventing automatic updates

## 1.0.0

* Initial release
