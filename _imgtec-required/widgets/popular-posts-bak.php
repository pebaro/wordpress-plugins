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

        //$options = get_option('custom_recent');
        $title = $instance['title'];
        $postscount = $instance['posts'];

        //GET the posts
        global $postcount;

        $myposts = get_posts(
            array('orderby' => 'comment_count','numberposts' => $postscount)
        );

        echo $before_widget . $before_title . $title . $after_title;

        //SHOW the posts
        foreach($myposts as $post){
            setup_postdata($post); ?>
            <div class="imgtec-popular-post">
                <div class="imgtec-twothirds-width">
                    <a href="<?php the_permalink() ?>">
                        <?php echo $post->post_title; ?>
                    </a>
                </div>
                <div class="imgtec-30pc-width">
                <?php // the_post_thumbnail('thumb'); ?>
                <?php the_post_thumbnail($post->ID); ?>
                </div>
            </div>
            <?php
        }
        echo $after_widget;
    }

    function update($newInstance, $oldInstance){
        $instance = $oldInstance;
        $instance['title'] = strip_tags($newInstance['title']);
        $instance['posts'] = $newInstance['posts'];

        return $instance;
    }

    function form($instance){
        echo '<p style="text-align:right;"><label>Title: <input style="width: 200px;" id="'.$this->get_field_id('title').'"  name="'.$this->get_field_name('title').'" type="text"  value="'.$instance['title'].'" /></label></p>';

        echo '<p style="text-align:right;"><label>Number of Posts: <input style="width: 50px;"  id="'.$this->get_field_id('posts').'"  name="'.$this->get_field_name('posts').'" type="text"  value="'.$instance['posts'].'" /></label></p>';

        echo '<input type="hidden" id="custom_recent" name="custom_recent" value="1" />';
    }
}

function register_show_popular_widget(){
    register_widget('show_popular');
}
add_action('widgets_init', 'register_show_popular_widget');

