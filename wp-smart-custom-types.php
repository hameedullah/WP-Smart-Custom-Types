<?php
/*
Plugin Name: WP Smart Custom Types
Plugin URI: http://hameedullah.com
Author: Hameedullah Khan
Author URI: http://hameedullah.com
Version: 0.1
 */

require_once('classes/smartcustomtype.class.php');

global $wp_version;


$sct_instance = new SmartCustomType();

// keep the registeration of the activation function to main plugin file
// but all the activation will be taken care of inside the class ;)
register_activation_hook( __FILE__, array( $sct_instance, 'activate' ) );
?>
