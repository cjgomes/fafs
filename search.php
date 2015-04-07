<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

    <div class="list-switch">
        <span>Resultado da Pesquisa / </span><strong><?php the_search_query(); ?></strong>
        <a href="javascript: void(0);" id="mode"<?php if ($_COOKIE['mode'] == 'grid') echo ' class="flip"'; ?>></a>
    </div>

    <?php get_template_part('loop'); ?>

<?php else : ?>

    <div class="content-title">
        Não encontramos nenhum resultado para sua pesquisa <strong><?php the_search_query(); ?></strong>
    </div>

    <div class="entry">
        <div class="single clear">
            <div class="post-content">
                <div class="searchagain">
                    <form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
                        <fieldset>
                            <input name="s" type="text" placeholder="Buscar novamente usando outros termos" />
                            <button type="submit"></button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php get_template_part('pagination'); ?>

<?php get_footer(); ?>