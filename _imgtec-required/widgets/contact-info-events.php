<?php
function add_icon_contact_info_events() {
  ?>
    <style>
    *[id*="_contact_info_events"] > div.widget-top > div.widget-title > h3:before {
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
add_action('admin_head-widgets.php','add_icon_contact_info_events');

class contact_info_events extends WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    // widget actual processes
    parent::__construct( false, 'Contact Info Events' );
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
    public function widget( $args, $instance ) {

      echo __('
        <div class="contact-widget widget">
          <h3>Events Contact</h3>
          <p>If you have any enquiries regarding any of the events we attend, please e-mail us:</p>
          <h5>International Events Marketing Manager</h5>
          <p><a href="mailto:maya.ahluwalia@imgtec.com">maya.ahluwalia@imgtec.com</a><br>
          Tel: +44 (0)1923 260511</p>
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

function register_contact_info_events_widget() {
  register_widget( 'contact_info_events' );
}

add_action( 'widgets_init', 'register_contact_info_events_widget' );
