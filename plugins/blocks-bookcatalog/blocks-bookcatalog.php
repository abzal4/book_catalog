<?php
/**
 * Plugin Name:       Blocks Book Catalog
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blocks-bookcatalog
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter('block_categories_all', function($categories){
	return array_merge($categories, [
		[
			'slug' => 'book_catalog',
			'title' =>'Book Catalog'
		]
	]);
});

function create_block_blocks_bookcatalog_block_init() {
	register_block_type( __DIR__ . '/build/block-header');
	// wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
}
add_action( 'init', 'create_block_blocks_bookcatalog_block_init' );
