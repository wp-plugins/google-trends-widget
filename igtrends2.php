<?php
/*
Plugin Name: Google Trends Widget
Plugin URI: http://ithoib.blogspot.com
Description: Google trends widget linked to search page. Are you autoblog or AGC player? Don't miss this awesome plugin.
Version: 1.0
Author: Imam Thoib
Author URI: http://ithoib.blogspot.com
License: GPL2
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

class iGtrends2 extends WP_Widget {
	function __construct() {
	parent::__construct(
	// Base ID of your widget
	'iGtrends2', 
	// Widget name will appear in UI
	__('Google Trends Widget', 'iGtrends2_domain'), 
	// Widget description
	array( 'description' => __( 'Show latest google trends item linked to search page', 'iGtrends2_domain' ), ) 
	);
}
	// Creating widget front-end
	// This is where the action happens
	public function clean($str, $replace=array(), $delimiter='-') {
	  if( !empty($replace) ) {
	    $str = str_replace((array)$replace, ' ', $str);
	  }

	  $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	  $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	  $clean = strtolower(trim($clean, '-'));
	  $clean = trim($clean);
	  $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	  return trim($clean);
	}
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$num = $instance['country'];
	if(($num=='') || ($num=='0')){
		$num = 'p1';
	}
	$limit = $instance['limit'];
	$cache = $instance['cache'];
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];
	// This is where you run the code and display the output
	$url = 'http://www.google.com/trends/hottrends/atom/feed?pn='.$num;
	if ( false === ( $data = get_transient( $num ) ) ) {
		if(@simplexml_load_file($url)){
		$data = json_decode(json_encode(simplexml_load_file($url)));
		}
		set_transient( $num, $data, $cache * HOUR_IN_SECONDS );
	}
	if($data){
		echo '<ul>';
		$i = 0;
		foreach($data->channel->item as $hot){
		$i++;
		$stop = $limit + 1;
		if($i==$stop) { break; }
		echo '<li><a href="'.get_bloginfo('url').'/?s='.$hot->title.'">'.$hot->title.'</a></li>';
		}
		echo '</ul>';
	}
	echo $args['after_widget'];
	}
	// Widget Backend 
	public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	}
	else {
	$title = __( 'Trending Now', 'iGtrends2_domain' );
	}
	if ( isset( $instance[ 'limit' ] ) ) {
	$limit = $instance[ 'limit' ];
	}
	else {
	$limit = 10;
	}
	if ( isset( $instance[ 'cache' ] ) ) {
	$cache = $instance[ 'cache' ];
	}
	else {
	$cache = 6;
	}
	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'country' ); ?>"><?php _e( 'Country:' ); ?></label> 
	<select class="widefat" id="<?php echo $this->get_field_id( 'country' ); ?>" name="<?php echo $this->get_field_name( 'country' ); ?>">
		<option value="0">&mdash; Select Country &mdash;</option>
		<option value="p30" <?php if($instance['country']=='p30') { echo 'selected="selected"'; } ?> >Argentina</option>
		<option value="p8" <?php if($instance['country']=='p8') { echo 'selected="selected"'; } ?> >Australia</option>
		<option value="p44" <?php if($instance['country']=='p44') { echo 'selected="selected"'; } ?> >Austria</option>
		<option value="p41" <?php if($instance['country']=='p41') { echo 'selected="selected"'; } ?> >Belgium</option>
		<option value="p18" <?php if($instance['country']=='p18') { echo 'selected="selected"'; } ?> >Brazil</option>
		<option value="p13" <?php if($instance['country']=='p13') { echo 'selected="selected"'; } ?> >Canada</option>
		<option value="p38" <?php if($instance['country']=='p38') { echo 'selected="selected"'; } ?> >Chile</option>
		<option value="p32" <?php if($instance['country']=='p32') { echo 'selected="selected"'; } ?> >Colombia</option>
		<option value="p43" <?php if($instance['country']=='p43') { echo 'selected="selected"'; } ?> >Czech Republic</option>
		<option value="p49" <?php if($instance['country']=='p49') { echo 'selected="selected"'; } ?> >Denmark</option>
		<option value="p29" <?php if($instance['country']=='p29') { echo 'selected="selected"'; } ?> >Egypt</option>
		<option value="p50" <?php if($instance['country']=='p50') { echo 'selected="selected"'; } ?> >Finland</option>
		<option value="p16" <?php if($instance['country']=='p16') { echo 'selected="selected"'; } ?> >France</option>
		<option value="p15" <?php if($instance['country']=='p15') { echo 'selected="selected"'; } ?> >Germany</option>
		<option value="p48" <?php if($instance['country']=='p48') { echo 'selected="selected"'; } ?> >Greece</option>
		<option value="p10" <?php if($instance['country']=='p10') { echo 'selected="selected"'; } ?> >Hong Kong</option>
		<option value="p45" <?php if($instance['country']=='p45') { echo 'selected="selected"'; } ?> >Hungary</option>
		<option value="p3" <?php if($instance['country']=='p3') { echo 'selected="selected"'; } ?> >India</option>
		<option value="p19" <?php if($instance['country']=='p19') { echo 'selected="selected"'; } ?> >Indonesia</option>
		<option value="p6" <?php if($instance['country']=='p6') { echo 'selected="selected"'; } ?> >Israel</option>
		<option value="p27" <?php if($instance['country']=='p27') { echo 'selected="selected"'; } ?> >Italy</option>
		<option value="p4" <?php if($instance['country']=='p4') { echo 'selected="selected"'; } ?> >Japan</option>
		<option value="p37" <?php if($instance['country']=='p37') { echo 'selected="selected"'; } ?> >Kenya</option>
		<option value="p34" <?php if($instance['country']=='p34') { echo 'selected="selected"'; } ?> >Malaysia</option>
		<option value="p21" <?php if($instance['country']=='p21') { echo 'selected="selected"'; } ?> >Mexico</option>
		<option value="p17" <?php if($instance['country']=='p17') { echo 'selected="selected"'; } ?> >Netherlands</option>
		<option value="p52" <?php if($instance['country']=='p52') { echo 'selected="selected"'; } ?> >Nigeria</option>
		<option value="p51" <?php if($instance['country']=='p51') { echo 'selected="selected"'; } ?> >Norway</option>
		<option value="p25" <?php if($instance['country']=='p25') { echo 'selected="selected"'; } ?> >Philippines</option>
		<option value="p31" <?php if($instance['country']=='p31') { echo 'selected="selected"'; } ?> >Poland</option>
		<option value="p47" <?php if($instance['country']=='p47') { echo 'selected="selected"'; } ?> >Portugal</option>
		<option value="p39" <?php if($instance['country']=='p39') { echo 'selected="selected"'; } ?> >Romania</option>
		<option value="p14" <?php if($instance['country']=='p14') { echo 'selected="selected"'; } ?> >Russia</option>
		<option value="p36" <?php if($instance['country']=='p36') { echo 'selected="selected"'; } ?> >Saudi Arabia</option>
		<option value="p5" <?php if($instance['country']=='p5') { echo 'selected="selected"'; } ?> >Singapore</option>
		<option value="p40" <?php if($instance['country']=='p40') { echo 'selected="selected"'; } ?> >South Africa</option>
		<option value="p23" <?php if($instance['country']=='p23') { echo 'selected="selected"'; } ?> >South Korea</option>
		<option value="p26" <?php if($instance['country']=='p26') { echo 'selected="selected"'; } ?> >Spain</option>
		<option value="p42" <?php if($instance['country']=='p42') { echo 'selected="selected"'; } ?> >Sweden</option>
		<option value="p46" <?php if($instance['country']=='p46') { echo 'selected="selected"'; } ?> >Switzerland</option>
		<option value="p12" <?php if($instance['country']=='p12') { echo 'selected="selected"'; } ?> >Taiwan</option>
		<option value="p33" <?php if($instance['country']=='p33') { echo 'selected="selected"'; } ?> >Thailand</option>
		<option value="p24" <?php if($instance['country']=='p24') { echo 'selected="selected"'; } ?> >Turkey</option>
		<option value="p35" <?php if($instance['country']=='p35') { echo 'selected="selected"'; } ?> >Ukraine</option>
		<option value="p9" <?php if($instance['country']=='p9') { echo 'selected="selected"'; } ?> >United Kingdom</option>
		<option value="p1" <?php if($instance['country']=='p1') { echo 'selected="selected"'; } ?> >United States</option>
		<option value="p28" <?php if($instance['country']=='p28') { echo 'selected="selected"'; } ?> >Vietnam</option>
	</select>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Number of items to show:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'cache' ); ?>"><?php _e( 'Cache:' ); ?></label> 
	<input id="<?php echo $this->get_field_id( 'cache' ); ?>" name="<?php echo $this->get_field_name( 'cache' ); ?>" type="text" value="<?php echo esc_attr( $cache ); ?>" /> hours
	</p>
	<?php 
	}
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['country'] = ( ! empty( $new_instance['country'] ) ) ? strip_tags( $new_instance['country'] ) : '';
	$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? strip_tags( $new_instance['limit'] ) : '';
	$instance['cache'] = ( ! empty( $new_instance['cache'] ) ) ? strip_tags( $new_instance['cache'] ) : '';
	return $instance;
	}
}
// Register and load the widget
function iGtrends2_load_widget() {
	register_widget( 'iGtrends2' );
}
add_action( 'widgets_init', 'iGtrends2_load_widget' );
?>