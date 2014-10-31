<?php

/**
 * Build an array of all our internaionalization strings here.
 * This makes it more convenient to handle and internationalization should be a lot more intuitive.
 */
function maera_i18n_strings() {

	$textdomain = 'maera';

	$strings = array(
		'day_s'     => __( 'Day: %s', $textdomain ),
		'month_s'   => __( 'Month: %s', $textdomain ),
		'year_s'    => __( 'Year: %s', $textdomain ),
		'author_s'  => __( 'Author: %s', $textdomain ),
		'asides'    => __( 'Asides', $textdomain ),
		'galleries' => __( 'Galleries', $textdomain ),
		'images'    => __( 'Images', $textdomain),
		'videos'    => __( 'Videos', $textdomain ),
		'quotes'    => __( 'Quotes', $textdomain ),
		'links'     => __( 'Links', $textdomain ),
		'statuses'  => __( 'Statuses', $textdomain ),
		'audios'    => __( 'Audios', $textdomain ),
		'chats'     => __( 'Chats', $textdomain ),
		'archives'  => __( 'Archives', $textdomain ),

		'searchresultsfor' => __( 'Search results for ', $textdomain ),

		'browse'              => __( 'Browse:', $textdomain ),
		'home'                => __( 'Home', $textdomain ),
		'search'              => __( 'Search results for "%s"', $textdomain ),
		'error_404'           => __( '404 Not Found', $textdomain ),
		'paged'               => __( 'Page %d', $textdomain ),
		'archives'            => __( 'Archives', $textdomain ),
		'archive_minute_hour' => __( 'g:i a', $textdomain ),
		'archive_minute'      => __( 'Minute %d', $textdomain ),
		'archive_hour'        => __( 'g a', $textdomain ),
		'archive_day'         => __( 'd', $textdomain ),
		'archive_week'        => __( 'Week %d', $textdomain ),
		'archive_month'       => __( 'F', $textdomain ),
		'archive_year'        => __( 'Y', $textdomain ),
		'edit'                => __( 'Edit', $textdomain ),
		'split'               => __( 'Split', $textdomain ),
		'merge'               => __( 'Merge', $textdomain ),

		'customwidgetareas'     => __( 'Custom Widget Areas', $textdomain ),
		'numberofwidgetareasin' => __( 'Number of widget areas in %s', $textdomain ),

		'maerathemeoptions' => __( 'Maera Theme Options', $textdomain ),

		'primarysidebar'   => __( 'Primary Sidebar', $textdomain ),
		'secondarysidebar' => __( 'Secondary Sidebar', $textdomain ),

		'nothingfound'      => __( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', $textdomain ),
		'skiptomaincontent' => __( 'Skip to main content', $textdomain ),
		'sorrynocontent'    => __( 'Sorry, no content', $textdomain ),
		'comments'          => __( 'Comments', $textdomain ),
		'pages'             =>__( 'Pages:', $textdomain ),
		'under'             => __( 'under', $textdomain ),
		'by'                => __( 'by', $textdomain ),
		'comments_lower'    => __( 'comments', $textdomain ),
		'with'              => __( 'with', $textdomain ),

		'cancelorclick'    => __( "'Cancel' to stop, 'OK' to update.", $textdomain ),
		'maeralatestposts' => __( 'Maera Latest Posts', $textdomain ),
		'readmore'         => __( 'Read More', $textdomain ),
		'maeralogo'        => __( 'Maera Logo', $textdomain ),
		'maeralogowidget'  => __( 'Maera logo widget.', $textdomain )
	);
}

global $maera_i18n;
$maera_i18n = maera_i18n_strings();
