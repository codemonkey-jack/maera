<?php while ( have_posts() ) : the_post(); ?>
    <?php maera_get_template_part( 'template-parts/content', 'page' ); ?>
<?php endwhile;
