<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Maera
 */

?>
		<footer id="colophon" class="site-footer mdl-mini-footer" role="contentinfo">
			<div class="mdl-mini-footer--left-section">
				<div>
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'maera' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'maera' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'maera' ), 'maera', '<a href="https://press.codes" rel="designer">Aristeides Stathopoulos</a>' ); ?>
				</div>
			</div>
		</footer>
	</main><!-- #content -->
</div>
<?php wp_footer(); ?>
</body>
</html>
