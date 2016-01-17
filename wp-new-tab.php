<?php
/*
Plugin Name:    WP New Tab
Plugin URI:     http://github.com/josephfusco/wp-new-tab/
Description:    Adds option in wp-admin to open posts/pages in a new tab.
Version:        1.0.0
Author:         Joseph Fusco
Author URI:     http://josephfus.co/
License:        GPLv2 or later
License URI:    http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;

function wpnt_add_new_tab_link( $actions, $page_object ) {

    global $post;

    if ( in_array( $post->post_status, array( 'pending', 'draft', 'future' ) ) ) {
        $unpublished_link = set_url_scheme( get_permalink( $post ) );
        $preview_link = get_preview_post_link( $post, array(), $unpublished_link );
        $actions['view_new_tab'] = '<a href="' . esc_url( $preview_link ) . '" rel="permalink" target="_blank">' . __( 'Preview In New Tab' ) . '</a>';
    } elseif ( 'trash' != $post->post_status ) {
        $actions['view_new_tab'] = '<a href="' . get_permalink( $post->ID ) . '" rel="permalink" target="_blank">' . __( 'View In New Tab' ) . '</a>';
    }

    return $actions;
}
add_filter('post_row_actions', 'wpnt_add_new_tab_link', 10, 2);
add_filter('page_row_actions', 'wpnt_add_new_tab_link', 10, 2);
