<?php

class ToRo_Recipe_Manager_Installer {
    
    function __construct() {
        // Do nothing
    }
    
    function install() {
        //if(!get_option('toro_rm_db_version')) {
            $this->create_database();
            $this->create_data();
        //}
    }
    
    function update() {
        global $toro_rm_db_version;
        
        // If option does not exist we stop
        if(!get_option('toro_rm_db_version')) {
            return;
        }
        
        // If option exist we update
        if (get_option('toro_rm_db_version') != $toro_rm_db_version) {
            $this->create_database();
        }
    }
    
    private function create_database() {
        global $wpdb;
        global $toro_rm_db_version;
        $table_name = $wpdb->prefix . "toro_rm_ingredients";
        $charset_collate = $wpdb->get_charset_collate();
        
        // SQL statement
        $sql = "CREATE TABLE " . $table_name . " (
		id int(9) NOT NULL AUTO_INCREMENT,
		name varchar(100) NOT NULL,
                UNIQUE KEY id (id)
	) " . $charset_collate . ";";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('toro_rm_db_version', $toro_rm_db_version);
    }
    
    function create_data() {
        global $wpdb;
        $table_name = $wpdb->prefix . "toro_rm_ingredients";
        
        $wpdb->insert( 
            $table_name, 
            array( 
                'name' => 'Senf',
            ) 
	);
    }
    
    function update_database() {
        
    }
    
}

?>