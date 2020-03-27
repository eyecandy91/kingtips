<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

$footer          = get_field('footer', 101);

 	if ($footer) { ?>
	<footer class="footer content has-text-white">
		<div class="has-text-centered">
			<?php echo $footer ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	<?php } ?>

	</section>
	</div><!-- .container -->
</div><!-- .site -->

<?php wp_footer(); 
?>

</body>
</html>
