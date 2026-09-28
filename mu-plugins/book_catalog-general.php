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

function register_book_news_post_type() {

	register_post_type( 'book_news', array(
		'labels' => array(
			'name'               => 'Новости',
			'singular_name'      => 'Новость',
            'name_admin_bar'     => 'Новости',
			'menu_name'          => 'Новости',
			'archives'           => 'Архивы',
			'attributes'         => 'Атрибуты',
			'add_new'            => 'Добавить новость',
			'add_new_item'       => 'Добавить новость',
			'parent_item_colon'  => 'Parent новости',
			'edit_item'          => 'Редактировать новость',
			'new_item'           => 'Новая новость',
			'view_item'          => 'Просмотреть новость',
			'search_items'       => 'Поиск новостей',
			'not_found'          => 'Новости не найдены',
			'not_found_in_trash' => 'Новостей в корзине нет',
			'all_items'          => 'Все новости',
		)
        
        ,

		'public'       => true,
		'show_ui'      => true,
		'show_in_menu' => true,
        'show_in_rest' => true,

		'menu_icon'    => 'dashicons-megaphone',
		'menu_position' => 5,

		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'revisions',
		),

		'has_archive' => true,

		'rewrite' => array(
			'slug' => 'news',
		),

		'show_in_rest' => true,
	) );
}

add_action( 'init', 'register_book_news_post_type' );


/**
 * Регистрация таксономии "Категория новостей"
 */
function register_book_news_category_taxonomy() {

	register_taxonomy( 'news_category', array( 'book_news' ), array(

		'labels' => array(
			'name'              => 'Категории новостей',
			'singular_name'     => 'Категория новостей',
			'menu_name'         => 'Категории',
			'all_items'         => 'Все категории',
			'edit_item'         => 'Редактировать категорию',
			'update_item'       => 'Обновить категорию',
			'add_new_item'      => 'Добавить категорию',
			'new_item_name'     => 'Название новой категории',
			'search_items'      => 'Поиск категорий',
			'not_found'         => 'Категории не найдены',
		),

		'public'       => true,
		'show_ui'      => true,
		'show_in_rest' => true,

		'hierarchical' => true,

		'rewrite' => array(
			'slug' => 'news-category',
		),
	) );
}

add_action( 'init', 'register_book_news_category_taxonomy' );