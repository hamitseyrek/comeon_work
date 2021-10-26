jQuery(document).ready( function( $ ) {

    console.log(1254);
    $('#upload_image_button').click(function() {

        formfield = $('#upload_image').val();
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        window.send_to_editor = function(html) {
            imgurl = $(html).attr('src');
            $('#upload_image').val(imgurl);
            tb_remove();
        }
        return false;
    });

});