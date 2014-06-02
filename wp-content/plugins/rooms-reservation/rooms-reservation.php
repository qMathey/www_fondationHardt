<?php
/**
 * @package Rooms Reservation
 */
/*
Plugin Name: Rooms Reservation
Plugin URI: 
Description: Here come a description
Version: 1.0
Author: Damien Fayet
Author URI: 
License: GPLv2 or later
Text Domain: rooms-reservation
*/

// Bloquer accès direct
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

	
	// Executer a l'activation du plugin
	register_activation_hook(__FILE__,'rms_reservation_activation'); 
	
	// Executer a l'a desactivation du plugin
	register_deactivation_hook(__FILE__,'rms_reservation_deactivation'); 
	
	// Support traduction
	function rms_reservation_init() 
	{	
		// Charger la langue
		load_plugin_textdomain( 
			'rooms_reservation',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages' 
		);
	}// Fin rms_reservation_init()

	add_action( 'init' , 'rms_reservation_init');
	
	// Verifier si on est dans l'admin panel
	/*if( is_admin() )
	{*/
		// Appeler fichier d'init de l'admin
		require_once(dirname(__FILE__) . '/admin/init.php');
		
/*	}
	else
	{*/
		
		// Appeler fichier frontend
		require_once(dirname(__FILE__) . '/frontend/init.php');
		
	//}// Fin if( is_admin() )
