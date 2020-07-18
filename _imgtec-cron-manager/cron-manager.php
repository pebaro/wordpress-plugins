<?php
/**
 * Plugin Name: _imgtec Cron Manager
 * Plugin URI:  https://university.imgtec.com
 * Description: Manager of WordPress CRON schedules and events
 * Author:      Rob Masters
 * Author URI:  https://university.imgtec.com
 * Version:     1.0
 * Text Domain: iup-cron-manager
 */

defined( 'ABSPATH' ) || die();

define( 'IUP_CRON_MANAGER_TEXTDOMAIN', 'iup-cron-manager' );
/**
 * The main encapsulating class for WP Control.
 */
class IUPCronManager {

	/**
	 * Hook onto all of the actions and filters needed by the plugin.
	 */
	protected function __construct() {

		$plugin_file = plugin_basename( __FILE__ );

		add_action( 'init',                               array( $this, 'action_init' ) );
		add_action( 'init',                               array( $this, 'action_handle_posts' ) );
		add_action( 'admin_menu',                         array( $this, 'action_admin_menu' ) );
		add_filter( "plugin_action_links_{$plugin_file}", array( $this, 'plugin_action_links' ), 10, 4 );
		add_filter( 'removable_query_args',               array( $this, 'filter_removable_query_args' ) );

		add_action( 'load-tools_page_iup_cron_admin_manage_page', array( $this, 'enqueue_code_editor' ) );

		register_activation_hook( __FILE__, array( $this, 'action_activate' ) );

		add_filter( 'cron_schedules',    array( $this, 'filter_cron_schedules' ) );
		add_action( 'iup_cron_job', array( $this, 'action_php_cron_event' ) );
	}

	/**
	 * Evaluates the provided code using eval.
	 *
	 * @param string $code The PHP code to evaluate.
	 */
	public function action_php_cron_event( $code ) {
		eval( $code ); // @codingStandardsIgnoreLine
	}

	/**
	 * Run using the 'init' action.
	 */
	public function action_init() {
		load_plugin_textdomain( IUP_CRON_MANAGER_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Handles any POSTs made by the plugin. Run using the 'init' action.
	 */
	public function action_handle_posts() {
		if ( isset( $_POST[ 'new_cron' ] ) ) :

			if ( ! current_user_can( 'manage_options' ) ) :
				wp_die( esc_html__( 'You are not allowed to add new cron events.', IUP_CRON_MANAGER_TEXTDOMAIN ), 401 );
			endif;

			check_admin_referer( 'new-cron' );
			extract( wp_unslash( $_POST ), EXTR_PREFIX_ALL, 'in' );

			if ( 'iup_cron_job' === $in_hookname && ! current_user_can( 'edit_files' ) ) :
				wp_die( 
					esc_html__( 
						'You are not allowed to add new PHP cron events.', IUP_CRON_MANAGER_TEXTDOMAIN 
					), 401 
				);
			endif;

			$in_args = json_decode( $in_args, true );

			$next_run = ( 'custom' === $in_next_run_date ) 
				? $in_next_run_date_custom 
				: $in_next_run_date;

			$this->add_cron( $next_run, $in_schedule, $in_hookname, $in_args );

			$redirect = array(
				'page'             => 'iup_cron_admin_manage_page',
				'iup_cron_message' => '5',
				'iup_cron_name'    => rawurlencode( $in_hookname ),
			);

			wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );

			exit;

		elseif ( isset( $_POST['new_php_cron'] ) ) :
			
			if ( ! current_user_can( 'edit_files' ) ) :
				wp_die( 
					esc_html__( 
						'You are not allowed to add new PHP cron events.', IUP_CRON_MANAGER_TEXTDOMAIN 
					), 401 
				);
			endif;

			check_admin_referer( 'new-cron' );
			extract( wp_unslash( $_POST ), EXTR_PREFIX_ALL, 'in' );

			$args = [
				'code' => $in_hookcode,
				'name' => $in_eventname,
			];

			$next_run = ( 'custom' === $in_next_run_date ) 
				? $in_next_run_date_custom 
				: $in_next_run_date;

			$this->add_cron( $next_run, $in_schedule, 'iup_cron_job', $args );

			$hookname = ( ! empty( $in_eventname ) ) 
				? $in_eventname 
				: __( 'PHP Cron', IUP_CRON_MANAGER_TEXTDOMAIN );

			$redirect = [
				'page'             => 'iup_cron_admin_manage_page',
				'iup_cron_message' => '5',
				'iup_cron_name'    => rawurlencode( $hookname ),
			];

			wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );

			exit;

		elseif ( isset( $_POST['edit_cron'] ) ) :

			if ( ! current_user_can( 'manage_options' ) ) :
				wp_die( 
					esc_html__( 
						'You are not allowed to edit cron events.', IUP_CRON_MANAGER_TEXTDOMAIN 
					), 401 
				);
			endif;

			extract( wp_unslash( $_POST ), EXTR_PREFIX_ALL, 'in' );

			check_admin_referer( "edit-cron_{$in_original_hookname}_{$in_original_sig}_{$in_original_next_run}" );

			if ( 'iup_cron_job' === $in_hookname && ! current_user_can( 'edit_files' ) ) :
				wp_die( esc_html__( 'You are not allowed to edit PHP cron events.', IUP_CRON_MANAGER_TEXTDOMAIN ), 401 );
			endif;

			$in_args = json_decode( $in_args, true );
			$i = $this->delete_cron( $in_original_hookname, $in_original_sig, $in_original_next_run );

			$next_run = ( 'custom' === $in_next_run_date ) 
				? $in_next_run_date_custom 
				: $in_next_run_date;

			$i = $this->add_cron( $next_run, $in_schedule, $in_hookname, $in_args );

			$redirect = [
				'page'             => 'iup_cron_admin_manage_page',
				'iup_cron_message' => '4',
				'iup_cron_name'    => rawurlencode( $in_hookname ),
			];

			wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );

			exit;

		elseif ( isset( $_POST['edit_php_cron'] ) ) :

			if ( ! current_user_can( 'edit_files' ) ) :
				wp_die( 
					esc_html__( 
						'You are not allowed to edit PHP cron events.', IUP_CRON_MANAGER_TEXTDOMAIN 
					), 401 
				);
			endif;

			extract( wp_unslash( $_POST ), EXTR_PREFIX_ALL, 'in' );

			check_admin_referer( "edit-cron_{$in_original_hookname}_{$in_original_sig}_{$in_original_next_run}" );

			$args['code'] = $in_hookcode;
			$args['name'] = $in_eventname;

			$args = [
				'code' => $in_hookcode,
				'name' => $in_eventname,
			];

			$i = $this->delete_cron( $in_original_hookname, $in_original_sig, $in_original_next_run );

			$next_run = ( 'custom' === $in_next_run_date ) 
				? $in_next_run_date_custom 
				: $in_next_run_date;

			$i = $this->add_cron( $next_run, $in_schedule, 'iup_cron_job', $args );

			$hookname = ( ! empty( $in_eventname ) ) 
				? $in_eventname 
				: __( 'PHP Cron', IUP_CRON_MANAGER_TEXTDOMAIN );

