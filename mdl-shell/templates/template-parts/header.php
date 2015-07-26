<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <div class="mdl-layout-spacer"></div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">
                <label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer-exp">
                    <i class="material-icons">search</i>
                </label>
                <div class="mdl-textfield__expandable-holder">
                    <input class="mdl-textfield__input" type="text" name="sample" id="fixed-header-drawer-exp" />
                </div>
            </div>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
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
