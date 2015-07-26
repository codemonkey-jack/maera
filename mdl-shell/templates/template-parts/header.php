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
            'theme_location' => 'primary',
            'walker'         => new Maera_MDL_Menu_Navwalker,
            'container'      => 'nav',
            'container_class' => 'mdl-navigation',
            'items_wrap'     => '%3$s',
            'depth'          => -1,
        ) );
        ?>
    </div>
