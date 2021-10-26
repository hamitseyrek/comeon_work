<?php

// shortcode

function popup_campaign() {
	if ( getSegment() == 'VIP' ) {
		return '
        <div id="dialogForm" style="background-color: #0a4b78">
        <form id="myform" method="post">
                                 Name:
            <input type="text" value="VIP"/><br/>
            Phone:
            <input type="text"/><br/>
            <button type="submit"> Submit </button>
        </form>
    </div>
';
	} else if ( getSegment() == 'HV' ) {
		return '
        <div id="dialogForm" style="background-color: #0a4b78">
        <form id="myform" method="post">
                                 Name:
            <input type="text" value="HV"/><br/>
            Phone:
            <input type="text"/><br/>
            <button type="submit"> Submit </button>
        </form>
    </div>
';
	}
	if ( getSegment() == 'MV' ) {
		return '
        <div id="dialogForm" style="background-color: #0a4b78">
        <form id="myform" method="post">
                                 Name:
            <input type="text" value="MV"/><br/>
            Phone:
            <input type="text"/><br/>
            <button type="submit"> Submit </button>
        </form>
    </div>
';
	}
	if ( getSegment() == 'LV' ) {
		$data = json_decode(get_post_meta( 76, "lv", true ), true );
		$image = $data['upload_image'];

		return '
		<div  style=" background-image: url(' . esc_attr( $image ) . ');background-size:100% 100%; width: 100%; height: 100%">
        ' . esc_attr( $data['header'] ) . '
    </div>
		';
	} else {
		return '';
	}
}

add_shortcode( 'my_campaign', 'popup_campaign' );
function popup_shortcode( $name ) {
	echo do_shortcode( '[my_campaign]' );
}
add_action( 'wp_head', 'popup_shortcode' );


