<?php

function book_catalog_styles() {
	wp_enqueue_style( 'book-catalog-general', get_template_directory_uri() . '/assets/css/book-catalog.css', [], wp_get_theme()->get( 'Version' ));
	wp_enqueue_script( 'book-theme-related', get_template_directory_uri() . '/assets/js/book-catalog-theme-related.js', [], wp_get_theme()->get( 'Version' ));

	//swiper
	wp_enqueue_style( 'swiper-bundle', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', [], wp_get_theme()->get( 'Version' ));
	wp_enqueue_script( 'swiper-bundle', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', [], wp_get_theme()->get( 'Version' ));
}
add_action( 'wp_enqueue_scripts', 'book_catalog_styles' );

function book_catalog_google_font() {
	$font_url = '';
	$font = 'Roboto';
	$font_extra = 'ital,wght@0,100..900;1,100..900';
	
	if('off' !== _x('on', 'Google font: on or off', 'book_catalog')) {
		$query_args = array(
			'family' => urldecode($font.':'.$font_extra),
			'subset' => urldecode('latin,latin-ext'),
			'display' => urldecode('swap')
		);
		$font_url = add_query_arg($query_args, '//fonts.googleapis.com/css2');
	}

	return $font_url;
}

function book_catalog_google_font_script(){
	wp_enqueue_style('book-catalog-google-font', book_catalog_google_font(),[],'1.0.0');
}

add_action('wp_enqueue_scripts', 'book_catalog_google_font_script');
