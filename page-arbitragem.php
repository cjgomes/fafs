<?php
/**
 *Template Name: Página sobre Arbitragem
**/
?>
<?php get_header(); ?>

<div class="blog_container">

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>

		<div class="single_container">
        <div class="background content">
            <div <?php post_class('content article-content clear'); ?> id="post_<?php the_ID(); ?>">
                <div class="meta">
                    <h1><?php the_title(); ?></h1><hr color="#243C80"/></br>
                        
                <div class="article"><?php the_content(); ?></div><hr color="#243C80"/>
            </div>
        </div>
	</div>

        <?php endwhile; 
		else: ?>
		
<p> Nenhum post encontrado! <p>
    <?php endif; ?>
</div>
</div>

<?php get_footer(); ?>