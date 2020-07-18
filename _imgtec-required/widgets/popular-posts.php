<?php
function add_icon_show_popular() {
    ?>
    <style>
    *[id*="_show_popular"] > div.widget-top > div.widget-title > h3:before {
        font-family: "dashicons";
        content: "\f109";
        float:right;
        margin:-2px 0 -10px 0;
        font-size: 150%;
        color: #750054;
    }
    </style>
    <?php
}
add_action('admin_head-widgets.php','add_icon_show_popular');

// POPULAR POST WIDGET
class Show_Popular extends WP_Widget {

    public function __construct(){
        $widget_ops = array(
            'classname' => 'show_popular',
            'description' => 'Show Popular Blog Posts'
        );
        parent::__construct( 'show_popular', 'Popular Posts', $widget_ops);
    }

    public function widget($args, $instance){
        extract($args);
				
						$popularpost = get_transient( 'imgtec_popular_posts');
			
						if (empty($popularpost)){
							 $popular_post_transient = new WP_Query( array( 'posts_per_page' => 8, 'meta_key' => 'imgtec_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
							 $popularpost = $popular_post_transient;
								set_transient( 'imgtec_popular_posts', $popular_post_transient, 1 * DAY_IN_SECONDS );
						}
				echo '<section class="imgtec-featured-post blog-widget">';
				echo '<h3>Popular Posts</h3>';

				//SHOW the posts
        while ( $popularpost->have_posts() ) : $popularpost->the_post(); ?>
            <div class="imgtec-popular-post">
                <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
            </div>
            <?php
        endwhile;
        wp_reset_query();
        echo '</section>';
    }

}

function register_show_popular_widget(){
    register_widget('show_popular');
}
add_action('widgets_init', 'register_show_popular_widget');

