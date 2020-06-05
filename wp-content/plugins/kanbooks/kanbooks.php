<?php
/*
 * Plugin Name: Book plugin for KAN
 * Plugin URI: localhost
 * description: A plugin to list and show books and authors
 * Version: 1.0
 * Author: Katalin Szasz
 * Author URI: https://motif.knittedforyou.com
 * License: GPL2
 */

/* Prevent direct access */
defined( 'ABSPATH' ) or die( "You can't access this file directly." );

define('KANBOOKS_DIR' , dirname(__FILE__));
define('KANBOOKS_INCLUDES', KANBOOKS_DIR . '/includes');
include_once KANBOOKS_DIR.'/../../../wp-includes/pluggable.php';

add_action( 'acf/init', 'KANBooks_create_post_type' );
add_action( 'acf/init', 'KANBooks_author_create_post_type');
add_action( 'pre_get_posts', 'kanbooks_cpt_archive_items' );

add_filter('template_include', 'kanbooks_template');

function kanbooks_template( $template ) {
    if ( is_post_type_archive('kanbooks') ) {
            $theme_files = array(plugin_dir_path(__FILE__).'themes/archive-kanbooks.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ( $exists_in_theme != '' ) {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . '/themes/archive-kanbooks.php';
            }
    }
    if ( is_singular("kanbooks") ) {
        $theme_files = array(plugin_dir_path(__FILE__).'/themes/single-kanbooks.php');
        $exists_in_theme = locate_template($theme_files, false);
        if ( $exists_in_theme != '' ) {
            return $exists_in_theme;
        } else {
            return plugin_dir_path(__FILE__) . '/themes/single-kanbooks.php';
        }
    }
    if ( is_singular("kanbooksauthor") ) {
        $theme_files = array(plugin_dir_path(__FILE__).'/themes/single-kanbooksauthor.php');
        $exists_in_theme = locate_template($theme_files, false);
        if ( $exists_in_theme != '' ) {
            return $exists_in_theme;
        } else {
            return plugin_dir_path(__FILE__) . '/themes/single-kanbooksauthor.php';
        }
    }
    return $template;
}

function kanbooks_cpt_archive_items( $query ) {
    if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'kanbooks' ) ) {
        if( !isset( $_GET['orderby'] ) )
            $orderby = 'kanbooks_release_date';
        else
            $orderby = trim( $_GET['orderby'] );
    
        $query->set('order', 'ASC');
        $query->set( 'posts_per_page', '3' );
                
        switch ($orderby) {
             case 'kanbooks_release_date':
                   $query->set( 'orderby', 'meta_value' );
                   $query->set( 'meta_key', $orderby );
                   break;
             default:
             $query->set( 'orderby', 'post_date');
         }
    }
}
    
/*
 * create custom field types for books and authors
 */  
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_5ed0b0cdf2011',
        'title' => 'Book',
        'fields' => array(
            array(
                'key' => 'field_5ed0b0e3fd92f',
                'label' => 'Omslagsbild',
                'name' => 'omslagsbild',
                'type' => 'image',
                'instructions' => 'Upload your books image.',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_5ed0b20efd930',
                'label' => 'BookTitel',
                'name' => 'bookTitel',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => 200,
            ),
            array(
                'key' => 'field_5ed0b253fd931',
                'label' => 'Author',
                'name' => 'kanbook_author',
                'type' => 'checkbox',
                'instructions' => 'Who are the authors of your book. Check out them or add new ones in Kanbooks/authors.',
                'required' => 1,
                'choices' => KANBooks_getAuthors_for_selectbox(),
                'layout' => 0,
                'allow_custom' => false,
                'save_custom' => false,
                'toggle' => false,
                'return_format' => 'value',
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'field_5ed0b2b1fd932',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
            array(
                'key' => 'field_5ed240ec09fb5',
                'label' => 'ISBN',
                'name' => 'kanbooks_isbn',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5ed0b0e3fd92f',
                            'operator' => '!=empty',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => 'kanbooks_isbn',
                ),
                'default_value' => '',
                'placeholder' => 111111111,
                'prepend' => '',
                'append' => '',
                'maxlength' => 10,
            ),
            array(
                'key' => 'field_5ed3b0eaba25f',
                'label' => 'Release date',
                'name' => 'kanbooks_release_date',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'kanbooks',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'kanbooks_meta_nonce' => true
        
    ));
   
}

////////////Creating posttype
function KANBooks_create_post_type() {
    $labels = array(
        'name'               => 'KANBooks',
        'singular_name'      => 'KANBook',
        'menu_name'          => 'KANBooks',
        'name_admin_bar'     => 'KANBook',
        'add_new'            => 'Add New Book',
        'add_new_item'       => 'Add New Book',
        'new_item'           => 'New Book',
        'edit_item'          => 'Edit Book',
        'view_item'          => 'View Book',
        'all_items'          => 'All Books',
        'search_items'       => 'Search Books',
        'parent_item_colon'  => 'Parent Book',
        'not_found'          => 'No Book Found',
        'not_found_in_trash' => 'No books Found in Trash'
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-appearance',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array( 'title', 'editor', 'author' ),
        'has_archive'         => true,
        'rewrite'             => array( 'slug' => 'kanbooks' ),
        'query_var'           => true,
        'show_in_rest' => true,
    );
    
    register_post_type( 'KANBooks', $args );
    log_me("registered new posttype");
}

////////////Creating posttype
function KANBooks_author_create_post_type() {
    $labels = array(
        'name'               => 'KANAuthors',
        'singular_name'      => 'KANAuthor',
        'menu_name'          => 'KANAuthor',
        'name_admin_bar'     => 'KANAuthor',
        'add_new'            => 'Add New Author',
        'add_new_item'       => 'Add New',
        'new_item'           => 'New',
        'edit_item'          => 'Edit',
        'view_item'          => 'View',
        'all_items'          => 'All authors',
        'search_items'       => 'Search author',
        'parent_item_colon'  => 'Parent Author',
        'not_found'          => 'No author Found',
        'not_found_in_trash' => 'No author Found in Trash'
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-appearance',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array( 'title', 'editor', 'author' ),
        'has_archive'         => true,
        'rewrite'             => array( 'slug' => 'authors' ),
        'query_var'           => true,
        'show_in_rest' => true,
    );
    
    register_post_type( 'KANBooksAuthor', $args );
}

function log_me($message) {
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}

function KANBooks_getAuthors_for_selectbox($book_id = null) {
    global $linker;
    $res = array();
    if (!$book_id) {
        $authors = get_posts(array('post_type' => 'kanbooksauthor'));
    } 
    foreach ($authors as $author) {
        $res[$author->ID] = $author->post_title;
    }
    return $res;
}; 

function get_books_by_author($author_id) {
    $authors_books = []; 
    $books = get_posts(array(
        'post_type' => 'kanbooks', 
        'meta_key' => 'kanbook_author', 
    ));
    
    foreach ($books as $book) {
        $authors = get_field('kanbook_author', $book->ID);
        if (in_array($author_id, $authors)){
            $authors_books[] = $book; 
        }
    }
    return $authors_books; 
}

?>