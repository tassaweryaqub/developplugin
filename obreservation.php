<?php 
/** 
 * @package obreservation
 */

 /* 
 Plugin Name: obreservation
 Plugin URI: http://localhost:8888/mysite
 Description: Maak gebruik van de unieke mogelijkheden met de OfficeBooking plugin
 Version: 0.1
 Author: Tassawer Yaqub 
 Author URI: http://localhost:8888/mysite
 License: GPLv2 or Later 
 Text domain: obreservation-plugin 

 */

 /* We protect your rights with two steps: (1) copyright the software, and (2) offer you this license which gives you legal permission to copy, distribute and/or modify the software. */ 

 
// ervoor zorgen dat er geen toegang wordt verleend tot deze file without pathrechten
    if (! defined ('ABSPATH')){
     die; 
    }

    if(!class_exists('reservation')){


     class reservation {

        public $plugin;

		function __construct() {
			$this->plugin = plugin_basename( __FILE__ );
		}

            function register(){
                add_action ('admin_enqueue_scripts', array($this, 'enqueue' )); 
                add_action ('admin_menu', array($this, 'add_admin_pages'));  
                add_filter( "plugin_action_links_$this->plugin", array($this, 'settings_link' ));
            }

            public function settings_link( $links ) {
                $settings_link = '<a href="admin.php?page=officebooking_plugin">Settings</a>';
                array_push( $links, $settings_link );
                return $links;
            }

            public function add_admin_pages() {
                add_menu_page( 'Officebooking Plugin', 'Officebooking', 'manage_options', 'officebooking_plugin', array( $this, 'admin_index' ), 'dashicons-universal-access-alt', 110 );
            }

            public function admin_index(){
                // vereiste template inzetten
                require_once plugin_dir_path(__FILE__). '/templates/admin.php'; 
                

            }

            function activate(){
                require_once plugin_dir_path(__FILE__). '/obreservation-activate.php'; 
                reservationactive::activate();
                //generate the CPT
                $this-> custom_post_type(); 
                flush_rewrite_rules(); 
            }

            function deactivate(){

                flush_rewrite_rules(); 
            }
            function uninstall(){

            }

            function custom_post_type(){
                register_post_type( 'reservations', ['public' => true, 'label' => 'Reservations'] ); 
            }
            //alle scripts linken 

            function enqueue(){
                
                wp_enqueue_style ('mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__ ));
                wp_enqueue_script ('mypluginscript', plugins_url('/assets/myscript.js', __FILE__ ));
            }
            
        }
    
        // if the class exist run the message 
       
        $res = new reservation();
        $res -> register();
        

        // activate the method in the class reservation function activate
        require_once plugin_dir_path(__FILE__). '/obreservation-activate.php'; 
        register_activation_hook ( __FILE__, array('reservationactive','activate')); 

        // deactivate function method
        require_once plugin_dir_path(__FILE__). '/obreservation-deactivate.php'; 
        register_deactivation_hook ( __FILE__, array('reservationdeactivate','deactivate')); 
        

}

