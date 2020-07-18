<?php
function add_icon_featured_posts() {
    ?>
    <style>
    *[id*="_featured_posts"] > div.widget-top > div.widget-title > h3:before {
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
add_action('admin_head-widgets.php','add_icon_featured_posts');

// FEATURED POST WIDGET
class Featured_Posts extends WP_Widget {

    public function __construct(){
        $widget_ops = array(
            'classname' => 'featured_posts',
            'description' => 'Featured Blog Posts'
        );
        parent::__construct( 'featured_posts', 'Featured Posts', $widget_ops);
    }

    public function widget($args, $instance){
        extract($args);

				$featuredpost = get_transient( 'imgtec_featured_posts');
			
						if (empty($featuredpost)){
							 $featured_post_transient = new WP_Query( array( 'orderby' => 'post_date',
                'meta_query' => array(
                    array(
                        'key' => 'featured_blog_post',
                        'value' => 'featured',
                        'compare' => 'LIKE'
                    )
                )  ) );
							 $featuredpost = $featured_post_transient;
								set_transient( 'imgtec_featured_posts', $featured_post_transient, 1 * DAY_IN_SECONDS );
						}
				echo '<section class="imgtec-featured-post blog-widget">';
				echo '<h3>Featured Posts</h3>';
				//SHOW the posts
        while($featuredpost->have_posts()) : $featuredpost->the_post(); ?>
				
						<div class="meta-info">
						<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
						<p class="imgtec-featured-post-date">
									<?php the_date('d M Y'); ?>
						<span class="imgtec-featured-post-author">
									<?php echo get_the_author(); ?>
						</span>
						</p>
						</div>
				
            <?php
        endwhile;
        wp_reset_query();
				echo '</section>';
    }

   
}

function register_featured_posts_widget(){
    register_widget('featured_posts');
}
add_action('widgets_init', 'register_featured_posts_widget');