			$redirect = [
				'page'             => 'iup_cron_admin_manage_page',
				'iup_cron_message' => '4',
				'iup_cron_name'    => rawurlencode( $hookname ),
			];

			wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );

			exit;

		elseif ( isset( $_POST['new_schedule'] ) ) :
			
			if ( ! current_user_can( 'manage_options' ) ) :
				wp_die( 
					esc_html__( 
						'You are not allowed to add new cron schedules.', IUP_CRON_MANAGER_TEXTDOMAIN 
					), 401 
				);
			endif;

			check_admin_referer( 'new-sched' );

			$name 		= wp_unslash( $_POST['internal_name'] );
			$interval 	= wp_unslash( $_POST['interval'] );
			$display 	= wp_unslash( $_POST['display_name'] );

			// The user entered something that wasn't a number.
			// Try to convert it with strtotime.
			if ( ! is_numeric( $interval ) ) :
				$now = time();
				$future = strtotime( $interval, $now );
				
				if ( false === $future || -1 == $future || $now > $future ) :
					$redirect = [
						'page'             => 'iup_cron_admin_options_page',
						'iup_cron_message' => '7',
						'iup_cron_name'    => rawurlencode( $interval ),
					];

					wp_safe_redirect( add_query_arg( $redirect, admin_url( 'options-general.php' ) ) );

					exit;
				endif;

				$interval = $future - $now;

			elseif ( $interval <= 0 ) :
				$redirect = [
					'page'             => 'iup_cron_admin_options_page',
					'iup_cron_message' => '7',
					'iup_cron_name'    => rawurlencode( $interval ),
				];

				wp_safe_redirect( add_query_arg( $redirect, admin_url( 'options-general.php' ) ) );
				
				exit;
			endif;

			$this->add_schedule( $name, $interval, $display );

			$redirect = [
				'page'             => 'iup_cron_admin_options_page',
				'iup_cron_message' => '3',
				'iup_cron_name'    => rawurlencode( $name ),
			];

			wp_safe_redirect( add_query_arg( $redirect, admin_url( 'options-general.php' ) ) );

			exit;

		elseif ( isset( $_GET['action'] ) && 'delete-sched' == $_GET['action'] ) :
			
			if ( ! current_user_can( 'manage_options' ) ) :
				wp_die( 
					esc_html__( 
						'You are not allowed to delete cron schedules.', IUP_CRON_MANAGER_TEXTDOMAIN 
					), 401 
				);
			endif;

			$id = wp_unslash( $_GET['id'] );
			check_admin_referer( "delete-sched_{$id}" );
			$this->delete_schedule( $id );

			$redirect = [
				'page'             => 'iup_cron_admin_options_page',
				'iup_cron_message' => '2',
				'iup_cron_name'    => rawurlencode( $id ),
			];

			wp_safe_redirect( add_query_arg( $redirect, admin_url( 'options-general.php' ) ) );

			exit;

		elseif ( isset( $_POST['delete_crons'] ) ) :

			if ( ! current_user_can( 'manage_options' ) ) :
				wp_die( 
					esc_html__( 
						'You are not allowed to delete cron events.', IUP_CRON_MANAGER_TEXTDOMAIN 
					), 401 
				);
			endif;

			check_admin_referer( 'bulk-delete-crons' );

			if ( empty( $_POST['delete'] ) ) :
				return;
			endif;

			$delete  = wp_unslash( $_POST['delete'] );
			$deleted = 0;

			foreach ( $delete as $next_run => $events ) :

				foreach ( $events as $id => $sig ) :

					if ( 'iup_cron_job' === $id && ! current_user_can( 'edit_files' ) ) :
						continue;
					endif;

					if ( $this->delete_cron( urldecode( $id ), $sig, $next_run ) ) :
						$deleted++;
					endif;

				endforeach;

			endforeach;

			$redirect = [
				'page'             => 'iup_cron_admin_manage_page',
				'iup_cron_name'    => $deleted,
				'iup_cron_message' => '9',
			];

			wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );

			exit;

		elseif ( isset( $_GET['action'] ) && 'delete-cron' == $_GET['action'] ) :

			if ( ! current_user_can( 'manage_options' ) ) :
				wp_die( esc_html__( 'You are not allowed to delete cron events.', IUP_CRON_MANAGER_TEXTDOMAIN ), 401 );
			endif;

			$id 		= wp_unslash( $_GET['id'] );
			$sig 		= wp_unslash( $_GET['sig'] );
			$next_run 	= intval( $_GET['next_run'] );

			check_admin_referer( "delete-cron_{$id}_{$sig}_{$next_run}" );

			if ( 'iup_cron_job' === $id && ! current_user_can( 'edit_files' ) ) :
				wp_die( esc_html__( 'You are not allowed to delete PHP cron events.', IUP_CRON_MANAGER_TEXTDOMAIN ), 401 );
			endif;

			if ( $this->delete_cron( $id, $sig, $next_run ) ) :
				$redirect = [
					'page'             => 'iup_cron_admin_manage_page',
					'iup_cron_message' => '6',
					'iup_cron_name'    => rawurlencode( $id ),
				];

				wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );
				
				exit;

			else :
				$redirect = [
					'page'             => 'iup_cron_admin_manage_page',
					'iup_cron_message' => '7',
					'iup_cron_name'    => rawurlencode( $id ),
				];

				wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );
				
				exit;

			endif;

		elseif ( isset( $_GET['action'] ) && 'run-cron' == $_GET['action'] ) :

			if ( ! current_user_can( 'manage_options' ) ) :
				wp_die( 
					esc_html__( 
						'You are not allowed to run cron events.', IUP_CRON_MANAGER_TEXTDOMAIN 
					), 401 
				);
			endif;

			$id 	= wp_unslash( $_GET['id'] );
			$sig 	= wp_unslash( $_GET['sig'] );

			check_admin_referer( "run-cron_{$id}_{$sig}" );

			if ( $this->run_cron( $id, $sig ) ) :
				$redirect = [
					'page'             => 'iup_cron_admin_manage_page',
					'iup_cron_message' => '1',
					'iup_cron_name'    => rawurlencode( $id ),
				];

				wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );
				
				exit;

			else :
				$redirect = [
					'page'             => 'iup_cron_admin_manage_page',
					'iup_cron_message' => '8',
					'iup_cron_name'    => rawurlencode( $id ),
				];

				wp_safe_redirect( add_query_arg( $redirect, admin_url( 'tools.php' ) ) );
				
				exit;

			endif;

		endif;
	}

	/**
	 * Executes a cron event immediately.
	 *
	 * Executes an event by scheduling a new single event with the same arguments.
	 *
	 * @param string $hookname The hook name of the cron event to run.
	 * @param string $sig      The cron event signature.
	 */
	public function run_cron( $hookname, $sig ) {
		$crons = _get_cron_array();

		foreach ( $crons as $time => $cron ) :

			if ( isset( $cron[ $hookname ][ $sig ] ) ) :

				$args = $cron[ $hookname ][ $sig ]['args'];
				delete_transient( 'doing_cron' );
				wp_schedule_single_event( time() - 1, $hookname, $args );
				spawn_cron();

				return true;

			endif;

		endforeach;

		return false;
	}

	/**
	 * Adds a new cron event.
	 *
	 * @param string $next_run A GMT time that the event should be run at.
	 * @param string $schedule The recurrence of the cron event.
	 * @param string $hookname The name of the hook to execute.
	 * @param array  $args     Arguments to add to the cron event.
	 */
	public function add_cron( $next_run, $schedule, $hookname, $args ) {
		$next_run = strtotime( $next_run );

		if ( false === $next_run ) :
			$next_run = time();
		else :
			$next_run = get_gmt_from_date( date( 'Y-m-d H:i:s', $next_run ), 'U' );
		endif;

		if ( ! is_array( $args ) ) :
			$args = array();
		endif;

		if ( '_oneoff' === $schedule ) :
			return wp_schedule_single_event( $next_run, $hookname, $args ) === null;
		else :
			return wp_schedule_event( $next_run, $schedule, $hookname, $args ) === null;
		endif;
	}

	/**
	 * Deletes a cron event.
	 *
	 * @param string $to_delete The hook name of the event to delete.
	 * @param string $sig       The cron event signature.
	 * @param string $next_run  The GMT time that the event would be run at.
	 */
	public function delete_cron( $to_delete, $sig, $next_run ) {
		$crons = _get_cron_array();

		if ( isset( $crons[ $next_run ][ $to_delete ][ $sig ] ) ) :
			$args = $crons[ $next_run ][ $to_delete ][ $sig ]['args'];
			wp_unschedule_event( $next_run, $to_delete, $args );

			return true;
		endif;

		return false;
	}

	/**
	 * Adds a new custom cron schedule.
	 *
	 * @param string $name     The internal name of the schedule.
	 * @param int    $interval The interval between executions of the new schedule.
	 * @param string $display  The display name of the schedule.
	 */
	public function add_schedule( $name, $interval, $display ) {
		$old_scheds = get_option( 'iup_cron_schedules', array() );

		$old_scheds[ $name ] = [
			'interval' => $interval,
			'display'  => $display,
		];

		update_option( 'iup_cron_schedules', $old_scheds );
	}

	/**
	 * Deletes a custom cron schedule.
	 *
	 * @param string $name The internal_name of the schedule to delete.
	 */
	public function delete_schedule( $name ) {
		$scheds = get_option( 'iup_cron_schedules', array() );
		unset( $scheds[ $name ] );
		update_option( 'iup_cron_schedules', $scheds );
	}

	/**
	 * Sets up the plugin environment upon first activation.
	 *
	 * Run using the 'activate_' action.
	 */
	public function action_activate() {
		add_option( 'iup_cron_schedules', array() );

		// If there's never been a cron event, _get_cron_array will return false.
		if ( _get_cron_array() === false ) :
			_set_cron_array( array() );
		endif;
	}

	/**
	 * Adds options & management pages to the admin menu.
	 *
	 * Run using the 'admin_menu' action.
	 */
	public function action_admin_menu() {
		add_options_page( esc_html__( 'Cron Schedules', IUP_CRON_MANAGER_TEXTDOMAIN ), esc_html__( 'Cron Schedules', IUP_CRON_MANAGER_TEXTDOMAIN ), 'manage_options', 'iup_cron_admin_options_page', array( $this, 'admin_options_page' ) );
		add_management_page( esc_html__( 'Cron Events', IUP_CRON_MANAGER_TEXTDOMAIN ), esc_html__( 'Cron Events', IUP_CRON_MANAGER_TEXTDOMAIN ), 'manage_options', 'iup_cron_admin_manage_page', array( $this, 'admin_manage_page' ) );
	}

	/**
	 * Adds items to the plugin's action links on the Plugins listing screen.
	 */
	public function plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {
		$actions['crontrol-events'] = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'tools.php?page=iup_cron_admin_manage_page' ) ),
			esc_html__( 'Cron Events', IUP_CRON_MANAGER_TEXTDOMAIN )
		);

		$actions['crontrol-schedules'] = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'options-general.php?page=iup_cron_admin_options_page' ) ),
			esc_html__( 'Cron Schedules', IUP_CRON_MANAGER_TEXTDOMAIN )
		);

		return $actions;
	}

	/**
	 * Gives WordPress the plugin's set of cron schedules.
	 *
	 * Called by the 'cron_schedules' filter.
	 */
	public function filter_cron_schedules( $scheds ) {
		$new_scheds = get_option( 'iup_cron_schedules', array() );

		return array_merge( $new_scheds, $scheds );
	}

	/**
	 * Displays the options page for the plugin.
	 */
	public function admin_options_page() {
		$schedules 			= $this->get_schedules();
		$events 			= $this->get_cron_events();
		$custom_schedules 	= get_option( 'iup_cron_schedules', array() );
		$custom_keys 		= array_keys( $custom_schedules );

		if ( is_wp_error( $events ) ) :
			$events = array();
		endif;

		$used_schedules = array_unique( wp_list_pluck( $events, 'schedule' ) );

		$messages = array(
			/* translators: 1: The name of the cron schedule. */
			'2' => __( 'Successfully deleted the cron schedule %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),

			/* translators: 1: The name of the cron schedule. */
			'3' => __( 'Successfully added the cron schedule %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),

			/* translators: 1: The name of the cron schedule. */
			'7' => __( 'Cron schedule not added because there was a problem parsing %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),
		);
		if ( isset( $_GET['iup_cron_message'] ) && isset( $_GET['iup_cron_name'] ) && isset( $messages[ $_GET['iup_cron_message'] ] ) ) :
			$hook 		= wp_unslash( $_GET['iup_cron_name'] );
			$message 	= wp_unslash( $_GET['iup_cron_message'] );
			$msg  		= sprintf( esc_html( $messages[ $message ] ), '<strong>' . esc_html( $hook ) . '</strong>' );

			printf( '<div id="message" class="updated notice is-dismissible"><p>%s</p></div>', $msg ); // WPCS:: XSS ok.
		endif;
		?>

		<div class="wrap">
		<h1><?php esc_html_e( 'WP-Cron Schedules', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></h1>
		<p><?php esc_html_e( 'WP-Cron schedules are the time intervals that are available for scheduling events. You can only delete custom schedules.', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></p>
		<table class="widefat striped">
		<thead>
			<tr>
				<th scope="col"><?php esc_html_e( 'Name', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
				<th scope="col"><?php esc_html_e( 'Interval', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
				<th scope="col"><?php esc_html_e( 'Display Name', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
				<th scope="col"><?php esc_html_e( 'Delete', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		if ( empty( $schedules ) ) {
			?>
			<tr colspan="4"><td><?php esc_html_e( 'You currently have no schedules. Add one below.', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></td></tr>
			<?php
		} else {
			foreach ( $schedules as $name => $data ) {
				printf(
					'<tr id="sched-%s">',
					esc_attr( $name )
				);
				printf(
					'<td>%s</td>',
					esc_html( $name )
				);
				printf(
					'<td>%s (%s)</td>',
					esc_html( $data['interval'] ),
					esc_html( $this->interval( $data['interval'] ) )
				);
				printf(
					'<td>%s</td>',
					esc_html( $data['display'] )
				);

				echo '<td>';
				if ( in_array( $name, $custom_keys, true ) ) {
					if ( in_array( $name, $used_schedules, true ) ) {
						esc_html_e( 'This custom schedule is in use and cannot be deleted', IUP_CRON_MANAGER_TEXTDOMAIN );
					} else {
						$url = add_query_arg( array(
							'page'   => 'iup_cron_admin_options_page',
							'action' => 'delete-sched',
							'id'     => rawurlencode( $name ),
						), admin_url( 'options-general.php' ) );
						$url = wp_nonce_url( $url, 'delete-sched_' . $name );
						printf( '<span class="row-actions visible"><span class="delete"><a href="%s">%s</a></span></span>',
							esc_url( $url ),
							esc_html__( 'Delete', IUP_CRON_MANAGER_TEXTDOMAIN )
						);
					}
				} else {
					echo '&nbsp;';
				}
				echo '</td>';
				echo '</tr>';
			}
		}
		?>
		</tbody>
		</table>
		</div>
		<div class="wrap">
			<p class="description">
				<?php
					printf(
						'<a href="%s">%s</a>',
						esc_url( admin_url( 'tools.php?page=iup_cron_admin_manage_page' ) ),
						esc_html__( 'Manage Cron Events', IUP_CRON_MANAGER_TEXTDOMAIN )
					);
				?>
			</p>
		</div>
		<div class="wrap narrow">
			<h2 class="title"><?php esc_html_e( 'Add Cron Schedule', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></h2>
			<p><?php esc_html_e( 'Adding a new cron schedule will allow you to schedule events that re-occur at the given interval.', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></p>
			<form method="post" action="options-general.php?page=iup_cron_admin_options_page">
				<table class="form-table">
					<tbody>
					<tr>
						<th valign="top" scope="row"><label for="cron_internal_name"><?php esc_html_e( 'Internal name', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
						<td><input type="text" class="regular-text" value="" id="cron_internal_name" name="internal_name" required/></td>
					</tr>
					<tr>
						<th valign="top" scope="row"><label for="cron_interval"><?php esc_html_e( 'Interval (seconds)', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
						<td><input type="number" class="regular-text" value="" id="cron_interval" name="interval" min="1" step="1" required/></td>
					</tr>
					<tr>
						<th valign="top" scope="row"><label for="cron_display_name"><?php esc_html_e( 'Display name', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
						<td><input type="text" class="regular-text" value="" id="cron_display_name" name="display_name" required/></td>
					</tr>
				</tbody></table>
				<p class="submit"><input id="schedadd-submit" type="submit" class="button-primary" value="<?php esc_attr_e( 'Add Cron Schedule', IUP_CRON_MANAGER_TEXTDOMAIN ); ?>" name="new_schedule"/></p>
				<?php wp_nonce_field( 'new-sched' ); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Gets a sorted (according to interval) list of the cron schedules
	 */
	public function get_schedules() {
		$schedules = wp_get_schedules();
		uasort( $schedules, array( $this, 'sort_schedules' ) );
		return $schedules;
	}

	/**
	 * Internal sorting comparison callback function. Compares schedules by their interval.
	 */
	protected function sort_schedules( $a, $b ) {
		return ( $a['interval'] - $b['interval'] );
	}

	/**
	 * Displays a dropdown filled with the possible schedules, including non-repeating.
	 */
	public function schedules_dropdown( $current = false ) {
		$schedules = $this->get_schedules();
		?>
		<select class="postform" name="schedule" id="schedule" required>
		<option <?php selected( $current, '_oneoff' ); ?> value="_oneoff"><?php esc_html_e( 'Non-repeating', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></option>
		<?php foreach ( $schedules as $sched_name => $sched_data ) { ?>
			<option <?php selected( $current, $sched_name ); ?> value="<?php echo esc_attr( $sched_name ); ?>">
				<?php
				printf(
					'%s (%s)',
					esc_html( $sched_data['display'] ),
					esc_html( $this->interval( $sched_data['interval'] ) )
				);
				?>
			</option>
		<?php } ?>
		</select>
		<?php
	}

	/**
	 * Gets the status of WP-Cron functionality on the site by performing a test spawn. Cached for one hour when all is well.
	 */
	public function test_cron_spawn( $cache = true ) {
		global $wp_version;

		if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) {
			/* translators: 1: The name of the PHP constant that is set. */
			return new WP_Error( 'iup_cron_info', sprintf( __( 'The %s constant is set to true. WP-Cron spawning is disabled.', IUP_CRON_MANAGER_TEXTDOMAIN ), 'DISABLE_WP_CRON' ) );
		}

		if ( defined( 'ALTERNATE_WP_CRON' ) && ALTERNATE_WP_CRON ) {
			/* translators: 1: The name of the PHP constant that is set. */
			return new WP_Error( 'iup_cron_info', sprintf( __( 'The %s constant is set to true.', IUP_CRON_MANAGER_TEXTDOMAIN ), 'ALTERNATE_WP_CRON' ) );
		}

		$cached_status = get_transient( 'wp-cron-test-ok' );

		if ( $cache && $cached_status ) {
			return true;
		}

		$sslverify     = version_compare( $wp_version, 4.0, '<' );
		$doing_wp_cron = sprintf( '%.22F', microtime( true ) );

		$cron_request = apply_filters( 'cron_request', array(
			'url'  => site_url( 'wp-cron.php?doing_wp_cron=' . $doing_wp_cron ),
			'key'  => $doing_wp_cron,
			'args' => array(
				'timeout'   => 3,
				'blocking'  => true,
				'sslverify' => apply_filters( 'https_local_ssl_verify', $sslverify ),
			),
		) );

		$cron_request['args']['blocking'] = true;

		$result = wp_remote_post( $cron_request['url'], $cron_request['args'] );

		if ( is_wp_error( $result ) ) {
			return $result;
		} elseif ( wp_remote_retrieve_response_code( $result ) >= 300 ) {
			return new WP_Error( 'unexpected_http_response_code', sprintf(
				/* translators: 1: The HTTP response code. */
				__( 'Unexpected HTTP response code: %s', IUP_CRON_MANAGER_TEXTDOMAIN ),
				intval( wp_remote_retrieve_response_code( $result ) )
			) );
		} else {
			set_transient( 'wp-cron-test-ok', 1, 3600 );
			return true;
		}

	}

	/**
	 * Shows the status of WP-Cron functionality on the site. Only displays a message when there's a problem.
	 */
	public function show_cron_status() {

		$status = $this->test_cron_spawn();

		if ( is_wp_error( $status ) ) {
			if ( 'iup_cron_info' === $status->get_error_code() ) {
				?>
				<div id="cron-status-notice" class="notice notice-info">
					<p><?php echo esc_html( $status->get_error_message() ); ?></p>
				</div>
				<?php
			} else {
				?>
				<div id="cron-status-error" class="error">
					<p>
						<?php
						printf(
							/* translators: 1: Error message text. */
							esc_html__( 'There was a problem spawning a call to the WP-Cron system on your site. This means WP-Cron events on your site may not work. The problem was: %s', IUP_CRON_MANAGER_TEXTDOMAIN ),
							'<br><strong>' . esc_html( $status->get_error_message() ) . '</strong>'
						);
						?>
					</p>
				</div>
				<?php
			}
		}

	}

	/**
	 * Get the display name for the site's timezone.
	 */
	public function get_timezone_name() {
		$timezone_string = get_option( 'timezone_string', '' );
		$gmt_offset      = get_option( 'gmt_offset', 0 );

		if ( $gmt_offset >= 0 ) {
			$gmt_offset = '+' . $gmt_offset;
		}

		if ( '' === $timezone_string ) {
			$name = sprintf( 'UTC%s', $gmt_offset );
		} else {
			$name = sprintf( '%s (UTC%s)', str_replace( '_', ' ', $timezone_string ), $gmt_offset );
		}

		return $name;
	}

	/**
	 * Shows the form used to add/edit cron events.
	 */
	public function show_cron_form( $is_php, $existing ) {
		$new_tabs = array(
			'cron'     => __( 'Add Cron Event', IUP_CRON_MANAGER_TEXTDOMAIN ),
			'php-cron' => __( 'Add PHP Cron Event', IUP_CRON_MANAGER_TEXTDOMAIN ),
		);
		$modify_tabs = array(
			'cron'     => __( 'Modify Cron Event', IUP_CRON_MANAGER_TEXTDOMAIN ),
			'php-cron' => __( 'Modify PHP Cron Event', IUP_CRON_MANAGER_TEXTDOMAIN ),
		);
		$new_links = array(
			'cron'     => admin_url( 'tools.php?page=iup_cron_admin_manage_page&action=new-cron' ) . '#iup_cron_form',
			'php-cron' => admin_url( 'tools.php?page=iup_cron_admin_manage_page&action=new-php-cron' ) . '#iup_cron_form',
		);
		$display_args = '';
		if ( $is_php ) {
			$helper_text = esc_html__( 'Cron events trigger actions in your code. Enter the schedule of the event, as well as the PHP code to execute when the action is triggered.', IUP_CRON_MANAGER_TEXTDOMAIN );
		} else {
			$helper_text = sprintf(
				/* translators: %s: A file name */
				esc_html__( 'Cron events trigger actions in your code. A cron event needs a corresponding action hook somewhere in code, e.g. the %1$s file in your theme.', IUP_CRON_MANAGER_TEXTDOMAIN ),
				'<code>functions.php</code>'
			);
		}
		if ( is_array( $existing ) ) {
			$other_fields  = wp_nonce_field( "edit-cron_{$existing['hookname']}_{$existing['sig']}_{$existing['next_run']}", '_wpnonce', true, false );
			$other_fields .= sprintf( '<input name="original_hookname" type="hidden" value="%s" />',
				esc_attr( $existing['hookname'] )
			);
			$other_fields .= sprintf( '<input name="original_sig" type="hidden" value="%s" />',
				esc_attr( $existing['sig'] )
			);
			$other_fields .= sprintf( '<input name="original_next_run" type="hidden" value="%s" />',
				esc_attr( $existing['next_run'] )
			);
			if ( ! empty( $existing['args'] ) ) {
				$display_args = wp_json_encode( $existing['args'] );
			}
			$action = $is_php ? 'edit_php_cron' : 'edit_cron';
			$button = $is_php ? $modify_tabs['php-cron'] : $modify_tabs['cron'];
			$show_edit_tab = true;
			$next_run_date = get_date_from_gmt( date( 'Y-m-d H:i:s', $existing['next_run'] ), 'Y-m-d H:i:s' );
		} else {
			$other_fields = wp_nonce_field( 'new-cron', '_wpnonce', true, false );
			$existing = array(
				'hookname' => '',
				'args'     => array(),
				'next_run' => 'now',
				'schedule' => false,
			);
			$action = $is_php ? 'new_php_cron' : 'new_cron';
			$button = $is_php ? $new_tabs['php-cron'] : $new_tabs['cron'];
			$show_edit_tab = false;
			$next_run_date = '';
		}
		if ( $is_php ) {
			if ( ! isset( $existing['args']['code'] ) ) {
				$existing['args']['code'] = '';
			}
			if ( ! isset( $existing['args']['name'] ) ) {
				$existing['args']['name'] = '';
			}
		}

		$allowed = ( ! $is_php || current_user_can( 'edit_files' ) );
		?>
		<div id="iup_cron_form" class="wrap narrow">
			<h2 class="nav-tab-wrapper">
				<a href="<?php echo esc_url( $new_links['cron'] ); ?>" class="nav-tab<?php echo ( ! $show_edit_tab && ! $is_php ) ? ' nav-tab-active' : ''; ?>"><?php echo esc_html( $new_tabs['cron'] ); ?></a>
				<a href="<?php echo esc_url( $new_links['php-cron'] ); ?>" class="nav-tab<?php echo ( ! $show_edit_tab && $is_php ) ? ' nav-tab-active' : ''; ?>"><?php echo esc_html( $new_tabs['php-cron'] ); ?></a>
				<?php if ( $show_edit_tab ) { ?>
					<span class="nav-tab nav-tab-active"><?php echo esc_html( $button ); ?></span>
				<?php } ?>
			</h2>
			<?php if ( $allowed ) { ?>
			<p><?php echo $helper_text; // WPCS:: XSS ok. ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'tools.php?page=iup_cron_admin_manage_page' ) ); ?>">
				<?php echo $other_fields; // WPCS:: XSS ok. ?>
				<table class="form-table"><tbody>
					<?php if ( $is_php ) : ?>
						<tr>
							<th valign="top" scope="row"><label for="hookcode"><?php esc_html_e( 'PHP Code', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
							<td>
								<p class="description">
									<?php
										printf(
											/* translators: The PHP tag name */
											esc_html__( 'The opening %s tag must not be included.', IUP_CRON_MANAGER_TEXTDOMAIN ),
											'<code>&lt;?php</code>'
										);
									?>
								</p>
								<p><textarea class="large-text code" rows="10" cols="50" id="hookcode" name="hookcode"><?php echo esc_textarea( $existing['args']['code'] ); ?></textarea></p>
							</td>
						</tr>
						<tr>
							<th valign="top" scope="row"><label for="eventname"><?php esc_html_e( 'Event Name (optional)', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
							<td><input type="text" class="regular-text" id="eventname" name="eventname" value="<?php echo esc_attr( $existing['args']['name'] ); ?>"/></td>
						</tr>
					<?php else : ?>
						<tr>
							<th valign="top" scope="row"><label for="hookname"><?php esc_html_e( 'Hook Name', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
							<td><input type="text" class="regular-text" id="hookname" name="hookname" value="<?php echo esc_attr( $existing['hookname'] ); ?>" required /></td>
						</tr>
						<tr>
							<th valign="top" scope="row"><label for="args"><?php esc_html_e( 'Arguments (optional)', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
							<td>
								<input type="text" class="regular-text" id="args" name="args" value="<?php echo esc_attr( $display_args ); ?>"/>
								<p class="description">
									<?php
										printf(
											/* translators: 1, 2, and 3: Example values for an input field. */
											esc_html__( 'Use a JSON encoded array, e.g. %1$s, %2$s, or %3$s', IUP_CRON_MANAGER_TEXTDOMAIN ),
											'<code>[25]</code>',
											'<code>["asdf"]</code>',
											'<code>["i","want",25,"cakes"]</code>'
										);
									?>
								</p>
							</td>
						</tr>
					<?php endif; ?>
					<tr>
						<th valign="top" scope="row"><label for="next_run_date"><?php esc_html_e( 'Next Run', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
						<td>
							<ul>
								<li>
									<label>
										<input type="radio" name="next_run_date" value="now()" checked>
										<?php esc_html_e( 'Now', IUP_CRON_MANAGER_TEXTDOMAIN ); ?>
									</label>
								</li>
								<li>
									<label>
										<input type="radio" name="next_run_date" value="+1 day">
										<?php esc_html_e( 'Tomorrow', IUP_CRON_MANAGER_TEXTDOMAIN ); ?>
									</label>
								</li>
								<li>
									<label>
										<input type="radio" name="next_run_date" value="custom" id="next_run_date_custom" <?php checked( $show_edit_tab ); ?>>
										<?php
										printf(
											/* translators: %s: An input field for specifying a date and time */
											esc_html__( 'At: %s', IUP_CRON_MANAGER_TEXTDOMAIN ),
											sprintf(
												'<input type="text" name="next_run_date_custom" value="%s" class="regular-text" onfocus="jQuery(\'#next_run_date_custom\').prop(\'checked\',true);" />',
												esc_attr( $next_run_date )
											)
										);
										?>
									</label>
								</li>
							</ul>

							<p class="description">
								<?php
									printf(
										/* translators: 1: Date/time format for an input field, 2: PHP function name. */
										esc_html__( 'Format: %1$s or anything accepted by %2$s', IUP_CRON_MANAGER_TEXTDOMAIN ),
										'<code>YYYY-MM-DD HH:MM:SS</code>',
										'<a href="https://www.php.net/manual/en/function.strtotime.php"><code>strtotime()</code></a>'
									);
								?>
							</p>
							<p class="description">
								<?php
									printf(
										/* translators: %s Timezone name. */
										esc_html__( 'Timezone: %s', IUP_CRON_MANAGER_TEXTDOMAIN ),
										'<code>' . esc_html( $this->get_timezone_name() ) . '</code>'
									);
								?>
							</p>
						</td>
					</tr><tr>
						<th valign="top" scope="row"><label for="schedule"><?php esc_html_e( 'Recurrence', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label></th>
						<td>
							<?php $this->schedules_dropdown( $existing['schedule'] ); ?>
							<p class="description">
								<?php
								printf(
									'<a href="%s">%s</a>',
									esc_url( admin_url( 'options-general.php?page=iup_cron_admin_options_page' ) ),
									esc_html__( 'Manage Cron Schedules', IUP_CRON_MANAGER_TEXTDOMAIN )
								);
								?>
							</p>
						</td>
					</tr>
				</tbody></table>
				<p class="submit"><input type="submit" class="button-primary" value="<?php echo esc_attr( $button ); ?>" name="<?php echo esc_attr( $action ); ?>"/></p>
			</form>
			<?php } else { ?>
				<div class="error inline">
					<p><?php esc_html_e( 'You cannot add, edit, or delete PHP cron events because your user account does not have the ability to edit files.', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></p>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Returns a flattened array of cron events.
	 */
	public function get_cron_events() {

		$crons  = _get_cron_array();
		$events = array();

		if ( empty( $crons ) ) {
			return new WP_Error(
				'no_events',
				__( 'You currently have no scheduled cron events.', IUP_CRON_MANAGER_TEXTDOMAIN )
			);
		}

		foreach ( $crons as $time => $cron ) {
			foreach ( $cron as $hook => $dings ) {
				foreach ( $dings as $sig => $data ) {

					// This is a prime candidate for a iup_cron_Event class but I'm not bothering currently.
					$events[ "$hook-$sig-$time" ] = (object) array(
						'hook'     => $hook,
						'time'     => $time,
						'sig'      => $sig,
						'args'     => $data['args'],
						'schedule' => $data['schedule'],
						'interval' => isset( $data['interval'] ) ? $data['interval'] : null,
					);

				}
			}
		}

		return $events;

	}

	/**
	 * Displays the manage page for the plugin.
	 */
	public function admin_manage_page() {
		$messages = array(
			/* translators: 1: The name of the cron event. */
			'1' => __( 'Successfully executed the cron event %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),
			/* translators: 1: The name of the cron event. */
			'4' => __( 'Successfully edited the cron event %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),
			/* translators: 1: The name of the cron event. */
			'5' => __( 'Successfully created the cron event %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),
			/* translators: 1: The name of the cron event. */
			'6' => __( 'Successfully deleted the cron event %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),
			/* translators: 1: The name of the cron event. */
			'7' => __( 'Failed to the delete the cron event %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),
			/* translators: 1: The name of the cron event. */
			'8' => __( 'Failed to the execute the cron event %s.', IUP_CRON_MANAGER_TEXTDOMAIN ),
			'9' => __( 'Successfully deleted the selected cron events.', IUP_CRON_MANAGER_TEXTDOMAIN ),
		);
		if ( isset( $_GET['iup_cron_name'] ) && isset( $_GET['iup_cron_message'] ) && isset( $messages[ $_GET['iup_cron_message'] ] ) ) {
			$hook = wp_unslash( $_GET['iup_cron_name'] );
			$message = wp_unslash( $_GET['iup_cron_message'] );
			$msg = sprintf( esc_html( $messages[ $message ] ), '<strong>' . esc_html( $hook ) . '</strong>' );

			printf( '<div id="message" class="updated notice is-dismissible"><p>%s</p></div>', $msg ); // WPCS:: XSS ok.
		}
		$events = $this->get_cron_events();
		$doing_edit = ( isset( $_GET['action'] ) && 'edit-cron' === $_GET['action'] ) ? wp_unslash( $_GET['id'] ) : false;
		$time_format = 'Y-m-d H:i:s';
		$can_edit_files = current_user_can( 'edit_files' );

		$core_hooks = array(
			'wp_version_check',
			'wp_update_plugins',
			'wp_update_themes',
			'wp_scheduled_delete',
			'wp_scheduled_auto_draft_delete',
			'update_network_counts',
			'delete_expired_transients',
		);

		$this->show_cron_status();

		?>
		<div class="wrap">
		<h1><?php esc_html_e( 'WP-Cron Events', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></h1>
		<form method="post" action="tools.php?page=iup_cron_admin_manage_page">
		<table class="widefat striped">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1"><?php esc_html_e( 'Select All', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></label><input id="cb-select-all-1" type="checkbox"></td>
				<th scope="col"><?php esc_html_e( 'Hook Name', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
				<th scope="col"><?php esc_html_e( 'Arguments', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
				<th scope="col"><?php esc_html_e( 'Actions', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
				<th scope="col"><?php esc_html_e( 'Next Run', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
				<th scope="col"><?php esc_html_e( 'Recurrence', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></th>
				<th scope="col"><span class="screen-reader-text"><?php esc_html_e( 'Actions', IUP_CRON_MANAGER_TEXTDOMAIN ); ?></span></th>
			</tr>
		</thead>
		<tbody>
		<?php
		if ( is_wp_error( $events ) ) {
			?>
			<tr><td colspan="7"><?php echo esc_html( $events->get_error_message() ); ?></td></tr>
			<?php
		} else {
			foreach ( $events as $id => $event ) {

				if ( $doing_edit && $doing_edit == $event->hook && $event->time == $_GET['next_run'] && $event->sig == $_GET['sig'] ) {
					$doing_edit = array(
						'hookname' => $event->hook,
						'next_run' => $event->time,
						'schedule' => ( $event->schedule ? $event->schedule : '_oneoff' ),
						'sig'      => $event->sig,
						'args'     => $event->args,
					);
				}

				if ( empty( $event->args ) ) {
					$args = '<em>' . esc_html__( 'None', IUP_CRON_MANAGER_TEXTDOMAIN ) . '</em>';
				} else {
					$json_options = 0;

					if ( defined( 'JSON_UNESCAPED_SLASHES' ) ) {
						$json_options |= JSON_UNESCAPED_SLASHES;
					}
					if ( defined( 'JSON_PRETTY_PRINT' ) ) {
						$json_options |= JSON_PRETTY_PRINT;
					}

					$args = '<pre style="white-space:pre-wrap;margin-top:0">' . wp_json_encode( $event->args, $json_options ) . '</pre>';
				}

				echo '<tr>';

				echo '<th scope="row" class="check-column">';
				if ( ! in_array( $event->hook, $core_hooks, true ) ) {
					printf(
						'<input type="checkbox" name="delete[%1$s][%2$s]" value="%3$s">',
						esc_attr( $event->time ),
						esc_attr( rawurlencode( $event->hook ) ),
						esc_attr( $event->sig )
					);
				}
				echo '</th>';

				if ( 'iup_cron_job' === $event->hook ) {
					if ( ! empty( $event->args['name'] ) ) {
						/* translators: 1: The name of the PHP cron event. */
						echo '<td><em>' . esc_html( sprintf( __( 'PHP Cron (%s)', IUP_CRON_MANAGER_TEXTDOMAIN ), $event->args['name'] ) ) . '</em></td>';
					} else {
						echo '<td><em>' . esc_html__( 'PHP Cron', IUP_CRON_MANAGER_TEXTDOMAIN ) . '</em></td>';
					}
					echo '<td><em>' . esc_html__( 'PHP Code', IUP_CRON_MANAGER_TEXTDOMAIN ) . '</em></td>';
					echo '<td><em>' . esc_html__( 'WP IUPCronManager', IUP_CRON_MANAGER_TEXTDOMAIN ) . '</em></td>';
				} else {
					echo '<td>' . esc_html( $event->hook ) . '</td>';
					echo '<td>' . $args . '</td>'; // WPCS:: XSS ok.
					echo '<td>';
					$callbacks = array();
					foreach ( $this->get_action_callbacks( $event->hook ) as $callback ) {
						$callbacks[] = '<pre style="margin-top:0">' . self::output_callback( $callback ) . '</pre>';
					}
					echo implode( '', $callbacks ); // WPCS:: XSS ok.
					echo '</td>';
				}

				echo '<td style="white-space:nowrap">';
				printf( '%s (%s)',
					esc_html( get_date_from_gmt( date( 'Y-m-d H:i:s', $event->time ), $time_format ) ),
					esc_html( $this->time_since( time(), $event->time ) )
				);
				echo '</td>';

				echo '<td style="white-space:nowrap">';
				if ( $event->schedule ) {
					$schedule_name = $this->get_schedule_name( $event );
					if ( is_wp_error( $schedule_name ) ) {
						printf(
							'<span class="dashicons dashicons-warning"></span>%s',
							esc_html( $schedule_name->get_error_message() )
						);
					} else {
						echo esc_html( $schedule_name );
					}
				} else {
					esc_html_e( 'Non-repeating', IUP_CRON_MANAGER_TEXTDOMAIN );
				}
				echo '</td>';

				$links = array();

				echo '<td style="white-space:nowrap"><span class="row-actions visible">';

				if ( ( 'iup_cron_job' !== $event->hook ) || $can_edit_files ) {
					$link = array(
						'page'     => 'iup_cron_admin_manage_page',
						'action'   => 'edit-cron',
						'id'       => rawurlencode( $event->hook ),
						'sig'      => rawurlencode( $event->sig ),
						'next_run' => rawurlencode( $event->time ),
					);
					$link = add_query_arg( $link, admin_url( 'tools.php' ) ) . '#iup_cron_form';
					$links[] = "<a href='" . esc_url( $link ) . "'>" . esc_html__( 'Edit', IUP_CRON_MANAGER_TEXTDOMAIN ) . '</a>';
				}

				$link = array(
					'page'     => 'iup_cron_admin_manage_page',
					'action'   => 'run-cron',
					'id'       => rawurlencode( $event->hook ),
					'sig'      => rawurlencode( $event->sig ),
					'next_run' => rawurlencode( $event->time ),
				);
				$link = add_query_arg( $link, admin_url( 'tools.php' ) );
				$link = wp_nonce_url( $link, "run-cron_{$event->hook}_{$event->sig}" );
				$links[] = "<a href='" . esc_url( $link ) . "'>" . esc_html__( 'Run Now', IUP_CRON_MANAGER_TEXTDOMAIN ) . '</a>';

				if ( ! in_array( $event->hook, $core_hooks, true ) && ( ( 'iup_cron_job' !== $event->hook ) || $can_edit_files ) ) {
					$link = array(
						'page'     => 'iup_cron_admin_manage_page',
						'action'   => 'delete-cron',
						'id'       => rawurlencode( $event->hook ),
						'sig'      => rawurlencode( $event->sig ),
						'next_run' => rawurlencode( $event->time ),
					);
					$link = add_query_arg( $link, admin_url( 'tools.php' ) );
					$link = wp_nonce_url( $link, "delete-cron_{$event->hook}_{$event->sig}_{$event->time}" );
					$links[] = "<span class='delete'><a href='" . esc_url( $link ) . "'>" . esc_html__( 'Delete', IUP_CRON_MANAGER_TEXTDOMAIN ) . '</a></span>';
				}

				echo implode( ' | ', $links ); // WPCS:: XSS ok.
				echo '</span></td>';
				echo '</tr>';

			}
		}
		?>
		</tbody>
		</table>
		<p style="float:right">
			<?php
				echo esc_html( sprintf(
					/* translators: %s: The current date and time */
					__( 'Current site time: %s', IUP_CRON_MANAGER_TEXTDOMAIN ),
					date_i18n( 'Y-m-d H:i:s' )
				) );
			?>
		</p>
		<?php
		wp_nonce_field( 'bulk-delete-crons' );
		submit_button(
			__( 'Delete Selected Events', IUP_CRON_MANAGER_TEXTDOMAIN ),
			'primary large',
			'delete_crons'
		);
		?>
		</form>

		</div>
		<?php
		if ( is_array( $doing_edit ) ) {
			$this->show_cron_form( 'iup_cron_job' == $doing_edit['hookname'], $doing_edit );
		} else {
			$this->show_cron_form( ( isset( $_GET['action'] ) && 'new-php-cron' === $_GET['action'] ), false );
		}
	}

	/**
	 * Returns an array of the callback functions that are attached to the given hook name.
	 */
	protected function get_action_callbacks( $name ) {
		global $wp_filter;

		$actions = array();

		if ( isset( $wp_filter[ $name ] ) ) {

			$action = $wp_filter[ $name ];

			foreach ( $action as $priority => $callbacks ) {
				foreach ( $callbacks as $callback ) {
					$callback = self::populate_callback( $callback );

					$actions[] = array(
						'priority' => $priority,
						'callback' => $callback,
					);
				}
			}
		}

		return $actions;
	}

	/**
	 * Populates the details of the given callback function.
	 */
	public static function populate_callback( array $callback ) {
		// If Query Monitor is installed, use its rich callback analysis.
		if ( method_exists( 'QM_Util', 'populate_callback' ) ) {
			return QM_Util::populate_callback( $callback );
		}

		if ( is_string( $callback['function'] ) && ( false !== strpos( $callback['function'], '::' ) ) ) {
			$callback['function'] = explode( '::', $callback['function'] );
		}

		if ( is_array( $callback['function'] ) ) {
			if ( is_object( $callback['function'][0] ) ) {
				$class  = get_class( $callback['function'][0] );
				$access = '->';
			} else {
				$class  = $callback['function'][0];
				$access = '::';
			}

			$callback['name'] = $class . $access . $callback['function'][1] . '()';
		} elseif ( is_object( $callback['function'] ) ) {
			if ( is_a( $callback['function'], 'Closure' ) ) {
				$callback['name'] = 'Closure';
			} else {
				$class = get_class( $callback['function'] );
				$callback['name'] = $class . '->__invoke()';
			}
		} else {
			$callback['name'] = $callback['function'] . '()';
		}

		return $callback;

	}

	/**
	 * Returns a user-friendly representation of the callback function.
	 */
	public static function output_callback( array $callback ) {
		$qm   = WP_PLUGIN_DIR . '/query-monitor/query-monitor.php';
		$html = plugin_dir_path( $qm ) . 'output/Html.php';

		// If Query Monitor is installed, use its rich callback output.
		if ( class_exists( 'QueryMonitor' ) && file_exists( $html ) ) {
			require_once $html;

			if ( class_exists( 'QM_Output_Html' ) ) {
				return QM_Output_Html::output_filename(
					$callback['callback']['name'],
					$callback['callback']['file'],
					$callback['callback']['line']
				);
			}
		}

		return $callback['callback']['name'];
	}

	/**
	 * Pretty-prints the difference in two times.
	 */
	public function time_since( $older_date, $newer_date ) {
		return $this->interval( $newer_date - $older_date );
	}

	/**
	 * Converts a period of time in seconds into a human-readable format representing the interval.
	 *
	 * Example:
	 *
	 *     echo self::interval( 90 );
	 *     // 1 minute 30 seconds
	 */
	public function interval( $since ) {
		// Array of time period chunks.
		$chunks = array(
			/* translators: 1: The number of years in an interval of time. */
			array( 60 * 60 * 24 * 365, _n_noop( '%s year', '%s years', IUP_CRON_MANAGER_TEXTDOMAIN ) ),

			/* translators: 1: The number of months in an interval of time. */
			array( 60 * 60 * 24 * 30, _n_noop( '%s month', '%s months', IUP_CRON_MANAGER_TEXTDOMAIN ) ),

			/* translators: 1: The number of weeks in an interval of time. */
			array( 60 * 60 * 24 * 7, _n_noop( '%s week', '%s weeks', IUP_CRON_MANAGER_TEXTDOMAIN ) ),

			/* translators: 1: The number of days in an interval of time. */
			array( 60 * 60 * 24, _n_noop( '%s day', '%s days', IUP_CRON_MANAGER_TEXTDOMAIN ) ),

			/* translators: 1: The number of hours in an interval of time. */
			array( 60 * 60, _n_noop( '%s hour', '%s hours', IUP_CRON_MANAGER_TEXTDOMAIN ) ),

			/* translators: 1: The number of minutes in an interval of time. */
			array( 60, _n_noop( '%s minute', '%s minutes', IUP_CRON_MANAGER_TEXTDOMAIN ) ),

			/* translators: 1: The number of seconds in an interval of time. */
			array( 1, _n_noop( '%s second', '%s seconds', IUP_CRON_MANAGER_TEXTDOMAIN ) ),
		);

		if ( $since <= 0 ) {
			return __( 'now', IUP_CRON_MANAGER_TEXTDOMAIN );
		}

		/**
		 * We only want to output two chunks of time here, eg:
		 * x years, xx months
		 * x days, xx hours
		 * so there's only two bits of calculation below:
		 */
		$j = count( $chunks );

		// Step one: the first chunk.
		for ( $i = 0; $i < $j; $i++ ) {
			$seconds = $chunks[ $i ][0];
			$name = $chunks[ $i ][1];

			// Finding the biggest chunk (if the chunk fits, break).
			$count = floor( $since / $seconds );
			if ( $count ) {
				break;
			}
		}

		// Set output var.
		$output = sprintf( translate_nooped_plural( $name, $count, IUP_CRON_MANAGER_TEXTDOMAIN ), $count );

		// Step two: the second chunk.
		if ( $i + 1 < $j ) {
			$seconds2 = $chunks[ $i + 1 ][0];
			$name2 = $chunks[ $i + 1 ][1];
			$count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2 );
			if ( $count2 ) {
				// Add to output var.
				$output .= ' ' . sprintf( translate_nooped_plural( $name2, $count2, IUP_CRON_MANAGER_TEXTDOMAIN ), $count2 );
			}
		}

		return $output;
	}

	/**
	 * Returns the schedule display name for a given event.
	 */
	protected function get_schedule_name( stdClass $event ) {
		$schedules = $this->get_schedules();

		if ( isset( $schedules[ $event->schedule ] ) ) {
			return $schedules[ $event->schedule ]['display'];
		}

		return new WP_Error( 'unknown_schedule', __( 'Unknown', IUP_CRON_MANAGER_TEXTDOMAIN ) );
	}

	/**
	 * Enqueues the editor UI that's used for the PHP cron event code editor.
	 */
	public function enqueue_code_editor() {
		if ( ! function_exists( 'wp_enqueue_code_editor' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_files' ) ) {
			return;
		}

		$settings = wp_enqueue_code_editor( array(
			'type' => 'text/x-php',
		) );

		if ( false === $settings ) {
			return;
		}

		wp_add_inline_script( 'code-editor', sprintf(
			'jQuery( function( $ ) {
				if ( $( "#hookcode" ).length ) {
					wp.codeEditor.initialize( "hookcode", %s );
				}
			} );',
			wp_json_encode( $settings )
		) );
	}

	/**
	 * Filters the list of query arguments which get removed from admin area URLs in WordPress.
	 */
	public function filter_removable_query_args( array $args ) {
		return array_merge( $args, array(
			'iup_cron_message',
			'iup_cron_name',
		) );
	}

	/**
	 * Singleton instance instantiator.
	 */
	public static function init() {

		static $instance = null;

		if ( ! $instance ) {
			$instance = new IUPCronManager();
		}

		return $instance;

	}
}

// Get this show on the road.
IUPCronManager::init();
