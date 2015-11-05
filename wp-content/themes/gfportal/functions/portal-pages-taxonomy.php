<?php

// register portal page taxonomy
function portal_page_taxonomy() {
	$labels = array(
		'name'                       => 'Categories',
		'singular_name'              => 'Category',
		'menu_name'                  => 'Categories',
		'all_items'                  => 'All Categories',
		'parent_item'                => 'Parent Category',
		'parent_item_colon'          => 'Parent Category:',
		'new_item_name'              => 'New Category Name',
		'add_new_item'               => 'Add New Category',
		'edit_item'                  => 'Edit Category',
		'update_item'                => 'Update Category',
		'view_item'                  => 'View Category',
		'separate_items_with_commas' => 'Separate categories with commas',
		'add_or_remove_items'        => 'Add or remove categories',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Categories',
		'search_items'               => 'Search Categories',
		'not_found'                  => 'Not Found'
	);

	$rewrite = array(
		'slug'                       => 'category',
		'with_front'                 => true,
		'hierarchical'               => false
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite
	);

	register_taxonomy('portal_page_category', array('portal_page'), $args);
}

add_action('init', 'portal_page_taxonomy', 0);