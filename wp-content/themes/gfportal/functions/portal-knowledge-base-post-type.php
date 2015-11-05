<?php

// register knowledge base post type
function knowledge_base_post_type() {
    $labels = array(
        'name'                => 'Articles',
        'singular_name'       => 'Article',
        'menu_name'           => 'Knowledge Base',
        'name_admin_bar'      => 'Articles',
        'parent_item_colon'   => 'Parent Article:',
        'all_items'           => 'All Articles',
        'add_new_item'        => 'Add New Article',
        'add_new'             => 'Add New',
        'new_item'            => 'New Article',
        'edit_item'           => 'Edit Article',
        'update_item'         => 'Update Article',
        'view_item'           => 'View Article',
        'search_items'        => 'Search Article',
        'not_found'           => 'Not found',
        'not_found_in_trash'  => 'Not found in Trash'
    );

    $rewrite = array(
        'slug'				  => 'article',
        'with_front'          => false,
        'hierarchical'		  => false
    );

    $args = array(
        'label'               => 'knowledge_base_page',
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'revisions', 'custom-fields', 'page-attributes'),
        'taxonomies'          => array('knowledge_base_category'),
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

    register_post_type('knowledge_base_page', $args);
}

add_action('init', 'knowledge_base_post_type', 0);