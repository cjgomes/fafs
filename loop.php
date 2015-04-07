<?php if ( have_posts() ) : ?>

    <div id="loop" class="<?php if ($_COOKIE['mode'] == 'grid') echo 'grid'; else echo 'list'; ?> clear">

    <?php while ( have_posts() ) : the_post(); ?>

        <div <?php post_class('content article-content'); ?> id="post_<?php the_ID(); ?>">
            <?php if ( has_post_thumbnail() ) :?>
            <a href="<?php the_permalink() ?>" class="thumb"><?php the_post_thumbnail('thumbnail', array(
                        'alt'	=> trim(strip_tags( $post->post_title )),
                        'title'	=> trim(strip_tags( $post->post_title )),
                    )); ?>
            </a>
                <?php endif; ?>

             <div class="article-content">
            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2></div>

            <div class="meta">
                        <span class="article-date"><?php the_time(__('j M, Y')) ?> &bull; <span><?php the_time() ?></span>
            </div>
            <div class="article"><?php if (function_exists('smart_excerpt')) smart_excerpt(get_the_excerpt(), 50); ?></div>

        </div>

        <?php endwhile; ?>

    </div>

    <?php endif; ?>
