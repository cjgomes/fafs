<?php
/**
 *Template Name: Página de Campeonatos
**/
get_header();
?>

<div class= "blog_container">

    <ul id="secao">
        <li id="genero" class="masc">Masculino</li>
        <li id="genero"class="fem">Feminino</li>
    </ul>
    <div class="clearfix"></div>
    <div id="camp-masc">
	<div class="text-nipe">Competições do nipe Masculino</div>
    <?php wp_nav_menu( array( 
'theme_location' 	=> 'Campeonatos-M',
'menu' 				=> 'Campeonato',
'container'			=> 'div',
'container_class'	=> 'camp-list',
'menu_class'		=> 'camp')); ?>
    </div>
    
    <div id="camp-fem">
	<div class="text-nipe">Competições do nipe Feminino</div>
    <?php wp_nav_menu( array( 
'theme_location' 	=> 'Campeonatos-F',
'menu' 				=> 'Campeonato',
'container'			=> 'div',
'container_class'	=> 'camp-list',
'menu_class'		=> 'camp')); ?>
    </div>
    
	<div class="article"><?php the_content(); ?></div><hr color="#243C80"/>
</div>
 

<div style="clear:both;"></div>

<?php get_footer (); ?>