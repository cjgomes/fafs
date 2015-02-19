<?php
/**
    *Template Name: Página de Inicio
**/
get_header();
?>
<div class="container">

<?php get_template_part('slideshow'); ?>
 <script type="text/javascript">
            (function($) {
                $(function() {
                    $('#slideshow').cycle({
                        fx: 'scrollHorz',
                        timeout: <?php echo (get_option('ss_timeout')) ? get_option('ss_timeout') : '7000' ?>,
                        next:   '#rarr',
                        prev:   '#larr'
                    });
                })
            })(jQuery)
        </script>

                <?php while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>


                <?php endwhile; // end of the loop. ?>
                
<div class="left_container">
</div>

</div>

<div style="clear:both;"></div>

<?php get_footer (); ?>
