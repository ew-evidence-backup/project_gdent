<?php

// register portal page post type
function portal_page_post_type() {
	$labels = array(
		'name'                => 'Pages',
		'singular_name'       => 'Page',
		'menu_name'           => 'Pages',
		'name_admin_bar'      => 'Pages',
		'parent_item_colon'   => 'Parent Page:',
		'all_items'           => 'All Pages',
		'add_new_item'        => 'Add New Page',
		'add_new'             => 'Add New',
		'new_item'            => 'New Page',
		'edit_item'           => 'Edit Page',
		'update_item'         => 'Update Page',
		'view_item'           => 'View Page',
		'search_items'        => 'Search Page',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash'
	);

	$rewrite = array(
		'slug'				  => 'page',
		'with_front'          => false,
		'hierarchical'		  => false
	);

	$args = array(
		'label'               => 'portal_page',
		'labels'              => $labels,
		'supports'            => array('title', 'editor', 'revisions', 'custom-fields', 'page-attributes'),
		'taxonomies'          => array('portal_page_category'),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-admin-page',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page'
	);

	register_post_type('portal_page', $args);
}

add_action('init', 'portal_page_post_type', 0);