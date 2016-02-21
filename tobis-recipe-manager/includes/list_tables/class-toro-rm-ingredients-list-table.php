<?php

class ToRo_RM_Ingredients_List_Table extends WP_List_Table {
    
    private $example_data = array(
        array('id' => 1, 'name' => 'Senf'),
    );
    
    public function __construct() {
        parent::__construct( [
            'singular' => __( 'Ingredient', 'sp' ), //singular name of the listed records
            'plural'   => __( 'Ingredients', 'sp' ), //plural name of the listed records
            'ajax'     => false //should this table support ajax?
        ] );
    }
    
    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => 'Name',
        );
        return $columns;
    }
    
    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->example_data;
    }
    
    function column_default($item, $column_name) {
        switch($column_name) {
            case 'name':
                return $item[$column_name];
            default:
                return print_r($item, true) ; //Show the whole array for troubleshooting purposes
        }
    }
    
    function column_cb($item) {
        return sprintf(
          '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }
    
}


?>