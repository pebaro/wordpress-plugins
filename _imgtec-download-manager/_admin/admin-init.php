<?php
function iupdm_admin_init(){
	iupdm_include_file( '_admin/downloads-table.php' );

	add_filter( 'manage_iup_downloads_posts_columns', 'iupdm_add_new_downloads_columns' );
	add_action( 'manage_iup_downloads_posts_custom_column', 'iupdm_manage_new_downloads_columns', 10, 2 );
}