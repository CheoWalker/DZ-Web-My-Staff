<?php

if ( ! defined( 'ABSPATH' ) ) { 
    exit; 
}

/**
 * 
 */
class dzweb_staff_post_types  {
	
	public function __construct() {
	    $this->dzweb_mystaff_offices_post_type();
		$this->dzweb_mystaff_departments_post_type();        
        $this->dzweb_mystaff_staff_post_type();
	}
    
    public function dzweb_mystaff_offices_post_type() {
        $labels = array(
            'name'               => _x( 'Offices', 'post type general name', '' ),
            'singular_name'      => _x( 'Office', 'post type singular name', '' ),
            'add_new'            => _x( 'Add New', 'Office', '' ),
            'add_new_item'       => __( 'Add New Office', 'add a new office' ),
            'edit_item'          => __( 'Edit Office', '' ),
            'new_item'           => __( 'New Office'. '' ),
            'all_items'          => __( 'All Office', '' ),
            'view_item'          => __( 'View Office', '' ),
            'search_items'       => __( 'Search Offices', '' ),
            'not_found'          => __( 'No offices found', '' ),
            'not_found_in_trash' => __( 'No offices found in the Trash', '' ), 
            'parent_item_colon'  => '',
            'menu_name'          => 'Offices'
    
        );
    
        $args = array(
            'labels'        => $labels,
            'description'   => 'Current Office.',
            'public'        => true,
            'menu_position' => 5,
            'supports'      => array( 'title', 'thumbnail', 'comments', 'excerpt', 'custom field', 'editor' ),
            'has_archive'   => true,
        );
        register_post_type( 'office', $args );    
    }

    public function dzweb_mystaff_departments_post_type() {
        $labels = array(
            'name'               => _x( 'Departments', 'post type general name', '' ),
            'singular_name'      => _x( 'Department', 'post type singular name', '' ),
            'add_new'            => _x( 'Add New', 'Department', '' ),
            'add_new_item'       => __( 'Add New Department', 'add a new department' ),
            'edit_item'          => __( 'Edit Department', '' ),
            'new_item'           => __( 'New Department'. '' ),
            'all_items'          => __( 'All Department', '' ),
            'view_item'          => __( 'View Department', '' ),
            'search_items'       => __( 'Search Departments', '' ),
            'not_found'          => __( 'No departments found', '' ),
            'not_found_in_trash' => __( 'No departments found in the Trash', '' ), 
            'parent_item_colon'  => '',
            'menu_name'          => 'Departments'
    
        );
    
        $args = array(
            'labels'        => $labels,
            'description'   => 'Current Department.',
            'public'        => true,
            'menu_position' => 5,
            'supports'      => array( 'title', 'thumbnail', 'comments', 'excerpt', 'custom field', 'editor' ),
            'has_archive'   => true,
        );
        register_post_type( 'department', $args );    
    }

    public function dzweb_mystaff_staff_post_type() {
        $labels = array(
            'name'               => _x( 'Employees', 'post type general name', '' ),
            'singular_name'      => _x( 'Employee', 'post type singular name', '' ),
            'add_new'            => _x( 'Add New', 'Employee', '' ),
            'add_new_item'       => __( 'Add New Employee', 'add a new employee' ),
            'edit_item'          => __( 'Edit Employee', '' ),
            'new_item'           => __( 'New Employee'. '' ),
            'all_items'          => __( 'All Employee', '' ),
            'view_item'          => __( 'View Employee', '' ),
            'search_items'       => __( 'Search Employees', '' ),
            'not_found'          => __( 'No employees found', '' ),
            'not_found_in_trash' => __( 'No employees found in the Trash', '' ), 
            'parent_item_colon'  => '',
            'menu_name'          => 'Staff'
    
        );
    
        $args = array(
            'labels'        => $labels,
            'description'   => 'Current Employees.',
            'public'        => true,
            'menu_position' => 5,
            'supports'      => array( 'title', 'thumbnail', 'comments', 'excerpt', 'custom field', 'editor' ),
            'has_archive'   => true,
        );
        register_post_type( 'staff', $args );    
    }
    
    
    public function taxonomies() {
        
        $taxonomies = array();
        
                
        $this->register_all_taxonomies($taxonomies);
    } 
    
    public function register_all_taxonomies($taxonomies)
    {
    }
    
}

add_action( 'init', 'dzweb_staff_post_types_cb' );
 function dzweb_staff_post_types_cb()
{
    new dzweb_staff_post_types();
};
