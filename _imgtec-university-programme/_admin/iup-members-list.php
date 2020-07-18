<?php
/**
 * =========================================================
 * class to extend WP_List_Table
 * for use with listing IUP members and registration data
 * =========================================================
 */

class IUP_Members_List extends WP_List_Table {

	// ==============
	// constructor
	public function __construct(){

		parent::__construct( [
			'singular' 	=> __( 'Member', IUPDM_TEXTDOMAIN ),
			'plural' 	=> __( 'Members', IUPDM_TEXTDOMAIN ),
			'ajax' 		=> false
		] );
	}

	// =======================
	// retreive member data
	public static function iup_get_members( $per_page = 5, $page_number = 1 ){

		global $wpdb;

		$sql 	  = "SELECT * FROM {$wpdb->prefix}wpforo_profiles";

		if ( ! empty( $_REQUEST[ 'orderby' ] ) ){
			$sql .= " ORDER BY " . esc_sql( $_REQUEST[ 'orderby' ] );
			$sql .= ! empty( $_REQUEST[ 'order' ] ) ? " " . esc_sql( $_REQUEST[ 'order' ] ) : " ASC";
		}
		$sql 	 .= " LIMIT $per_page";
		$sql 	 .= " OFFSET " . ( $page_number - 1 ) * $per_page;

		$result   = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}

	// =======================
	// delete member record
	public static function iup_delete_member( $member_id ){

		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}wpforo_profiles",
			[ 'userid' => $member_id ],
			[ '%d' ]
		);
	}

	// ==============================
	// count the number of members
	public static function iup_members_count(){
 
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}wpforo_profiles";

		return $wpdb->get_var( $sql );
	}

	// ================================
	// message when no members exist
	public function iup_no_members(){
		_e( 'IUP Members Unavailable!', IUPDM_TEXTDOMAIN );
	}

	// ==============
	// name column
	function iup_members_column_name( $item ){

		// create a nonce
		$delete_nonce 	= wp_create_nonce( 'iup_delete_member' );

		$title 			= '<strong>' . $item[ 'name' ] . '</strong>';

		$actions 		= [
			'delete' => sprintf( '<a href="?page=%s&action=%s&member=%s&wpnonce=%s">Delete IUP Member</a>', esc_attr( $_REQUEST[ 'page' ] ), 'delete', absint( $item[ 'userid' ] ), $delete_nonce )
		];

		return $title . $this->row_actions( $actions );
	}

	// ========================
	// setup default columns
	public function iup_members_column_default( $item, $column_name ){

		switch ( $column_name ){

			case 'title_fullname' :

			case 'language' :

			case 'emails_emailpreference' :

			case 'telephones' :

			case 'uni_dept_job_cstatus' :

			case 'address' :

			case 'country' :

			case 'contactconsent_shareconsent' :


			default :
				return print_r( $item, true );
		}
	}

	// =====================
	// bulk edit checkbox
	function iup_members_column_checkbox( $item ){

		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item[ 'userid' ]
		);
	}

	// ===================
	// name the columns
	function iup_get_members_columns(){

		$columns = [
			'cb' 							=> '<input type="checkbox" />',
			'title_fullname' 				=> __( 'Title / Full Name', IUPDM_TEXTDOMAIN ),
			'language' 						=> __( 'Language', IUPDM_TEXTDOMAIN ),
			'emails_emailpreference' 		=> __( 'Emails / ePreferrence', IUPDM_TEXTDOMAIN ),
			'telephones' 					=> __( 'Phone Numbers', IUPDM_TEXTDOMAIN ),
			'uni_dept_job_cstatus' 			=> __( 'Commercial Details', IUPDM_TEXTDOMAIN ),
			'address' 						=> __( 'Address', IUPDM_TEXTDOMAIN ),
			'country' 						=> __( 'Country', IUPDM_TEXTDOMAIN ),
			'contactconsent_shareconsent' 	=> __( 'Consent Given', IUPDM_TEXTDOMAIN )
		];

		return $columns;
	}

	// ========================
	// make columns sortable
	public function iup_get_sortable_members_columns(){

		$sortable_columns = [
			'title_fullname' 	=> [ 'title_fullname', true ],
			'language' 			=> [ 'language', true ],
			'country' 			=> [ 'country', true ]
		];

		return $sortable_columns;
	}

	// ==============
	// bulk action
	public function iup_get_bulk_actions(){

		$actions = [
			'bulk-delate' => 'Delete IUP Members'
		];

		return $actions;
	}

	// ==============================
	// filter, sorting, pagination
	public function iup_prepare_members(){

		$this->_column_headers = $this->get_column_info();

		// Process bulk action
		$this->iup_process_bulk_action();

		$per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();
	  
		$this->set_pagination_args( [
		  'total_items' => $total_items, //WE have to calculate the total number of items
		  'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );
	  
	  
		$this->items = self::iup_get_members( $per_page, $current_page );
	}

	// ==================
	// bulk processing
	public function iup_process_bulk_action(){

		// detect bulk action trigger
		if ( 'delete' === $this->current_action() ){
			// verify nonce
			$nonce = esc_attr( $_REQUEST[ '_wpnonce' ] );

			if ( ! wp_verify_nonce( $nonce, 'iup_delete_member' ) ){
				die ( 'Go Get Some Members Registered!!!' );
			} else {
				self::iup_delete_member( absint( $_GET[ 'member' ] ) );

				wp_redirect( esc_url( add_query_arg() ) );

				exit;
			}
		}

		// if bulk delete is triggered
		if ( ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'bulk-delete' ) || ( isset( $_POST[ 'action2' ] ) && $_POST[ 'action2' ] == 'bulk-delete' ) ){
			$delete_ids = esc_sql( $_POST[ 'bulk-delete' ] );

			// loop IDs and delete them
			foreach ( $delete_ids as $id ){
				self::iup_delete_member( $id );
			}

			wp_redirect( esc_url( add_query_arg() ) );

			exit;
		}
	}

}