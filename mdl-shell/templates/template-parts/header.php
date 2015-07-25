<div class="layout-transparent mdl-layout mdl-js-layout">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <!-- Title -->
            <span class="mdl-layout-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>
            <!-- Navigation -->
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'walker'         => new Maera_MDL_Menu_Navwalker,
                'container'      => 'nav',
                'container_class' => 'mdl-navigation mdl-layout--large-screen-only',
                'items_wrap'     => '%3$s',
                'depth'          => -1,
            ) );
            ?>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Title</span>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'walker'         => new Maera_MDL_Menu_Navwalker,
            'container'      => 'nav',
            'container_class' => 'mdl-navigation',
            'items_wrap'     => '',
            'depth'          => -1,
        ) );
        ?>
    </div>
    <div class="mdl-layout__drawer-button"><i class="material-icons">menu</i></div>
