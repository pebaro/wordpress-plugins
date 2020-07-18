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

        //$options = get_option('custom_recent');
        $title = $instance['title'];
        $postscount = $instance['posts'];

        //GET the posts
        global $postcount;

        $myposts = get_posts(
            array(
                'orderby' => 'post_date',
                'meta_query' => array(
                    array(
                        'key' => 'featured_blog_post',
                        'value' => 'featured',
                        'compare' => 'LIKE'
                    )
                )
            )
        );

        echo $before_widget . $before_title . $title . $after_title;

        $date = get_the_date('d M Y');
        $author = get_the_author();
        // $firstName = get_the_author_meta('user_firstname');
        // $lastName = get_the_author_meta('user_lastname'); 
        $categories = get_the_category();

        //SHOW the posts
        foreach($myposts as $post){
            setup_postdata($post); ?>
            <div class="imgtec-featured-post">
                <?php the_post_thumbnail('small'); ?>
                <div class="meta-info">
                    <p><span class="imgtec-featured-post-date">
                            <?php echo $date; ?>
                        </span><span class="imgtec-featured-post-author">
                            <?php echo $author; ?>
                        </span></p>
                    <p><a href="<?php the_permalink() ?>"><?php echo $post->post_title; ?></a></p>
                    <p class="imgtec-featured-post-category"><?php foreach ($categories as $category) {
                        echo $category->name;
                    } ?></p>
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

function register_featured_posts_widget(){
    register_widget('featured_posts');
}
add_action('widgets_init', 'register_featured_posts_widget');

