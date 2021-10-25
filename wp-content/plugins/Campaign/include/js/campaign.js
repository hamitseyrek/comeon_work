jQuery(document).ready(function ($) {

    $('#upload_image_button').click(function () {

        formfield = $('#upload_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $(html).attr('src');
            $('#upload_image').val(imgurl);
            tb_remove();
        }
        return false;
    });
});