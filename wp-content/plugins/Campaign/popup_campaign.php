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

			return ' <div  style=" background-image: url(' . esc_attr( $image ) . ');background-size:100% 100%; width: 100%; height: 100%">' . esc_attr( $data['header'] ) . '</div>';
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

			return '<div class="d-flex masthead"
     style="background-image:url(' . esc_attr( $image ) . ');height:100%;">
    <div class="container my-auto text-center" style="height: 600px;">
        <h3 class="mb-5"></h3><img style="margin-bottom: 15px;">
        <h1 class="mb-1">Stylish Portfolio</h1><em>A Free Bootstrap Theme<br>A Free Bootstrap ThemeA Free Bootstrap
        Theme<br>A Free Bootstrap Theme<br>A Free Bootstrap Theme<br><br></em><a
            class="btn btn-primary btn-xl js-scroll-trigger" role="button" href="#about" style="margin-top: 0px;">Find
        Out More</a>
        <div class="overlay"></div>
        <em style="margin-top: 0px;">A Free Bootstrap Theme<br>A Free Bootstrap ThemeA Free Bootstrap Theme<br>A Free
            Bootstrap Theme<br>A Free Bootstrap Theme<br><br></em>
    </div>
</div>';
		} else {
			$data  = json_decode( get_post_meta( $first_post->ID, 'lv', true ), true );
			$image = $data['upload_image'];

			return '
			<div class="masthead" style="background-image:url(' . esc_attr( $image ) . ')">
    			<div class="container text-style">
    			<div class="my-img-header">
        			<img src=' . WP_PLUGIN_URL . "/Campaign/assets/image/pzbuklogo.png" . '>
        			<h1>' . esc_attr( $data['header'] ) . '</h1>
        			<div class="my-description">
        			' . esc_attr( $data['description'] ) . '
        			</div>
        			<a class="btn btn-pzbuk btn-l" role="button" href="' . esc_attr( $data['button_link'] ) . '">' . esc_attr( $data['button_text'] ) . '</a><br>
    			<div class="disclaimer">
        			' . esc_attr( $data['disclaimer'] ) . '
        			</div>
    			</div>   
    			</div>     
			</div>';
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