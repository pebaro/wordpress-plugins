<?php
function iup_admin_init(){
	iup_include_file( '_admin/iup-members-list.php' );
	
	// include class for use when paginating tables
	if ( ! class_exists( 'WP_List_Table' ) ){
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}
}
