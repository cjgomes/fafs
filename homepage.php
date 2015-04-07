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
	
	<br /><br /><h4>Parceiros:</h4>	
	<div class="parceiros_container">
		<a href= "http://www.pinhopinto.adv.br/" target="_blank"><img src="<?php bloginfo('template_directory');?>./img/pinho-pinto-advogados.jpg" alt="Pinho Pinto Advogados" title="Pinho Pinto Advogados" width="160px" height="86px"/></a>
		
		<a href= "https://www.facebook.com/SushiPontaNegra" target="_blank"><img src="<?php bloginfo('template_directory');?>\img\sushi-ponta-negra.jpg"alt="Sushi Ponta Negra" title="Sushi Ponta Negra" width="130px" height="130px"/></a>
		
		<a href= "http://www.comepicosmeticos.com.br/" target="_blank"><img src="<?php bloginfo('template_directory');?>\img\comepi.png" alt="Comepi" title="Comepi"width="160px" height="98px"/></a>
		
		<a href= "http://www.iacmanaus.com.br/" target="_blank"><img src="<?php bloginfo('template_directory');?>\img\instituto-analises-clinicas.png" alt="Instituto de Análises Clínicas" title="Instituto de Análises Clínicas" width="150px" height="88px"/></a>
		
		<a href= "http://www.kagiva.com.br/" target="_blank"><img src="<?php bloginfo('template_directory');?>\img\kagiva.png" alt="Kagiva" title="Kagiva" width="150px" height="48px"/></a>
		</div>
		
		<?php while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>


                <?php endwhile; // end of the loop. ?>	
</div>

	
                
<div class="left_container">
</div>

</div>

<div style="clear:both;"></div>

<?php get_footer (); ?>
