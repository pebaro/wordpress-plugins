<?php
function add_icon_in_the_news() {
    ?>
    <style>
    *[id*="_in_the_news"] > div.widget-top > div.widget-title > h3:before {
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
add_action('admin_head-widgets.php','add_icon_in_the_news');

// POPULAR POST WIDGET
class in_the_news extends WP_Widget {
		

    public function __construct(){
        $widget_ops = array(
            'classname' => 'in_the_news',
            'description' => 'Show In The News Posts'
        );
        parent::__construct( 'in_the_news', 'In The News', $widget_ops);
    }

    public function widget($args, $instance){
        extract($args);

        //$options = get_option('custom_recent');
        //$title = "In The News";
        
				if (isset($instance['posts'])) {
					$postscount = $instance['posts'];    
				}else{  
					$postscount = 5;
				}
				
        $inthenewspost = new WP_Query( array( 'post_type' => 'the_news', 'post_status' => 'publish', 'posts_per_page' => $postscount, 'orderby' => 'date', 'order' => 'DESC'  ) );

        //echo $before_widget . $before_title . $title . $after_title;

        //SHOW the posts
        while ( $inthenewspost->have_posts() ) : $inthenewspost->the_post(); 
				$id = get_the_ID();
				$source         = get_post_meta($id, 'source', true);
				$source_url     = get_post_meta($id, 'url', true);
				?>
            
            		<article class="imgtec-news-item">
								<h3 class="imgtec-news-heading"><?php the_title(); ?></h3>
								<span class="imgtec-news-date"><?php the_time( get_option( 'date_format', 'd F Y' ) ); ?></span>
								<a href="<?php echo $source_url; ?>" target="_blank" class="imgtec-news-source"><?php echo $source; ?></a>
								<a href="<?php echo $source_url; ?>" target="_blank" rel="nofollow" class="imgtec-news-readmore">Read the article</a>
								</article>
            
            <?php
        endwhile;
        wp_reset_query();
        echo $after_widget;
    }

    function update($newInstance, $oldInstance){
        $instance = $oldInstance;
        //$instance['title'] = strip_tags($newInstance['title']);
        $instance['posts'] = $newInstance['posts'];

        return $instance;
    }

    function form($instance){
        //echo '<p style="text-align:right;"><label>Title: <input style="width: 200px;" id="'.$this->get_field_id('title').'"  name="'.$this->get_field_name('title').'" type="text"  value="In The News" /></label></p>';

        echo '<p style="text-align:right;"><label>Number of Posts: <input style="width: 50px;"  id="'.$this->get_field_id('posts').'"  name="'.$this->get_field_name('posts').'" type="text"  value="'.$instance['posts'].'" /></label></p>';

        echo '<input type="hidden" id="custom_recent" name="custom_recent" value="1" />';
    }
}

function register_in_the_news_widget(){
    register_widget('in_the_news');
}
add_action('widgets_init', 'register_in_the_news_widget');

