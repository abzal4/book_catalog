<?php
// This file is generated. Do not modify it manually.
return array(
	'block-contact' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'blocks-bookcatalog/block-contact',
		'version' => '0.1.0',
		'title' => 'Contact form',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'blocks-bookcatalog',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	),
	'block-games-line' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'blocks-bookcatalog/books-line',
		'version' => '0.1.0',
		'title' => 'Books Line',
		'category' => 'book_catalog',
		'icon' => 'columns',
		'description' => 'Dynamic Animated Line with Books',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'attributes' => array(
			'count' => array(
				'type' => 'number',
				'default' => 12
			)
		),
		'textdomain' => 'blocks-bookcatalog',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	),
	'block-header' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'blocks-bookcatalog/block-header',
		'version' => '0.1.0',
		'title' => 'Header',
		'category' => 'book_catalog',
		'icon' => 'layout',
		'description' => 'Site Header Block',
		'supports' => array(
			'html' => false
		),
		'attributes' => array(
			'cartLink' => array(
				'type' => 'string'
			)
		),
		'textdomain' => 'blocks-bookcatalog',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	),
	'block-hero' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'blocks-bookcatalog/block-hero',
		'version' => '0.1.0',
		'title' => 'Hero Block',
		'category' => 'book_catalog',
		'icon' => 'smiley',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'attributes' => array(
			'title' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.hero_title'
			),
			'description' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.hero_description'
			),
			'link' => array(
				'type' => 'string',
				'source' => 'attribute',
				'selector' => 'a',
				'attribute' => 'href'
			),
			'linkAnchor' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => 'a'
			),
			'video' => array(
				'type' => 'string'
			),
			'image' => array(
				'type' => 'string'
			),
			'isVideo' => array(
				'type' => 'boolean'
			),
			'slides' => array(
				'type' => 'array',
				'default' => array(
					
				)
			)
		),
		'textdomain' => 'blocks-bookcatalog',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	)
);
