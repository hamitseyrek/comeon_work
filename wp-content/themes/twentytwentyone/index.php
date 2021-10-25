<?php
echo do_shortcode( '[my_campaign]' );
?>
<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

?>

<script>
    jQuery(document).ready(function() {

        var formfield;

        jQuery('#Image_button').click(function() {
            jQuery('html').addClass('Image');
            formfield = jQuery('#Image').attr('name');
            tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            return false;
        });

// user inserts file into post. only run custom if user started process using the above process
// window.send_to_editor(html) is how wp would normally handle the received data

        window.original_send_to_editor = window.send_to_editor;
        window.send_to_editor = function(html){

            if (formfield) {
                fileurl = jQuery('img',html).attr('src');

                jQuery('#Image').val(fileurl);

                tb_remove();

                jQuery('html').removeClass('Image');

            } else {
                window.original_send_to_editor(html);
            }
        };

    });
</script>

