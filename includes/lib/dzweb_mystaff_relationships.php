<?php






class dzweb_post_type_relationships{
        public function __construct(){
            $this->offices_departments_cb();
            $this->staff_departments_cb();
        }
        
        public function offices_departments_cb(){
            p2p_register_connection_type( array(
                'name' => 'office_department',
                'from' => 'office',
                'to' => 'department',
                'cardinality' => 'one-to-many',
                'title' => array( 'from' => 'Department', 'to' => 'Office')
            ));
        }
        
        public function staff_departments_cb(){
            p2p_register_connection_type( array(
                'name' => 'Member of Department',
                'from' => 'department',
                'to' => 'staff',
                'cardinality' => 'one-to-many',
                'title' => array( 'from' => 'Staff Member', 'to' => 'Department')
            ));
        }
                
}
add_action( 'p2p_init', 'my_connection_types' );
 function my_connection_types() {
     new dzweb_post_type_relationships();
 };