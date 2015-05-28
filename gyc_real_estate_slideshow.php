<?php
/*
 * Plugin Name: Real Estate Slideshow
 * Plugin URI: https://www.genteycasas.com
 * Description: Property and Real Estate Plugin for WordPress. Creates a slideshow with latest real estate listings for sale and for rent.
 * Version: 1.0
 * Author: Gente & Casas
 * License: GPL2
 * Copyright 2015 Gente & Casas
 */

$withlogo	 = '<!-- Gente & Casas widget start --><div id="gyc_whatsnew" style="-moz-box-shadow:0 4px 8px #a0a0a0;-webkit-box-shadow:0 4px 8px #a0a0a0;display:none;width:250px;height:185px;box-shadow:0 4px 8px #a0a0a0;background-color: #fff;"><a id="gyc_href" href="#" style="float:left;" target="_blank"><div style="height: 145px; overflow: hidden;"><img alt="" id="gyc_img" style="display: inline;" /></div></a><a href="https://www.genteycasas.com" target="_blank" title="Gente &amp; Casas" style="float:left"><img alt="Gente &amp; Casas" src="https://static.genteycasas.com/www/img/logo/logo-97x18.png" style="float: left; margin: 5px 7px 0pt 0pt;" id="gyc_logo" /></a><ul id="gyc_text" style="float:left;"><li id="gyc_title" style="float:left;"></li><li id="gyc_link" style="float:left;"></li></ul></div><script type="text/javascript" src="https://api.genteycasas.com/widget/wpslideshow"></script><!-- Gente & Casas widget end -->';

$withoutlogo = '<!-- Gente & Casas widget start --><div id="gyc_whatsnew" style="-moz-box-shadow:0 4px 8px #a0a0a0;-webkit-box-shadow:0 4px 8px #a0a0a0;display:none;width:250px;height:157px;box-shadow:0 4px 8px #a0a0a0;background-color: #fff;"><a id="gyc_href" href="#" style="float:left;" target="_blank"><div style="height: 145px; overflow: hidden;"><img alt="" id="gyc_img" style="display: inline;" /></div></a><span id="gyc_logo"><span><ul id="gyc_text" style="float:left;display:none"><li id="gyc_title" style="float:left;"></li><li id="gyc_link" style="float:left;"></li></ul></div><script type="text/javascript" src="https://api.genteycasas.com/widget/wpslideshow"></script><style>#gyc_whatsnew{height: 155px !important; }</style><!-- Gente & Casas widget end -->';

if(class_exists('WP_Widget') && function_exists('register_widget')) {

	class Gyc_Widget extends WP_Widget {

		function __construct() {
			parent::__construct( 'gyc_widget',  __('Gente & Casas', 'gyc_widget_domain'), array( 'description' => __( 'A Real Estate Slideshow', 'gyc_widget_domain' ), ) );
		}

		public function widget( $args, $instance ) {

			global $withlogo;
			global $withoutlogo;

			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $args['before_widget'];

			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];

			$show_logo_name = $instance['show_logo_name'] ? 'true' : 'false';

			if( $show_logo_name == 'true' )
				echo $withlogo;
			else
				echo $withoutlogo;

			echo $args['after_widget'];
		}

		public function form( $instance ) {

			if ( isset( $instance[ 'title' ] ) )
				$title = $instance[ 'title' ];
			else
				$title = __( 'Real Estate Slideshow ', 'gyc_widget' );

			if ( isset( $instance[ 'show_logo_name' ] ) )
				$show_logo_name = 1;
			else
				$show_logo_name = $instance[ 'show_logo_name' ];

?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['show_logo_name'], 'on'); ?> id="<?php echo $this->get_field_id('show_logo_name'); ?>" name="<?php echo $this->get_field_name('show_logo_name'); ?>" />
                <label for="<?php echo $this->get_field_id('show_logo_name'); ?>">Show Logo &amp; Name</label>
            </p>

<?php
		}

		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['show_logo_name'] = ( ! empty( $new_instance['show_logo_name'] ) ) ? strip_tags( $new_instance['show_logo_name'] ) : '';
			return $instance;
		}

	} // Class wpb_widget ends here

	// Register and load the widget
	function gyc_load_widget() {
		register_widget( 'Gyc_Widget' );
	}
	add_action( 'widgets_init', 'gyc_load_widget' );
}

/**************** Short Code function ************************/

add_shortcode( 'gyc_real_estate_slideshow', 'gyc_shortcodes');

function gyc_shortcodes( $atts ) {
	global $withlogo;
	global $withoutlogo;

	extract(shortcode_atts(array(
      'showlogo' => 'false',
   	), $atts));

	if( $showlogo == 'true' )
		echo $withlogo;
	else
		echo $withoutlogo;
}

?>