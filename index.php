
<?php get_header (); ?>

<div class="container">
<div class="left_container">

<?php if ( have_posts() ) : ?>

    <div id="loop" class="clear">

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
    <?php if (get_option('paging_mode') == 'default') : ?>
    <div class="pagination">
        <div class="previouspostslink"><?php previous_posts_link(__('Postagens Recentes')); ?></div>
        <?php next_posts_link(__('Postagens Antigas')); ?>
        <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>
    </div>
    <?php else : ?>
    <div id="pagination"><?php next_posts_link(__('Mostrar Mais')); ?></div>
<?php endif; ?>
    </div>
	
<?php endif; ?>

</div>
</div>

<div style="clear:both;"></div>

<?php get_footer (); ?>