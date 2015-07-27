<!DOCTYPE html>
<html <?php language_attributes(); ?>>

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

        <div id="page" class="hfeed site mdl-layout__container">
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'maera' ); ?></a>

            <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">

                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <div class="mdl-layout-spacer"></div>
                        <?php get_search_form(); ?>
                    </div>
                </header>

                <div class="mdl-layout__drawer">
                    <span class="mdl-layout-title">
                        <?php if ( function_exists( 'jetpack_the_site_logo' ) ) : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php jetpack_the_site_logo(); ?>
                            </a>
                        <?php endif; ?>
                    </span>

                    <?php
                    wp_nav_menu( array(
                        'theme_location'  => 'primary',
                        'walker'          => new Maera_MDL_Menu_Navwalker,
                        'container'       => 'nav',
                        'container_class' => 'mdl-navigation',
                        'items_wrap'      => '%3$s',
                        'depth'           => -1,
                    ) );
                    ?>
                </div>

                <main id="content" class="site-content mdl-layout__content">

                    <?php include maera_template_path(); ?>

                </main>

                <?php get_sidebar(); ?>
                <?php get_footer(); ?>

            </div>

        </div>

        <?php wp_footer(); ?>

    </body>

</html>
