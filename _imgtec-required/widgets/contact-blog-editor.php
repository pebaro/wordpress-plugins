<?php
function add_icon_contact_info_blog_editor() {
  ?>
    <style>
    *[id*="_contact_info_blog_editor"] > div.widget-top > div.widget-title > h3:before {
      font-family: "dashicons";
      content: "\f466";
      float:right;
      margin:-2px 0 -10px 0;
      font-size: 150%;
      color: #750054;
    }
    </style>
  <?php
}
add_action('admin_head-widgets.php','add_icon_contact_info_blog_editor');

class contact_info_blog_editor extends WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    // widget actual processes
    parent::__construct( false, 'Contact Info Blog Editor' );
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
    public function widget( $args, $instance ) {

      echo __('
        <div class="blog-widget">
          <h3>Blog Contact</h3>
          <p>If you have any enquiries regarding any of our blog posts, please contact:</p>
          <h5>United Kingdom</h5>
          <p><a href="mailto:benny.har-even@imgtec.com">benny.har-even@imgtec.com</a><br>
          Tel: +44 (0)1923 260 511</p>
        </div>', 'text_domain'
      );
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

function register_contact_info_blog_editor_widget() {
  register_widget( 'contact_info_blog_editor' );
}

add_action( 'widgets_init', 'register_contact_info_blog_editor_widget' );
