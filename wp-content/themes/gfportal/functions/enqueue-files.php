<?php

function enqueue_scripts()
{
    // css
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '0.0.0.0');
    wp_enqueue_style('theme-css', get_stylesheet_uri(), array(), '0.0.0.0');

    // js
    wp_enqueue_script('jquery-js', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), '2.1.3', true);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '0.0.0.0', true);

    if(!is_page('login')) {
        wp_enqueue_script('jquery-ui-widget-js', get_template_directory_uri() . '/assets/js/jquery.ui.widget.js', array(), '0.0.0.0', true);
        wp_enqueue_script('jquery-portal-js', get_template_directory_uri() . '/assets/js/jquery.portal.js', array(), '0.0.0.0', true);
        wp_enqueue_script('theme-js', get_template_directory_uri() . '/assets/js/script.js', array(), '0.0.0.0', true);

        // upload
        wp_enqueue_script('iframe-transport-js', get_template_directory_uri() . '/assets/js/iframe-transport.js', array(), '0.0.0.0', true);
        wp_enqueue_script('fileupload-js', get_template_directory_uri() . '/assets/js/fileupload.js', array(), '0.0.0.0', true);
    }
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');