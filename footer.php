


<div class="footer">
	<div class="centered_footer">
		<div class="left_centered_footer"><a href="<?php echo get_option ('home');?> "><?php bloginfo ('name');?> &reg;</a> - Todos os Direitos Reservados&copy;</div>
		<div class="right_centered_footer">
			<li><a href="<?php echo get_option ('home');?> "> Início </a></li>
			<?php wp_list_pages('title_li='); ?>
		</div>
	</div>
</div>

<?php 
	wp_footer ();
?>

</body>

</html>