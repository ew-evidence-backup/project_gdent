<?php

// disable automatic updates for all plugins including security team updates
add_filter('auto_update_plugin', '__return_false');

// disable automatic updates for all themes
add_filter('auto_update_theme', '__return_false');

// remove dashboard widgets
function remove_dashboard_widget() {
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
}

add_action('wp_dashboard_setup', 'remove_dashboard_widget');
remove_action('welcome_panel', 'wp_welcome_panel');

// remove unnecessary dashboard pages
function remove_menu_pages() {
    remove_menu_page('tools.php');
    //remove_menu_page('options-general.php');
    //remove_menu_page('users.php');
    remove_menu_page('edit.php');
    //remove_menu_page('upload.php');
    remove_menu_page('edit-comments.php');
    remove_menu_page('edit.php?post_type=page');
    remove_submenu_page('plugins.php', 'plugin-install.php');
    remove_submenu_page('plugins.php', 'plugin-editor.php');
    remove_meta_box('postcustom', 'portal_page', 'normal');
    remove_meta_box('slugdiv', 'portal_page', 'normal');

    global $submenu;
    unset($submenu['themes.php'][6]);
}

add_action('admin_menu', 'remove_menu_pages');

// remove stuborn pages
function remove_more_menu_pages() {
    remove_submenu_page('themes.php', 'theme-editor.php');
}

add_action('admin_init', 'remove_more_menu_pages');

// remove admin bar elements
function remove_adminbar_nodes($wp_admin_bar) {
    $wp_admin_bar->remove_node('wp-logo');
    $wp_admin_bar->remove_node('comments');
    $wp_admin_bar->remove_node('new-content');
    $wp_admin_bar->remove_node('edit-profile');
    $wp_admin_bar->remove_node('user-info');
    $wp_admin_bar->remove_node('view');
}

add_action('admin_bar_menu', 'remove_adminbar_nodes', 999);

// remove wordpress login logo
function remove_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 {
            display: none;
        }
    </style>
<?php }

add_action('login_enqueue_scripts', 'remove_login_logo');

// add user meta fields
function add_user_meta_fields($user) {
    ?>
        <h3>Guidant Financial</h3>
        <table class="form-table">
            <tr>
                <th><label for="sforce_contact_id">SalesForce Contact ID</label></th>
                <td><input type="text" name="sforce_contact_id" value="<?php echo esc_attr(get_the_author_meta('sforce_contact_id', $user->ID)); ?>" class="regular-text"/></td>
            </tr>
            <tr>
                <th><label for="sforce_account_id">SalesForce Account ID</label></th>
                <td><input type="text" name="sforce_account_id" value="<?php echo esc_attr(get_the_author_meta('sforce_account_id', $user->ID)); ?>" class="regular-text"/></td>
            </tr>
            <tr>
                <th><label for="sfile_id">ShareFile User ID</label></th>
                <td><input type="text" name="sfile_id" value="<?php echo esc_attr(get_the_author_meta('sfile_id', $user->ID)); ?>" class="regular-text"/></td>
            </tr>
        </table>
    <?php
}

add_action('show_user_profile', 'add_user_meta_fields');
add_action('edit_user_profile', 'add_user_meta_fields');

// save user meta fields
function save_user_meta_field($user_id) {
    update_user_meta($user_id,'sforce_contact_id', $_POST['sforce_contact_id']);
    update_user_meta($user_id,'sforce_account_id', $_POST['sforce_account_id']);
    update_user_meta($user_id,'sfile_id', $_POST['sfile_id']);
}

add_action('personal_options_update', 'save_user_meta_field');
add_action('edit_user_profile_update', 'save_user_meta_field');

function refresh_sforce_tokens() {
    SalesForce::authenticate();
    ShareFile::authenticate();
}

add_action('optionsframework_after', 'refresh_sforce_tokens');