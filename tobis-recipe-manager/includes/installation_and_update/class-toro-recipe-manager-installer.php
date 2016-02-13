<?php

class ToRo_Recipe_Manager_Installer {
    
    function __construct() {
        // Do nothing
    }
    
    function install() {
        $this->create_database();
    }
    
    function create_database() {
        global $wpdb;
        global $toro_rm_db_version;
        $table_name = $wpdb->prefix . "toro_rm_ingredients";
        $charset_collate = $wpdb->get_charset_collate();
        
        // SQL statement
        $sql = "CREATE TABLE " . $table_name . " (
		id int(9) NOT NULL AUTO_INCREMENT,
		name varchar(70) NOT NULL,
                UNIQUE KEY id (id)
	) " . $charset_collate . ";";
        
        echo get_option('toro_rm_db_version');
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('toro_rm_db_version', $toro_rm_db_version);
    }
    
    function update_database() {
        
    }
    
}

?>