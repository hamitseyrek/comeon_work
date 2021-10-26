<?php

// shortcode

function popup_campaign() {
	$args       = array( 'post_type' => 'campaign', 'orderby' => 'post_date' );
	$the_query  = new WP_Query( $args );
	$first_post = $the_query->posts[0];

	if ( $the_query->have_posts() ) {
		$segment = getSegment();
		if ( getSegment() == 'VIP' ) {
			$data  = json_decode( get_post_meta( $first_post->ID, 'vip', true ), true );
			$image = $data['upload_image'];

			return ' <div  style=" background-image: url(' . esc_attr( $image ) . ');background-size:100% 100%; width: 100%; height: 100%">'
			       . esc_attr( $data['header'] ) . ' 
 </div>';
		} else if ( getSegment() == 'HV' ) {
			$data  = json_decode( get_post_meta( $first_post->ID, "hv", true ), true );
			$image = $data['upload_image'];

			return ' <div  style=" background-image: url(' . esc_attr( $image ) . ');background-size:100% 100%; width: 100%; height: 100%">' . esc_attr( $data['header'] ) . ' </div>';
		} else if ( getSegment() == 'MV' ) {
			$data  = json_decode( get_post_meta( $first_post->ID, "mv", true ), true );
			$image = $data['upload_image'];

			return ' <div  style=" background-image: url(' . esc_attr( $image ) . ');background-size:100% 100%; width: 100%; height: 100%">' . esc_attr( $data['header'] ) . ' </div>';
		} else if ( getSegment() == 'LV' ) {
			$data  = json_decode( get_post_meta( $first_post->ID, 'lv', true ), true );
			$image = $data['upload_image'];

			return ' <div  style=" background-image: url(' . esc_attr( $image ) . ');background-size:100% 100%; width: 100%; height: 100%">' . esc_attr( $data['header'] ) . ' </div>';

		}
	} else {
		return '';
	}
}

add_shortcode( 'my_campaign', 'popup_campaign' );
function popup_shortcode( $name ) {
	echo do_shortcode( '[my_campaign]' );
}

add_action( 'wp_head', 'popup_shortcode' );


