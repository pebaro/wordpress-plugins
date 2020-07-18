<?php
function add_icon_forums() {
  ?>
    <style>
    *[id*="_forums"] > div.widget-top > div.widget-title > h3:before {
      font-family: "dashicons";
      content: "\f338";
      float:right;
      margin:-2px 0 -10px 0;
      font-size: 150%;
      color: #750054;
    }
    </style>
  <?php
}
add_action('admin_head-widgets.php','add_icon_forums');

class discwid_widget extends WP_Widget {
     
    function __construct() {
    	    parent::__construct(
         
        // base ID of the widget
        'discourse_list_pages_widget',
         
        // name of the widget
        __('Imagination Developer Forum', 'imgtec' ),
         
        // widget options
        array (
            'description' => __( 'Display widget in the sidebar', 'imgtec' )
        )
         
    );
    }
    
		// Widget options
    function form( $instance ) {
      $defaults = array(
            'title' => '-1',
            'URL' => '-1',
            'Order' => 'Latest'
        );  
        $URL = $instance[ 'URL' ];
        $Order = $instance[ 'Order' ];
         
        // markup for form ?>
        <p></p>
        <?php
    }
    
		

     
function widget( $args, $instance ) {



$response = get_transient( 'imgtec_forum_json');
			
	    if (empty($response)){	
				$forum_json = wp_remote_get('https://forums.imgtec.com/latest.json');
				$response = $forum_json;
        set_transient( 'imgtec_forum_json', $forum_json, 1 * HOUR_IN_SECONDS );
    }

if( is_wp_error( $response ) ) {
   $error_message = $response->get_error_message();
   echo "Something went wrong: $error_message";
} else {
  $body = wp_remote_retrieve_body( $response ) ;
  $data = json_decode($body);
	//var_dump($data);
  if( ! empty( $data) ){
  $i=0;
  ?>

	<table class="dsc-topic-list">
		<thead>
			<tr>
				<th class="dsc-topic-title">Topic</th>
				<th class="dsc-topic-users">Users</th>
				<th class="dsc-topic-replies">Replies</th>
				<th class="dsc-topic-views">Views</th>
				<th class="dsc-topic-activity">Activity</th>
			</tr>
		</thead>
		<tbody>
		<?php
		
		foreach( $data->topic_list->topics as $one ) {
			
			
			$last_update 		= date('M j', strtotime($one->last_posted_at));
			$topic_slug 		= $instance['URL'].'t/'.$one->slug;
			$topic_title		= $one->title;
			$topic_views		= $one->views;
			$topic_replies	    = $one->posts_count;
			$last_poster 		= $one->last_poster_username;
			
			
		if ($i<=5 && $one->pinned_globally !== true ) {
		?>
			<tr id="dsc-topic-id-<?php echo $one->id ?>">
				<td class="dsc-topic-title"><a href="<?php echo $topic_slug ?>" target="_blank" title="View the latest post by <?php echo $last_poster ?> in <?php echo $topic_title ?>"><?php echo $topic_title ?></a></td>
				<td class="dsc-topic-users"><?php 
							
							foreach ($one->posters as $poster) {

							foreach ($data->users as $user) {
							if ($poster->user_id == $user->id) {
							
							echo '<a href="https://forums.imgtec.com/u/'.$user->username.'" target="_blank" title="'.$user->username.' - '.$poster->description.'">
										<img class="dsc-avatar-img" alt="'.$user->username.'"  width="24" height="24" src="';
							
							$avatar = $user->avatar_template;

							if (strpos($avatar, 'user_avatar') !== false) {
							echo 'https://forums.imgtec.com/'. str_replace("{size}", "24", $user->avatar_template).'';
							}else{
							echo ''. str_replace("{size}", "20", $user->avatar_template).'';
							}
							echo '"/></a>';
							}
							}
							}// end of poster avatars
						?>
				</td>
				<td class="dsc-topic-replies"><?php echo $topic_replies ?></td>
				<td class="dsc-topic-views"><?php echo $topic_views ?></td>
				<td class="dsc-topic-activity"><a href="<?php echo $topic_slug ?>" target="_blank" title="View the latest post by <?php echo $last_poster ?> in <?php echo $topic_title ?>"><?php echo $last_update ?></a></td>
			</tr>	
		<?php
		$i++;}} // End of post 
		?>				
		</tbody>
	</table>
	
<?php

}}}}

function discwid_register() {

	register_widget( 'discwid_widget' );

}
add_action( 'widgets_init', 'discwid_register' );