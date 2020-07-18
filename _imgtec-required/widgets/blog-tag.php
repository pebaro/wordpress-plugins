<?php
function add_icon_blog_tag_list() {
  ?>
    <style>
    *[id*="_blog_tag_list"] > div.widget-top > div.widget-title > h3:before {
      font-family: "dashicons";
      content: "\f323";
      float:right;
      margin:-2px 0 -10px 0;
      font-size: 150%;
      color: #750054;
    }
    </style>
  <?php
}
add_action('admin_head-widgets.php','add_icon_blog_tag_list');

class Blog_Tag_List extends WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    // widget actual processes
    parent::__construct( false, 'Blog Tag List' );
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
	public function widget( $args, $instance ) {

?>
	<section class="blog-widget">
	<form>
  <h3><?php _e('Search by Tag'); ?></h3>
	<label for="tag-select">Search for posts by tag.</label>
	
	<?php 
		
		$tag_items = get_transient( 'imgtec_all_tags');
			
		if (empty($tag_items)){
        $tags = get_tags();	
				$tag_items = $tags; 
        set_transient( 'imgtec_all_tags', $tags, 1 * HOUR_IN_SECONDS );
    }
		
		echo '<select id="tag-select" onChange="window.location.replace(this.options[this.selectedIndex].value)">';
		echo '<option value="">Select a Tag</option>';
		foreach ( $tag_items as $tag ) {
		echo '<option value="/blog/tag/'. $tag->slug .'/">'. $tag->name .' ('. $tag->count .')</option>';
		}
		echo '</select>';

	?>
	</form>
	</section>
<?php
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

function register_blog_tag_list() {
  register_widget( 'blog_tag_list' );
}

add_action( 'widgets_init', 'register_blog_tag_list' );

//[blog_tag_list]
function blog_tag_list_func( $atts ){

		return get_the_tag_list('<ul class="blog-tag-list"><li class="post-tag">','</li><li class="post-tag">','</li></ul>');

}
add_shortcode( 'blog_tag_list', 'blog_tag_list_func' );
