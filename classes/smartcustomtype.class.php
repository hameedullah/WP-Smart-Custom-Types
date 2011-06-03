<?php
if ( !class_exists( 'SmartCustomType' ) ) {
    class SmartCustomType {

        protected $prefix = "sct_";
        protected $version = "0.1";

        function __construct() {

            global $wpdb;

            // I am assuming there won't be much data
            // for the custom types so we will store
            // all our custom type data in a single table for now
            $this->cpt_table_name = $wpdb->prefix . $this->prefix . "customtypes";

            add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
            add_action( 'admin_head', array( $this, 'admin_tasks' ) );

            add_action( 'init', array( $this, 'register_smart_types' ) );
        }

        function add_admin_menu() {
            // Add the main top level menu
            $top_level_slug = 'sct_main_menu';
            add_menu_page( 
                'Smart Custom Types',
                'Smart Custom Types',
                'manage_options',
                $top_level_slug,
                array( $this, 'dashboard_page' )
            );

            add_submenu_page(
                $top_level_slug,  // add this menu as child to our toplevel
                'Smart Custom Post Types',
                'Custom Post Types',
                'manage_options',
                'sct_cpt_menu',
                array( $this, 'post_type_page' )
            );
        }

        function dashboard_page() {
        }

        function post_type_page() {
            global $wpdb;

            if ( isset( $_POST['sct_cpt_nonce'] ) && wp_verify_nonce( $_POST['sct_cpt_nonce'], 'sct_cpt_page' ) ) {
                $type_name = $_POST['type_name'];
                $is_public = (int) isset( $_POST['is_public'] );
                $has_archive = (int) isset( $_POST['has_archive'] );
                $show_in_menu = (int) isset( $_POST['show_in_menu'] );

                // create a slugified internal type name
                $internal_type_name = str_replace( " ", "-", str_replace("  ", " ", strtolower( $type_name ) ) );
                

                $sql = "INSERT INTO {$this->cpt_table_name} (type_name, name, is_public, show_in_menu, has_archive, sct_type)
                         VALUES ( '$internal_type_name', '$type_name', $is_public, $show_in_menu, $has_archive, 'cpt' )";

                $dbData = array();
                $dbData['type_name'] = $internal_type_name;
                $dbData['name'] = $type_name;
                $dbData['is_public'] = $is_public;
                $dbData['show_in_menu'] = $show_in_menu;
                $dbData['has_archive'] = $has_archive;
                $dbData['sct_type'] = 'cpt';

                $wpdb->insert( $this->cpt_table_name, $dbData );
                

            }

            $sql = "SELECT * FROM {$this->cpt_table_name}";
            $post_types = $wpdb->get_results( $sql );
            include( dirname( __FILE__ ) . '/../templates/post-types-page.php' );
        }

        function admin_tasks() {
            $installed_version = get_option( 'sct_plugin_version' );
            if ( !$installed_version || version_compare( $installed_version, $this->version, "<" ) ) {
                $this->install();
            }
        }

        function register_smart_types() {
            global $wpdb;
            
            $sql = "SELECT * FROM $this->cpt_table_name";
            $results = $wpdb->get_results( $sql );
            if ( !$results ) return;
            foreach ( $results as $result ) {
                $args = array(
                    'label' => $result->name,
                    'public' => (bool) $result->is_public,
                    'show_in_menu' => (bool) $result->show_in_menu,
                    'has_archive' => (bool) $result->has_archive
                );
                register_post_type(
                    $result->type_name,
                    $args
                );
            }

        }

        function activate() {
            global $wp_version;

            // TODO: need to fix and find the better way to show the error
            /*if ( version_compare( $wp_version, "3.0", "<" ) ) {*/
                //$msg = _( "Smart Plugins require smart Wordpress" );
                //deactivate_plugins( basename( __FILE__ ) );
                ////wp_die( $msg );
            /*}*/


            $this->install();

        }

        function install() {

            $sql = "CREATE TABLE " . $this->cpt_table_name . " (
                        id INT NOT NULL AUTO_INCREMENT,
                        type_name VARCHAR(20) NOT NULL,
                        name VARCHAR(20) NOT NULL,
                        labels BLOB,
                        is_public BOOL DEFAULT 1,
                        show_in_menu BOOL,
                        has_archive BOOL DEFAULT 0,
                        sct_type VARCHAR(20) NOT NULL,
                        UNIQUE KEY id (id)
                    );";

            // lets execute the sql
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

            // store the plugin version
            update_option( "sct_plugin_version", $this->version );
        }
    }
}
?>
