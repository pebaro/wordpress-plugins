<?php
function add_icon_ecosystem_news() {
    ?>
    <style>
    *[id*="_ecosystem_news"] > div.widget-top > div.widget-title > h3:before {
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
add_action('admin_head-widgets.php','add_icon_ecosystem_news');

// POPULAR POST WIDGET
class ecosystem_news extends WP_Widget {
		

    public function __construct(){
        $widget_ops = array(
            'classname' => 'ecosystem_news',
            'description' => 'Show Ecosystem News Posts'
        );
        parent::__construct( 'ecosystem_news', 'Ecosystem News', $widget_ops);
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
				
        $inthenewspost = new WP_Query( array( 'post_type' => 'ecosystem_news', 'post_status' => 'publish', 'posts_per_page' => $postscount, 'orderby' => 'date', 'order' => 'DESC'  ) );

        //echo $before_widget . $before_title . $title . $after_title;

        //SHOW the posts
        while ( $inthenewspost->have_posts() ) : $inthenewspost->the_post(); 
				//$id = get_the_ID();
				//$source_url     = get_post_meta($id, 'third_party_links', true);
				?>
            
            		<article class="imgtec-news-item">
								<h3 class="imgtec-esysnews-header"><?php the_title(); ?></h3>
								<span class="imgtec-esysnews-news-content"><?php the_content(); ?></span>
								<span class="imgtec-news-date"><?php the_time( get_option( 'date_format', 'd F Y' ) ); ?></span>
								<a href="<?php the_field('third_party_links'); ?>" target="_blank" rel="nofollow" class="imgtec-news-readmore">Read the article</a>
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

function register_ecosystem_news_widget(){
    register_widget('ecosystem_news');
}
add_action('widgets_init', 'register_ecosystem_news_widget');

