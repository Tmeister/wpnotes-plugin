<?php

/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://enriquechavez.co
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Notes
 * Plugin URI:        http://wpnotes.io
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Enrique Chavez
 * Author URI:        https://enriquechavez.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpnotes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

function register_notes()
{
    $labels = array(
        'name' => _x('Notes', 'post type general name', 'wpnote'),
        'singular_name' => _x('Note', 'post type singular name', 'wpnote'),
        'menu_name' => _x('Notes', 'admin menu', 'wpnote'),
        'name_admin_bar' => _x('Note', 'add new on admin bar', 'wpnote'),
        'add_new' => _x('Add New', 'Note', 'wpnote'),
        'add_new_item' => __('Add New Note', 'wpnote'),
        'new_item' => __('New Note', 'wpnote'),
        'edit_item' => __('Edit Note', 'wpnote'),
        'view_item' => __('View Note', 'wpnote'),
        'all_items' => __('All Notes', 'wpnote'),
        'search_items' => __('Search Notes', 'wpnote'),
        'parent_item_colon' => __('Parent Notes:', 'wpnote'),
        'not_found' => __('No Notes found.', 'wpnote'),
        'not_found_in_trash' => __('No Notes found in Trash.', 'wpnote')
    );
    $args = array(
        'labels' => $labels,
        'description' => __('User Notes.', 'wpnotes'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'notes'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
    );
    register_post_type('notes', $args);
}

function wpsd_add_events_args()
{
    global $wp_post_types;
    $wp_post_types['notes']->show_in_rest = true;
    $wp_post_types['notes']->rest_base = 'notes';
    $wp_post_types['notes']->rest_controller_class = 'WP_REST_Posts_Controller';
}

function custom_excerpt_length( $length ) {
	return 20;
}

function remove_more_links( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'remove_more_links', 99 );
add_filter( 'excerpt_length', 'custom_excerpt_length', 99 );
add_action('init', 'register_notes');
add_action('init', 'wpsd_add_events_args', 30);
