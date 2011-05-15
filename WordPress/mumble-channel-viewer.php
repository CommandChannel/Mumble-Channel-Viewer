<?php
/*
Plugin Name: Mumble Channel Viewer
Plugin URI: http://CommandChannel.com/Downloads/Wordpress-Mumble-Viewer.aspx
Description: Shows you who is logged in to your Mumble server and their status.
Version: 2.1.0
Author: Command Channel
Author URI: http://CommandChannel.com
License: GPLv2
*/

/*  Copyright 2010 - 2011 Command Channel Corporation

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action( 'widgets_init', 'mumble_channel_viewer_load_widget' );

/**
 * Register our widget.
 *
 * @since 1.0
 */
function mumble_channel_viewer_load_widget() {
	register_widget( 'WP_MumbleChannelViewer' );
	wp_register_style( "mumble-channel-viewer", plugins_url( 'mumble-channel-viewer.css', __FILE__ ) );
	add_option('mumble_channel_viewer_data_uri');
	add_option('mumble_channel_viewer_data_format');
	add_option('mumble_channel_viewer_icon_style');
	add_option('mumble_channel_viewer_font_color');
}

/**
 * Widget class.
 *
 * @since 1.0
 */
class WP_MumbleChannelViewer extends WP_Widget {
	function WP_MumbleChannelViewer() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Mumble Channel Viewer', 'description' => 'Shows you who is logged in to your Mumble server and their status.' );

		/* Create the widget. */
		$this->WP_Widget( 'mumble-channel-viewer', 'Mumble Channel Viewer', $widget_ops );
		
		add_action( 'wp_head', array( &$this, 'wp_head' ), 1 );
	}
	
	function wp_head() {
		wp_enqueue_style( "mumble-channel-viewer" );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$dataUri = $instance['mumble_channel_viewer_data_uri'];
		$dataFormat = $instance['mumble_channel_viewer_data_format'];
		$iconStyle = $instance['mumble_channel_viewer_icon_style'];
		$fontColor = $instance['mumble_channel_viewer_font_color'];
		
		$cssClass = trim( $iconStyle . ' ' . $fontColor );
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		echo "<div id='mumbleViewer' class='{$cssClass}'>";
		if ( $dataUri && $dataFormat ) {
			require_once( 'class-mumble-channel-viewer.php' );
			echo MumbleChannelViewer::render( $dataUri, $dataFormat );
		}
		echo '</div>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['mumble_channel_viewer_data_uri'] = strip_tags( $new_instance['mumble_channel_viewer_data_uri'] );
		$instance['mumble_channel_viewer_data_format'] = strip_tags( $new_instance['mumble_channel_viewer_data_format'] );
		$instance['mumble_channel_viewer_icon_style'] = strip_tags( $new_instance['mumble_channel_viewer_icon_style'] );
		$instance['mumble_channel_viewer_font_color'] = strip_tags( $new_instance['mumble_channel_viewer_font_color'] );

		return $instance;
	}
	
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Mumble Server'), 'mumble_channel_viewer_data_uri' => '', 'mumble_channel_viewer_data_format' => 'json', 'mumble_channel_viewer_icon_style' => 'mumbleViewerIconsDefault', 'mumble_channel_viewer_font_color' => 'mumbleViewerColorBlack' );
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'mumble_channel_viewer_data_uri' ); ?>"><?php _e( 'Data URI' ); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'mumble_channel_viewer_data_uri' ); ?>" name="<?php echo $this->get_field_name( 'mumble_channel_viewer_data_uri' ); ?>" value="<?php echo $instance['mumble_channel_viewer_data_uri']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'mumble_channel_viewer_data_format' ); ?>"><?php _e( 'Data Format' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'mumble_channel_viewer_data_format' ); ?>" name="<?php echo $this->get_field_name( 'mumble_channel_viewer_data_format' ); ?>" class="widefat">
				<option value="json"<?php selected( $instance['mumble_channel_viewer_data_format'], 'json' ); ?>>JSON</option>
				<option value="xml"<?php selected( $instance['mumble_channel_viewer_data_format'], 'xml' ); ?>>XML</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'mumble_channel_viewer_icon_style' ); ?>"><?php _e( 'Icon Style' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'mumble_channel_viewer_icon_style' ); ?>" name="<?php echo $this->get_field_name( 'mumble_channel_viewer_icon_style' ); ?>" class="widefat">
				<option value="mumbleViewerIconsDefault"<?php selected( $instance['mumble_channel_viewer_icon_style'], 'mumbleViewerIconsDefault' ); ?>>Default</option>
				<option value="mumbleViewerIconsFarCry2"<?php selected( $instance['mumble_channel_viewer_icon_style'], 'mumbleViewerIconsFarCry2' ); ?>>Far Cry 2</option>
				<option value="mumbleViewerIconsNextGen"<?php selected( $instance['mumble_channel_viewer_icon_style'], 'mumbleViewerIconsNextGen' ); ?>>NextGen</option>
				<option value="mumbleViewerIconsSCGermania"<?php selected( $instance['mumble_channel_viewer_icon_style'], 'mumbleViewerIconsSCGermania' ); ?>>SC Germania</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'mumble_channel_viewer_font_color' ); ?>"><?php _e( 'Font Color' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'mumble_channel_viewer_font_color' ); ?>" name="<?php echo $this->get_field_name( 'mumble_channel_viewer_font_color' ); ?>" class="widefat">
				<option value="mumbleViewerColorAqua"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorAqua' ); ?>>Aqua</option>
				<option value="mumbleViewerColorBlack"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorBlack' ); ?>>Black</option>
				<option value="mumbleViewerColorBlue"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorBlue' ); ?>>Blue</option>
				<option value="mumbleViewerColorFuchsia"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorFuchsia' ); ?>>Fuchsia</option>
				<option value="mumbleViewerColorGray"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorGray' ); ?>>Gray</option>
				<option value="mumbleViewerColorGreen"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorGreen' ); ?>>Green</option>
				<option value="mumbleViewerColorLime"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorLime' ); ?>>Lime</option>
				<option value="mumbleViewerColorMaroon"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorMaroon' ); ?>>Maroon</option>
				<option value="mumbleViewerColorNavy"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorNavy' ); ?>>Navy</option>
				<option value="mumbleViewerColorOlive"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorOlive' ); ?>>Olive</option>
				<option value="mumbleViewerColorPurple"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorPurple' ); ?>>Purple</option>
				<option value="mumbleViewerColorRed"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorRed' ); ?>>Red</option>
				<option value="mumbleViewerColorSilver"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorSilver' ); ?>>Silver</option>
				<option value="mumbleViewerColorTeal"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorTeal' ); ?>>Teal</option>
				<option value="mumbleViewerColorWhite"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorWhite' ); ?>>White</option>
				<option value="mumbleViewerColorYellow"<?php selected( $instance['mumble_channel_viewer_font_color'], 'mumbleViewerColorYellow' ); ?>>Yellow</option>
			</select>
		</p>
	<?php
	}
}
?>
