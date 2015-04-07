<?php
/**
 *Template Name: Página sobre Estatuto da FAFS
**/
get_header();
?>

<div class= "blog_container"
<?php

	if (have_posts()) : while (have_posts()) : the_post ();
	
?>
<div class="single_container">
<h1> <?php the_title(); ?>  </h1>
<hr color="#243C80"/><br /><br />
<?php the_content();?> <br /><hr color="#243C80"/>  
</div> 

<br /> 
 
<?php
	endwhile;
	else: 
?> 
<p> Nenhum post encontrado! <p>
<?php

	endif;
?>
</div>

<div style="clear:both;"></div>

<?php get_footer (); ?>