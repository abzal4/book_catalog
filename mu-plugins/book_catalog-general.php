<?php
/**
 * Plugin Name: Book Catalog General
 * Desciption: Core Code for Gamestore
 * Version: 1.0
 * Author: abzal
 * Author URI: https://abzal
 * License GPL2
 * License URI: https://gnu.org/licenses/gpl-2.0.html
 * Text domain: book_catalog
 */

function book_catalog_remove_dashboard_widgets(){
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['high']['rank_math_dashboard_widget']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
}
add_action('wp_dashboard_setup', 'book_catalog_remove_dashboard_widgets');

/**
 * Разрешить загрузку SVG.
 */
function book_catalog_allow_svg_uploads( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', 'book_catalog_allow_svg_uploads' );


/**
 * Исправить определение MIME-типа SVG.
 */
function book_catalog_fix_svg_mime_type( $data, $file, $filename, $mimes ) {

	$extension = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

	if ( 'svg' === $extension ) {
		$data['ext']  = 'svg';
		$data['type'] = 'image/svg+xml';
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'book_catalog_fix_svg_mime_type', 10, 4 );


/**
 * Добавить SVG в список поддерживаемых типов изображений.
 */
function book_catalog_add_svg_to_image_types( $types ) {

	$types['svg'] = 'image/svg+xml';

	return $types;
}
add_filter( 'image_editor_output_format', 'book_catalog_add_svg_to_image_types' );