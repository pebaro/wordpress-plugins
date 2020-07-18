<?php
function add_icon_blog_author() {
  ?>
    <style>
    *[id*="_blog_author"] > div.widget-top > div.widget-title > h3:before {
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
add_action('admin_head-widgets.php','add_icon_blog_author');

class Blog_Author extends WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    // widget actual processes
    parent::__construct( false, 'Blog Author List' );
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
	public function widget( $args, $instance ) {

		$debugstate = 'false';

		if ($debugstate === 'false'){
			$authors = get_transient('imgtec_all_authors');
		}
	
		if (empty($authors)){
			$user_args = array(
			'orderby' => 'display_name',
			'order'   => 'ASC',
			'count_total'  => true,
			'has_published_posts' => array('post'),
			);
		
			$authors = new WP_User_Query( $user_args );
			set_transient('imgtec_all_authors', $authors, 1 * HOUR_IN_SECONDS );
		}	
		$authors 	= $authors->results;
		$authors 	= array_map("unserialize", array_unique(array_map("serialize", $authors)));
		$total 		= sizeof($authors);
		
		// Create the output of the widget 
		echo '<section class="blog-widget">';
		echo '<form>';
		if ($debugstate === 'true'){
		echo '<h4>Debbuging</h4>';
		}
		echo '<h3>Search by Author</h3>';
		echo '<label for="author-select">Search for posts by one of our authors.</label>';		
		echo '<select id="author-select" onChange="window.location.replace(this.options[this.selectedIndex].value)">';
		echo '<option value="">Select an Author</option>';		
		foreach ( $authors as $author ){
      		echo '<option value="'. get_author_posts_url( $author->ID, $author->user_nicename ) .'">' . esc_html( $author->display_name ) .'</option>';
		}
		echo '</select>';
		echo '<noscript><input type="submit" value="View" /></noscript></form>';
		echo '</section>';
		
	}

  /**
   * Outputs the options form on admin
   *
   * @param array $instance The widget options
   */
  public function form( $instance ) {
    // outputs the options form on admin
  }

  /**
   * Processing widget options on save
   *
   * @param array $new_instance The new options
   * @param array $old_instance The previous options
   */
  public function update( $new_instance, $old_instance ) {
    // processes widget options to be saved
  }
}

function register_blog_author_widget() {
  register_widget( 'blog_author' );
}

add_action( 'widgets_init', 'register_blog_author_widget' );

//[author_post_count]
function author_post_count_func( $atts ){

	$auth_post_count = count_user_posts( get_the_author_meta('ID') );
	
	if ($auth_post_count < '2' ){
		return $auth_post_count .' post';
	}else{
		return $auth_post_count .' posts';
	
	}
	
}
add_shortcode( 'author_post_count', 'author_post_count_func' );
