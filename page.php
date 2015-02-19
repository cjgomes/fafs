
<?php get_header (); ?>


<div class= "blog_container"
<?php

	if (have_posts()) : while (have_posts()) : the_post ();
	
?>
<div class="single_container">
<a href="<?php the_permalink ();?>" id="title"><h1> <?php the_title(); ?>  </h1></a>
<hr color="#243C80"/><br /><br />
<?php the_content();?> <hr color="#243C80"/><br /><br />
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