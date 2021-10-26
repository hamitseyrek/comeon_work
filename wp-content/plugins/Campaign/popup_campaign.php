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

/*
        <div style=" background-image: url(' . esc_attr( $image ) . '); width: 100%; height: 100%">
        ' . esc_attr( $data ) . '
    </div>
*/
add_shortcode( 'my_campaign', 'popup_campaign' );
function popup_shortcode( $name ) {
	echo do_shortcode( '[my_campaign]' );
}
add_action( 'wp_head', 'popup_shortcode' );
?>

<!--
not necessary hmtsyrk
-->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    $('#but').click(function () {
        $("#dialogForm").dialog("open");
    });
    $("#dialogForm").dialog({
        modal: true,
        autoOpen: true,
        show: {effect: "blind", duration: 800}
    });
    $(window).load(function () {

        $("#dialogForm").dialog({
            modal: true,
            autoOpen: true,
            show: {effect: "blind", duration: 800}
        });
    });
</script>