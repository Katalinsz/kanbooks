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
error_log("plugin init"); 
define('KANBOOKS_DIR' , dirname(__FILE__));
define('KANBOOKS_INCLUDES', KANBOOKS_DIR . '/includes');

/* Code to define ACF, taken from: https://www.advancedcustomfields.com/resources/including-acf-within-a-plugin-or-theme/ */
// Define path and URL to the ACF plugin.
define( 'KANBOOKS_ACF_PATH', KANBOOKS_INCLUDES . '/acf/' );
define( 'KANBOOKS_ACF_URL', get_stylesheet_directory_uri() . '/includes/acf/' );

// Include the ACF plugin.
include_once( KANBOOKS_ACF_PATH . 'acf.php' );
// Customize the url setting to fix incorrect asset URLs.

//add_filter('acf/settings/url', 'kanbooks_acf_settings_url');
function kanbooks_acf_settings_url() {
    return KANBOOKS_ACF_URL;
}


// (Optional) Hide the ACF admin menu item.
add_filter('acf/settings/show_admin', 'kanbooks_acf_settings_show_admin');
function kanbooks_acf_settings_show_admin( $show_admin ) {
    return true;
}

add_action( 'acf/init', 'KANBooks_create_post_type' );
add_action( 'acf/init', 'KANBooks_author_create_post_type');


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
                'instructions' => 'Upload you books image.',
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
                'choices' => array("red" => "red"),
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
    
    acf_add_local_field_group(array(
        'key' => 'group_5ed29725075c3',
        'title' => 'Author',
        'fields' => array(
            array(
                'key' => 'field_5ed297330f04b',
                'label' => 'Authors Full Name',
                'name' => 'kanbooks_author_name',
                'type' => 'text',
                'instructions' => 'Type the author of your book.',
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
                'maxlength' => 70,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'kanbooksauthor',
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
        'public'              => false,
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
        'rewrite'             => array( 'slug' => 'books' ),
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
        'public'              => false,
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
    log_me("registered new posttype");
}

function KANBooks_create_taxonomies() {
    /////////////////////////////////
    //Add taxonomies for books
    /////////////////////////////////////
    
    // Add a taxonomy like categories
    $labels = array(
        'name'              => 'Types',
        'singular_name'     => 'Type',
        'search_items'      => 'Search Types',
        'all_items'         => 'All Types',
        'parent_item'       => 'Parent Type',
        'parent_item_colon' => 'Parent Type:',
        'edit_item'         => 'Edit Type',
        'update_item'       => 'Update Type',
        'add_new_item'      => 'Add New Type',
        'new_item_name'     => 'New Type Name',
        'menu_name'         => 'Types',
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'type' ),
    );
    
    register_taxonomy('KANBooks_type',array('KANBooks'),$args);
    
    // Add a taxonomy like tags
    $labels = array(
        'name'                       => 'Attributes',
        'singular_name'              => 'Attribute',
        'search_items'               => 'Attributes',
        'popular_items'              => 'Popular Attributes',
        'all_items'                  => 'All Attributes',
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit Attribute',
        'update_item'                => 'Update Attribute',
        'add_new_item'               => 'Add New Attribute',
        'new_item_name'              => 'New Attribute Name',
        'separate_items_with_commas' => 'Separate Attributes with commas',
        'add_or_remove_items'        => 'Add or remove Attributes',
        'choose_from_most_used'      => 'Choose from most used Attributes',
        'not_found'                  => 'No Attributes found',
        'menu_name'                  => 'Attributes',
    );
    
    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'attribute' ),
    );
    
    register_taxonomy('KANBooks_attribute','KANBooks',$args);
    
    /////////////////////////////////
    //Add taxonomies for authors too
    /////////////////////////////////////
    
    // Add a taxonomy like categories
    $labels = array(
        'name'              => 'Types',
        'singular_name'     => 'Type',
        'search_items'      => 'Search Types',
        'all_items'         => 'All Types',
        'parent_item'       => 'Parent Type',
        'parent_item_colon' => 'Parent Type:',
        'edit_item'         => 'Edit Type',
        'update_item'       => 'Update Type',
        'add_new_item'      => 'Add New Type',
        'new_item_name'     => 'New Type Name',
        'menu_name'         => 'Types',
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'type' ),
    );
    
    register_taxonomy('KANBooksAuthor_type',array('KANBooksAuthor'),$args);
    
    // Add a taxonomy like tags
    $labels = array(
        'name'                       => 'Attributes',
        'singular_name'              => 'Attribute',
        'search_items'               => 'Attributes',
        'popular_items'              => 'Popular Attributes',
        'all_items'                  => 'All Attributes',
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit Attribute',
        'update_item'                => 'Update Attribute',
        'add_new_item'               => 'Add New Attribute',
        'new_item_name'              => 'New Attribute Name',
        'separate_items_with_commas' => 'Separate Attributes with commas',
        'add_or_remove_items'        => 'Add or remove Attributes',
        'choose_from_most_used'      => 'Choose from most used Attributes',
        'not_found'                  => 'No Attributes found',
        'menu_name'                  => 'Attributes',
    );
    
    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'attribute' ),
    );
    
    register_taxonomy('KANBooksAuthor_attribute','KANBooksAuthor',$args);
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
?>