<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">
    <label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer-exp">
        <i class="material-icons">search</i>
    </label>
    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    	<div class="mdl-textfield__expandable-holder">
    		<label class="screen-reader-text" for="fixed-header-drawer-exp"><?php _x( 'Search for:', 'label' ); ?></label>
    		<input class="mdl-textfield__input header-search" type="text" value="<?php echo get_search_query(); ?>" name="s" id="fixed-header-drawer-exp" />
    	</div>
    </form>
</div>
