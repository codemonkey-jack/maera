<?php
/**
 * Utility functions
 */

function is_element_empty( $element ) {
	$element = trim( $element );
	return empty( $element ) ? false : true;
}

/**
 * Transliteration for css classes etc.
 *
 * @param string $str
 * @param array $options
 * @return string
 */
function maera_transliterate( $str ) {

	// Only process this if the mb_convert_encoding function is installed.
	if ( function_exists( 'mb_convert_encoding' ) ) {
		$str = mb_convert_encoding( ( string ) $str, 'UTF-8', mb_list_encodings() );

		$char_map = array(
			// Latin
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
			'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',  'Ï' => 'I',
			'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',  'Ő' => 'O',
			'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y',  'Þ' => 'TH',
			'ß' => 'ss',
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
			'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',  'ï' => 'i',
			'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',  'ő' => 'o',
			'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y',  'þ' => 'th',
			'ÿ' => 'y',

			// Latin symbols
			'©' => '_c_',

			// Greek
			'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H',  'Θ' => '8',
			'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O',  'Π' => 'P',
			'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W',  'Ϊ' => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h',  'θ' => '8',
			'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o',  'π' => 'p',
			'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w',  'ς' => 's',
			'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

			// Turkish
			'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

			// Russian
			'А' => 'A',  'Б' => 'B',  'В' => 'V',  'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z',  'И' => 'I',  'Й' => 'J',  'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',  'О' => 'O',
			'П' => 'P',  'Р' => 'R',  'С' => 'S',  'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H',  'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '',  'Ы' => 'Y', 'Ь' => '',  'Э' => 'E',  'Ю' => 'Yu',
			'Я' => 'Ya',
			'а' => 'a',  'б' => 'b',  'в' => 'v',  'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z',  'и' => 'i',  'й' => 'j',  'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',  'о' => 'o',
			'п' => 'p',  'р' => 'r',  'с' => 's',  'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h',  'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '',  'ы' => 'y', 'ь' => '',  'э' => 'e',  'ю' => 'yu',
			'я' => 'ya',

			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

			// Czech
			'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
			'Ž' => 'Z',
			'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
			'ž' => 'z',

			// Polish
			'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
			'Ż' => 'Z',
			'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
			'ż' => 'z',

			// Latvian
			'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
			'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
			'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
			'š' => 's', 'ū' => 'u', 'ž' => 'z'
		);

		// Transliterate characters to ASCII
		$str = str_replace( array_keys( $char_map ), $char_map, $str );

		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace( '/[^\p{L}\p{Nd}]+/u', '-', $str );

		// Remove duplicate delimiters
		$str = preg_replace( '/(' . preg_quote( '-', '/' ) . '){2,}/', '$1', $str );

		// Truncate slug to max. characters
		$str = mb_substr( $str, 0, ( null ? null : mb_strlen( $str, 'UTF-8' ) ), 'UTF-8' );

		// Remove delimiter from ends
		$str = trim( $str, '-' );

		return mb_strtolower( $str, 'UTF-8' );

	} else {

		return $srt;

	}
}

/**
 * This is a helper function to bypass some of the quirks of twig
 */
function maera_get_post_teaser( $post_id ) {

	$mode = get_theme_mod( 'blog_post_mode', 'excerpt' );

	// Get the post
	$content_post = get_post( $post_id );

	$content = '';

	$image = Maera_Image::featured_image( $post_id );

	if ( $image ) {
		$content .= '<a class="featured-image" href="' . get_permalink( $post_id ) . '" style="background: url(\'' . $image['url'] . '\'); width: ' . $image['width'] . 'px; height: ' . $image['height'] . 'px;"></a>';
	}

	if ( 'full' == $mode ) {

		// Get the content of the post
		$content .= $content_post->post_content;
		// Apply the content filters
		$content = apply_filters( 'the_content', $content );

	} else {

		// Get the content of the post
		if ( $content_post->post_excerpt ) {

			$content .= $content_post->post_excerpt;

		} else {

			$excerpt_length = apply_filters( 'excerpt_length', 55 );
			$excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[&hellip;]', $post_id );
			$content        .= wp_trim_words( $content_post->post_content, $excerpt_length, $excerpt_more );

		}

		// Apply the content filters
		$content = apply_filters( 'get_the_excerpt', $content );
		$content = apply_filters( 'the_excerpt', $content );

	}

	$content = str_replace( ']]>', ']]&gt;', $content );

	return $content;
}

function maera_return_0() { return 0; }

function maera_return_1() { return 1; }

function maera_return_2() { return 2; }

function maera_return_3() { return 3; }

function maera_return_4() { return 4; }

function maera_return_5() { return 5; }
