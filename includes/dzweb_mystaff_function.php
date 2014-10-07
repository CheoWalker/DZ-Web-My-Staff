<?php

if ( ! defined( 'ABSPATH' ) ) { 
    exit; 
}

/* Required Files */

require_once 'lib/dzweb_mystaff_post_types.php'; // Adds Custom Posts Types
require_once 'lib/dzweb_mystaff_relationships.php'; 
require_once 'lib/class-tgm-plugin-activation.php';
 
/* Scripts and Stylesheets Installed */

function dzweb_mystaff_scripts() {
    wp_enqueue_style( 'dzweb_mystaff_style', plugin_dir_path( __FILE__ ) . '/css/style.css' );
    wp_enqueue_script( 'dzweb_mystaff_js', plugin_dir_path( __FILE__ ) . '/js/dzweb_mystaff.js', true);
}
add_action( 'wp_enqueue_scripts', 'dzweb_mystaff_scripts' );

/* Load Custom Post's Page Templates */

class PageTemplater {

        /**
         * A Unique Identifier
         */
         protected $plugin_slug;

        /**
         * A reference to an instance of this class.
         */
        private static $instance;

        /**
         * The array of templates that this plugin tracks.
         */
        protected $templates;


        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                        self::$instance = new PageTemplater();
                } 

                return self::$instance;

        } 

        /**
         * Initializes the plugin by setting filters and administration functions.
         */
        private function __construct() {

                $this->templates = array();


                // Add a filter to the attributes metabox to inject template into the cache.
                add_filter(
                    'page_attributes_dropdown_pages_args',
                     array( $this, 'register_project_templates' ) 
                );


                // Add a filter to the save post to inject out template into the page cache
                add_filter(
                    'wp_insert_post_data', 
                    array( $this, 'register_project_templates' ) 
                );


                // Add a filter to the template include to determine if the page has our 
                // template assigned and return it's path
                add_filter(
                    'template_include', 
                    array( $this, 'view_project_template') 
                );


                // Add your templates to this array.
                $this->templates = array(
                        'page-office.php'     => 'Office Page',
                        'page-department.php'     => 'Department Page',
                        'page-staff.php'     => 'Staff Page',
                );
                
        } 


        /**
         * Adds our template to the pages cache in order to trick WordPress
         * into thinking the template file exists where it doens't really exist.
         *
         */

        public function register_project_templates( $atts ) {

                // Create the key used for the themes cache
                $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

                // Retrieve the cache list. 
                // If it doesn't exist, or it's empty prepare an array
                $templates = wp_get_theme()->get_page_templates();
                if ( empty( $templates ) ) {
                        $templates = array();
                } 

                // New cache, therefore remove the old one
                wp_cache_delete( $cache_key , 'themes');

                // Now add our template to the list of templates by merging our templates
                // with the existing templates array from the cache.
                $templates = array_merge( $templates, $this->templates );

                // Add the modified cache to allow WordPress to pick it up for listing
                // available templates
                wp_cache_add( $cache_key, $templates, 'themes', 1800 );

                return $atts;

        } 

        /**
         * Checks if the template is assigned to the page
         */
        public function view_project_template( $template ) {

                global $post;

                if (!isset($this->templates[get_post_meta( 
                    $post->ID, '_wp_page_template', true 
                )] ) ) {
                    
                        return $template;
                        
                } 

                $file = plugin_dir_path(__FILE__). get_post_meta( 
                    $post->ID, '_wp_page_template', true 
                );
                
                // Just to be safe, we check if the file exist first
                if( file_exists( $file ) ) {
                        return $file;
                } 
                else { echo $file; }

                return $template;

        } 


} 

add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );

/* Load Custom Post's Templates */
if( !function_exists('get_office_template') ):
 function get_office_template($single_template) {
    global $wp_query, $post;
    if ($post->post_type == 'office'){
        $single_template = plugin_dir_path(__FILE__) . 'office.php';
    }//end if office
    return $single_template;
}//end get_office_template function
endif;
 
add_filter( 'single_template', 'get_office_template' ) ;

if( !function_exists('get_department_template') ):
 function get_department_template($single_template) {
    global $wp_query, $post;
    if ($post->post_type == 'department'){
        $single_template = plugin_dir_path(__FILE__) . 'department.php';
    }//end if department
    return $single_template;
}//end get_department_template function
endif;

add_filter( 'single_template', 'get_department_template' ) ;

if( !function_exists('get_staff_template') ):
 function get_staff_template($single_template) {
    global $wp_query, $post;
    if ($post->post_type == 'staff'){
        $single_template = plugin_dir_path(__FILE__) . 'staff.php';
    }//end if staff
    return $single_template;
}//end get_staff_template function
endif;
 
add_filter( 'single_template', 'get_staff_template' ) ;
 
/* Plugin Required */ 

add_action( 'tgmpa_register', 'dzweb_mystaff_register_required_plugins' );

/* WARNING: DO NOT EDIT ANY CODE BELOW THIS POINT UNDER ANY CIRCUMSTANCES! */

function dzweb_mystaff_register_required_plugins() {
 
    $plugins = array(
         array(
            'name'               => 'Posts 2 Posts', 
            'slug'               => 'posts-to-posts',
            'required'           => true,
            'force_activation'   => false, 
            'force_deactivation' => false, 
            'external_url'       => '', 
        ),
 
         
    );

    $config = array(
        'default_path' => '',                      
        'menu'         => 'tgmpa-install-plugins', 
        'has_notices'  => true,                    
        'dismissable'  => true,                    
        'dismiss_msg'  => '',                      
        'is_automatic' => false,                   
        'message'      => '',                      
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), 
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), 
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), 
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), 
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ),
            'nag_type'                        => 'updated' 
        )
    );
 
    tgmpa( $plugins, $config );
 
}