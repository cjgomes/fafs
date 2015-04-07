
<?php get_header (); ?>

<div class="container">
<div class="left_container">

<?php if ( have_posts() ) : ?>

    <div id="loop" class="<?php if ($_COOKIE['mode'] == 'grid') echo 'grid'; else echo 'list'; ?> clear">

    <?php while ( have_posts() ) : the_post(); ?>

        <div <?php post_class('post clear'); ?> id="post-<?php the_ID(); ?>">
            <?php if ( has_post_thumbnail() ) :?>
            <a href="<?php the_permalink() ?>" class="thumb"><?php the_post_thumbnail('thumbnail', array(
                        'title'	=> trim(strip_tags( $post->post_title )),
                        'alt'	=> trim(strip_tags( $post->post_title )),
                    )); ?></a>
            <?php endif; ?>

             <!--<div class="post-category"><?php the_category(' / '); ?></div>-->
            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

            <div class="post-meta">Publicado em <span
                        class="post-date"><?php the_time(__('j/M/Y')) ?></span> </br></br>
            </div>
            <div class="post-content"><?php if (function_exists('smart_excerpt')) smart_excerpt(get_the_excerpt(), 55); ?></div>
        </div>
    <?php endwhile; ?>
	
    </div>
	
<?php endif; ?>

</div>
</div>

<div style="clear:both;"></div>

<?php get_footer (); ?>