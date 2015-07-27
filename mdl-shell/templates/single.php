<?php while ( have_posts() ) : the_post(); ?>
    <?php Maera::get_template_part( 'template-parts/content', 'single' ); ?>
<?php endwhile;
