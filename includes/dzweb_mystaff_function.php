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