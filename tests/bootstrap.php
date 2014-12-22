<?php

define( 'WP_DEFAULT_THEME', 'maera' );
define( 'JETPACK_DEV_DEBUG', true);

$_tests_dir = getenv('WP_TESTS_DIR');
if ( !$_tests_dir ) $_tests_dir = '/tmp/wordpress-tests-lib';

// function _manually_load_plugin() {
// 	require dirname( __FILE__ ) . '/../functions.php';
// }
// tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require WP_PLUGIN_DIR . '/jetpack/jetpack.php';
require WP_PLUGIN_DIR . '/timber/timber.php';
require WP_PLUGIN_DIR . '/kirki/kirki.php';

require $_tests_dir . '/includes/bootstrap.php';
