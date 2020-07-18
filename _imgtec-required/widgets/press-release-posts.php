<?php
function add_icon_press_releases() {
    ?>
    <style>
    *[id*="_press_releases"] > div.widget-top > div.widget-title > h3:before {
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
add_action('admin_head-widgets.php','add_icon_press_releases');

// English Press Release Widget
class press_releases extends WP_Widget {

    public function __construct(){
        $widget_ops = array(
            'classname' => 'press_releases',
            'description' => 'Show Press Releases'
        );
        parent::__construct( 'press_releases', 'Press Releases', $widget_ops);
    }

    public function widget($args, $instance){
        extract($args);

				if (isset($instance['posts'])) {
					$postscount = $instance['posts'];
				}else{
					$postscount = 6;
				}

        $pressreleases = new WP_Query( array( 'post_type' => 'press_releases', 'meta_query' => array(array('key' => 'language', 'value' => 'english', 'compare' =>'IN')), 'post_status' => 'publish', 'posts_per_page' => $postscount, 'orderby' => 'date', 'order' => 'DESC'  ) );


        echo '<ul class="pr-list">';

        //SHOW the posts
        while ( $pressreleases->have_posts() ) : $pressreleases->the_post();?>
            <li class="pr-list-item">
                <div class="pr-list-wrapper">
                   <a href="<?php echo the_permalink(); ?>"> <?php the_post_thumbnail(); ?> </a>
                    <div class="pr-list-content">
                        <h3><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="pr-list-content-date"><?php the_time( get_option( 'date_format', 'd F Y' ) ); ?></div>
                            <?php the_excerpt() ?>
                        </div>
                </div>
            </li>
            <?php
        endwhile;
        wp_reset_query();
        //echo $after_widget;
        echo '</ul>';
    }

    function update($newInstance, $oldInstance){
        $instance = $oldInstance;
        //$instance['title'] = strip_tags($newInstance['title']);
        $instance['posts'] = $newInstance['posts'];

        return $instance;
    }

    function form($instance){

        ?>

        echo '<p style="text-align:right;"><label>Number of Posts: <input style="width: 50px;"  id="'.$this->get_field_id('posts').'"  name="'.$this->get_field_name('posts').'" type="text"  value="'.$instance['posts'].'" /></label></p>';

        echo '<input type="hidden" id="custom_recent" name="custom_recent" value="1" />';

        <?php
    }
}

function register_press_releases_widget(){
    register_widget('press_releases');
}
add_action('widgets_init', 'register_press_releases_widget');

