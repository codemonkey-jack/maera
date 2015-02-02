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
